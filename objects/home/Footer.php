<?php 
	/**
	 * Object Home/Footer default
	 * Object Home/Footer for footer of themes vnwomen
	 */
	class PzkHomeFooter extends PzkObject{
		public $layout 		= 'home/footer';
		public $cacheable 	= false;
		public $cacheParams	= 'layout';
		
		public function hash() {
			$addInfo = (pzk_session()->getUserId() && (pzk_request('softwareId') ==1) && (pzk_session('email') =='' || pzk_session('phone') == ''));
			return md5($addInfo . parent::hash());
		}
	}
 ?>