<?php
/**
 * Xóa các file và thư mục trong một thư mục
 * @param String $dir thư mục cần xóa
 * @return boolean
 */
function dir_remove($dir) {
    $files = dir_list($dir);
    foreach ($files as $file) {
        (is_dir("$dir/$file") && !is_link($dir)) ? dir_remove("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}
/**
 * Lấy toàn bộ file và folder trong một thư mục
 * @param String $dir thư mục cần duyệt
 * @param bool $recusive Duyệt cả trong thư mục con
 * @return Array các file và thư mục
 */
function dir_list($dir, $recusive=false) {
    $listFile = array();
    if($recusive){
        $files = array_diff(scandir($dir), array('.','..'));
        foreach($files as $file) {
            if(strpos($file, '.')) {
                $listFile[] = $file;
            }
        }
        foreach ($files as $file) {
            if(is_dir("$dir/$file") && !is_link($dir)) {
                $fileChilds = dir_list("$dir/$file");
                foreach($fileChilds as $fileChild) {
                    if(strpos($fileChild, '.')) {
                        $listFile[] =   $fileChild;
                    }
                }
            }  else {
                $listFile[] = $dir.'/'.$file;
            }
        }
    }else{
        $listFile = array_diff(scandir($dir), array('.','..'));

    }
    return $listFile;
}

/**
 * Lấy danh sách các thư mục con của một thư mục
 * @param String $dir thư mục cần lấy
 * @param bool $recusive Lấy cả trong thư mục con
 * @return Array các thư mục
 */
function dir_dirs($dir, $recusive = false) {
	$listFile = array();
	$files = array_diff(scandir($dir), array('.','..'));
	foreach($files as $file) {
		if(is_dir("$dir/$file")) {
			$listFile[] = $file;
		}
	}    
    return $listFile;
}