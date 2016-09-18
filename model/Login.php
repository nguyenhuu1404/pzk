<?php
class LoginModel {
	public function submit($rq) {
		$loginModel = _pzk('element.loader')->getModel('User');

		if ($user = $loginModel->login(@$rq['username'], @$rq['password'])) {
			unset($user['password']);
			_pzk('session.user', $user);
			return false;
		} else {
			_pzk('element.login')->errorMessage = 'Login Failed!';
			_pzk('session.user', false);
		}
		return false;
	}
}
?>