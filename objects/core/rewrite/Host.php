<?php
pzk_import('core.rewrite.Request');
class PzkCoreRewriteHost extends PzkCoreRewriteRequest {
	public $matcher 	= 'host';
	public $matchMethod = 'equal';
	public $name 		= '';
	public $app 		= '';
	public $controller 	= 'Home';
	public $action 		= 'index';
	public $softwareId 	= '2';
	public $siteId		=	'0';
	public function init() {
		$this->pattern = $this->name;
		$this->defaultQueryParams = array(
			'app'			=>	$this->app,
			'controller'	=> 	$this->controller,
			'action'		=>	$this->action,
			'softwareId'	=> 	$this->softwareId,
			'siteId'		=>	$this->siteId
		);
		parent::init();
	}
}