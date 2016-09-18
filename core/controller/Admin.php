<?php
require_once __DIR__ . '/Constant.php';

class PzkAdminController extends PzkBackendController {
	public $table = false;
    public $childTables = false;
	
	public $customModule = false;
	public $logable = false;
	public $logFields = 'id, name';
	public function __construct() {
        parent:: __construct();//goi lop cha
		$controller = pzk_request('controller');
		$contrParts = explode('_', $controller);
		array_shift($contrParts);
		$this->setModule(implode('_', $contrParts));
		if(!$this->getTable()) {
			$this->setTable($this->getModule());
		}
		
		$controller_name = pzk_request('controller');
		$menu =  pzk_session(MENU, $controller_name);

	}
	public $_session = false;
	public $_filterSession = false;
	
	public $editActions = array(
		array(
			'name'	=> BTN_EDIT_AND_CLOSE,
			'label'	=> 'Update'
		)
	);
	
	public $addActions = array(
		array(
			'name'	=> BTN_ADD_AND_CLOSE,
			'label'	=> 'Add'
		)
	);
	/**
	 * 
	 * @return PzkSGStorePrefix
	 */
	public function getSession() {
		if(!$this->_session) {
			$this->_session = new PzkSGStorePrefix(pzk_session());
			$this->_session->setPrefix($this->getTable());
		}
		return $this->_session;
	}
	
	public function getFilterSession() {
		if(!$this->_filterSession) {
			$this->_filterSession = new PzkSGStorePrefix($this->getSession());
			$this->_filterSession->setPrefix('filter');
		}
		return $this->_filterSession;
	}
	public function changeStatusAction() {
		$id = pzk_request()->getSegment(3);
		$entity = _db()->getTableEntity($this->getTable());
		$entity->load($id);
		$status = 1 - $entity->getStatus();
		$entity->update(array('status' => $status));
		$this->redirect('index');
	}
	public function changeOrderByAction() {
		$this->getSession()->setOrderBy(pzk_request()->getOrderBy());
		if(pzk_request()->getIsAjax()) {
			echo 1;
		} else {
			$this->redirect('index');
		}
	}
    public function filterAction() {
        $this->getFilterSession()->set(pzk_request()->getIndex(), pzk_request()->getSelect());
        if(pzk_request()->getIsAjax()) {
			echo 1;
		} else {
			$this->redirect('index');
		}
    }

	public function changePageSizeAction() {
		$this->getSession()->setPageSize(pzk_request()->getPageSize());
		if(pzk_request()->getIsAjax()) {
			echo '1';
		} else {
			$this->redirect('index');
		}
		
	}
	
	public function searchPostAction() {
		$action	=	pzk_request('submit_action');
		if($action != ACTION_RESET){
			$this->getSession()->setKeyword(pzk_request()->getKeyword());
			$this->getSession()->setPageNum(pzk_request()->getPageNum());
		}else{
			$this->getSession()->delKeyword();
			$this->getSession()->delType();
			$this->getSession()->delCategoryId();
			$this->getSession()->delStatus();
			$this->getSession()->delCheck();
			$this->getSession()->delDeleted();
			$this->getSession()->delPageNum();
		}
		$this->redirect('index');
	}
    public function searchFilterAction() {
        $action	=	pzk_request('submit_action');
        if($action != ACTION_RESET){
        	$this->getSession()->setKeyword(pzk_request()->getKeyword());
        	$this->getSession()->delPageNum();
        }else{
        	$this->getSession()->delKeyword();
        	$this->getSession()->delOrderBy();
            $fields = $this->getFilterFields();
            if(!empty($fields)) {
                foreach($fields as $val) {
                    $this->getSession()->del($val['type'].$val['index']);
                }
            }

        }
		if(pzk_request()->getIsAjax()) {
			echo 1;
		} else {
			$this->redirect('index');
		}
    }
	public function searchAction() {
		$this->getSession()->setKeyword(pzk_request()->getKeyword());
		if(pzk_request()->getIsAjax()) {
			echo 1;
		} else {
			$this->redirect('index');
		}
	}
	public function indexAction() {
		$this->initPage()
		->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/index')
		->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');
		$this->prepareListDisplay();
		$this->display();
	}
	
