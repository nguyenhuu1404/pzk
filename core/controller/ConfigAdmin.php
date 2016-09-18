<?php
/**
 *
 * @author: Huunv
 * date: 21/4
 */
class PzkConfigAdminController extends PzkBackendController {
    public $masterStructure = 'admin/home/index';
    public $masterPosition = 'left';
    public $table = false;
    public $customModule = false;
    public $menuLinks = false;
    public $addLabel = false;
    public $databaseFieldSettings = false;
    public $writeFields = false;
    public function __construct() {
        parent::__construct();
        //get module
        $controller = pzk_request('controller');
        $contrParts = explode('_', $controller);
        array_shift($contrParts);//get first array value
        $this->setModule(implode('_', $contrParts));
        if(!$this->getTable()) {
            $this->setTable($this->getModule());
        }
        //set session for menu
        $controller_name = pzk_request('controller');
        $menu =  pzk_session(MENU, $controller_name);
    }

    public function indexAction()
    {
        $this->initPage()->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/index')
            ->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');

        $this->display();
    }

    public function editAction() {
        $this->initPage()->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/edit')
            ->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');

        $this->display();
    }
    public function getAddData() {
    	$fields = pzk_request()->getConfig() . 'Fields';
        return pzk_request()->getFilterData($this->$fields);
    }
    public function writePostAction() {
    	pzk_notifier_add_message('Sửa cấu hình thành công', 'success');
        $row = $this->getAddData();
        	
        if(pzk_session()->getStoreType() == 'app') {
        	$config = pzk_app_store()->getConfig();
        } else {
        	$config = pzk_site_store()->getConfig();
        }
        if(!$config) {
        	$config = array();
        }
        $config = merge_array($config, $row);
        if(pzk_session()->getStoreType() == 'app') {
        	file_put_contents("app/".pzk_app()->getPathByName()."/configuration.php", '<?php pzk_store_instance("'.pzk_request()->getAppPath() .'")->setConfig('.var_export($config, true) . ');');
        } else {
        	file_put_contents("app/".pzk_app()->getPathByName()."/configuration.".pzk_request()->getSoftwareId().".php", '<?php pzk_store_instance("'.pzk_request()->getAppPath() . '/' . pzk_request()->getSoftwareId() .'")->setConfig('.var_export($config, true) . ');');
        }
        
    	$this->redirect('edit', array('config' => pzk_request()->getConfig()));
    }
    public function readAction() {
        $myfile = fopen("newfile.txt", "r") or die("Unable to open file!");
        echo fread($myfile,filesize("newfile.txt"));
        fclose($myfile);
    }
    
    public function changeStoreTypeAction() {
    	$storeType = pzk_request()->getStoreType();
    	pzk_session()->setStoreType($storeType);
    	$this->redirect('edit', array('config' => pzk_request()->getConfig()));
    }
}