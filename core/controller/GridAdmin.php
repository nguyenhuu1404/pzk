<?php
class PzkGridAdminController extends PzkAdminController {
	public $masterStructure = 'admin/home/index';
	public $masterPosition = 'left';
	public $customModule = 'grid';
    public $moduleDetail = FALSE;
	public $table = false;
	public $joins = false;
	public $filterCreator = false;
	public $selectFields = '*';
	public $childTables = false;
	public $addFieldSettingTabs = false;
	public $editFieldSettingTabs = false;
	public $filterFields = false;
	public $quickFilterFields = false;
	public $links = false;
	public $listSettingType = false;
	public $listFieldSettings = array ();
	public $addLabel = 'Thêm bản ghi';
	public $addFieldSettings = array ();
	public $editFieldSettings = array ();
	public $searchFields = array ();
	public $searchLabels = false;
	public $filterFieldSettings = array ();
	
	public $sortFields = array ();
	public $exportFields = false;
	public $exportTypes = false;
	public $importFields = false;
	public $actions = array();
	public $title = false;
	public $editLabel = false;
	public $fixedPageSize = false;
	public $orderBy = false;
    //update menu
    public $updateData = false;
	public $updateDataTo = false;
	public $updateForms = array();
	public $quickMode = false;
	public $quickFieldSettings = false;
	public $detailFields = false;
	public $viewFieldSettings = false;
	public $childrenGridSettings = false;
	public $parentDetailSettings = false;
	
