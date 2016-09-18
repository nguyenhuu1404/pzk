<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

// cac ham xu ly thong thuong
mb_language('uni');
mb_internal_encoding('UTF-8');
require_once 'config.php';
require_once 'include.php';

$sys = pzk_parse('system/full');

$app = $sys->getApp();

if(isset($_GET['token'])){
    $token = $_GET['token'];
}else {
    die();
}
if(isset($_GET['time'])){
    $time = $_GET['time'];
}else{
    die();
}
$username = pzk_session('adminUser');
if(isset($username)) {
    $username = pzk_session('adminUser');
}else {
    die();
}

$controller = pzk_controller();

if ($token == md5( $time . $username . SECRETKEY ) ) {
    $importFields = $_POST['importFields'];

    $allowed = array('csv','xlsx','xls');
    $dir = __DIR__."/tmp/";

    if(!empty($_FILES['file']['name'])){
        $fileParts = pathinfo($_FILES['file']['name']);
        // Kiem tra xem file upload co nam trong dinh dang cho phep
        if(in_array($fileParts['extension'], $allowed)) {
            // Neu co trong dinh dang cho phep, tach lay phan mo rong
            $tam = explode('.', $_FILES['file']['name']);
            $ext = end($tam);
            $renamed = md5(rand(0,200000)).'.'."$ext";

            move_uploaded_file($_FILES['file']['tmp_name'], $dir.$renamed);
        } else {
            // FIle upload khong thuoc dinh dang cho phep
           die("File upload không thuộc định dạng cho phép!");
        }
    }


    // Xoa file da duoc upload va ton tai trong thu muc tam
    //if(isset($_FILES[$filename]['tmp_name']) && is_file($_FILES[$filename]['tmp_name']) && file_exists($_FILES[$filename]['tmp_name'])) {
       // unlink($_FILES[$filename]['tmp_name']);
    //}
    //$path = __DIR__."/tmp/test.xls";
    $path = $dir.$renamed;
    if(!file_exists($path)) {
        die('file not exist');
    }

    require_once __DIR__ . '/3rdparty/phpexcel/PHPExcel.php';

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

    $objPHPExcel = PHPExcel_IOFactory::load($path);

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
    for ($row = 1; $row <= $highestRow; $row++){
        //  Read a row of data into an array
        $rowData = $sheet->toArray('A' . $row . ':' . $highestColumn . $row,
            NULL,
            TRUE,
            FALSE);

    }
    $bang = mysqli_real_escape_string($dbc, $_POST['table']);
    $cols = mysqli_real_escape_string($dbc, $importFields);
    $list = '';
    unset($rowData[0]);
    if(!empty($rowData)) {
        foreach($rowData as $item) {
            for($i=0; $i < count($item); $i++) {
                $list .= ','."'".mysqli_real_escape_string($dbc,$item[$i])."'";
            }
            $list = substr($list,1);
            $sql = "INSERT INTO test($cols)  VALUES ($list)";
            mysqli_query($dbc, $sql);
            $list ='';
        }
    }


    if(file_exists($path)) {
        unlink($path);
    }
    $url ="/admin_".$_POST['module']."/import";
    header("location: $url");
    exit;
}
?>