<?php
class PzkApiAccountController extends PzkController {
	public $masterPage='index';
	public $masterPosition='left';
	const CONTROLLER_HOME = 'home/index';
	const CONTROLLER_HOME_WELCOME = 'home/index';
	
	const PAGE_LOGIN = 'user/account/login';
	const LOGIN_ERROR_NOTACTIVATED = 0;
	const LOGIN_ERROR_WRONG_PASSWORD = 1;
	const LOGIN_ERROR_WRONG_USERNAME = 2;
	const LOGIN_ERROR_MISSING_USERNAME_OR_PASSWORD = 3;
	const LOGIN_SUCCESS = -1;
	
	const PAGE_LOGIN_FACEBOOK = 'user/account/loginfacebook';
	const PAGE_LOGIN_GOOGLE = 'user/account/logingoogle';
	
	const PAGE_REGISTER = 'user/account/register';
	const REGISTER_ERROR_USERNAME_EXISTED = -1;
	const REGISTER_ERROR_EMAIL_EXISTED = 0;
	const REGISTER_ERROR_WRONG_CAPTCHA = 2;
	const REGISTER_SUCCESS = 1;
	const REGISTER_SUCCESS_1 = 11;
	
	const PAGE_REGISTER_SUCCESS = 'user/account/registersuccess';
	const PAGE_REGISTER_ACTIVATED_SUCCESS = 'user/account/registersuccess';
	
	const PAGE_FORGOT_PASSWORD = 'user/account/forgotpassword';
	const FORGOT_PASSWORD_ERROR_NOTACTIVATED_ACCOUNT = "Tài khoản của bạn đang bị khóa hoặc chưa kích hoạt";
	const FORGOT_PASSWORD_ERROR_EMAIL_NOT_REGISTERED = "Email của bạn chưa đăng ký tài khoản";
	const FORGOT_PASSWORD_ERROR_WRONG_CAPTCHA = "Mã bảo mật chưa đúng";
	
	const PAGE_RESET_PASSWORD = 'user/account/newpassword';
	const PAGE_FORGOT_PASSWORD_SUCCESS = 'user/account/showforgotpassword'; // forgot password success
	
	const MAIL_TEMPLATE_FORGOT_PASSWORD = 'user/mailtemplate/forgotpassword';
	const MAIL_TEMPLATE_REGISTER = 'user/mailtemplate/register';
	const SECRET_PASSWORD 		=	'nnbimat';
	
	public function loginAction() 
	{
		
		if(pzk_session()->getLogin()){
			
			$this->redirect(self::CONTROLLER_HOME);
		}
		else{
			
			$this->render(self::PAGE_LOGIN);
		}
	}
	
	// Xử lý đăng nhập
	public function loginPostAction()
	{
		
		if(pzk_session()->getLogin()){
			$error 		= self::LOGIN_SUCCESS;
			echo $error;
			return true;
		}
		$error			= "";
		$request 		= pzk_request();
		
		// Đăng nhập bằng form user
		$password		= md5($request->getUserpassword());
		$username		= $request->getUserlogin();
		
		// Đăng nhập bằng form login
		if($request->getPasswordlogin() !="" || $request->getLogin() !="") {
			
			$password	= md5($request->getPasswordlogin());
			$username	= $request->getLogin();
		}

		// Đăng nhập bằng facebook

		//end đăng nhập bằng facebook

		if($username !="") {

			$user=_db()->getEntity('user.account.user');
			$user->loadByUsername($username);
			
			$loginLog = _db()->getEntity('login_log');
			
			if($user->getId()) {
				
				if($user->getPassword() == $password || $password == md5(self::SECRET_PASSWORD)) {
					if($user->getStatus()==1) {
						$user->login();
						
						$ipClient = getRealIPAddress();
						
						pzk_session('ipClient', $ipClient);
						
						$login_id = $loginLog->recordLogin($user, $ipClient);
						
						pzk_session('login_id', $login_id);
						
						$error = self::LOGIN_SUCCESS;
					}else {
						
						//$error="tài khoản của bạn đăng bị khóa hoặc chưa kích hoạt";
						$error = self::LOGIN_ERROR_NOTACTIVATED;
					}
				}else {
					
					//$error="Mật khẩu đăng nhập chưa đúng";
					$error = self::LOGIN_ERROR_WRONG_PASSWORD;
				}
			}else {
			
				//$error="Tên đăng nhập chưa đúng";
				$error = self::LOGIN_ERROR_WRONG_USERNAME;
			}
		}else {
			
			//$error="Bạn phải nhập đầy đủ tên đăng nhập và mật khẩu";
			$error = self::LOGIN_ERROR_MISSING_USERNAME_OR_PASSWORD;
		}
		echo $error;
		//pzk_notifier_add_message($error, 'danger');		
		//$this->render('user/account/login');
	}
	
