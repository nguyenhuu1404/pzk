<?php
class PzkSGStoreDomain extends PzkSGStore {
	public function set($key, $value) {
		$key = self::getDomainName().'_'. $key;
		$this->storage->set($key, $value);
	}
	
	public function get($key, $timeout = null) {
		$key = self::getDomainName().'_'. $key;
		return $this->storage->get($key, $timeout);
	}
	public function del($key) {
		$key = self::getDomainName().'_'. $key;
		return $this->storage->del($key);
	}
	public static $domainName;
	public static function getDomainName() {
		if(!self::$domainName) {
			self::$domainName = str_replace('www.', '', $_SERVER['HTTP_HOST']);
		}
		return self::$domainName;
	}
}