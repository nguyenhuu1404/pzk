<?php
set_time_limit(0);
$srcRoot = __DIR__;
$buildRoot = __DIR__."/build";

$phar = new Phar($buildRoot . "/myapp.phar", FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, "myapp.phar");
$phar["index.php"] = file_get_contents($srcRoot . "/src/index.php");
$phar["string.php"] = file_get_contents($srcRoot . "/lib/string.php");
$phar["error.php"] = file_get_contents($srcRoot . "/lib/error.php");
$phar["array.php"] = file_get_contents($srcRoot . "/lib/array.php");
$phar["condition.php"] = file_get_contents($srcRoot . "/lib/condition.php");
$phar["format.php"] = file_get_contents($srcRoot . "/lib/format.php");
$phar["thumb.php"] = file_get_contents($srcRoot . "/lib/thumb.php");
$phar["recursive.php"] = file_get_contents($srcRoot . "/lib/recursive.php");
$phar["dir.php"] = file_get_contents($srcRoot . "/lib/dir.php");
$phar["browser.php"] = file_get_contents($srcRoot . "/lib/browser.php");

$phar["SG.php"] = file_get_contents($srcRoot . "/core/SG.php");
$phar["Store.php"] = file_get_contents($srcRoot . "/core/SG/Store.php");
$phar["Cluster.php"] = file_get_contents($srcRoot . "/core/SG/Store/Cluster.php");
$phar["Crypt.php"] = file_get_contents($srcRoot . "/core/SG/Store/Crypt.php");
$phar["Driver.php"] = file_get_contents($srcRoot . "/core/SG/Store/Driver.php");
$phar["Php.php"] = file_get_contents($srcRoot . "/core/SG/Store/Driver/Php.php");
$phar["File.php"] = file_get_contents($srcRoot . "/core/SG/Store/Driver/File.php");
$phar["Memcache.php"] = file_get_contents($srcRoot . "/core/SG/Store/Driver/Memcache.php");
$phar["Format.php"] = file_get_contents($srcRoot . "/core/SG/Store/Format.php");

$phar["Json.php"] = file_get_contents($srcRoot . "/core/SG/Store/Format/Json.php");
$phar["Xml.php"] = file_get_contents($srcRoot . "/core/SG/Store/Format/Xml.php");
$phar["Serialize.php"] = file_get_contents($srcRoot . "/core/SG/Store/Format/Serialize.php");
$phar["Prefix.php"] = file_get_contents($srcRoot . "/core/SG/Store/Prefix.php");
$phar["Session.php"] = file_get_contents($srcRoot . "/core/SG/Store/Session.php");
$phar["App.php"] = file_get_contents($srcRoot . "/core/SG/Store/App.php");
$phar["Domain.php"] = file_get_contents($srcRoot . "/core/SG/Store/Domain.php");
$phar["init.php"] = file_get_contents($srcRoot . "/core/SG/Store/init.php");

$phar["Object.php"] = file_get_contents($srcRoot . "/core/Object.php");
$phar["LightWeight.php"] = file_get_contents($srcRoot . "/core/Object/LightWeight.php");
$phar["LightWeightSG.php"] = file_get_contents($srcRoot . "/core/Object/LightWeightSG.php");

$phar["Parser.php"] = file_get_contents($srcRoot . "/core/Parser.php");
$phar["Controller.php"] = file_get_contents($srcRoot . "/core/Controller.php");

$phar["Backend.php"] = file_get_contents($srcRoot . "/core/controller/Backend.php");
$phar["Admin.php"] = file_get_contents($srcRoot . "/core/controller/Admin.php");
$phar["GridAdmin.php"] = file_get_contents($srcRoot . "/core/controller/GridAdmin.php");
$phar["Report.php"] = file_get_contents($srcRoot . "/core/controller/Report.php");
$phar["Frontend.php"] = file_get_contents($srcRoot . "/core/controller/Frontend.php");
$phar["ConfigAdmin.php"] = file_get_contents($srcRoot . "/core/controller/ConfigAdmin.php");
$phar["Entity.php"] = file_get_contents($srcRoot . "/model/Entity.php");
$phar["Compile.php"] = file_get_contents($srcRoot . "/core/Compile.php");

$files = glob('compile/controller/*.*');

foreach($files as $file) {
	echo $file. '<br />';
	$phar[$file]	= file_get_contents(__DIR__ . '/' . $file);
}

$files = glob('compile/objects/*.*');

foreach($files as $file) {
	echo $file. '<br />';
	$phar[$file]	= file_get_contents(__DIR__ . '/' . $file);
}

$files = glob('compile/models/*.*');

foreach($files as $file) {
	echo $file. '<br />';
	$phar[$file]	= file_get_contents(__DIR__ . '/' . $file);
}

$files = glob('compile/pages/*.*');

foreach($files as $file) {
	echo $file. '<br />';
	$phar[$file]	= file_get_contents(__DIR__ . '/' . $file);
}

$files = glob('compile/layouts/*.*');

foreach($files as $file) {
	echo $file. '<br />';
	$phar[$file]	= file_get_contents(__DIR__ . '/' . $file);
}

$phar->setStub($phar->createDefaultStub("index.php"));

//copy($srcRoot . "/config.ini", $buildRoot . "/config.ini");