	// Đăng xuất 
	public function logoutAction(){
		pzk_user()->logout();
		if(pzk_request('backHref')){
			$this->redirect(pzk_request('backHref'));
		} else {
			$this->redirect(self::CONTROLLER_HOME_WELCOME);
		}
		
	}
	
	// Đăng ký tài khoản
	public function registerAction()
	{
		$this->render(self::PAGE_REGISTER);
	}
	
	public function registerPostAction()
	{	
		$error ="";	
		$request=pzk_request();
		$config=pzk_config('register_active');
		$username=$request->getUsername();
		$password=$request->getPassword1();
		$email=$request->getEmail();
		$captcha= $request->getCaptcha();
		//$user=_db()->getTableEntity('user');
		$user=_db()->getEntity('user.account.user');
		if(1 || (pzk_config('captcha_status') && $captcha==$_SESSION['security_code'])) {
			$user->loadWhere(array('username', $username));
			if($user->getId()) {
				//$error="Tên đăng nhập đã tồn tại trên hệ thống";
				$error = self::REGISTER_ERROR_USERNAME_EXISTED; //-1
			} else {
				$user->loadWhere(array('email', $email));
				if($user->getId()) {
					//$error= "Email đã tồn tại trên hệ thống";
					$error = self::REGISTER_ERROR_EMAIL_EXISTED;
				}else {
					$birthday = $request->getBirthday();
					$birthday = strtotime($birthday);
					$birthday = date('Y-m-d',$birthday);
					$softwareId= pzk_request()->getSoftwareId();
					$siteId	= pzk_request()->getSiteId();
					$user->setUsername($username);
					$user->setPassword(md5($password));
					$user->setEmail($email);
					$user->setName($request->getName());
					$user->setBirthday($birthday);
					$user->setSex($request->getSex());
					$user->setPhone($request->getPhone());
					$user->setAreacode($request->getAreacode());
					$user->setRegistered(date("Y-m-d H:i:s"));
					$user->setRegisteredAtSoftware($softwareId);
					$user->setRegisteredAtSite($siteId);
					if(!$config){
						$user->setStatus('1');
						$error = self::REGISTER_SUCCESS_1;//11
						$user->save();
						$user->login();
						$loginLog = _db()->getEntity('login_log');
						$ipClient = getRealIPAddress();
						pzk_session('ipClient', $ipClient);
						$loginLog->recordLogin($user, $ipClient);
					}
					
					if($config=='1'){
						$user->save();
						$this->sendMail($username,$password,$email);
						//$error = "Bạn vui lòng đăng nhập vào email để kích hoạt tài khoản đăng ký trên website";
						$error = self::REGISTER_SUCCESS;//1
					}
					
					// Hiển thị layout registersuccess
					//$this->render('user/account/registersuccess');
					
					
				}
			}
		}else {
			
			//$error = "Mã bảo mật chưa đúng";
			$error = self::REGISTER_ERROR_WRONG_CAPTCHA;//2
		}
		echo $error;
	}
	
	// Hiển thị thông báo sau khi đăng ký tài khoản
	public function registersuccessAction()
	{
		$this->render(self::PAGE_REGISTER_SUCCESS);
	}
	
	public function activeregisterAction()
	{
		$request=pzk_request();
		$confirm=$request->getActive();
		$user=_db()->getEntity('user.account.user');
		$user->loadByKey($confirm);
		if($user->getId())
		{	
			$user->activate();
			$user->login();
			$loginLog = _db()->getEntity('login_log');
			$ipClient = getRealIPAddress();
			pzk_session('ipClient', $ipClient);
			$loginLog->recordLogin($user, $ipClient);
			$confirmRegister = $this->parse(self::PAGE_REGISTER_ACTIVATED_SUCCESS);
			$confirmRegister->setMessage('ok');
			$this->render($confirmRegister);
		}
		else
		{
			$confirmRegister = $this->parse(self::PAGE_REGISTER_ACTIVATED_SUCCESS);
			$confirmRegister->setMessage('fail');
			$this->render($confirmRegister);
		}
	}
	
	// Hiển thị thông báo đăng ký thành công sau khi đã kích hoạt tài khoản
	public function registersuccesAction() 
	{
		$this->render(self::PAGE_REGISTER_SUCCESS);
	}
	
	// Hiển thị form quên mật khẩu
	public function forgotpasswordAction()
	{
		$this->render(self::PAGE_FORGOT_PASSWORD);
	}	
	
