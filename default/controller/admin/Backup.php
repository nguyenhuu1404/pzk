<?php
class PzkAdminBackupController extends PzkGridAdminController {
	public $table = 'admin_backup';

    public function getSortFields() {
    	return PzkSortConstant::gets('id', 'admin_backup');
    }
	public $addFields = 'name, url';
	public $logable = true;
	public $logFields = 'name, url';
	
	public function getListFieldSettings() {
		return PzkListConstant::gets('nameOfBackup, urlOfBackup, created', 'admin_backup');
	}
	
	public function add($row) {
		$row['name'] = 'backup_' . date('Ymd_His');
		$this->backup($row['name']);
		$row['url'] = '/backup/' . $row['name'] . '.zip';
		parent::add($row);
	}
	
	public function backup($fileName) {
		// Create Backup image Folder
        $folder = BASE_DIR . '/backup/';
        if (!is_dir($folder))
            mkdir($folder, 0777, true);
        chmod($folder, 0777);
        //get all file in tinymce
        $parent_files = glob(BASE_MEDIA_DIR . '/3rdparty/Filemanager/source/*');
        $sub_files1 = glob(BASE_MEDIA_DIR . '/3rdparty/Filemanager/source/*/*');
        $sub_files2 = glob(BASE_MEDIA_DIR . '/3rdparty/Filemanager/source/*/*/*');

        //get all file in upload
        $parentUploadFiles = glob(BASE_MEDIA_DIR . '/3rdparty/uploads/*');
        $subUploadFiles = glob(BASE_MEDIA_DIR . '/3rdparty/uploads/*/*');
		
        $allfile = array_merge($parent_files?$parent_files: array(), $sub_files1?$sub_files1: array(), $sub_files2?$sub_files2: array(),$parentUploadFiles?$parentUploadFiles: array(),$subUploadFiles?$subUploadFiles: array());
        // increase script timeout value
        ini_set('max_execution_time', 5000);

        // create object
        $zip = new ZipArchive();
        //set date
        if ($zip->open(BASE_DIR . '/backup/'.$fileName.'.zip', ZIPARCHIVE::CREATE) !== TRUE) {
            die ("Could not open archive");
        }

        foreach ($allfile as $key=>$value) {
            if(is_file($value)) {
				$name = str_replace(BASE_MEDIA_DIR . '/','', $value);
                $zip->addFile($value, $name) ;
            }
        }

        $zip->close();
        pzk_notifier()->addMessage('Backup thành công');
	}
	
	public function delPostAction() {
		$id = pzk_request()->getId();
		$row = _db()->getTableEntity('admin_backup')->load($id);
		unlink(BASE_DIR . $row->getUrl());
		parent::delPostAction();
	}
	
	public function downloadAction($id) {
		$row = _db()->getTableEntity('admin_backup')->load($id);
		header('Location: ' . BASE_URL . $row->getUrl());
	}
}
	
?>