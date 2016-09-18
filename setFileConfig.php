<?php
$action = $_GET['action'];
if($action == 'zip') {
    $content = file_get_contents('./config.json');
    $dataConfig = json_decode($content);

    $allFile = $dataConfig->files;
    if(count($allFile) > 0) {
        $folder = 'zipcode/';
        if (!is_dir($folder))
            mkdir($folder, 0777, true);
        chmod($folder, 0777);

        // increase script timeout value
        ini_set('max_execution_time', 5000);

        // create object
        $zip = new ZipArchive();
        //set date
        if ($zip->open('zipcode/filebackup.zip', ZIPARCHIVE::CREATE) !== TRUE) {
            die ("Could not open archive");
        }

        foreach ($allFile as $key=>$value) {
            if(is_file($value)) {
                $zip->addFile($value) ;
            }
        }

        $zip->close();
    }
}elseif($action == 'unzip') {

    $content = file_get_contents('./config.json');
    $dataConfig = json_decode($content);

    $allFile = $dataConfig->files;

    $data = array(
        "name" => $dataConfig->name,
        "version" => $dataConfig->version,
        "description" => $dataConfig->description,
        "author" => $dataConfig->author,
        "script" => $dataConfig->script,
        "keywords" => $dataConfig->keywords,
        "files" => serialize($dataConfig->files),
        "license" => $dataConfig->license
    );

    $zip = new ZipArchive;

    $zipped = $zip->open('./zipcode/filebackup.zip');


    if ($zipped) {
        $zip->extractTo('./zipcode');
        $zip->close();
    }
}else{
    die();
}
?>