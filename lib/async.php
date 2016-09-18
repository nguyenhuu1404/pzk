<?php
function JobStartAsync($server, $url, $port=80,$conn_timeout=30, $rw_timeout=86400)
{
	$errno = '';
	$errstr = '';
	
	set_time_limit(0);
	
	$fp = fsockopen($server, $port, $errno, $errstr, $conn_timeout);
	if (!$fp) {
	   echo "$errstr ($errno)<br />\n";
	   return false;
	}
	$out = "GET $url HTTP/1.1\r\n";
	$out .= "Host: $server\r\n";
	$out .= "Connection: Close\r\n\r\n";
	
	stream_set_blocking($fp, false);
	stream_set_timeout($fp, $rw_timeout);
	fwrite($fp, $out);
	
	return $fp;
}

// returns false if HTTP disconnect (EOF), or a string (could be empty string) if still connected
function JobPollAsync(&$fp) 
{
	if ($fp === false) return false;
	
	if (feof($fp)) {
		fclose($fp);
		$fp = false;
		return false;
	}
	
	return fread($fp, 10000);
}?>