	public function append($obj, $position = NULL) {
		$obj = $this->parse ( $obj );
		$obj->setTable ( $this->table );
		return parent::append ( $obj, $position );
	}
	public function prepareListDisplay() {
		$grid = pzk_element ( 'list' );
		if ($grid) {
			$grid->setSortFields($this->getSortFields());
			$grid->setFields($this->getFilterFields());
			$grid->setSearchFields($this->getSearchFields());
			$grid->setSearchLabels($this->getSearchLabels());
			$grid->setListSettingType($this->getListSettingType());
			$grid->setListFieldSettings($this->getListFieldSettings());
			$grid->setExportFields($this->getExportFields());
			$grid->setExportTypes($this->getExportTypes());
			$grid->setModule($this->getModule());
			$grid->setQuickMode($this->getQuickMode());
			$grid->setQuickFieldSettings($this->getQuickFieldSettings());
			$parentMode = pzk_request()->getParentMode();
			if($parentMode) {
				$parentId = pzk_request()->getParentId();
				$parentField = pzk_request()->getParentField();
				$grid->setParentMode(true);
				$grid->setParentField($parentField);
				$grid->setParentId($parentId);
				$grid->init();
			}
			$grid->setColumnDisplay($this->getSession()->getColumnDisplay());
			
			//set links
			$grid->setLinks($this->getLinks());

			//check admin level action
			$level = pzk_session('adminLevel');
			if($level == 'Administrator') {
				$grid->setCheckAdd(true);
				$grid->setCheckEdit(true);
				$grid->setCheckDel(true);
				$grid->setCheckDialog(true);
			}else {
				$controller = pzk_request('controller');
				$adminmodel = pzk_model('admin');
				$checkAdd = $adminmodel->checkActionType('add', $controller, $level);
				$checkEdit = $adminmodel->checkActionType('edit', $controller, $level);
				$checkDel = $adminmodel->checkActionType('del', $controller, $level);
				$checkDialog = $adminmodel->checkActionType('dialog', $controller, $level);
				if($checkAdd) {
					$grid->setCheckAdd(true);
				}
				if($checkEdit) {
					$grid->setCheckEdit(true);
				}
				if($checkDel) {
					$grid->setCheckDel(true);
				}
				if($checkDialog) {
					$grid->setCheckDialog(true);
				}
			}



			if ($this->getExportFields()) {
				$grid->setExportFields($this->getExportFields());
			}
			$orderBy = false;
			if($orderBys = $this->getSession()->getOrderBys()) {
				$orderByArr = array();
				$orderByIndexes = array();
				foreach($orderBys as $field => $order) {
					$orderByArr[] = $field . ' ' . $order;
					$orderByIndexes[$field] = ($order == 'asc')? 1: 2;
				}
				$orderBy = implode(', ', $orderByArr);
				$grid->setOrderBys($orderBys);
				$grid->setOrderByIndexes($orderByIndexes);
				
			}
			if(!$orderBy) {
				$orderBy = $this->getSession()->getOrderBy();
			}
			
			$orderBy = $orderBy ? $orderBy : $this->getOrderBy();
			
			if ($orderBy) {
				$grid->setOrderBy($orderBy);
			}
			
			// joins
			if ($this->getJoins()) {
				$grid->setJoins($this->getJoins());
			}
            
			//filterCreator
			if ($this->getFilterCreator() && pzk_session()->getAdminLevel() == 'Reseller') {
                $grid->addFilter( array('column', $this->getTable(), 'creatorId') , pzk_session()->getAdminId());
            }
			
			//set index owner
			$adminmodel = pzk_model('admin');
			$controller = pzk_request('controller');
			 
			$checkIndexOwner = $adminmodel->checkActionType('indexOwner', $controller, pzk_session('adminLevel'));
			
			if($checkIndexOwner){
				 $grid->addFilter( array('column', $this->getTable(), 'creatorId') , pzk_session()->getAdminId());
			}
			
			
			// select fields
			if ($this->getSelectFields()) {
				$grid->setFields($this->getSelectFields());
			}
			// filter
			if ($this->getFilterFields()) {
				$fields = $this->getFilterFields();
				$listFieldSettings = $this->getListFieldSettings();
				foreach($listFieldSettings as $listFieldSetting) {
					if(isset($listFieldSetting['filter'])) {
						$found = false;
						foreach($fields as $filterField) {
							if($filterField['index'] == $listFieldSetting['filter']) {
								$found = true;
								break;
							}
						}
						if(!$found) {
							$fields[]	= $listFieldSetting['filter'];
						}
					}
					
				}
				foreach ( $fields as $val ) {
					if(isset($val['index']) && $val['index']) {
						$value = $this->getFilterSession()->get($val ['index']);
						if (isset ( $value ) && $value != NUll) {
							if($val['index'] === 'created'){
								$condition1 = date('Y:m:d 00:00:00', $_SERVER['REQUEST_TIME']+24*60*60);
								$condition2 = date('Y:m:d 00:00:00', $_SERVER['REQUEST_TIME']);
								$condition3 = date('Y:m:d 00:00:00', $_SERVER['REQUEST_TIME']-24*60*60);
								if($value === '1'){
									$grid->addFilter ( array('column', $this->getTable(), $val ['index']) , $condition1 , 'lt');
									$grid->addFilter ( array('column', $this->getTable(), $val ['index']) , $condition2 , 'gt');
								}if($value === '2'){
									$grid->addFilter ( array('column', $this->getTable(), $val ['index']) , $condition2 , 'lt');
									$grid->addFilter ( array('column', $this->getTable(), $val ['index']) , $condition3 , 'gt');
								}
							}elseif (isset($val['like']) && $val['like'] == true) {
								$grid->addFilter ( array('column', $this->getTable(), $val ['index']) , $value, 'like');
							}
							else{
								$grid->addFilter ( array('column', $this->getTable(), $val ['index']) , $value );
							}
						}
					}
				}
			}
			// end filter
			$pageSize = pzk_or(@$this->getFixedPageSize(), $this->getSession()->getPageSize());
			if ($pageSize) {
				$grid->setPageSize($pageSize);
			}
			$requestPageNum = pzk_request()->getPage();
			$sessionPageNum = $this->getSession()->getPageNum();
			if($requestPageNum != '') {
				$sessionPageNum = $requestPageNum;
				$this->getSession()->setPageNum($sessionPageNum);
			} else {
				pzk_request()->setPage($sessionPageNum);
			}
			$grid->setPageNum($sessionPageNum);
			
			$keyword = $this->getSession()->getKeyword();
			$grid->setKeyword($keyword);
			$grid->setModule($this->getModule());
			$grid->setTitle($this->getTitle());
			$grid->setAddLabel($this->getAddLabel());
			$grid->setActions($this->getActions());
			$grid->setLayout('admin/grid/index/view/grid');
			if(pzk_request()->getIsAjax()) {
				$grid->display();
				pzk_system()->halt();
			}
			$nav = pzk_element('nav');
			//set update one field
			$nav->setUpdateData($this->getUpdateData());
			$nav->setUpdateDataTo($this->getUpdateDataTo());

			$nav->setTitle($this->getTitle());
			$nav->setSortFields($this->getSortFields());
			$nav->setFilterFields($this->getFilterFields());
			$nav->setSearchFields($this->getSearchFields());
			$nav->setSearchLabels($this->getSearchLabels());
			$nav->setOrderBy($orderBy);
			$nav->setKeyword($keyword);
			$nav->setModule($this->getModule());
			$nav->setQuickMode($this->getQuickMode());
			
			$filter = pzk_element('filter');
			$filter->setFilterFields($this->getQuickFilterFields());
			
			$updateForms = $this->getUpdateForms();
			foreach($updateForms as $formSettings) {
				$formObject = pzk_obj('core.form');
				$formObject->setData($formSettings);
				$nav->append($formObject);
			}
			
			$export = pzk_element('export');
			$export->setExportTypes($this->getExportTypes());
			$export->setExportFields($this->getExportFields());
			$export->setModule($this->getModule());
			$export->setQuickMode($this->getQuickMode());
		}
	}
	public function getQuickMode() {
		$quickMode = $this->getSession()->getQuickMode();
		if($quickMode) return $quickMode;
		return $this->quickMode;
	}
	public function changeStatusAction() {
		$id = pzk_request()->getId();
		$field = pzk_request()->getField();
		if (! $field)
			$field = 'status';
		$entity = _db ()->getTableEntity ( $this->getTable() )->load ( $id );
		$status = 1 - $entity->get($field);
		$entity->update ( array (
				$field => $status 
		) );
		if(pzk_request()->getIsAjax()) {
			echo $status;
		} else {
			$this->redirect('index');
		}
		
	}
	public function columnDisplayAction() {
		$columnDisplay = pzk_request('columnDisplay');
		$this->getSession()->setColumnDisplay($columnDisplay);
		if(pzk_request()->getIsAjax()) {
			echo $status;
		} else {
			$this->redirect('index');
		}
		
	}
    public function updateOneFieldAction() {
        if(pzk_request('ids')) {
            $arrIds = json_decode(pzk_request('ids'));
            $field = pzk_request('field');
            $data = pzk_request('data');
            $type = pzk_request('type');

            if($type == 'mutiSelect') {
                if($data[$field]) {
                    $strCateIds = ','.implode(',', $data[$field]).',';
                }else{
                    $strCateIds = '';
                }
            }elseif($type == 'select') {
                if($data[$field]) {
                    $strCateIds =  $data[$field];
                }else{
                    $strCateIds = '';
                }
            } else {
				if($data[$field]) {
                    $strCateIds =  $data[$field];
                }else{
                    $strCateIds = '';
                }
			}

            if(count($arrIds) >0) {
                
				_db()->update($this->table)->set(array($field => $strCateIds))->where(array('in', 'id', $arrIds))->result();
				
                echo 1;
            }

        }else {
            pzk_system()->halt();
        }
    }
	public function updateDataToAction() {
		if(pzk_request('ids')) {
			$arrIds = json_decode(pzk_request('ids'));

			$data = pzk_request('data');
			$formIndex = $data['index'];

			$updateDataTo = $this->getUpdateDataTo();
			foreach($updateDataTo as $val) {
				if($val['index'] == $formIndex){
					$table = $val['table'];
					$selectField = $val['selectField'];
					break;
				}
			}

			if(count($arrIds) >0) {
				foreach($arrIds as $id) {
					foreach ($selectField as $key=>$val) {
						if($key == 'id') {
							$data[$val] = $id;
						}else{
							$entity = _db()->getTableEntity($this->getTable())->load($id);
							$data[$val] = $entity->data[$key];
						}
					}
					unset($data['index']);
					$data['createdId'] = pzk_session()->getAdminId();
					$data['creatorId'] = pzk_session()->getAdminId();
					$data['created'] = date(DATEFORMAT, $_SERVER['REQUEST_TIME']);
					$entityInsert = _db()->getTableEntity($table);
					$entityInsert->setData($data);
					$entityInsert->save();
				}
				echo 1;
			}

		}else {
			pzk_system()->halt();
		}
	}
	public function workflowAction() {
		$id = pzk_request()->getId();
		$field = pzk_request() ->getField();
		$value = pzk_request()->getValue();
		if (! $field)
			$field = 'status';
		$entity = _db()->getTableEntity($this->getTable())->load( $id );
		$oldValue = $entity->data[$field];
		$fieldSettings = null;
		foreach ($this->getListFieldSettings() as $fs) {
			if($fs['index'] == $field) {
				$fieldSettings = $fs;
				break;
			}
		}
		$rules = $fieldSettings['rules'];
		$states = $fieldSettings['states'];
		$rule = $rules[$oldValue][$value];
		if(isset($rule['adminLevel'])) {
			$adminLevel = pzk_session()->getAdminLevel();
			$adminLevels = explodetrim(',', $rule['adminLevel']);
			if($adminLevel != 'Administrator' &&  !in_array($adminLevel, $adminLevels)) {
				pzk_notifier_add_message('Bạn không có quyền thay đổi dữ liệu này', 'danger');
				$this->redirect('index');
				return ;
			}
		}
		if(isset($rule['model'])) {
			$model = $rule['model'];
			$handler = $rule['handler'];
			$modelObj = pzk_model($model);
			$modelObj->$handler($entity, $value);	
		}
		
		$entity->update ( array (
				$field => $value
		) );
		if(pzk_request()->getIsAjax()) {
			$nextRules = $rules[$value];
			$curState = $states[$value];
			echo '<option value="'.$value.'">' . $curState . '</option>';
			foreach ($nextRules as $state => $setting) {
				echo '<option value="'.$state.'"> -&gt; ' . $setting['action'] . '</option>';
			}
		} else {
			$this->redirect('index');
		}
		
	}
	
