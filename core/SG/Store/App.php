<?php
class PzkSGStoreApp extends PzkSGStore {
	public function set($key, $value) {
		$key = self::getAppName().'_'. $key;
		$this->storage->set($key, $value);
	}
	
	public function get($key, $timeout = null) {
		$key = self::getAppName().'_'. $key;
		return $this->storage->get($key, $timeout);
	}
	public function del($key) {
		$key = self::getAppName().'_'. $key;
		return $this->storage->del($key);
	}
	public static $appName;
	public static function getAppName() {
		if(!self::$appName) {
			self::$appName = pzk_app() ? pzk_app()->name:'';
		}
		return self::$appName;
	}
}