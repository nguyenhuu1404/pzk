<?php

extract($_REQUEST);

//set POST variables
$url = 'http://edict.vn/Home/SearchAjax/';
$fields = array(
	'Dictionaries' => urlencode($Dictionaries),
	'Word' => urlencode($Word)
);
$fields_string = '';
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
if(strpos($result, 'Server') !== false && strpos($result, 'Error') !== false) {
	echo ''; die();
} else {
	echo $result;
}

/*

$content = file_get_contents($_REQUEST['url']);
$content = preg_replace('/http:\/\/localhost:[\d]+\//', 'http://edict.vn/', $content);
$content = str_replace('../Scripts/configURL.js', '/configURL.js', $content);
$content = str_replace('../', 'http://edict.vn/', $content);
echo $content;
*/