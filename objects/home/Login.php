<?php 
	/**
	* 
	*/
	class PzkUserLogin extends PzkObject
	{
		public function listCate()
		{
			$listCate = _db()->select('*')->from($this->table)->result();
			return $listCate;
		}
	}
 ?>