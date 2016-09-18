<?php
class PzkBackendController extends PzkController
{
	public $masterStructure = 'admin/home/index';
	public $masterPosition = 'left';
	
    //config level action
    public $allowIndex = array('index', 'changeStatus', 'changeOrderBy', 'filter', 'changePageSize', 'searchPost', 'changeQuickMode', 'searchFilter','search','uploadPost', 'saveOrderings', 'saveOrdering', 'updateOneField','changeView', 'columnDisplay', 'changeColumns', 'orderBys', 'read', 'view', 'verify');
    public $allowEdit = array('edit', 'editAllCatePost', 'editPost', 'edit_tnPost', 'edit_tn20Post', 'changeStoreType', 'writePost', 'command', 'importQuestions', 'importQuestionsPost', 'previewImportQuestions', 'workflow', 'edit_tlPost');
    public $allowDel = array('del','delPost', 'delAll');
    public $allowDetails = array('details', 'updatePost');
	public $allowAdd = array('add', 'addPost', 'makePayment', 'detail', 'detailFull', 'makeContestPayment', 'makeViewPayment');

    public function __construct() {
		parent::__construct();
        $admin = pzk_session('adminUser') ;
        $level = pzk_session('adminLevel') ;

        if(!$admin) {
            $this->redirect('admin_login/index');
        }
        elseif($admin && $level=='Administrator') {
        }
        else {
            $controller = pzk_request('controller');
            $action = pzk_request('action');
            if(isset($action) && $action != 'index') {

                $adminmodel = pzk_model('admin');
		
                $arrAlow = array();
                $checkIndex = $adminmodel->checkActionType('index', $controller, $level);
                $checkEdit = $adminmodel->checkActionType('edit', $controller, $level);
				$checkAdd = $adminmodel->checkActionType('add', $controller, $level);
                $checkDel = $adminmodel->checkActionType('del', $controller, $level);
                $checkDetails = $adminmodel->checkActionType('details', $controller, $level);
               
                if($checkIndex) {
                    $arrAlow = array_merge($arrAlow, $this->allowIndex);
                }
                if($checkDetails) {
                    $arrAlow = array_merge($arrAlow, $this->allowDetails);
                }
                if($checkEdit) {
                    $arrAlow = array_merge($arrAlow, $this->allowEdit);
                }
                if($checkDel) {
                    $arrAlow = array_merge($arrAlow, $this->allowDel);
                }
				if($checkAdd) {
                    $arrAlow = array_merge($arrAlow, $this->allowAdd);
                }
				
                if(!in_array($action, $arrAlow)) {
                    $checkAction = $adminmodel->checkActionType($action, $controller, $level);

                    if (!$checkAction) {

                        $view = pzk_parse('<div layout="erorr/erorr" />');
                        $view->display();
                        pzk_system()->halt();
                    }
                }
            }
            else {
                $adminmodel = pzk_model('admin');
                $checkLogin = $adminmodel->checkAction($controller, $level);
                if(!$checkLogin) {
                    $view = pzk_parse('<div layout="erorr/erorr" />');
                    $view->display();
                    pzk_system()->halt();
                }
            }
        }

    }
}
?>