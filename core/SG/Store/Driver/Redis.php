<?php
class PzkSGStoreDriverRedis extends PzkSGStoreDriver {
	public function __construct() {
		$redis = new Redis ();
		$redis->connect ( 'localhost', 6379 ) or die ( "Could not connect" );
		$this->storage = $redis;
	}
	
	public function set($key, $value) {
		$key = md5($key);
		$this->storage->set($key, ''.$value);
		return ''.$value;
	}
	
	public function get($key, $timeout = NULL) {
		$key = md5($key);
		return $this->storage->get($key);
	}
	
	public function has($key) {
		$key = md5($key);
		return $this->storage->exists($key);
	}
	
	public function del($key) {
		$key = md5($key);
		return $this->storage->del($key);
	}
	
	public function clear(){
		$this->storage->flushAll();
	}
}