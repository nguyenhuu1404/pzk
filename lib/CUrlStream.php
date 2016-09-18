<?php
class CUrlStream {
	public $src = '';
	public function __construct($src) {
		$this->src = $src;
	}
	public function getContent() {
		$url = trim($this->src);
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => false,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5', // who am i
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
		);

		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );
		return $content;
	}
}

class ServiceCaller {
	public $baseUrl;
	public function __construct($baseUrl) {
		$this->baseUrl = $baseUrl;
	}
	public function call($route, $params = array()) {
		$url = $this->baseUrl . '/' . $route . '?' . http_build_query($params);
		$curl = new CUrlStream($url);
		$content = $curl->getContent();
		return json_decode($content, true);
	}
}