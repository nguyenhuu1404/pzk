<?php
class PzkFrontendController extends PzkController {
	
	public $masterPage = 'index';
	
	public function __construct() {
		
		$login = pzk_session('login');

        if(!$login) {
        	$this->redirect('WelCome/index');
        }
		parent::__construct();
		$controller_name = pzk_request('controller');
		$menu =  pzk_session(MENU, $controller_name);
	}
	
	public function indexAction(){
			
		$this->initPage()->display();
	}
}
?>