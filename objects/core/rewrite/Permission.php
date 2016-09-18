<?php
class PzkCoreRewritePermission extends PzkObjectLightWeight {
	public $user = false;
	public function init() {
		$request = pzk_element('request');
		$loginId = pzk_session('loginId');
		if(!$loginId) {
			$loginId = 3;
		}
		$this->user = _db()->getEntity('profile.profile')->load($loginId, 900);
		$action = $request->get('action');
		if($request->host == 'phongthuyhoangtra.vn' || $request->host == 'www.phongthuyhoangtra.vn') {
			return ;
		}
		if($action == 'logout' || $action == 'login' || $action == 'loginPost') {
			return ;
		}
		if(!$this->user->getPermission($request->get('controller'), $request->get('action'))) {
			header('Location: '.BASE_URL.'/index.php/demo/login'); die();
		}
	}
	
	public function check($controller, $action) {
		if($action == 'login' || $action == 'logout' || $action == 'loginPost') return true;
		return $this->user->getPermission($controller, $action);
	}
	
	public function login($username, $password) {
		$user = _db()->useCB()->select('*')->from('profile_profile')->where(array('and', array('username', $username), array('password', $password)))->result_one();
		if($user) {
			pzk_session('loginId', $user['id']);
			return true;
		}
		return false;
	}
	
	public function studentLogin($username, $password) {
		$student = _db()->useCB()->select('*')->from('student')
			->where(array('and', array('like', 'name', "%$username%"), array('phone', $password)));
		$student = $student->result_one();
		if($student) {
			
			pzk_session('studentId', $student['id']);
			$this->login('parent', '123456');
			return true;
		}
		return false;
	}
	
	public function teacherLogin($username, $password) {
		$teacher = _db()->useCB()->select('*')->from('teacher')
			->where(array('and', array('name', $username), array('password', $password)))
			->result_one();
		if($teacher) {
			pzk_session('teacherId', $teacher['id']);
			$this->login('teacher', '123456');
			return true;
		}
		return false;
	}
	
	public function getAllUserTypes() {
		$types = _db()->select('*')->from('profile_type')->result();
		$rs = array();
		foreach($types as $type) {
			$rs[] = $type['name'];
		}
		return $rs;
	}
	public function getAllControllers() {
		$files = glob(pzk_app()->getUri('controller'). '/*');
		$rs = array();
		foreach($files as $file) {
			$parts = explode('/', $file);
			$part = array_pop($parts);
			$parts = explode('.', $part);
			
			$content = file_get_contents($file);
			if(preg_match('/--IGNORE--/', $content)) continue;
			preg_match_all('/([\w]+)Action/', $content, $matches);
			
			$actions = $matches[1];
			preg_match('/[\w]+ extends ([\w]+)/', $content, $match);
			$class = $match[1];
			if($class == 'PzkTableController') {
				$content = file_get_contents('core/controller/Table.php');
				preg_match_all('/([\w]+)Action/', $content, $matches2);
				$actions2 = $matches2[1];
				foreach($actions2 as $action) {
					$actions[] = $action;
				}
			}
			if($class == 'PzkBaseController') {
				$actions[] = 'index';
			}
			
			$rs[] = array('controller' => $parts[0], 'actions' => $actions);
		}
		return $rs;
	}
}