<?php
/**
 * Returns an encrypted & utf8-encoded
 */
function mr_encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

/**
 * Returns decrypted original string
 */
function mr_decrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}

class PzkSGStoreCrypt extends PzkSGStore {
	public $encryption_key = 'secrete';
	public function __construct($storage, $encryption_key = 'secrete') {
		parent::__construct($storage);
		$this->encryption_key = $encryption_key;
	}
	public function set($key, $value) {
		$value = base64_encode($value);
		$this->storage->set($key, $value);
	}
	
	public function get($key, $timeout = NULL) {
		$value = $this->storage->get($key, $timeout);
		return base64_decode($value);
	}
}