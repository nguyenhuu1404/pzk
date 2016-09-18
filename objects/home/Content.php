<?php 
	/**
	 * Object Home/Content for content of themes vnwomen
	 */
	class PzkHomeContent extends PzkObject{
		public $scriptable = true;
		public function hash() {
			return md5(pzk_request()->getPageNews().parent::hash());
		}
		public function getClass(){
			
		}
	}
 ?>