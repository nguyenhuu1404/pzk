<?php
class pzkAdminPackagesController extends pzkGridAdminController {
    public $table = 'packages';
	public $logable = true;
	public $logFields = 'name, version,status';
    public $listFieldSettings = array(
        array(
            'index' => 'name',
            'type' => 'text',
            'label' => 'Tên phiên bản'
        ),
        array(
            'index' => 'version',
            'type' => 'text',
            'label' => "Phiên bản"
        ),
        array(
            'index' => 'status',
            'type' => 'status',
            'label' => 'status'
        ),
        array(
            'index' => 'none',
            'type' => 'link',
            'label' => 'Config',
            'link' => '/admin_packages/config/'
        ),
        array(
            'index' => 'none',
            'type' => 'link',
            'label' => 'Export',
            'link' => '/admin_packages/export/'
        )
    );
    //search by field
    public $searchFields = array('name');
    //search lable
    public $searchLables = 'Tên module';
    //sort by
    public $sortFields = array(
        'id desc' => 'id giảm',
        'id asc' => 'id tăng'
    );
    //add menu link
    public $links = array(

        array(
            'name' => 'update',
            'href' => '/admin_packages/update'
        )
    );

    public function updateAction() {
        $module = $this->parse('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/update');
        $module->setModule($this->getModule());
        $module->setFieldSettings($this->getAddFieldSettings());
        $module->setActions($this->getAddActions());

        $page = $this->initPage()
            ->append($module);

        $page->display();
    }
    public function updatePostAction(){
        if($_FILES) {
            $data = _db()->select('*')->fromPackages()->whereStatus('1')->whereName('jquery')->whereType('plugin')->result_one();
            $nameJquery = $data['name'];

            $targetFolder = BASE_DIR.'/packages';
            if (!is_dir($targetFolder))
                mkdir($targetFolder, 0777, true);
            chmod($targetFolder, 0777);

            $filename = 'filename';
            $fileTypes = array('zip');
            $nameConfig = str_replace('.zip','',$_FILES[$filename]['name']);
            if(!$nameJquery && $nameConfig != 'jquery' ){
                pzk_notifier_add_message('Bạn phải cài đặt jquery plugin', 'danger');
                $this->redirect('update');
            }else {

                $tempFile = $_FILES[$filename]['tmp_name'];
                $targetPath = $targetFolder;

                $tam = explode('.', $_FILES[$filename]['name']);
                $ext = end($tam);
                $renamed = md5(rand(0, 200000)) . '.' . "$ext";

                $targetFile = rtrim($targetPath, '/') . '/' . $renamed;
                // Validate the file type

                $fileParts = pathinfo($_FILES[$filename]['name']);


                if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                    move_uploaded_file($tempFile, $targetFile);
                    //xu li install plugin
                    $backupfile = pzk_model('Package');
                    $result = $backupfile->install($targetFile, $nameConfig);
                    //remove file
                    @unlink($targetFile);

                    switch ($result['errorno']) {
                        case PACKAGE_SUCCESS : {
                            pzk_notifier()->addMessage($result['message']);
                            $entity = _db()->getTableEntity($this->getTable());
                            $entity->loadWhere(array('name', $result['data']['name']));
                            $result['data']['id'] = $entity->getId();
                            $entity->setData($result['data']);
                            $entity->save();
                            $this->redirect('index');
                            break;
                        }
                        case PACKAGE_ERROR_VERSION: {
                            pzk_notifier_add_message($result['message'], 'danger');
                            $this->redirect('update');
                            break;
                        }
                        case PACKAGE_DEPEN: {
                            foreach($result['message'] as $error){
                                pzk_notifier_add_message($error, 'danger');
                            }
                            $this->redirect('update');
                            break;
                        }

                    }

                } else {
                    // error fomat file no zip

                    pzk_notifier_add_message('Chỉ chấp nhận file zip', 'danger');
                    $this->redirect('update');
                }

            }

        }
    }

    public function configAction($id) {
        $item = _db()->getTableEntity($this->getTable())->load($id);
        $settings = json_decode($item->getSettings(), true);
        $module = $this->parse('<core.form />');
        $module->setModule($this->getModule());
        $module->setFieldSettings($settings);
        $module->setAction('/admin_packages/configPost/'.$id);
        $module->setActions($this->getEditActions());
        $module->setBackLabel('Quay lại');
        $module->setBackHref('/admin_packages/index');
        $itemData = array();
        foreach ($settings as $setting) {
            $itemData[$setting['index']] = pzk_config($setting['index']);
        }

        $module->setItem($itemData);
        $this->initPage()
            ->append($module)
            ->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');
        $this->prepareEditDisplay();
        $this->display();
    }

    public function configPostAction($id) {
        $item = _db()->getTableEntity($this->getTable())->load($id);
        $settings = json_decode($item->getSettings(), true);
        $row = array();
        foreach($settings as $setting) {
            $row[$setting['index']] = pzk_request($setting['index']);
        }
        $config = pzk_config();
        if(!$config) {
            $config = array();
        }

        $config = merge_array($config, $row);

        if(pzk_session()->getStoreType() == 'app') {
            file_put_contents("app/".pzk_app()->getPathByName()."/configuration.php", '<?php pzk_store_instance("'.pzk_request()->getAppPath() .'")->setConfig('.var_export($config, true) . ');');
        } else {
            file_put_contents("app/".pzk_app()->getPathByName()."/configuration.".pzk_request()->getSoftwareId().".php", '<?php pzk_store_instance("'.pzk_request()->getAppPath() . '/' . pzk_request()->getSoftwareId() .'")->setConfig('.var_export($config, true) . ');');
        }
        $this->redirect('admin_packages/config/'.$id);
    }
    public function exportAction($id) {
        $package = _db()->getTableEntity($this->getTable())->load($id);
        $data = $package->data;
        $namePackage  = $data['name'];
        $folder = 'filePackages/';


        $backupfile = pzk_model('Package');
        $backupfile->build($namePackage, $folder);

        //dowload file zip
        header("Content-disposition: attachment; filename=$namePackage.zip");
        header('Content-type: application/zip');
        readfile($folder.$namePackage.'.zip');


    }
    public function editAction($id) {

        //call one obj
        $layout = pzk_obj('core.layout');
        $layout->setColumns(array(
            array(
                'index' => 'left',
                'col'   => 3
            ),
            array(
                'index' => 'right',
                'col'   => 9
            ),

        ));
        //get list file
        $item = _db()->getTableEntity($this->table)->load($id);
        $files = json_decode($item->getFiles(), true);
        //convert page to obj
        $list = $this->parse('admin/plugin/list');
        $list->setFiles($files);
        $list->setModule($this->getModule());
        $list->setItemId($id);
        //gan new obj to property left in obj
        $list->setColumn('left');

        $edit = $this->parse('admin/plugin/edit');
        $edit->setModule($this->getModule());
        $edit->setItemId($id);
        $edit->setColumn('right');

        $layout->append($edit);
        $layout->append($list);
        //show obj
        $this->initPage();
        $this->append($layout, 'right');
        $this->display();
    }
    public function putFileAction() {
        $file = pzk_request('file');
        $fileContent = pzk_request('content');
        $link = pzk_request('link');
        file_put_contents($file, $fileContent);
        $this->redirect($link);
    }

    public function delPostAction() {

        if($this->getChildTables()) {
            foreach($this->getChildTables() as $val) {
                _db()->useCB()->delete()->from($val['table'])
                    ->where(array($val['referenceField'], pzk_request()->getId()))->result();
            }

        }
        $entity = _db()->getTableEntity($this->getTable());
        $entity->load(pzk_request()->getId());

        $dataPlugin = $entity->data;
        $namePlugin = $dataPlugin['name'];

        $package =  pzk_model('package');
        $package->remove($namePlugin);

        if($this->getLogable()) {
            $logEntity = _db()->getTableEntity('admin_log');
            $logFields = explodetrim(',', $this->getLogFields());
            $brief = pzk_session()->getAdminUser() . ' Xóa bản ghi: ' . $this->getModule();
            foreach ($logFields as $field) {
                $brief .= '[' . $field . ': ' . $entity->get($field) . ']';
            }
            $logEntity->setUserId(pzk_session()->getAdminId());
            $logEntity->setCreated(date('Y-m-d H:i:s'));
            $logEntity->setActionType('delete');
            $logEntity->setAdmin_controller('admin_'.$this->getModule());
            $logEntity->setBrief($brief);
            $logEntity->save();
        }
        $entity->delete();
        pzk_notifier()->addMessage('Xóa thành công');
        $this->redirect('index');
    }
    public function testAction() {
        $files = dir_list(BASE_DIR.'/3rdparty/bootstrap', true);
        debug($files);
    }

    function buildTree(array $elements, $parentId = 0) {
        $branch = array();
        foreach ($elements as $key1=>$element) {
            if ($element['parent'] == $parentId) {
                $children = buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }
}
?>