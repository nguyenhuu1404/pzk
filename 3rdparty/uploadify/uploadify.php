<?php
// cac ham xu ly thong thuong
require_once $_SERVER['DOCUMENT_ROOT'] .'/config.php';
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
// Define a destination
//var_dump($_POST['time']);die();
    if(isset($_POST['timestamp'])) {
        $verifyToken = md5(SECRETKEY . $_POST['timestamp']);
    }

    if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
        if($_POST['uploadtype'] =='video') {
            $targetFolder = '/3rdparty/uploads/videos'; // Relative to the root
            $fileTypes = array('mp4'); // File extensions
        }elseif($_POST['uploadtype'] =='image') {
            $targetFolder = '/3rdparty/uploads/images'; // Relative to the root
            $fileTypes = array('jpg','jpeg','png','gif'); // File extensions
        }elseif($_POST['uploadtype'] =='file') {
            $targetFolder = '/3rdparty/uploads/files'; // Relative to the root
            $fileTypes = array('doc','docx','pdf', 'xlsx', 'lsx'); // File extensions
        }elseif($_POST['uploadtype'] =='fileBackup') {
            $targetFolder = '/3rdparty/uploads/fileBackup'; // Relative to the root
            $fileTypes = array('rar','zip'); // File extensions
        }

        $tempFile = $_FILES['Filedata']['tmp_name'];
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

        $tam = explode('.', $_FILES['Filedata']['name']);
        $ext = end($tam);
        $renamed = md5(rand(0,200000)).'.'."$ext";

        $targetFile = rtrim($targetPath,'/') . '/' . $renamed;
        // Validate the file type

        $fileParts = pathinfo($_FILES['Filedata']['name']);

        if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

            move_uploaded_file($tempFile,$targetFile);
            //ma hoa file
            if($_POST['uploadtype'] =='video') {
                $file = $targetFile;
                $handle = fopen($file, "rb");
                $initial_contents = fread($handle, filesize($file));
                fclose($handle);
                if($initial_contents){
                    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
                    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
                    mcrypt_generic_init($td, '123456', $iv);
                    $encrypted_data = mcrypt_generic($td, $initial_contents);

                    $encrypted_file = @fopen($file,'wb');
                    $ok_encrypt = @fwrite($encrypted_file,$encrypted_data);


                    @fclose($encrypted_file);

                }
            }

            //duong dan file video
            echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
        }//else {
        //echo 'Invalid file type.';
        //}
    }
?>