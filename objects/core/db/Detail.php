<?php
class PzkCoreDbDetail extends PzkObject {
	/**
	Bang can lay du lieu
	*/
	public $table = 'news';
	
	/**
	id cua ban ghi can lay
	*/
	public $itemId = false;
	
	/**
	Cac truong can lay
	*/
	public $fields = '*';
	
	/**
	Giao dien
	*/
	public $layout = 'db/detail';
	
	/**
	Entity model
	*/
	public $entity = false;
	
	/**
	Co comment facebook khong
	*/
	public $facebookComment = false;
	
	/**
	Cau hinh cac truong can hien thi
	*/
	public $displayFields = 'title,content';
	
	/**
	Cau hinh tag cho tung truong
	*/
	public $titleTag = 'h2';
	public $contentTag = 'div';
	
	/**
	Class prefix cho cac truong
	*/
	public $classPrefix = 'core_db_';
	
	/**
	Co hien thi hinh anh khong
	*/
	public $showImages = false;
	/**
	Co hien thi tin tuc lien quan khong
	*/
	public $showRelateds = false;
	/**
	Tin tuc lien quan dua vao truong
	*/
	public $relatedFields = 'categories';
	
	/**
		Co cau tra loi khong
	*/
	public $hasAnswer = false;
	
	public $joins = false;
	
	/**
		Lay du lieu
	*/
	public function getItem() {
		if(!$this->getItemId()) {
			$request = pzk_element('request');
			$this->setItemId($request->getSegment(3));
		}
		
		$query = _db()->useCB()->select($this->fields)->from($this->table)
				->where(array('equal', array('column', $this->getTable(), 'id'), $this->getItemId()));
		if(is_string($this->joins))
            $this->joins = json_decode($this->joins, true);
        $join = $this->joins;
        if($join) {
            foreach($join as $val) {
                $query->join($val['table'], $val['condition'], $val['type']);
            }
        }
		
		return $query->result_one($this->entity);
	}
}
?>