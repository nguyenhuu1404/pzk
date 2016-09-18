<?php
if (!function_exists('ftp_chmod')) {
   function ftp_chmod($ftp_stream, $mode, $filename){
        return ftp_site($ftp_stream, sprintf('CHMOD %o %s', $mode, $filename));
   }
}

class MyFtp {
	public $host = 'localhost';
	public $usr = 'ftp1';
	public $pwd = 'kienkien';
	public $conn_id;
	public $mode = FTP_ASCII;
	public $passive = false;
	
	public function MyFtp($host = 'localhost', $usr = 'ftp1', $pwd = 'kienkien') {
		$this->host = $host;
		$this->usr = $usr;
		$this->pwd = $pwd;
	}
	
	public function connect() {
		$this->conn_id = ftp_connect($this->host, 21) or die ("Cannot connect to host");

		// send access parameters
		ftp_login($this->conn_id, $this->usr, $this->pwd) or die("Cannot login");

		// turn on passive mode transfers (some servers need this)
		ftp_pasv ($this->conn_id, $this->passive);
	}
	
	public function transfer($local_file, $ftp_path = false, $chmod = 0666) {
		// perform file upload
		if(is_string($local_file)) {
			if(!$ftp_path) {
				$ftp_path = '/' . $local_file;
			}
			$upload = ftp_put($this->conn_id, $ftp_path, $local_file, $this->mode);
			@ftp_chmod($this->conn_id, $chmod, $ftp_path);
			return $upload;
		} else if(is_array($local_file)){
			$result = array();
			foreach($local_file as $file) {
				$rs = $this->transfer($file, $ftp_path, $chmod);
				$result[$file] = $rs;
			}
			return $result;
		}
	}
	
	public function close() {
		ftp_close($this->conn_id);
	}
}

class MyFtpChain {
	public $ftps = array();
	public function add($ftp) {
		$this->ftps[] = $ftp;
		return $this;
	}
	
	public function connect() {
		foreach($this->ftps as $ftp) {
			$ftp->connect();
		}
	}
	
	public function close() {
		foreach($this->ftps as $ftp) {
			$ftp->close();
		}
	}
	
	public function transfer($local_file, $ftp_path = false, $chmod = 0666) {
		foreach($this->ftps as $ftp) {
			$ftp->transfer($local_file, $ftp_path, $chmod);
		}
	}
	
	public function dtransfer($local_files, $ftp_path = false, $chmod = 0666) {
		$index = 0;
		$local_files = array_reverse($local_files);
		$result = array();
		while(count($local_files)) {
			$ftp = $this->ftps[$index];
			if(!isset($result[$index])) {
				$result[$index] = array();
			}
			$file = array_pop($local_files);
			$result[$index][$file] = $ftp->transfer($file, $ftp_path, $chmod);
			$index = ($index + 1) % count($this->ftps);
		}
		return $result;
	}
}?>