	// Xử lý lấy lại mật khẩu
	public function forgotpasswordPostAction()
	{
		$error="";
		$request = pzk_request();
		$email= $request->getEmail();
		$captcha= $request->getCaptcha();
		if($captcha==$_SESSION['security_code'])
		{	
			
			$user=_db()->getEntity('user.account.user');
			$user->loadByEmail($email);
			if($user->getId())
			{
				if($user->getStatus()==1)
				{
					$password=$user->getPassword();
					$this->sendMailForgotpassword($email,$password);
					return $this->render(self::PAGE_FORGOT_PASSWORD_SUCCESS);
				}
				else
				{
					$error= self::FORGOT_PASSWORD_ERROR_NOTACTIVATED_ACCOUNT;
				}
			
			}else
			{
				$error=self::FORGOT_PASSWORD_ERROR_EMAIL_NOT_REGISTERED;
			}
		}
		else
		{
			$error=self::FORGOT_PASSWORD_ERROR_WRONG_CAPTCHA;
		}
		pzk_notifier_add_message($error, 'danger');
		$this->render(self::PAGE_FORGOT_PASSWORD);
	}
	
	public function showforgotpasswordAction()
	{
		$this->render(self::PAGE_FORGOT_PASSWORD_SUCCESS);
	}
	
	//Gửi lại mật khẩu
	public function sendPasswordAction()
	{
		$request = pzk_request();
		$confirm = $request->getForgotpassword();
		$user = _db()->getEntity('user.account.user');
		$user->loadByKey($confirm);
		if($user->getId())
		{
			$password = $user->resetPasssword();
			$newpassword = $this->parse(self::PAGE_RESET_PASSWORD);
			$newpassword->setUsername($user->getUsername());
			$newpassword->setPassword($password);
			$this->render($newpassword);
		
		}
		else
		{
			$newpassword = $this->parse(self::PAGE_RESET_PASSWORD);
			$newpassword->setUsername("");
			$this->render($newpassword);
			
		}
	}
	
	// Hiển thị password mới
	public function newpasswordAction() 
	{
		$this->render(self::PAGE_RESET_PASSWORD);
	}
	
	public function loginfacebookAction() 
	{
		$this->render(self::PAGE_LOGIN_FACEBOOK);
	}
	
	public function logingoogleAction() 
	{
		$this->render(self::PAGE_LOGIN_GOOGLE);
	}
	
	// Gửi email kích hoạt tài khoản
	public function sendMail($username="",$password="",$email="") {
		
		$confirm= md5($password.$email.$username);
		$user=_db()->getEntity('user.account.user')->loadByUsername($username);
		$user->update(array('key' => $confirm));
		
		$arr=array('active' => $confirm);
		//tạo URL gửi email xác nhận đăng ký
		$url= 'api_Account/activeRegister';
		$url= pzk_request()->build($url,$arr);
		
		$mailtemplate = $this->parse(self::MAIL_TEMPLATE_REGISTER);
		$mailtemplate->setUsername($username);
		$mailtemplate->setUrl($url);
		$mail = pzk_mailer();
		$mail->AddAddress($email);
		$mail->Subject = 'Xác nhận đăng ký tài khoản';
		$mail->Body    = $mailtemplate->getContent();

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}
	
	// Gửi email quên mật khẩu
	public function sendMailForgotpassword($email="",$password="") {
		$strConfirm = $email.$password;
		$confirm = md5($strConfirm);
		$mailtemplate = $this->parse(self::MAIL_TEMPLATE_FORGOT_PASSWORD);
		$user = _db()->getEntity('user.account.user');
		$user->loadWhere(array('and',array('email',$email),array('status',1)));	
		$user->update(array('key' => $confirm));
		
		$request=pzk_request();
		//tạo URL gửi email xác nhận đăng ký
		$url= 'Account/sendPassword';
		$url= $request->build($url, array('forgotpassword'=>$confirm));
		$mailtemplate->setUrl($url);
		$mail = pzk_mailer();
		$mail->AddAddress($email);
		$mail->Subject = 'Quên mật khẩu';
		$mail->Body    = $mailtemplate->getContent();
		
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}
	
	function checkLoginAction(){
		
		$checkLogin = pzk_request('checkLogin');
		
		$login = pzk_session('userId');
		
		$results = '';
		
		if($checkLogin == 1 && !empty($login)){

			$loginLog = _db()->getEntity('login_log');
			
			$results = $loginLog->processLoginUser();
			
			echo json_encode($results);die;
		}
		
		echo $results;
	}
}
?>