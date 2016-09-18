<?php
if(PHAR_MODE) {
    require_once __DIR__."/build/myapp.phar";
}else {

    require_once __DIR__ . '/lib/string.php';
    require_once __DIR__ . '/lib/error.php';
    require_once __DIR__ . '/lib/array.php';
    require_once __DIR__ . '/lib/condition.php';
    require_once __DIR__ . '/lib/format.php';
    require_once __DIR__ . '/lib/thumb.php';
    require_once __DIR__ . '/lib/recursive.php';
    require_once __DIR__ . '/lib/dir.php';
    require_once __DIR__ . '/lib/browser.php';
    require_once __DIR__ . '/lib/util.php';

    require_once __DIR__ . '/core/SG.php';
    require_once __DIR__ . '/core/SG/Store.php';
    require_once __DIR__ . '/core/SG/Store/Cluster.php';
    require_once __DIR__ . '/core/SG/Store/Crypt.php';
    require_once __DIR__ . '/core/SG/Store/Driver.php';
    require_once __DIR__ . '/core/SG/Store/Driver/Php.php';
    require_once __DIR__ . '/core/SG/Store/Driver/File.php';
    require_once __DIR__ . '/core/SG/Store/Driver/Memcache.php';
    require_once __DIR__ . '/core/SG/Store/Driver/Redis.php';
    require_once __DIR__ . '/core/SG/Store/Lazy.php';
	require_once __DIR__ . '/core/SG/Store/Stat.php';
	require_once __DIR__ . '/core/SG/Store/Format.php';
    require_once __DIR__ . '/core/SG/Store/Format/Json.php';
    require_once __DIR__ . '/core/SG/Store/Format/Xml.php';
    require_once __DIR__ . '/core/SG/Store/Format/Serialize.php';
    require_once __DIR__ . '/core/SG/Store/Prefix.php';
    require_once __DIR__ . '/core/SG/Store/Session.php';
    require_once __DIR__ . '/core/SG/Store/App.php';
    require_once __DIR__ . '/core/SG/Store/Domain.php';
    require_once __DIR__ . '/core/SG/Store/init.php';

    require_once __DIR__ . '/core/Object.php';
    require_once __DIR__ . '/core/Object/LightWeight.php';
    require_once __DIR__ . '/core/Object/LightWeightSG.php';

    require_once __DIR__ . '/core/Parser.php';
    require_once __DIR__ . '/core/Controller.php';
	
	require_once __DIR__ . '/core/controller/Frontend.php';
	if(ADMIN_MODE) {
		require_once __DIR__ . '/core/controller/Backend.php';
		require_once __DIR__ . '/core/controller/Admin.php';
		require_once __DIR__ . '/core/controller/GridAdmin.php';
		require_once __DIR__ . '/core/controller/Report.php';
		require_once __DIR__ . '/core/controller/ConfigAdmin.php';
	}
	
    require_once __DIR__ . '/model/Entity.php';
    require_once __DIR__ . '/core/Compile.php';
}