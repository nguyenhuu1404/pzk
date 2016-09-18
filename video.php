<?php

date_default_timezone_set('Asia/Ho_Chi_Minh');

// cac ham xu ly thong thuong
mb_language('uni');
mb_internal_encoding('UTF-8');
require_once 'config.php';
require_once 'include.php';

$sys = pzk_parse('system/full');

$app = $sys->getApp();

if($_GET['id'] && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
}else {
    die();
}

$token = $_GET['token'];
$time = $_GET['time'];
$username = pzk_session('username');
if(isset($username)) {
    $username = pzk_session('username');
}else {
    $username = false;
}
//check token
if ($token == md5( $time . $username . SECRETKEY ) ) {
    $host = _db()->host;
    $user = _db()->user;
    $password = _db()->password;
    $db = _db()->dbName;
    //connect database
    $dbc = mysqli_connect($host, $user,$password,$db);
    if(!$dbc) {
        trigger_error("Could not connect to DB: " . mysqli_connect_error());
    } else {
        mysqli_set_charset($dbc, 'utf-8');
    }

    $q = "SELECT url FROM video WHERE id = {$id} LIMIT 1";
    $result = mysqli_query($dbc,$q);

    list($url) = mysqli_fetch_array($result, MYSQLI_NUM);

    //name file video
    $nametmp = basename($url);
    ///var_dump($nametmp);die();
    $file = __DIR__. $url;



    $file2 = __DIR__.'/tmp/'.$nametmp;

    //khong ton tai file2 trong thuc muc tmp
    if(!file_exists($file2)) {
        $handle = fopen($file, "rb");
        $initial_contents = fread($handle, filesize($file));
        fclose($handle);

        if($initial_contents){

            $td = mcrypt_module_open('tripledes', '', 'ecb', '');
            $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);

            mcrypt_generic_init($td, '123456', $iv);

            $encrypted_data = $initial_contents;

            $p_t = mdecrypt_generic($td, $encrypted_data);

            $newfile = @fopen($file2,'wb');
            $ok_decrypt = @fwrite($newfile,$p_t);

            @fclose($newfile);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);

        }
    }
    /*
    if (file_exists($file2)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file2));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file2));
        ob_clean();
        flush();
        readfile($file2);
        exit;
    }else{
        die("The File $fichero does not exist");
    }
    */
    //exit();
    //*doc file
        $fp = @fopen($file2, 'rb');
        $size = filesize($file2); // File size
        $length = $size; // Content length
        $start = 0; // Start byte
        $end = $size - 1; // End byte
        header('Content-type: video/mp4');
        header("Accept-Ranges: 0-$length");
        header("Accept-Ranges: bytes");
        if (isset($_SERVER['HTTP_RANGE'])) {
            $c_start = $start;
            $c_end = $end;
            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }

            if ($range == '-') {
                $c_start = $size - substr($range, 1);
            }else{
                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
            }
            $c_end = ($c_end > $end) ? $end : $c_end;

            if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            $start = $c_start;
            $end = $c_end;
            $length = $end - $start + 1;
            fseek($fp, $start);
            header('HTTP/1.1 206 Partial Content');
        }
        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: ".$length);
        $buffer = 10000024 * 8;
        while(!feof($fp) && ($p = ftell($fp)) <= $end) {
            set_time_limit(0);
            if ($p + $buffer > $end) {
                $buffer = $end - $p + 1;
            }
            echo fread($fp, $buffer);
            flush();
        }


        fclose($fp);
        exit();
}
?>