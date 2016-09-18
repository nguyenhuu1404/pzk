<?php
class UserModel {
	public function getUser($username) {
		static $data = array();
		if (!$username) return false;
		if (!@$data[$username]) {
			if (is_numeric($username)) {
				$userId = $username;
				$conds = "`id`='$userId'";
			} else {
				$conds = "`username`='$username'";
			}
			$users = _db()->select('*')->from('user')
					->where($conds)->limit(0, 1)->result();
			if ($users) $data[$username] = $users[0];
			else $data[$username] = false;
		}
		return $data[$username];
	}
	
	public function login($username, $password) {
		$users = _db()->select('*')
					->from('user')
					->where("username='$username' and password='$password'")
					->limit(0, 1)->result();
		if ($users) return $users[0];
		return false;
	}
	
	public function logout() {
		
	}
	
	
}
?>