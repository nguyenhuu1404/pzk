<?php

// Version của hệ thống
define('PZK_VERSION', '2.7');

// Bật thông báo lỗi
ini_set('error_reporting', E_ALL);

// Bật bộ đệm dữ liệu
ob_start();

// set timezone default: đặt timezone Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// encoding mặc định là utf-8
mb_language('uni');
mb_internal_encoding('UTF-8');

// Khởi tạo SESSION
// Thời gian sống của session
$lifetime = 60000;

// Sử dụng local mode cho session (session không theo sub domain)
define('SESSION_LOCAL_MODE', true);
define('LOCAL_MODE', true);
// session id
$a = session_id();

// Khởi tạo session theo domain và subdomain
if(!SESSION_LOCAL_MODE && !$a)
{
	$currentCookieParams = session_get_cookie_params(); 

	$rootDomain = '.nextnobels.com'; 

	session_set_cookie_params( 
		$currentCookieParams["lifetime"], 
		$currentCookieParams["path"], 
		$rootDomain, 
		$currentCookieParams["secure"], 
		$currentCookieParams["httponly"] 
	); 

	session_name('PHPSESSID');
	session_id(@$_COOKIE['PHPSESSID']);
	@session_start();  
} else {
    @session_start();
}
  
// Bắt quyền truy cập cho các file php của hệ thống
define('PZK_ACCESS', true);

// Thư mục hệ thống
define('SYSTEM_DIR', dirname(__FILE__));

// Thư mục gốc
define('BASE_DIR', SYSTEM_DIR);

// Đường dẫn gốc
define('BASE_URL', "http://{$_SERVER['HTTP_HOST']}");

// Chế độ rewrite không có index.php
define('REWRITE_MODE', true);

// Script khởi chạy
define('STARTUP_SCRIPT', 'index.php');

// Đường dẫn cho thư viện bên thứ 3
define('BASE_3RDPARTY_DIR', BASE_DIR);
define('BASE_3RDPARTY_URL', BASE_URL);

// Đường dẫn cho media
define('BASE_MEDIA_DIR', BASE_DIR);
define('BASE_MEDIA_URL', BASE_URL);

// Đường dẫn cho skin
define('BASE_SKIN_DIR', BASE_DIR);
define('BASE_SKIN_URL', BASE_URL);

// Đường dẫn khởi chạy vào hệ thống
if(REWRITE_MODE) {
	// Trường hợp có rewrite bỏ index.php
	define('BASE_REQUEST', "http://{$_SERVER['HTTP_HOST']}");
} else {
	// Trường hợp không có rewrite
	define('BASE_REQUEST', "http://{$_SERVER['HTTP_HOST']}/" . STARTUP_SCRIPT);
}

// Chế độ SEO | url thân thiện. Bỏ chế độ này đi sẽ chạy dạng controller/action
define('SEO_MODE', true);

// Thêm include path để php tìm kiếm file
set_include_path(get_include_path() . BASE_DIR . ';');

// Chế độ cache. Trường hợp vào trong admin chế dộ cache = false
if(strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
	// trong admin
	define('CACHE_MODE', false);
	define('ADMIN_MODE', true);
} else {
	// ngoài front-end
	define('CACHE_MODE', false);
	define('ADMIN_MODE', false);
}

// Engine cache mặc định
define('CACHE_DEFAULT_CACHER', 'pzk_filecache');

// Chế độ debug
define('DEBUG_MODE', true);

// Mức debug: 1 thì chỉ hiển thị query của mysql, 2 thì hiển thị luồng chạy
define('DEBUG_LEVEL', 1);

// Chế độ phar: Gói tất cả các file vào trong một file phar
define('PHAR_MODE', false);

// Chế độ compile: Compile các file ra thư mục compile để chạy nhanh hơn
define('COMPILE_MODE', false);

// Chế độ compile nối các file require trong include.php thành một file
define('COMPILE_INCLUDE_MODE', false);

// Chế độ compile các file model ra thư mục compile/models
define('COMPILE_MODEL_MODE', true);
// Chế độ compile các file object ra thư mục compile/objects
define('COMPILE_OBJECT_MODE', true);
// Chế độ compile các file pages ra thư mục compile/pages
define('COMPILE_PAGE_MODE', true);
// Chế độ compile các file layout ra thư mục compile/layouts
define('COMPILE_LAYOUT_MODE', true);


// Chế độ compile client
// Chế độ compile css: nối và nén các file css thành một file
define('COMPILE_CSS_MODE', false);

// Chế độ compile js: nối và nén các file js thành một file
define('COMPILE_JS_MODE', false);

//	MENU
define('MENU', 'MENU');

//	SEARCH
define('ACTION_SEARCH', '1');

define('ACTION_RESET', '0');

//	ACTIVE
define('ENABLED',	1);
define('DISABLED',	0);

//	FORMAT DATE
define('DATEFORMAT',		'Y-m-d H:i:s');

// Mã bảo mật
define('SECRETKEY', 		'onghuu');


// ADMIN

// Tên các nút edit
// Tên nút Sửa và đóng sau khi sửa
define('BTN_EDIT_AND_CLOSE', 		'edit_and_close');

// Tên nút Sửa và Tiếp tục
define('BTN_EDIT_AND_CONTINUE', 	'edit_and_continue');

// Tên nút Sửa và xem chi tiết sau khi sửa
define('BTN_EDIT_AND_DETAIL', 		'edit_and_detail');

// Tên các nút add
// Tên nút Thêm và đóng
define('BTN_ADD_AND_CLOSE', 		'add_and_close');

// Tên nút Thêm và tiếp tục thêm
define('BTN_ADD_AND_CONTINUE', 		'add_and_continue');

// Tên nút Thêm và sửa sau khi thêm
define('BTN_ADD_AND_EDIT', 			'add_and_edit');

if(LOCAL_MODE) {
	// Các đường dẫn đến ứng dụng
	define('FL_URL', 	'http://test1.vn');
	define('FLSN_URL', 	'http://test1sn.vn');
	define('NOBEL_URL', 'http://nobel.vn');

	
} else {
	define('FL_URL', 'http://s1.nextnobels.com');
	define('FLSN_URL', 'http://fulllooksongngu.com');
	define('NOBEL_URL', 'http://nextnobels.com');
	

}