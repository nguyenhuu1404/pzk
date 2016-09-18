<?php
class PzkDefaultAdminLevelactionController extends PzkAdminController {
    public $masterStructure 	= 'admin/home/index';
    public $masterPosition 		= 'left';
    public $table 				= 'pzk_admin_level_action';
	public $addLabel 			= 'Phân quyền';
    public $addFieldSettings 	= false ;
    //config admin level action
    public $levelAction 		= array('index', 'indexOwner', 'add', 'edit', 'editOwner', 'del', 'workflow', 'import', 'export', 'dialog', 'detail', 'details', 'highchart');

    public $addFields 			= 'admin_level_id,  admin_action, admin_level, action_type, status, software';
    public $editFields 			= 'admin_level_id,  admin_action, admin_level, action_type, status, software';
	public $logable = true;
	public $logFields = 'admin_level_id,  admin_action, admin_level, action_type, status';
    public $addValidator = array(
        'rules' => array(
            'admin_level_id' => array(
                'required' => true

            ),
            'admin_action' => array(
                'required' => true

            )

        ),
        'messages' => array(
            'admin_level_id' => array(
                'required' => 'Bạn phải chọn người dùng'

            ),
            'admin_action' => array(
                'required' => 'Bạn phải chọn menu'

            )

        )
    );

    public $editValidator = array(
        'rules' => array(
            'admin_level_id' => array(
                'required' => true

            ),
            'admin_action' => array(
                'required' => true

            ),
            'action_type' => array(
                'required' => true

            )

        ),
        'messages' => array(
            'admin_level_id' => array(
                'required' => 'Bạn phải chọn người dùng'

            ),
            'admin_action' => array(
                'required' => 'Bạn phải chọn menu'

            )
        ,
            'action_type' => array(
                'required' => 'Bạn phải chọn action'

            )
        )
    );
    function indexAction(){
        $this->initPage()->append('admin/'.pzk_or($this->customModule, $this->module).'/index')
            ->append('admin/'.pzk_or($this->customModule, $this->module).'/menu', 'right');
        $this->fireEvent('index.after', $this);
        $list = pzk_element ( 'list' );
        $list->setModule($this->getModule());
        $this->display();
    }

    public function addPostAction() {
        $row = $this->getAddData();

        if($this->validateAddData($row) ) {
            $admin = pzk_model('admin');
            $arrAction = $row['action_type'];

            if(is_array($arrAction) && count($arrAction)>0 ) {
                foreach($arrAction as $item) {
                    $arrAddAction = array(
                        "admin_level_id" => $row['admin_level_id'],
                        "admin_action" => $row['admin_action'],
                        "admin_level" => $row['admin_level'],
                        "action_type" => $item,
                        "status" => $row['status'],
                        "software" => pzk_request('softwareId')
                    );

                    $check = $admin->checkActionType($item, $row['admin_action'], $row['admin_level']);
                    if(!$check) {
                        $this->add($arrAddAction);


                    }
                }
            }elseif(!$arrAction) {
                pzk_validator()->setEditingData($row);
                pzk_notifier_add_message('Bạn phải chọn action', 'danger');
                $this->redirect('add');
            }
            else {
                $check = $admin->checkActionType($row['action_type'], $row['admin_action'], $row['admin_level']);
                if(!$check) {
                    $this->add($row);
                }
            }


            pzk_notifier()->addMessage('Thêm thành công');
            $this->redirect('index');
        } else {
            pzk_validator()->setEditingData($row);
            $this->redirect('add');
        }
    }

