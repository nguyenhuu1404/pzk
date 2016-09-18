 <?php 
	/**
	* 
	*/
	class PzkHomeMenu extends PzkObject
	{
		public $table = 'pzk_admin_menu';
		public function getDataMenu($level) {
			if($level) {
				if($level == 'Administrator'){
					$allmenu = _db()->useCB()->select('*')
						->from($this->table)
						->where(array('status',1))
						->where(array('software', pzk_request('softwareId')))
						->orderBy('ordering asc')
						->result();
				}else {
					$query = _db()->useCB()->select('am.*, ala.admin_level_id, ala.admin_action, ala.admin_level, ala.status, ala.action_type')
						->from('pzk_admin_menu am')
						->join('pzk_admin_level_action ala', 'am.admin_controller = ala.admin_action')
						->where(array('equal', array('column', 'ala', 'admin_level'), $level))
						->where(array('equal', array('column', 'am', 'software'), pzk_request('softwareId')))
						->where(array('equal', array('column', 'ala', 'software'), pzk_request('softwareId')))
						->where(array('equal', array('column', 'ala', 'action_type'),'index'))
						->where(array('equal', array('column', 'am', 'status'),1))
						->where(array('equal', array('column', 'ala', 'status'),1));
					$query->orderBy('am.ordering asc');
					//echo $query->getQuery();
				   // $query->where(array(array('in', 'am', 'status'),$arrIds));
					
					$allmenu = $query->result();
				}
			}
			return $allmenu;
		}
	}
 ?>