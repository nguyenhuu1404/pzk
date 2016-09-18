<?php
class PzkPackageModel {


    public function install($targetFile, $nameConfig) {
            //get content new config file
            $zip = new ZipArchive;
            $zip->open($targetFile);
            $fileConfig = "config/".$nameConfig.".json";
            $newConfig = json_decode($zip->getFromName($fileConfig), true);
            $zip->close();

            $newVersion = $newConfig['version'];
            if(isset($newConfig['dependencies'])) {
                $newDependencies =  $newConfig['dependencies'];

            }else{
                $newDependencies = array();
            }

            //check config file exist
            $checkFileExit = file_exists(BASE_DIR."/config/".$nameConfig.".json");

            if(!$checkFileExit) {
                $oldVersion = 0;
            }else {
                //get content old config file
                $redOldConfig = file_get_contents(BASE_DIR."/config/".$nameConfig.".json");
                //xu li version
                $oldConfig = json_decode($redOldConfig, true);
                $oldVersion = $oldConfig['version'];
            }

            $check = version_compare($newVersion, $oldVersion);//$new>$old retrun 1; $new < $old return -1; $new = $old retrun 0

            if($check == 1) {

                $error = array();
                foreach($newDependencies as $item) {
                    $checkFileExit = file_exists(BASE_DIR."/config/".$item.".json");
                    if(!$checkFileExit) {
                        $error[] = 'Bạn phải cài plugin '.$item .' trước';
                    }
                }


                if(count($error) > 0 ) {

                    $result = array(
                        'success' => true,
                        'errorno' => PACKAGE_DEPEN,
                        'data' => null,
                        'message' => $error
                    );

                }else {
                    $data = array(
                        "name" => $newConfig['name'],
                        "version" => $newConfig['version'],
                        "description" => $newConfig['description'],
                        "author" => $newConfig['author'],
                        "script" => $newConfig['script'],
                        "keywords" => $newConfig['keywords'],
                        "files" => json_encode($newConfig['files']),
                        "type" => $newConfig['type'],
                        "settings" => json_encode($newConfig['settings']),
                        "license" => $newConfig['license'],
                        "status" => 1
                    );

                    //unzip folder update to document root
                    $this->unzip($targetFile, './');

                    //insert to database
                    $data['createdId'] = pzk_session()->getAdminId();
                    $data['created'] = date(DATEFORMAT, $_SERVER['REQUEST_TIME']);

                    //cap nhat thanh cong
                    $result = array(
                        'success' => true,
                        'errorno' => PACKAGE_SUCCESS,
                        'data' => $data,
                        'message' => 'Cập nhật thành công'
                    );
                }
            }else{
                //error version
                $result = array(
                    'success'   => false,
                    'errorno'   => PACKAGE_ERROR_VERSION,
                    'data'      => null,
                    'message'    => 'Bạn hãy kiểm tra lại file config, đây không phải là phiên bản mới nhất'
                );
            }


        return $result;
    }



    public function unzip($targetFile, $targetFolder) {

        $zip = new ZipArchive;
        $zipped = $zip->open($targetFile);

        if ($zipped) {
            $zip->extractTo($targetFolder);
            $zip->close();
        }
    }

    public function build($namePackage, $folder) {

        $fileConfig = "config/".$namePackage.".json";

        $content = file_get_contents(BASE_DIR.'/'.$fileConfig);
        $dataConfig = json_decode($content, true);

        $allFile = $dataConfig['files'];
        $allFile[] = $fileConfig;
		var_dump($allFile);


        if(count($allFile) > 0) {
            //$folder = 'zipcode/';
            if (!is_dir($folder))
                mkdir($folder, 0777, true);
            chmod($folder, 0777);

            // increase script timeout value
            ini_set('max_execution_time', 5000);

            // create object
            $zip = new ZipArchive();
			if ($zip->open($folder.$namePackage.'.zip', ZIPARCHIVE::CREATE) !== TRUE) {
                die ("Could not open archive");
            }

            foreach ($allFile as $value) {
                if (is_file(BASE_DIR . '/'. $value)) {
                    $zip->addFile(BASE_DIR . '/'. $value, $value);
                }else if(is_dir(BASE_DIR . '/'. $value)){					
					foreach (glob("$value/*.*") as $file) {
						$zip->addFile($file);
					}
					foreach (glob("$value/*/*.*") as $file) {
						$zip->addFile($file);
					}
					foreach (glob("$value/*/*/*.*") as $file) {
						$zip->addFile($file);
					}
					foreach (glob("$value/*/*/*/*.*") as $file) {
						$zip->addFile($file);
					}
					foreach (glob("$value/*/*/*/*/*.*") as $file) {
						$zip->addFile($file);
					}
					foreach (glob("$value/*/*/*/*/*/*.*") as $file) {
						$zip->addFile($file);
					}
                } else {
					echo $value . ' not found<br />';
				}


            }

            $zip->close();


        }
    }


    public function remove($namePlugin){
        $fileConfig = BASE_DIR."/config/".$namePlugin.".json";

        $content = file_get_contents($fileConfig);
        $dataConfig = json_decode($content, true);

        $files = $dataConfig['files'];
        $files[] = BASE_DIR.'/config/'.$namePlugin.'.json';

        foreach ($files as $key => $file) {
            if (is_file($file)) {
                @unlink($file);
            }else {
                if (is_dir($file)) {
                    dir_remove($file);
                    rmdir($file);
                }
            }


        }
    }


    public function addFileTree($dir) {
        $zip = new ZipArchive();
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file") && !is_link($dir)) ? $this->addFileTree("$dir/$file") : $zip->addFile("$dir/$file");
        }

    }
}
?>