	public function prepareListDisplay() {
		
	}
	
	public function addAction() {
		$module = $this->parse('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/add');
		$module->setModule($this->getModule());
		$module->setFieldSettings($this->getAddFieldSettings());
		$module->setActions($this->getAddActions());
		$module->setLabel($this->getAddLabel());
		$row = pzk_validator()->getEditingData();
		if($row) {
			$module->getFormObject()->setItem($row);
		} else {
			$row = $this->getAddData();
			if($row) {
				if($module->getFormObject())
					$module->getFormObject()->setItem($row);
			}
		}
		$page = $this->initPage()
			->append($module)
			->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');
		
		$this->prepareAddDisplay();
		$page->display();
	}
	public function prepareAddDisplay() {
		
	}
	public function addPostAction() {
		$row 		= $this->getAddData();
		$backHref 	= pzk_request('backHref');
		if($this->validateAddData($row)) {

			$id 	= $this->add($row);
			pzk_notifier()->addMessage('Thêm thành công');
			if(pzk_request()->get(BTN_ADD_AND_CLOSE)) {
				if($backHref) {
					$this->redirect($backHref);
				} else {
					$this->redirect('index');
				}
			} else if(pzk_request()->get(BTN_ADD_AND_CONTINUE)) {
				$this->redirect('add');
			} else if(pzk_request()->get(BTN_ADD_AND_EDIT)) {
				$this->redirect('edit/' . $id);
			} else {
				if($backHref) {
					$this->redirect($backHref);
				} else {
					$this->redirect('index');
				}
				
			}
			
		} else {
			pzk_validator()->setEditingData($row);
			$this->redirect('add', array('backHref' => $backHref));
		}
	}
	public function getAddData() {
		return pzk_request()->getFilterData($this->getAddFields());
	}
	public function validateAddData($row) {
		return $this->validate($row, $this->getAddValidator()? $this->getAddValidator(): null);
	}
	public function add($row) {
		$row['creatorId'] = pzk_session()->getAdminId();
        $row['created'] = date(DATEFORMAT, $_SERVER['REQUEST_TIME']);
		$entity = _db()->getTableEntity($this->getTable());
		$entity->setData($row);
		$entity->save();
		if($this->getLogable()) {
			$logEntity = _db()->getTableEntity('pzk_admin_log');
			$logFields = explodetrim(',', $this->getLogFields());
			$brief = pzk_session()->getAdminUser() . ' Thêm mới bản ghi: ' . $this->getModule();
			foreach ($logFields as $field) {
				$brief .= '[' . $field . ': ' . (isset($row[$field]) ? $row[$field] : '') . ']';
			}
			$logEntity->setUserId(pzk_session()->getAdminId());
			$logEntity->setCreated(date('Y-m-d H:i:s'));
			$logEntity->setActionType('add');
			$logEntity->setAdmin_controller('admin_'.$this->getModule());
			$logEntity->setBrief($brief);
			$logEntity->save();
		}
		return $entity->getId();
	}
    public function editAllCatePostAction() {
        $row = $this->getEditData();
        if(!empty($row['categoryIds'])) {
            $str = ','.implode(',', $row['categoryIds']).',';
            $row['categoryIds'] = $str;
        }else {
            $row['categoryIds'] = '';
        }
        
        if(!empty($row['topic_id'])) {
        	$str = ','.implode(',', $row['topic_id']).',';
        	$row['topic_id'] = $str;
        }else {
        	$row['topic_id'] = '';
        }
		
        if($this->validateEditData($row)) {
            $this->edit($row);
            pzk_notifier()->addMessage('Cập nhật thành công');
            $this->redirect('index');
        } else {
            pzk_validator()->setEditingData($row);
            $this->redirect('edit/' . pzk_request()->getId());
        }
    }
	public function editPostAction() {
		$row = $this->getEditData();
		$backHref 	= pzk_request('backHref');
		if($this->validateEditData($row)) {

			$this->edit($row);
			pzk_notifier()->addMessage('Cập nhật thành công');
			if(pzk_request()->get(BTN_EDIT_AND_CLOSE)) {
				if($backHref) {
					$this->redirect($backHref);
				} else {
					$this->redirect('index');
				}
			} else if (pzk_request()->get(BTN_EDIT_AND_CONTINUE)) {
				$this->redirect('edit/' . pzk_request()->getId());
			} else if(pzk_request()->get(BTN_EDIT_AND_DETAIL)) {
				$this->redirect('detail/' . pzk_request()->getId());
			} else {
				if($backHref) {
					$this->redirect($backHref);
				} else {
					$this->redirect('index');
				}
			}
			
		} else {
			pzk_validator()->setEditingData($row);
			$this->redirect('edit/' . pzk_request()->getId());
		}
	}
	public function getEditData() {
		return pzk_request()->getFilterData($this->getEditFields());
	}
	public function validateEditData($row) {
		return $this->validate($row, $this->getEditValidator() ? $this->getEditValidator() : null);
	}
	public function edit($row) {
        $row['modifiedId'] = pzk_session()->getAdminId();
        $row['modified'] = date(DATEFORMAT,$_SERVER['REQUEST_TIME']);
		$entity = _db()->getTableEntity($this->getTable());
		$entity->load(pzk_request()->getId());
		
		//set index owner
		$adminmodel = pzk_model('admin');
		$controller = pzk_request('controller');
		 
		$checkIndexOwner = $adminmodel->checkActionType('editOwner', $controller, pzk_session('adminLevel'));
		
		if($checkIndexOwner){
			if($entity->getCreatorId == pzk_session()->getAdminId()) {
				$entity->update($row);
				$entity->save();
				if($this->getLogable()) {
					$logEntity = _db()->getTableEntity('pzk_admin_log');
					$logFields = explodetrim(',', $this->getLogFields());
					$brief = pzk_session()->getAdminUser() . ' Sửa bản ghi: ' . $this->getModule();
					foreach ($logFields as $field) {
						if(1 || $entity->get($field) !== @$row[$field])
							$brief .= '[' . $field . ': ' . $entity->get($field) . ']';
					}
					$brief .= ' thành ';
					foreach ($logFields as $field) {
						if(1 || $entity->get($field) !== @$row[$field])
							$brief .= '[' . $field . ': ' . (isset($row[$field]) ? $row[$field] : '') . ']';
					}
					$logEntity->setUserId(pzk_session()->getAdminId());
					$logEntity->setCreated(date('Y-m-d H:i:s'));
					$logEntity->setActionType('edit');
					$logEntity->setAdmin_controller('admin_'.$this->getModule());
					$logEntity->setBrief($brief);
					$logEntity->save();
				}
			}
		}else{
			$entity->update($row);
			$entity->save();
			
			if($this->getLogable()) {
				$logEntity = _db()->getTableEntity('pzk_admin_log');
				$logFields = explodetrim(',', $this->getLogFields());
				$brief = pzk_session()->getAdminUser() . ' Sửa bản ghi: ' . $this->getModule();
				foreach ($logFields as $field) {
					if(1 || $entity->get($field) !== @$row[$field])
						$brief .= '[' . $field . ': ' . $entity->get($field) . ']';
				}
				$brief .= ' thành ';
				foreach ($logFields as $field) {
					if(1 || $entity->get($field) !== @$row[$field])
						$brief .= '[' . $field . ': ' . (isset($row[$field]) ? $row[$field] : '') . ']';
				}
				$logEntity->setUserId(pzk_session()->getAdminId());
				$logEntity->setCreated(date('Y-m-d H:i:s'));
				$logEntity->setActionType('edit');
				$logEntity->setAdmin_controller('admin_'.$this->getModule());
				$logEntity->setBrief($brief);
				$logEntity->save();
			}
		}
		
		
	
	}
    public function importAction() {
        $this->initPage();
        $this->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/import')
            ->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');
        $this->display();
    }
	public function editAction($id) {
		
		//set edit owner
		$adminmodel = pzk_model('admin');
		$controller = pzk_request('controller');
		 
		$checkEditOwner = $adminmodel->checkActionType('editOwner', $controller, pzk_session('adminLevel'));
		
		if($checkEditOwner){
			
			$entity = _db()->getEntity('table')->setTable($this->table);
			$entity->load($id);
			
			if($entity->getCreatorId() != pzk_session()->getAdminId()) {
				$view = pzk_parse('<div layout="erorr/erorr" />');
				$view->display();
				pzk_system()->halt();
			}
		}
			
		
		
		$module = $this->parse('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/edit');
		$module->setItemId($id);
		$module->setModule($this->getModule());
		$module->setFieldSettings($this->getEditFieldSettings());
		$module->setActions($this->getEditActions());
		$module->setLabel($this->getEditLabel());
		$row = pzk_validator()->getEditingData();
		if($row) {
			if($module->getFormObject())
				$module->getFormObject()->setItem($row);
		}
		$this->initPage()
			->append($module)
			->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');
		$this->prepareEditDisplay();
		$this->display();
	}
	public function prepareEditDisplay() {
		
	}
	public function detailAction($id) {
		$module = $this->parse('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/detail');
		$module->setItemId($id);
		$this->initPage()
			->append($module)
			->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');
		if($childList = pzk_element($this->getModule().'Children')){
			$childList->setParentId($id);
		}
		$this->prepareDetailDisplay();
		$this->display();
	}
	public function prepareDetailDisplay() {
		if($detail = pzk_element('detail')) {
			if($fieldSettings = $this->getDetailFieldSettings()) {
				$detail->setDisplayFields($fieldSettings['displayFields']);
			}
			
		}
	}
	public function delAction($id) {
		$module = $this->parse('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/del');
		$module->setItemId($id);
		$this->initPage()
			->append($module)
			->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right')
			->display();
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
        
            if($this->getLogable()) {
            	$logEntity = _db()->getTableEntity('pzk_admin_log');
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
    public function delAllAction() {
        if(pzk_request('ids')) {
            $arrIds = json_decode(pzk_request()->getIds());
            if(count($arrIds) >0) {
                    _db()->useCB()->delete()->from($this->getTable())
                    ->where(array('in', 'id', $arrIds))->result();

                echo 1;
            }

        }else {
            pzk_system()->halt();
        }


    }
	public function uploadAction() {
		$this->initPage()
			->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/upload')
			->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right')
			->display();
	}
	public function uploadPostAction() {
		$row = $this->getUploadData();
        //debug($row);die();
		if($this->validateUploadData($row)) {
			$this->upload($row);
			pzk_notifier()->addMessage('Thêm thành công');
			$this->redirect('index');
		} else {
			pzk_validator()->setEditingData($row);
			$this->redirect('upload');
		}
	}
	public function getUploadData() {
		return pzk_request()->getFilterData($this->getUploadFields());
	}
	public function validateUploadData($row) {
		return $this->validate($row, $this->getUploadValidator() ? $this->getUploadValidator() : null);
	}
	public function upload($row) {
		$entity = _db()->getTableEntity($this->getTable());
		$entity->setData($row);
		$entity->save();
	}

    public function doUpload($filename, $dir, $allowed, $row) {
        if(isset($_FILES[$filename])) {
            if(!empty($_FILES[$filename]['name'])){
                // Kiem tra xem file upload co nam trong dinh dang cho phep
                if(in_array(strtolower($_FILES[$filename]['type']), $allowed)) {
                    // Neu co trong dinh dang cho phep, tach lay phan mo rong
                    $ext = end(explode('.', $_FILES[$filename]['name']));
                    $renamed = md5(rand(0,200000)).'.'."$ext";

                    if(move_uploaded_file($_FILES[$filename]['tmp_name'], $dir.$renamed)) {
                        if(!empty($row)) {
                            $row[$filename] = $renamed;
                            $id = pzk_request('id');
                            if(isset($id)) {
                                if($this->validateEditData($row)) {
                                    $data = _db()->useCB()->select('url')->from('video')->where(array('id', $id))->result_one();
                                    $url = BASE_DIR."/3rdparty/uploads/videos/".$data['url'];
                                    unlink($url);
                                    $this->edit($row);
                                    pzk_notifier()->addMessage('Cập nhật thành công');
                                    $this->redirect('index');
                                } else {
                                    pzk_validator()->setEditingData($row);
                                    $this->redirect('edit/' . pzk_request('id'));
                                }
                            }else {
                                if($this->validateAddData($row)) {
                                    $this->add($row);
                                    pzk_notifier()->addMessage('Thêm thành công');
                                    $this->redirect('index');
                                } else {
                                    pzk_validator()->setEditingData($row);
                                    $this->redirect('add');
                                }
                            }
                        }
                    } else {
                        $errors = "upload error";
                    }
                } else {
                    // FIle upload khong thuoc dinh dang cho phep
                    $errors = "File upload không thuộc định dạng cho phép!";
                    $this->redirect('index');
                }
            } else {
                if(!empty($row)) {
                    $id = pzk_request('id');
                    if(isset($id)) {
                        if($this->validateEditData($row)) {

                            $this->edit($row);
                            pzk_notifier()->addMessage('Cập nhật thành công');
                            $this->redirect('index');
                        } else {
                            pzk_validator()->setEditingData($row);
                            $this->redirect('edit/' . pzk_request('id'));
                        }
                    }else {
                        if($this->validateAddData($row)) {
                            $this->add($row);
                            pzk_notifier()->addMessage('Thêm thành công');
                            $this->redirect('index');
                        } else {
                            pzk_validator()->setEditingData($row);
                            $this->redirect('add');
                        }
                    }
                }
            } // END isset $_FILES



        }



        // Xoa file da duoc upload va ton tai trong thu muc tam
        if(isset($_FILES[$filename]['tmp_name']) && is_file($_FILES[$filename]['tmp_name']) && file_exists($_FILES[$filename]['tmp_name'])) {
            unlink($_FILES[$filename]['tmp_name']);
        }

        if(isset($errors)) {
            pzk_notifier_add_message($errors, 'danger');
        }

    }
	public function saveOrderingsAction() {
		$orderings = pzk_request()->getOrderings();
		$field = pzk_request()->getField();
		foreach($orderings as $id => $val) {
			$entity = _db ()->getTableEntity ( $this->getTable() )->load ( $id );
			$entity->update ( array (
					$field => $val
			) );
		}
	}
	public function saveOrderingAction(){
		$field = pzk_request()->getField();
		$id = pzk_request()->getId();
		$value = pzk_request()->getValue();
		$entity = _db ()->getTableEntity ( $this->getTable() )->load ( $id );
		$entity->update ( array (
				$field => $value
		) );
		echo $value;
	}
	
	public function verifyAction() {
		$arr = array();
		echo json_encode($arr);
	}
	
	public function aliasAction() {
		$items = _db()->selectAll()->from($this->getTable())->whereAlias('')->result();
		foreach($items as $item) {
			$alias = khongdauAlias(pzk_or(@$item['title'], @$item['name']));
			_db()->update($this->getTable())
				->set(array('alias' => $alias))
				->whereId($item['id'])->result();
		}
		$this->redirect('index');
	}
}
