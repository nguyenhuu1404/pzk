<?php
class PzkCoreDbList extends PzkObject {
	public $layout = 'db/list';
	public $layoutType = 'div';
	
	/**
	Cac dieu kien de lay du lieu
	*/
	public $table = 'news';
	public $fields = '*';
	public $conditions = '1';
	public $pageSize = 1000;
	public $pageNum = 0;
	public $pagination = false; // none, ajax
	public $orderBy = 'id desc';
	public $groupBy = false;
	public $having = false;
    public $processReport = false;
    public $status = 1;
    public $exportFields = false;
	public $filters = array();
    public $parentWhere = 'equal';

	/**
	Dieu kien theo parent
	*/
	public $parentId = false;
	public $parentMode = false;
	public $parentField = 'parentId';
	
	/**
	Cac truong can hien thi
	*/
	public $displayFields = 'title,content';
	public $titleTag = 'h3';
	public $contentTag = 'div';
	public $classPrefix = 'core_db_list_item_';
	
	public function init() {
		$this->conditions = json_decode($this->conditions, true);
	}
	
	public function getItems ($keyword = NULL, $fields = array()) {
        $query = _db()->useCache(1800)->select($this->fields)->from($this->table)
				->where($this->conditions)
                //->where($this->status)
				->orderBy($this->orderBy)
				->limit($this->pageSize, $this->pageNum)
				->groupBy($this->groupBy)
				->having($this->having);
		if(@$this->joins) {
			foreach($this->joins as $join) {
				$query->join($join['table'], $join['condition'], @$join['type']);
			}
		}
		if($this->parentMode && $this->parentMode !== 'false') {
			if($this->parentId === false) {
				$request = pzk_element('request');
				$this->parentId = $request->getSegment(3);
			}
            if($this->parentWhere == 'like') {
                $query->where(array($this->parentWhere, $this->parentField, '%,'.$this->parentId.',%'));

            }else {
                $query->where(array($this->parentWhere, $this->parentField, $this->parentId));

            }
		}
		if($this->filters && count($this->filters)) {
			
			foreach($this->filters as $filter) {
				$query->where($filter);
			}
		} 
		if($keyword && count($fields)) {
			$conds = array('or');
			foreach($fields as $field) {
				$conds[] = array('like', $field, "%$keyword%");
			}
			$query->where($conds);
		}
        $this->prepareQuery($query);
		//echo $query->getQuery();
		return $query->result();
	}

    public function stringQuery ($keyword = NULL, $fields = array(), $isSelect=0) {
        if($isSelect) {
            $select = $this->fields;

        }else {
            $select = implode(',', $this->exportFields);
        }
        $query = _db()->useCache(1800)->select($select)->from($this->table)
            ->where($this->conditions)
            ->orderBy($this->orderBy)
            //->limit($this->pageSize, $this->pageNum)
            ->groupBy($this->groupBy)
            ->having($this->having);
        if($this->filters && count($this->filters)) {
			foreach($this->filters as $filter) {
				$query->where($filter);
			}
		} 
		if($keyword && count($fields)) {
            $conds = array('or');
            foreach($fields as $field) {
                $conds[] = array('like', $field, "%$keyword%");
            }
            $query->where($conds);
        }
        $this->prepareQuery($query);
        return $query->getQuery();
    }

    public function addFilter($index, $value, $filterType ='equal') {
    	if($value == '') return $this;
		if($filterType == 'like' && is_numeric($value)) {
			$this->filters[] = array($filterType, $index, '%,' . $value . ',%');
		} else {
			$this->filters[] = array($filterType, $index, $value);
		}
		
		return $this;
    }

	public function addCondition($str) {
		$this->conditions.= ' and ' . $str;
	}
	
	public function getCountItems($keyword = NULL, $fields = array()) {
		$query = _db()->useCache(1800)->select('count(*) as c')
				->from($this->table)
				->where($this->conditions)
				->groupBy($this->groupBy)
				->having($this->having);
		if(@$this->joins) {
			foreach($this->joins as $join) {
				$query->join($join['table'], $join['condition'], @$join['type']);
			}
		}
		if($this->parentMode && $this->parentMode !== 'false') {
			if(!$this->parentId) {
				$request = pzk_element('request');
				$this->parentId = $request->getSegment(3);
			}
            if($this->parentWhere == 'like') {
                $query->where(array($this->parentWhere, $this->parentField, '%,'.$this->parentId.',%'));

            }else {
                $query->where(array($this->parentWhere, $this->parentField, $this->parentId));

            }
		}
		if($keyword && count($fields)) {
			$conds = array('or');
			foreach($fields as $field) {
				$conds[] = array('like', $field, "%$keyword%");
			}
			$query->where($conds);
		}
		if($this->filters && count($this->filters)) {
			foreach($this->filters as $filter) {
				$query->where($filter);
			}
		} 
        $this->prepareQuery($query);
        $row = $query->result_one();
		return $row['c'];
	}

    public function prepareQuery($query) {

    }

    public function getNameById($id, $table, $field) {
        $data = _db()->useCache(1800)->select('*')->from($table)->where(array('id', $id))->result_one();
        return $data[$field];
    }
    public function executeStringQuery($sql) {
        $data = _db()->useCache(1800)->query($sql);
        return $data;
    }
}