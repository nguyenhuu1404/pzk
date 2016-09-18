<?php
class PzkSGStoreDriverMemcache extends PzkSGStoreDriver {
	public function __construct() {
		if(!class_exists('Memcached')) {
			require_once BASE_DIR . '/3rdparty/memcached-client/memcached.php';
		}
		$memcache = new Memcached ();
		$memcache->addServer ( 'localhost', 11211 ) or die ( "Could not connect" );
		$this->storage = $memcache;
	}
	
	public function set($key, $value) {
		//file_put_contents(BASE_DIR .'/memcached.txt', $key . ':' . $value . "\r\n-----------\r\n", FILE_APPEND);
		$this->storage->set($key, ''.$value, time() + 1800);
	}
	
	public function get($key, $timeout = NULL) {
		return $this->storage->get($key);
	}
	
	public function has($key) {
		return NULL !== $this->storage->get($key);
	}
	
	public function del($key) {
		return $this->storage->delete($key);
	}
	
	public function clear(){
		$this->storage->flush();
	}
}