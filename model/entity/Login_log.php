<?php 
class PzkEntityLogin_logModel extends PzkEntityModel{
	
	public $table="login_log";
	
	function recordLogin($user, $ipClient) {
		$login_log = array(
				'userId'	=> $user->getId(),
				'username'	=> $user->getUsername(),
				'ipClient'	=> $ipClient,
				'time'		=> date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
		);
		
		$this->setData($login_log);
		$this->save();
		return $this->getId();
	}
	
	function processLoginUser(){
		
		$username = pzk_session('username');
		
		$ipClient = pzk_session('ipClient');
		
		$login_id = pzk_session('login_id');
		
		$CheckIp = $this->checkIpClientLogin($username, $ipClient, $login_id);
		
		$user=_db()->getEntity('user.account.user');
		
		if($CheckIp === false){
			
			$user->logout();
			
			return true;
		}
		
		$count_username = count($this->getUserLogin($username));
		
		if($count_username >1){
			
			$userNow = $this->getUserNowLogin($username);
			
			$result_del = $this->delUserLogin($userNow->data);
			
			if($result_del){
				
				$CheckIp = $this->checkIpClientLogin($username, $ipClient);
				
				if($CheckIp == false){
					
					return true;
				}
			}
		}elseif ($count_username == 0){
			
			$user->logout();
			
			return true;
		}
		
		return false;
	}
	
	function getUserLogin($username){
		
		return _db()->select('*')->fromLogin_log()
				->where(array('username', $username))
				->result('login_log');
	}
	
	function getUserTimeMax($username){
		
		return _db()->select('max(time) as time_max')->fromLogin_log()
		->where(array('username', $username))
		->result_one('login_log');
	}
	
	function getUserNowLogin($username){
		
		$timeMaxOjb = $this->getUserTimeMax($username);
		
		$timeMax = $timeMaxOjb->data['time_max'];
		
		return _db()->select('id, username, ipClient, time')->fromLogin_log()
						->where(array('username', $username))
						->where(array('time', $timeMax))
						->result_one('login_log');
	}
	
	function delUserLogin($data){
		$query =  _db()->delete()->fromLogin_log()->where(array('lt','id', (int)$data['id']))
												  ->where(array('equal', 'username', $data['username']))
												  ->result();
		return true;
	}
	
	function checkIpClientLogin($username, $ipClient, $login_id = ''){
		
		$query =  _db()->select('id')->fromLogin_log()
					->where(array('ipClient', $ipClient))
					->where(array('username', $username));
				  	if($login_id !==''){
				  		
				  		$query->where(array('id', $login_id));
					}
		$data_query = $query->result();
		
		if(count($data_query) >0){
			
			return true;
		}
		return false;
	}
}