	public function importPostAction() {
		$username = pzk_session ( )->getAdminUser();
		if (isset ( $username )) {
			$username = pzk_session ()->getAdminUser();
		} else {
			$this->redirect('admin_home/index');
		}
		$setting = pzk_controller ();
		if (empty ( $setting->importFields )) {
			$this->redirect('admin_home/index');
		}
		
		if (isset ( $_GET ['token'] )) {
			$token = $_GET ['token'];
		} else {
			$this->redirect('admin_home/index');
		}
		if (isset ( $_GET ['time'] )) {
			$time = $_GET ['time'];
		} else {
			$this->redirect('admin_home/index');
		}
		
		if ($token == md5 ( $time . $username . SECRETKEY )) {
			// upload
			if (! empty ( $_FILES ['file'] ['name'] )) {
				$allowed = array (
						'csv',
						'xlsx',
						'xls' 
				);
				$dir = BASE_DIR . "/tmp/";
				$fileParts = pathinfo ( $_FILES ['file'] ['name'] );
				// Kiem tra xem file upload co nam trong dinh dang cho phep
				if (in_array ( $fileParts ['extension'], $allowed )) {
					// Neu co trong dinh dang cho phep, tach lay phan mo rong
					$tam = explode ( '.', $_FILES ['file'] ['name'] );
					$ext = end ( $tam );
					$renamed = md5 ( rand ( 0, 200000 ) ) . '.' . "$ext";
					
					move_uploaded_file ( $_FILES ['file'] ['tmp_name'], $dir . $renamed );
				} else {
					// FIle upload khong thuoc dinh dang cho phep
					pzk_system()->halt ( "File upload không thuộc định dạng cho phép!" );
				}
			}
			
			// load file
			$path = $dir . $renamed;
			if (! file_exists ( $path )) {
				pzk_system()->halt ( 'file not exist' );
			}
			require_once BASE_DIR . '/3rdparty/phpexcel/PHPExcel.php';
			
			$host = _db ()->host;
			$user = _db ()->user;
			$password = _db ()->password;
			$db = _db ()->dbName;
			// connect database
			$dbc = mysqli_connect ( $host, $user, $password, $db );
			
			if (! $dbc) {
				trigger_error ( "Could not connect to DB: " . mysqli_connect_error () );
			} else {
				mysqli_set_charset ( $dbc, 'utf8' );
			}
			
			$objPHPExcel = PHPExcel_IOFactory::load ( $path );
			
			$sheet = $objPHPExcel->getSheet ( 0 );
			$highestRow = $sheet->getHighestRow ();
			$highestColumn = $sheet->getHighestColumn ();
			
			// Loop through each row of the worksheet in turn
			for($row = 1; $row <= $highestRow; $row ++) {
				// Read a row of data into an array
				$rowData = $sheet->toArray ( 'A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE );
			}
			$table = mysqli_real_escape_string ( $dbc, $setting->table );
			$importFields = implode ( ',', $setting->importFields );
			$cols = mysqli_real_escape_string ( $dbc, $importFields );
			$arrfields = explode ( ',', $importFields );
			
			unset ( $rowData [0] );
			// combine array
			if ($rowData) {
				foreach ( $rowData as $item ) {
					$arrWhere [] = array_combine ( $arrfields, $item );
				}
				
				$where = '';
				foreach ( $arrWhere as $item ) {
					foreach ( $item as $key => $val ) {
						$val = mysql_escape_string ( $val );
						$where .= "$key = " . "'$val'" . " AND ";
					}
					$where = substr ( $where, 0, - 4 );
					$sql = "SELECT id from {$table} WHERE {$where}";
					$result = mysqli_query ( $dbc, $sql );
					if (mysqli_errno ( $dbc )) {
						$message = 'Invalid query: ' . mysqli_error ( $dbc ) . "\n";
						$message .= 'Whole query: ' . $sql;
						pzk_system()->halt ( $message );
					}
					$row = mysqli_fetch_assoc ( $result );
					if ($row) {
						$vals = array ();
						foreach ( $item as $key => $value ) {
							$vals [] = '`' . $key . '`=\'' . mysql_escape_string ( $value ) . '\'';
						}
						$values = implode ( ',', $vals );
						$sql = "update {$table} set $values where id = " . $row ['id'] . "";
						mysqli_query ( $dbc, $sql );
						if (mysqli_errno ( $dbc )) {
							$message = 'Invalid query: ' . mysqli_error ( $dbc ) . "\n";
							$message .= 'Whole query: ' . $sql;
							pzk_system()->halt ( $message );
						}
					} else {
						
						$columns = explode ( ',', $cols );
						$list = '';
						foreach ( $columns as $col ) {
							$col = trim ( $col );
							$col = str_replace ( '`', '', $col );
							$list .= ',' . "'" . mysql_escape_string ( $item [$col] ) . "'";
						}
						$list = substr ( $list, 1 );
						$sql = "INSERT INTO {$table}($cols)  VALUES ($list)";
						mysqli_query ( $dbc, $sql );
						if (mysqli_errno ( $dbc )) {
							$message = 'Invalid query: ' . mysqli_error ( $dbc ) . "\n";
							$message .= 'Whole query: ' . $sql;
							pzk_system()->halt ( $message );
						}
					}
					$where = '';
				}
			}
			if (file_exists ( $path )) {
				unlink ( $path );
			}
			$url = "/admin_" . $setting->module . "/index";
			pzk_notifier_add_message ( 'Import thành công!', 'success' );
			header ( "location: $url" );
			exit ();
		}
	}
	public function highchartAction() {
		$this->initPage ();
		$this->append ( 'admin/' . pzk_or ( $this->getCustomModule(), $this->getModule() ) . '/highchart' )
		->append ( 'admin/' . pzk_or ( $this->customModule, $this->module ) . '/menu', 'right' );
		$this->display ();
	}

    public function detailAction($id) {
    	$module = false;
    	if($this->moduleDetail) {
    		$module = $this->parse('admin/'. pzk_or ( $this->getCustomModule(), $this->getModule() ).'/'.$this->moduleDetail.'/detail');
    	} else if(pzk_app()->existsPageUri('admin/'. $this->getModule() .'/detail')) {
    		$module = $this->parse('admin/'. $this->getModule() .'/detail');
    	} else if(pzk_app()->existsPageUri('admin/'. $this->getCustomModule() .'/detail')) {
    		$module = $this->parse('admin/'. $this->getCustomModule() .'/detail');
    	}
        if(!$module) {
        	$this->redirect('index');
        }
        $module->setItemId($id);
        $this->initPage()
            ->append($module)
            ->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');
        if($childList = pzk_element(pzk_or($this->getCustomModule(), $this->getModule()).$this->moduleDetail.'Children')){
            $childList->setParentId($id);
        }
        $this->display();
    }
	
	public function orderBysAction() {
		$this->getSession()->setOrderBys(pzk_request()->getOrderBys());
		echo json_encode(pzk_request()->getOrderBys());
	}
	
	public function dialogAction() {
		$id = pzk_request()->getId();
		$module = $this->parse('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/edit');
		$module->setTable($this->getTable());
		$module->setItemId($id);
		$module->setModule($this->getModule());
		$module->setFieldSettings($this->getEditFieldSettings());
		$module->setActions($this->getEditActions());
		$module->display();
	}
	
	public function inlineEditPostAction() {
		$id = pzk_request ( )->getId();
		$field = pzk_request ( ) ->getField();
		$value = pzk_request()->getValue();
		$entity = _db ()->getTableEntity ( $this->getTable() )->load ( $id );
		if($entity->getId()) {
			$entity->update ( array (
					$field => $value
			) );
			echo '1';
		} else {
			echo '0';
		}
	}
	
	public function changeQuickModeAction() {
		$quickMode = $this->getSession()->getQuickMode();
		$quickMode = !$quickMode;
		$this->getSession()->setQuickMode($quickMode);
		$this->redirect('index');
	}
	
	public function viewAction($id, $gridIndex) {
		$this->initPage();
		$module = false;
    	if($this->moduleDetail) {
    		$module = $this->parse('admin/'. pzk_or ( $this->getCustomModule(), $this->getModule() ).'/'.$this->moduleDetail.'/view');
    	} else if(pzk_app()->existsPageUri('admin/'. $this->getModule() .'/view')) {
    		$module = $this->parse('admin/'. $this->getModule() .'/view');
    	} else if(pzk_app()->existsPageUri('admin/'. $this->getCustomModule() .'/view')) {
    		$module = $this->parse('admin/'. $this->getCustomModule() .'/view');
    	} else {
			$module = $this->parse('admin/grid/view');
		} 
		
        $module->setItemId($id);
		$module->setFieldSettings(pzk_or($this->getViewFieldSettings(), $this->getListFieldSettings()));
		$module->setJoins($this->getJoins());
		$module->setFields(pzk_or($this->getDetailFields(), '`'.$this->getTable() . '`.*'));
		$module->setListSettingType($this->getListSettingType());
		$module->setChildrenGridSettings($this->getChildrenGridSettings());
		$module->setParentDetailSettings($this->getParentDetailSettings());
        $module->setModule($this->getModule());
		$module->setGridIndex($gridIndex);
		
		$childrenGridSettings = $module->getChildrenGridSettings();
		$gridIndex = $module->getGridIndex();
		$selectedGridSettings = null;
		$grid = null;
		
		
		if($childrenGridSettings):
			foreach($childrenGridSettings as $gridSettings):
				if($gridIndex == $gridSettings['index']):
					$selectedGridSettings = $gridSettings;
					break;
				endif;
			endforeach;
			if($selectedGridSettings):
				$grid = pzk_parse('default/pages/admin/grid/index');
				foreach($selectedGridSettings as $key => $val) {
					$grid->set($key, $val);
				}
				$grid->setLayout('admin/grid/index/view/grid');
				$grid->setParentMode(true);
				$grid->setParentId($id);
				$grid->init();
				$nav = pzk_element('nav');
				$nav->setModule($selectedGridSettings['module']);
				$nav->setSortFields(@$selectedGridSettings['sortFields']);
			endif;
		endif;
		
		$parentDetailSettings = $module->getParentDetailSettings();
		$gridIndex = $module->getGridIndex();
		$selectedDetailSettings = null;
		$detail = null;
		
		
		if($parentDetailSettings):
			foreach($parentDetailSettings as $detailSettings):
				if($gridIndex == $detailSettings['index']):
					$selectedDetailSettings = $detailSettings;
					break;
				endif;
			endforeach;
			if($selectedDetailSettings):
				$detail = pzk_parse('default/pages/admin/grid/view');
				$detail->setModule($this->getModule());
				$detail->setIsChildModule(true);
				foreach($selectedDetailSettings as $key => $val) {
					$detail->set($key, $val);
				}
				$detail->setParentMode(true);
			endif;
		endif;
		
		$module->setParentDetail($detail);
		$module->setChildGrid($grid);
		
            $this->append($module)
            ->append('admin/'.pzk_or($this->getCustomModule(), $this->getModule()).'/menu', 'right');
		if(pzk_request()->getIsAjax()) {
			$module->display();
		} else {
			$this->display();
		}
        
	}
}