    public function getAdminLevel() {
        $data = _db()->useCB()->select('id, level')->from('pzk_admin_level')->where(array('status', 1))->result();
        $option = array();
        foreach($data as $item) {
            $option[$item['level']] = $item['level'];
        }
        return $option;
    }
    public  function getAdminActionAction() {
        $adminController = trim(pzk_request('adminController'));
        $checkcontroller = substr($adminController, 0, 2);
        if($checkcontroller == '0_'){
            $html = "<select id='action_type' name='action_type' class='form-control input-sm'>
                <option value=''>-- Chọn action cho phép truy cập --</option>
                    <option value='index'>index</option>
            </select>";
        }else {
            //get all defauft action in controller admin, gridAdmin
            /*$paternDefauftAction = '/function[\s]+(\w+)Action/';

            //all action in admin
            $contentAdmin = file_get_contents(BASE_DIR.'/core/controller/Admin.php');
            preg_match_all($paternDefauftAction, $contentAdmin, $actionInAdmin);
            $actionInAdmin = $actionInAdmin[1];

            //all action in adminGrid
            $contentGridAdmin = file_get_contents(BASE_DIR.'/core/controller/GridAdmin.php');
            preg_match_all($paternDefauftAction, $contentGridAdmin, $actionInGridAdmin);
            $actionInGridAdmin = $actionInGridAdmin[1];

            //all action in configAdmin
            $contentConfigAdmin = file_get_contents(BASE_DIR.'/core/controller/ConfigAdmin.php');
            preg_match_all($paternDefauftAction, $contentConfigAdmin, $actionInConfigAdmin);
            $actionInConfigAdmin=$actionInConfigAdmin[1];

            //all action in Report
            $contentReport = file_get_contents(BASE_DIR.'/core/controller/Report.php');
            preg_match_all($paternDefauftAction, $contentReport, $actionInReport);
            $actionInReport = $actionInReport[1];

            // action in curent action
            $controlerAdmin = explode('_', $adminController);
            $contentCurent = file_get_contents(pzk_app()->getControllerRealPath($adminController));
            preg_match_all($paternDefauftAction, $contentCurent, $actionCurent);
            $actionCurent = $actionCurent[1];

            //all action default
            $allaction = $actionInAdmin;
            //merge grid admin
            if($actionInGridAdmin) {
                foreach($actionInGridAdmin as $item) {
                    if(!in_array($item, $allaction)) {
                        $allaction[] = $item;
                    }
                }
            }
            //merger config admin
            if($actionInConfigAdmin) {
                foreach($actionInConfigAdmin as $item) {
                    if(!in_array($item, $allaction)) {
                        $allaction[] = $item;
                    }
                }
            }
            //merger report admin
            if($actionInReport) {
                foreach($actionInReport as $item) {
                    if(!in_array($item, $allaction)) {
                        $allaction[] = $item;
                    }
                }
            }
            //merger curent admin
            if($actionCurent) {
                foreach($actionCurent as $item) {
                    if(!in_array($item, $allaction)) {
                        $allaction[] = $item;
                    }
                }
            }

            $html = "<select style='height: 150px;' id='action_type' name='action_type[]' multiple class='form-control input-sm'>
                <option value=''>-- Chọn action cho phép truy cập --</option>";
                foreach($allaction as $item) {
                    $html .= "<option value='".$item."'>$item</option>";
                }
            $html .= "</select>";*/

            $html = "<select style='height: 150px;' id='action_type' name='action_type[]' multiple class='form-control input-sm'>
                <option value=''>-- Chọn action cho phép truy cập --</option>";
            foreach($this->levelAction as $item) {
				$color = '';
				if($item == 'indexOwner' or $item == 'editOwner'){
					$color = "style='color: red;'";
				}
                $html .= "<option ".$color." value='".$item."'>$item</option>";
            }
            $html .= "</select>";
        }
        echo $html;

    }

    public function changeAdminLevelIdAction() {
        pzk_session('alaadminLevelId', pzk_request('adminLevelId'));
        $this->redirect('index');
    }

    public function changeAdminControllerAction() {
        pzk_session('alaadminController', pzk_request('adminController'));
        $this->redirect('index');
    }

    public function searchPostAction() {
        $action	=	pzk_request('submit_action');
        if($action != ACTION_RESET){
            pzk_session($this->table.'Keyword', pzk_request('keyword'));
        }else{
            pzk_session('alaadminLevelId', '');
            pzk_session('alaadminController', '');
        }
        $this->redirect('index');
    }
    public function onChangeStatusAction() {
        $id = pzk_request ( 'id' );
        $field = pzk_request ( 'field' );
        if (! $field)
            $field = 'status';
        $entity = _db ()->getTableEntity ( $this->table )->load ( $id );
        $status = 1 - $entity->get($field);
        $entity->update ( array (
            $field => $status
        ) );
        $this->redirect('index');
    }

}