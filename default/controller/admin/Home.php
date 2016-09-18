<?php
class PzkAdminHomeController extends PzkAdminController {
	/*nguyenson*/
	function __construct(){
		
		$admin = pzk_session('adminUser') ;
		
		if(!$admin){
			 $this->redirect('admin_login/index');
		}
		
		$menu =  pzk_session(MENU, 'admin_home');
	}
	public $masterPage = 'admin/home/index';
	public $masterPosition = 'left';
	public function indexAction() {
		$this->initPage();
		$this->append('admin/home/shortcut');
		$this->display();
	}
	
}