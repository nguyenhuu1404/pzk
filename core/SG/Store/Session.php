<?php
class PzkSGStoreSession extends PzkSGStore {
	public $session = null;
	public $isChanged = false;
	public function set($key, $value) {
		$this->loadSession();
		$this->session[$key] = $value;
		$this->isChanged = true;
		//$this->saveSession();
	}
	
	public function saveSession() {
		if($this->isChanged) {
			$this->storage->set('session_'.self::getSessionId(), $this->session);
		}
	}
	
	public function loadSession() {
		if(!$this->session) {
			$this->session = $this->storage->get('session_'.self::getSessionId());
			if(!$this->session) {
				$this->session = array();
			}
		}
		return $this->session;
	}
	
	public function get($key, $timeout = null) {
		$this->loadSession();
		if(isset($this->session[$key])) return $this->session[$key];
		return null;
	}
	public function del($key) {
		$this->loadSession();
		if(isset($this->session[$key])) {
			unset($this->session[$key]);
			$this->isChanged = true;
		}
		//$this->saveSession();
	}
	public static $sessionId;
	public static function getSessionId() {
		return session_id();
		if(!self::$sessionId) {
			self::$sessionId = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] . $_SERVER["HTTP_X_FORWARDED_FOR"]);
		}
		return self::$sessionId;
	}
}