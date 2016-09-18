<?php
$time = $_REQUEST['t'];
$currentTime = time();
if($currentTime - $time > 5) {
	die('Request timeout');
}
$id = $_REQUEST['id'];
$key = $_REQUEST['k'];
require_once 'config.php';

$confirmKey = md5(SECRETKEY . '-' . $id . '-' . $time);
if($confirmKey == $key) {
	$views = @file_get_contents(BASE_DIR . '/cache/data/banner-' . $id . '.txt');
	$views = 1 + $views;
	@file_put_contents(BASE_DIR . '/cache/data/banner-' . $id . '.txt', $views);
	$sessionTime = @file_get_contents(BASE_DIR . '/cache/data/time.txt');
	if($currentTime - $sessionTime > 180) {
		@file_get_contents(BASE_REQUEST . '/banner/statview');
		@file_put_contents(BASE_DIR . '/cache/data/time.txt', $currentTime);
	}
}
