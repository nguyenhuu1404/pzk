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

    //query
    $q = mysqli_real_escape_string($dbc, $_POST['q']);
    $q = decrypt(base64_decode($q), SECRETKEY);
    /*$result = mysqli_query($dbc,$q);
    $finfo = mysqli_fetch_fields($result);
    $arrtitle = array();
    foreach($finfo as $val) {
        $arrtitle[] = $val->name;
    }
    echo '<pre>'; var_dump($arrtitle);
    die();*/
    //$q = mysqli_real_escape_string($dbc, $q);
    $result = mysqli_query($dbc, trim($q));
    mysqli_close($dbc);
    if(empty($result)){
        die();
    }

    require_once __DIR__ . '/3rdparty/phpexcel/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $currenttime = date("m-d-Y");

    $fields = $_POST['exportFields'];
    $headings = explode(',', $fields);
    $arrJoin = array();
    foreach($headings as $field) {
        $tam = explode('.', $field);
        if(isset($tam[1])) {
            $arrJoin[] = $tam[1];
        }

    }
    if(!empty($arrJoin)) {
        $headings = $arrJoin;
    }

    $type = $_POST['type'];

    if($type == 'pdf') {
        //require library 3rdparty(dmopdf, mpdf, tcpdf)
        $rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
        $rendererLibrary = 'dompdf';
        $rendererLibraryPath = dirname(__FILE__).'/3rdparty/' . $rendererLibrary;
        if (!PHPExcel_Settings::setPdfRenderer(
            $rendererName,
            $rendererLibraryPath
        )) {
            die(
                'not work'
            );
        }

        if ( $result or die(mysql_error())) {
            // Create a new PHPExcel object
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle('Data');

            $rowNumber = 1;
            $col = 'A';
            foreach($headings as $heading) {
                //set value col in file excel
                $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading);
                $col++;
            }

            // Loop through the result set
            $rowNumber = 2;
            while ($row = mysqli_fetch_row($result)) {
                $col = 'A';
                foreach($row as $cell) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell);
                    $col++;
                }
                $rowNumber++;
            }
        }

        //http headers, redirect output to client browers
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment;filename="table.pdf"');
        header('Cache-Control: max-age=0');
        // writer data excel to pdf
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
        $objWriter->save('php://output');
            exit();
    }
    elseif($type == 'csv' ) {
        if ($result or die(mysql_error())) {
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->setTitle('CYImport'.$currenttime.'');

            $rowNumber = 1;

            $objPHPExcel->getActiveSheet()->fromArray(array($headings),NULL,'A'.$rowNumber);
            $rowNumber++;
            while ($row = mysqli_fetch_row($result)) {
                $col = 'A';
                foreach($row as $cell) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell);
                    $col++;
                }
                $rowNumber++;
            }


            $objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
            $objWriter->setDelimiter(',');
            $objWriter->setEnclosure('');
            $objWriter->setLineEnding("\r\n");
            $objWriter->setSheetIndex(0);



            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Import'.$currenttime.'".csv"');
            header('Cache-Control: max-age=0');

            $objWriter->save('php://output');
            exit();
        }
    }
    elseif($type == 'excel' ) {

        if ($result or die(mysql_error())) {
            // Create a new PHPExcel object
            $objPHPExcel->getActiveSheet()->setTitle('data');

            $rowNumber = 1;
            $col = 'A';
            foreach($headings as $heading) {
                //set value col in file excel
                $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$heading);
                $col++;
            }

            // Loop through the result set
            $rowNumber = 2;
            while ($row = mysqli_fetch_row($result)) {
                $col = 'A';
                foreach($row as $cell) {
                    $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$cell);
                    $col++;
                }
                $rowNumber++;
            }

            // Freeze pane so that the heading line won't scroll
            $objPHPExcel->getActiveSheet()->freezePane('A2');

            // Save as an Excel BIFF (xls) file
            //excel 2007
            //$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);//Excel5,PDF
            //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            //header('Content-Disposition: attachment;filename="userList.xlsx"');
            //excel 2003
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//Excel5,PDF
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="userList.xls"');
            header('Cache-Control: max-age=0');
            if($objWriter) {
                $objWriter->save('php://output');
            }
            exit();
        }
    }
}
?>