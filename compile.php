<?php
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

// cac ham xu ly thong thuong
mb_language('uni');
mb_internal_encoding('UTF-8');
//define('COMPILE_MODE', true);
require_once 'config.php';
require_once 'include.php';
require_once 'core/Compilers.php';

$objectCompiler = new PzkObjectCompiler();
$objectCompiler->compileDir('objects');

$pageCompiler = new PzkPageCompiler();
$pageCompiler->compileDir('system');
$pageCompiler->setSource('app/nobel/application.php')->compile();
$pageCompiler->setSource('app/nobel/test/application.php')->compile();
//$pageCompiler->setSource('app/nobel/cms/application.php')->compile();
$pageCompiler->setSource('app/nobel/olympic/application.php')->compile();
$pageCompiler->setSource('app/nobel/ptnn/application.php')->compile();
$pageCompiler->setSource('app/nobel/test/pmtv/application.php')->compile();
$pageCompiler->compileDir('default/pages');
$pageCompiler->compileDir('app/*/pages');
$pageCompiler->compileDir('app/*/*/pages');
$pageCompiler->compileDir('themes/*/pages');

$modelCompiler = new PzkModelCompiler();
$modelCompiler->compileDir('model');


$controllerCompiler = new PzkControllerCompiler();
$controllerCompiler->compileDir('default/controller');
$controllerCompiler->compileDir('app/*/controller');
$controllerCompiler->compileDir('app/*/*/controller');
$controllerCompiler->compileDir('themes/*/controller');
/*
compileInclude();
compileObjects();
compileXmlFile('system/full.php',true);
require_once 'compile/pages/system_full.php';
define('regenerate', true);
compileObjects();
compileModels();
compileXmls();
compileControllers();
compileLayouts();
//compileXmlFile('system/full.php', regenerate);
//compileXmlFile('app/ptnn/offapplication.php', regenerate);
//compileXmlFile('app/cms/pages/home/index.php', regenerate);
//pzk_element('page')->display();
//require_once 'compile/pages/system_full.php';
//require_once 'compile/pages/app_ptnn_offapplication.php';
*/

