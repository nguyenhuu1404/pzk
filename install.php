<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

// cac ham xu ly thong thuong
mb_language('uni');
mb_internal_encoding('UTF-8');
require_once 'config.php';
require_once 'include.php';

$sys = pzk_parse('system/full');

$app = $sys->getApp();

$username = pzk_session('adminUser');
if(!$username) {
	echo 'Bạn không có quyền truy cập';
	echo '<script type="text/javascript">setTimeout(function() { window.location = "/admin_login"; }, 3000 );</script>';
	die();
}

_dbs()->create('schema_version')
	->addVarchar('schema_table')
	->addInt('schema_version')
	->execute();
_dbs()->menu('schema', 'Phiên bản Database');
$files = glob('install/'.pzk_request()->getApp().'/*.php');
foreach($files as $file) {
	require_once $file;
}
$files = glob('install/'.pzk_request()->getApp().'/*/*.php');
foreach($files as $file) {
	require_once $file;
}
$files = glob('install/'.pzk_request()->getApp().'/*/*/*.php');
foreach($files as $file) {
	require_once $file;
}
pzk_notifier_add_message('Cài đặt hoàn tất', 'success');
echo '<script type="text/javascript">setTimeout(function() { window.location = "/admin_schema"; }, 100 );</script>';
die();