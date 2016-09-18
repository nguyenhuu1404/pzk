<?php

// Cấu hình các constant
require_once __DIR__ . '/config.php';

// Chạy chế độ compile
if(COMPILE_MODE) {
	// include các thư viện và file hệ thống
	require_once __DIR__ . '/include.php';
	
	// chạy hệ thống
	require_once __DIR__ . '/compile/pages/system_full.php';
	
	// include các cấu hình tùy chỉnh của gói
	if(pzk_request()->getPackagePath() && file_exists(BASE_DIR . '/app/'.pzk_request()->getPackagePath().'/configuration.php'))
		require_once BASE_DIR . '/app/'.pzk_request()->getPackagePath().'/configuration.php';
	
	// include cấu hình tùy chỉnh của ứng dụng
	if(file_exists(BASE_DIR . '/app/'.pzk_request()->getAppPath().'/configuration.php'))
		require_once BASE_DIR . '/app/'.pzk_request()->getAppPath().'/configuration.php';
	
	// include cấu hình tùy chỉnh của phần mềm
	if(file_exists(BASE_DIR . '/app/'.pzk_request()->getAppPath().'/configuration.'.pzk_request()->getSoftwareId().'.php'))
		require_once BASE_DIR . '/app/'.pzk_request()->getAppPath().'/configuration.'.pzk_request()->getSoftwareId().'.php';
	
	
	// chạy ứng dụng
	$sys = pzk_element('system');
	$application = pzk_request()->getApp();
	require_once __DIR__ . '/compile/pages/app_'.$application.'_'.$sys->bootstrap.'.php';
	
	$app = pzk_app();
	
	// Chạy controller action
	$controller = pzk_request()->getController();
	$action = pzk_request()->getAction();
	
	// Khởi tạo controller
	$controllerObject = $app->_getController($controller);
	if(!$controllerObject) die('No controller ' .$controller);
	pzk_global()->setController($controllerObject);
	
	// Tìm action của controller và chạy
	$actionMethod = $action.'Action';
	if(method_exists($controllerObject, $actionMethod)){
		/*
		$method = new ReflectionMethod($controllerObject, $action . 'Action');
		
		// khởi tạo action với các tham số theo segment
		$params = $method->getParameters();
		$paramsArray = array();
		foreach($params as $index => $param) {
			$paramValue = pzk_request()->getSegment(3+$index);
			$paramsArray[] = $paramValue;
		}
		
		// Chạy action
		call_user_func_array(array($controllerObject, $action . 'Action'), $paramsArray);
		*/
		$request = pzk_request();
		$controllerObject->$actionMethod($request->getSegment(3), $request->getSegment(4), $request->getSegment(5), $request->getSegment(6), $request->getSegment(7));
	} else {
		
		// không có action trong hệ thống
		pzk_system()->halt('No route ' . $action);
	}
} else {
	// include các thư viện và file hệ thống
	require_once __DIR__ . '/include.php';
	
	// Chạy hệ thống
	$sys = pzk_parse('system/full');
	
	// Include các cấu hình tùy chỉnh của gói
	if(pzk_request()->getPackagePath() && file_exists(BASE_DIR . '/app/'.pzk_request()->getPackagePath().'/configuration.php'))
		require_once BASE_DIR . '/app/'.pzk_request()->getPackagePath().'/configuration.php';
	
	// Include các cấu hình tùy chỉnh của ứng dụng
	if(file_exists(BASE_DIR . '/app/'.pzk_request()->getAppPath().'/configuration.php'))
		require_once BASE_DIR . '/app/'.pzk_request()->getAppPath().'/configuration.php';
	
	// Include các cấu hình tùy chỉnh của phần mềm
	if(file_exists(BASE_DIR . '/app/'.pzk_request()->getAppPath().'/configuration.'.pzk_request()->getSoftwareId().'.php'))
		require_once BASE_DIR . '/app/'.pzk_request()->getAppPath().'/configuration.'.pzk_request()->getSoftwareId().'.php';
	
	// Chạy ứng dụng
	$app = $sys->getApp();
	$app->run();
}
if(0 || DEBUG_MODE) {
	//echo_memory_usage() . "\n"; // 36640
	//echo get_server_load() . '<br />' . "\n";
}

// shutdown hệ thống
pzk_system()->halt();