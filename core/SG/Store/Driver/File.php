<?php
class PzkSGStoreDriverFile extends PzkSGStoreDriver {
	public $dir = 'cache';
	public function __construct($dir = 'cache') {
		$this->dir = $dir;
	}
	public function get($key, $timeout = null) {
		if (! isset($key) || !$key)
			return false;
		$fileName = BASE_DIR . '/' . $this->dir . '/' . md5 ( $key ) . '.txt';
		
		if (! file_exists ( $fileName )) {
			return NULL;
		}
		if ($timeout) {
			
			$remainingTime = - (time () - filemtime ( $fileName ) - $timeout);
			
			if ($remainingTime < 0) {
				unlink ( $fileName );
				return NULL;
			}
		}
		
		return file_get_contents ( $fileName );
	}
	
	public function set($key, $value) {
		return file_put_contents (BASE_DIR . '/' . $this->dir . '/' . md5 ( $key ) . '.txt', $value );
	}
	
	public function has($key) {
		return file_exists(BASE_DIR . '/' . $this->dir . '/' . md5 ( $key ) . '.txt');
	}
	
	public function del($key) {
		if($this->has($key))
			return unlink(BASE_DIR . '/' . $this->dir . '/' . md5 ( $key ) . '.txt');
		return false;
	}
	
	public function clear() {
		$d = dir ( $this->dir );
		while ( false !== ($entry = $d->read ()) ) {
			unlink (BASE_DIR . '/' . $this->dir. '/' . $entry . '.txt' );
		}
		$d->close ();
	}
}