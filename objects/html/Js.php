<?php
class PzkHtmlJs extends PzkObject {
	public $boundable = false;
	public $layout = 'html/js';
	public $group = 'common';
	public $src = '';
	
	public function display() {
		if(!COMPILE_MODE || !COMPILE_JS_MODE || !pzk_js($this->src)) {
			parent::display();
		}
	}
}