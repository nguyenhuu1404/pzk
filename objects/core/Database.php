<?php
class PzkCoreDatabase extends PzkObjectLightWeight {

    public $connId;
    public $options;
	public $prefix = '';
	
	public $host = false;
	public $user = false;
	public $password = false;
	public $dbName = false;
    /**
     * Hàm khởi tạo và clear
     * @param string $attrs các thuộc tính
     */
    public function __construct($attrs = array()) {
        parent::__construct($attrs);
        $this->clear();
    }
	
	public function init() {
		if(!$this->host) {
			$this->host = pzk_config('db_host');
			$this->user = pzk_config('db_user');
			$this->password = pzk_config('db_password');
			$this->dbName = pzk_config('db_database');
		}
		//$this->connect();
	}
	
	public function lock() {
		$this->options['lock'] = true;
		return $this;
	}
	
	public function unlock() {
		$this->options['lock'] = false;
		return $this;
	}
	
    /**
     * Join với table với điều kiện join, và kiểu join
     * @param string $table bảng cần join
     * @param mixed $conds điều kiện join
     * @param string $type kiểu join: inner, left, right, mặc định là inner
     * @return PzkCoreDatabase
     */
	public function join($table, $conds, $type = 'inner') {
		if(!isset($this->options['joins'])) {
			$this->options['joins'] = array();
		}
		$this->options['joins'][$table] = array('conds' => $this->buildCondition($conds), 'type' => $type);
		return $this;
	}
	
	public function leftJoin($table, $conds) {
		return $this->join($table, $conds, 'left');
	}
	
	public function rightJoin($table, $conds) {
		return $this->join($table, $conds, 'right');
	}

	/**
	 * Kết nối tới cơ sở dữ liệu
	 */
    public function connect() {
        if (!isset($this->connId) || $this->connId) {
            $this->connId = mysqli_connect($this->host, $this->user, $this->password, $this->dbName) or die('Cant connect');

			//mysqli_query("SET character_set_results=utf8", $this->connId);
            //mysqli_select_db(@$this->dbName, $this->connId) or die('Cant select db: ' . @$this->dbName);
            if(pzk_app()->name=='qlhs' || pzk_app()->name=='phongthuy') {
				mysqli_query($this->connId, 'set names utf-8');
			} else {
				mysqli_set_charset($this->connId, 'utf8');
			}
        }
    }
	
	public function close() {
		if($this->connId) {
			mysqli_close($this->connId);
		}
	}

    /**
     * Chèn vào bảng
     * @param string $table
     * @return PzkCoreDatabase
     */
    public function insert($table) {
        $this->options['action'] = 'insert';
        $this->from($table);
        return $this;
    }
	
	public function insertRow($table, $row) {
		$vals = array();
		$fields = array();
		foreach($row as $field => $val) {
			$vals[] 	= 	"'" . mysql_escape_string($val) . "'";
			$fields[]	=	'`'.$field.'`';
		}
		$query = 'insert into `' . $table . '`(' . implode(',', $field) . ') values(' . implode(',', $vals) . ')';
		$result = $this->query($query);
		if($result) {
			return mysqli_insert_id($this->connId);
		}
		return NULL;
	}
	
	public function updateRow($table, $id, $data) {
		
	}
	
	public function deleteRow($table, $id) {
		
	}

    /**
     * Giá trị cần chèn vào bảng
     * @param array $values: dạng array($row1, $row2), trong đó $row1 là giá trị bản ghi
     * @return PzkCoreDatabase
     */
    public function values($values) {
		if(!isset($values[0])) {
			$values = array($values);
		}
        $this->options['values'] = $values;
        return $this;
    }

    /**
     * Các trường cần insert vào
     * @param string $fields dạng chuỗi, cách nhau bởi dấu ,
     * @return PzkCoreDatabase
     */
    public function fields($fields) {
        $this->options['fields'] = $fields;
        return $this;
    }

    /**
     * Lệnh xóa
     * @return PzkCoreDatabase
     */
    public function delete() {
        $this->options['action'] = 'delete';
        return $this;
    }

    /**
     * Lệnh cập nhật
     * @param string $table
     * @return PzkCoreDatabase
     */
    public function update($table) {
        $this->options['action'] = 'update';
        $this->from($table);
        return $this;
    }
	
	/**
     * Lệnh cập nhật
     * @param string $table
     * @return PzkCoreDatabase
     */
    public function multiUpdate($table) {
        $this->options['action'] = 'multiUpdate';
        $this->from($table);
        return $this;
    }
	
	public function setField($field, $increase = false) {
		$this->options['values'] = array(
			'field'		=> $field,
			'increase'	=> $increase,
			'rows'		=> array()
		);
		return $this;
	}
	
	public function addToUpdate($id, $value) {
		$this->options['values']['rows'][] = array('id'	=> $id, 'value'	=> $value);
		return $this;
	}

    /**
     * Lệnh đặt giá trị cho cập nhật
     * @param string $values: giá trị dạng array('trường' => 'giá trị')
     * @return PzkCoreDatabase
     */
    public function set($values) {
		
		if(isset($values['lock'])) {
			if(count($values) > 1 && $values['lock'] == 1){
				$this->where(array('lock', 0));
			}
		}else {
			$listFields = $this->getTableFields();
			if(in_array('lock', $listFields)) {
				if(!$this->isNotLocked()) {
					$this->where(array('lock', 0));
				}
			}
		}
        $this->options['values'] = $values;
        return $this;
    }
	
	public function isNotLocked() {
		return isset($this->options['lock']) && $this->options['lock'] === false;
	}

    /**
     * Lệnh SELECT
     * @param string $fields các trường, cách nhau bởi dấu phẩy ,
     * @return PzkCoreDatabase
     */
    public function select($fields) {
        $this->options['action'] = 'select';
        $this->options['fields'] = $this->prefixify($fields);
        return $this;
    }
    
    /**
     * Add more fields to select
     * @param string $fields
     * @return PzkCoreDatabase
     */
    public function addFields($fields) {
    	if(!isset($this->options['fields']) || !$this->options['fields'])
    		$this->select($fields);
    	else 
    		$this->options['fields'] .= ',' . $this->prefixify($fields);
    	return $this;
    }

    /**
     * Lệnh đếm
     * @return PzkCoreDatabase
     */
    public function count() {
        $this->options['action'] = 'count';
        return $this;
    }

    /**
     * Lệnh FROM
     * @param string $table
     * @return PzkCoreDatabase
     */
    public function from($table) {
        if (strpos($table, '`') !== false || strpos($table, ' ') !== false || strpos($table, '.') !== false) {
            $this->options['table'] = $this->prefixify($table);
        } else {
            $this->options['table'] = '`' . $this->prefixify($table) . '`';
        }
        return $this;
    }

    /**
     * Lệnh WHERE
     * @param mixed $conds điều kiện: là chuỗi hoặc là biểu thức dạng mảng
     * @return PzkCoreDatabase
     */
    public function where($conds) {
		$condsStr = $this->buildCondition($conds);
		if(@$condsStr[0] !== '(') {
			$condsStr = "($condsStr)";
		}
        $this->options['conds'] = pzk_or(isset($this->options['conds'])?$this->options['conds']: null, 1) . ' AND ' . $condsStr;
        return $this;
    }
	
	public function equal($col, $val) {
		return $this->where(array($col, $val));
	}
    
    /**
     * Sử dụng condition builder
     * @see PzkCoreDatabaseArrayCondition
     * @return PzkCoreDatabase
     */
	public function useCB() {
		$this->options['useConditionBuilder'] = true;
		return $this;
	}
	/**
	 * Sử dụng cache
	 * @param string $timeout
	 * @return PzkCoreDatabase
	 */
	public function useCache($timeout = null) {
		$this->options['useCache'] = true;
		$this->options['cacheTimeout'] = $timeout;
		return $this;
	}
	/**
	 * Lệnh xây dựng điều kiện từ biểu thức dạng mảng
	 * @see PzkCoreDatabaseArrayCondition
	 * @param mixed $conds điều kiện
	 * @return string điều kiện sql
	 */
	public function buildCondition($conds) {
		$builder = pzk_element('conditionBuilder');
		if($builder) {
			return $this->prefixify($builder->build($conds));
		}
	}
	
	public function prefixify($str) {
		return str_replace('#', $this->prefix, $str);
	}
	
	/**
	 * Lọc dữ liệu theo mảng, dùng như where
	 * @param array $filters bộ lọc
	 * @return PzkCoreDatabase
	 */
    public function filters($filters) {
        if ($filters && is_array($filters)) {
            $this->where($filters);
        }
        return $this;
    }

    /**
     * Sắp xếp thứ tự
     * @param string $orderBy
     * @return PzkCoreDatabase
     */
    public function orderBy($orderBy) {
        $this->options['orderBy'] = $this->prefixify($orderBy);
        return $this;
    }

    /**
     * Gom nhóm
     * @param string $groupBy
     * @return PzkCoreDatabase
     */
    public function groupBy($groupBy) {
		if(!$groupBy) return $this;
        if(!isset($this->options['groupBy']) || !$this->options['groupBy']){
			$this->options['groupBy'] = $this->prefixify($groupBy);
		} else {
			$this->options['groupBy'] .= ', ' . $this->prefixify($groupBy);
		}
        return $this;
    }

    /**
     * Điều kiện having
     * @param mixed $conds
     * @return PzkCoreDatabase
     */
    public function having($conds) {
		if(!$conds) return $this;
        if (isset($this->options['groupBy'])) {
			$condsStr = $this->buildCondition($conds);
            $this->options['having'] =  pzk_or(isset($this->options['having'])?$this->options['having']: null, 1) . ' AND ' . $condsStr;;
        }
		return $this;
    }
	
    /**
     * Thực thi query
     * @param string $entity trả về mảng dạng entity hay dạng mảng thông thường
     * @return NULL|array|array<PzkEntityModel>
     */
    public function result($entity = false) {
        //mysqli_query('set names utf-8', $this->connId);
        
        if ($this->isSelectQuery()) {
			return $this->executeSelectQuery($entity);
			
        } else if ($this->isInsertQuery()) {
			return $this->executeInsertQuery($entity);
			
        } else if ($this->isUpdateQuery()) {
			return $this->executeUpdateQuery($entity);
			
        } else if ($this->isMultiUpdateQuery()) {
			return $this->executeMultiUpdateQuery($entity);
			
        } else if ($this->isDeleteQuery()) {
			return $this->executeDeleteQuery($entity);
            
        }
        return $this;
    }
	
	
	public function isSelectQuery() {
		if(isset($this->options['action']) && $this->options['action'] == 'select') {
			return true;
		}
		return false;
	}
	
	public function executeSelectQuery($entity = false) {
		$rslt = array();
		
		$query = $this->getSelectQuery();
		$cacheKey = false;
		if(CACHE_MODE && $this->isUsingCache()) {
			$cacheKey = md5($_SERVER['HTTP_HOST'] .$query . $entity);
			$cacher = NULL;
			if(1 && defined('CACHE_DEFAULT_CACHER')) {
				$cacher = CACHE_DEFAULT_CACHER;
			} else {
				$cacher = 'pzk_filecache';
			}
			
			
			$data = $cacher()->get($cacheKey, isset($this->options['cacheTimeout'])? $this->options['cacheTimeout']: null);
			
			
			
			if($data !== NULL && $data !== '' && !!$data) {
				$data = unserialize($data);
				if($entity) {
					$rsltEntity = array();
					foreach($data as $item) {
						$entityObj = _db()->getEntity($entity);
						$entityObj->setData($item);
						$rsltEntity[] = $entityObj;
					}
					return $rsltEntity;
				}
				return $data;
			}
		}
		if(DEBUG_MODE)
			$this->addToDebug($query);
		$this->connect();
		$result = mysqli_query($this->connId, $query);
		
		$this->verifyError($query);
		$rsltEntity = array();
		while ($row = mysqli_fetch_assoc($result)) {
			if(isset($row['params']) && $row['params']) {
				$params = json_decode($row['params'], true);
				$row = array_merge($row, $params);
			}
			if($entity) {
				$entityObj = pzk_loader()->createModel('entity.' . $entity);
				$entityObj->setData($row);
				$rslt[] = $entityObj;
				if(CACHE_MODE && $this->isUsingCache()) {
					$rsltEntity[] = $row;
				}
			} else {
				$rslt[] = $row;
			}
		}
		mysqli_free_result($result);
		if(CACHE_MODE && $this->isUsingCache()) {
			$cacher = NULL;
			if(defined('CACHE_DEFAULT_CACHER')) {
				$cacher = CACHE_DEFAULT_CACHER;
			} else {
				$cacher = 'pzk_filecache';
			}
			if($entity) {
				$cacher()->set($cacheKey, serialize($rsltEntity));
			} else {
				$cacher()->set($cacheKey, serialize($rslt));
			}
			
		}
		return $rslt;
	}
	
	public function getSelectQuery() {
		// neu bang co truong software thi
			// them dieu kien loc where software $this->where();
		if(!$this->hasSoftwareConditions()) {
			$softwareConds = $this->getSoftwareConditions();
			if($softwareConds) {
				$this->where($softwareConds);
			}
			$this->markHavingSoftwareConditions();
		}
		
		$query = 'select ' . $this->options['fields']
				. ' from ' . $this->prefix . $this->options['table'];
		if(isset($this->options['joins'])) {
			$joins = $this->options['joins'];
			foreach($joins as $table => $join) {
				$query.= ' ' . $join['type'] . ' join ' . $this->prefix . $table . ' on ' . $join['conds'];
			}
		}
		$query .= ((isset($this->options['conds']) && $this->options['conds']) ? ' where ' . $this->options['conds'] : '')
				. (isset($this->options['groupBy']) && $this->options['groupBy'] ? ' group by ' . $this->options['groupBy'] : '')
				. (isset($this->options['having']) && $this->options['having'] ? ' having ' . $this->options['having'] : '')
				. (isset($this->options['orderBy']) && $this->options['orderBy'] ? ' order by ' . $this->options['orderBy'] : '')
				. (isset($this->options['pagination']) && $this->options['pagination'] ?
						' limit ' . $this->options['start'] . ', '
						. $this->options['pagination'] : '');
		return $query;
	}
	
	public function hasSoftwareConditions() {
		return isset($this->options['hasSoftwareConditions']) && $this->options['hasSoftwareConditions'];
	}
	
	public function markHavingSoftwareConditions() {
		$this->options['hasSoftwareConditions'] = true;
	}
	
	public function verifyError($query = false) {
		if (mysqli_errno($this->connId)) {
			$message = 'Invalid query: ' . mysqli_error($this->connId) . "\n";
			$message .= 'Whole query: ' . $query;
			
			if($this->isSelectQuery())
				die($message);
			else
				pzk_notifier_add_message($message, 'danger');
			
		}
	}
	
	public function isUsingCache() {
		return isset($this->options['useCache']) && $this->options['useCache'];
	}
	
	public function getSoftwareConditions() {
		$table = $this->getTable();
		$tablefields = $this->getTableFields();
		if(in_array('software', $tablefields)) {
			$softwareId = pzk_request('softwareId');
			
			$softwareConds = array('equal', array('column',$table, 'software'), $softwareId);
			if(in_array('global', $tablefields)) {
				$globalConds = array('equal', array('column',$table, 'global'), '1');
				$softwareConds = array('or', $globalConds, $softwareConds);
			}
			if(in_array('sharedSoftwares', $tablefields)) {
				$sharedConds = array('like', array('column',$table, 'sharedSoftwares'), '%,'.$softwareId.',%');
				$softwareConds = array('or', $sharedConds, $softwareConds);
			}
			
			if(in_array('site', $tablefields)) {
				$siteId = pzk_request('siteId');
				if($siteId) {
					$softwareConds = array('and', $softwareConds, array('or', array('equal', array('column',$table, 'site'), $siteId), array('equal', array('column',$table, 'site'), 0)));
				} else {
					$softwareConds = array('and', $softwareConds, array('equal', array('column',$table, 'site'), 0));
				}
			}
			
			return $softwareConds;
		}
		
		return null;
	}
	
	public function getTable() {
		$table = str_replace('`', '', $this->options['table']);
		$tmp = preg_split('/[\. ]/', $table);
		$table = end($tmp);
		return $table;
	}
	
	public $_tableFields = array();
	public function getTableFields() {
		
		$table = $this->options['table'];
		if(!isset($this->_tableFields[$table])) {
			$fields = $this->getFields($table);
			$this->_tableFields[$table] = $fields;
		}
		return $this->_tableFields[$table];
	}
	
	public function isInsertQuery() {
		if(isset($this->options['action']) && $this->options['action'] == 'insert') {
			return true;
		}
		return false;
	}
	
	public function executeInsertQuery($entity = false) {
		$query = $this->getInsertQuery();
		if(DEBUG_MODE)
			$this->addToDebug($query);
		$this->connect();
		$result = mysqli_query($this->connId, $query);
		$this->verifyError($query);
		if ($result) {
			$insertId = mysqli_insert_id($this->connId);
			return $insertId;
		}
		return 0;
	}
	
	public function getInsertQuery() {
		$vals = array();
		$columns = array();
		if(isset($this->options['fields']) && is_string($this->options['fields'])) {
			$columns = explode(',', $this->options['fields']);
		} else {
			$columns = $this->getTableFields();
			$this->options['fields'] = implode(',', $this->getTableFields());
		}
		$softwareId = pzk_request('softwareId');
		$siteId		= pzk_request('siteId');
		foreach ($this->options['values'] as $value) {
			$value['software'] 	= $softwareId;
			$value['site']		= $siteId;
			$colVals = array();
			foreach ($columns as $col) {
				$col = trim($col);
				$col = str_replace('`', '', $col);
				$colVals[] = "'" . @mysql_escape_string(isset($value[$col])?$value[$col]: '') . "'";
			}
			$vals[] = '(' . implode(',', $colVals) . ')';
		}
		
		$table = $this->options['table'];
		$fields = $this->options['fields'];

		$values = implode(',', $vals);
		
		$query = "insert into $table($fields) values $values";
		return $query;
	}
	
	public function isUpdateQuery() {
		if(isset($this->options['action']) && $this->options['action'] == 'update') {
			return true;
		}
		return false;
	}
	
	public function executeUpdateQuery($entity = false) {
		$query = $this->getUpdateQuery();
		if(DEBUG_MODE)
			$this->addToDebug($query);
		$this->connect();
		$result = mysqli_query($this->connId, $query);
		$this->verifyError($query);
		return $result;
	}
	
	public function getUpdateQuery() {
		$columns = $this->getTableFields();
		$vals = array();
		$this->options['values']['software'] = pzk_request('softwareId');
		foreach ($this->options['values'] as $key => $value) {

			if (in_array($key, $columns)) {
				$vals[] = '`'.$key . '`=\'' . @mysql_escape_string($value) . '\'';
			}
		}
		$values = implode(',', $vals);
		$query = "update {$this->options['table']} set $values where {$this->options['conds']}";
		return $query;
	}
	
	public function isMultiUpdateQuery() {
		if(isset($this->options['action']) && $this->options['action'] == 'multiUpdate') {
			return true;
		}
		return false;
	}
	
	public function executeMultiUpdateQuery($entity = false) {
		$query = $this->getMultiUpdateQuery();
		if($query) {
			if(DEBUG_MODE)
				$this->addToDebug($query);
			$this->connect();
			$result = mysqli_query($this->connId, $query);
			$this->verifyError($query);
			return $result;	
		} else {
			return NULL;
		}
	}
	
	public function getMultiUpdateQuery() {
		$columns = $this->getTableFields();
		// field name
		$field = $this->options['values']['field'];
		if(in_array($field, $columns)) {
			// value to set
			$rows = $this->options['values']['rows'];
			$increase = isset($this->options['values']['increase']) && $this->options['values']['increase'];
			if(count($rows)) {
				$ids = array();
				$whens = array();
				foreach($rows as $row) {
					$id = $row['id'];
					$value = $row['value'];
					$ids[] = $id;
					if($increase) {
						$whens[] = "when $id then $field + $value";
					} else {
						$whens[] = "when $id then $value";
					}
					
				}
				$ids = implode(',', $ids);
				$whens = implode(' ', $whens);
				$query = "update {$this->options['table']} set $field = case id $whens end where id in ($ids)";
				return $query;	
			}
			
			return null;
		}
		return NULL;
	}
	
	public function isDeleteQuery() {
		if(isset($this->options['action']) && $this->options['action'] == 'delete') {
			return true;
		}
		return false;
	}
	
	public function executeDeleteQuery($entity = false) {
		
		$query = $this->getDeleteQuery();
		if(DEBUG_MODE)
			$this->addToDebug($query);
		$this->connect();
		$result = mysqli_query($this->connId, $query);
		$this->verifyError($query);
		return $result;
	}
	
	public function getDeleteQuery() {
		$query = "delete from {$this->options['table']} where {$this->options['conds']}";
		return $query;
	}
	
    /**
     * Trả về câu query trước khi execute
     * @return string
     */
	public function getQuery() {
		if($this->isSelectQuery()) {
			return $this->getSelectQuery();
		} elseif($this->isInsertQuery()) {
			return $this->getInsertQuery();
		} elseif($this->isUpdateQuery()) {
			return $this->getUpdateQuery();
		} elseif($this->isDeleteQuery()) {
			return $this->getDeleteQuery();
		} elseif($this->isMultiUpdateQuery()) {
			return $this->getMultiUpdateQuery();
		} else {
			return null;
		}
	}
	
	/**
	 * Trả về một bản ghi
	 * @param string $entity: trả về theo entity hay theo dạng mảng thông thường
	 * @return Ambigous <multitype:, Ambigous <NULL, unknown>>|NULL
	 */
	public function result_one($entity = false) {
		$this->limit(1,0);
		$rows = $this->result($entity);
		if(count($rows)) {
			return $rows[0];
		}
		return NULL;
	}
	
	/**
	 * Phân trang
	 * @param unknown $pagination: số bản ghi / trang
	 * @param unknown $page: số hiệu trang
	 * @return PzkCoreDatabase
	 */
    public function limit($pagination, $page = 0) {
        $this->options['start'] = $pagination * $page;
        $this->options['pagination'] = $pagination;
        return $this;
    }
	
    /**
     * Clear query để bắt đầu lại
     * @return PzkCoreDatabase
     */
    public function clear() {
        $this->options = array();
		//$this->useCache(15*60);
        return $this;
    }

    /**
     * Describle một bảng: trả về các columns của bảng
     * @param string $table
     * @param boolean $columns trả về danh sách tên column hay trả về danh sách chi tiết của column
     * @return array
     */
    public function describle($table, $columns = true) {
		$this->connect();
        $result = mysqli_query($this->connId, 'describe ' . $this->prefix . $table);
        $rslt = array();
        while ($row = mysqli_fetch_assoc($result)) {
            if ($columns) {
                $rslt[] = $row['Field'];
            } else {
                $rslt[] = $row;
            }
        }
        return $rslt;
    }

    /**
     * Query một câu lệnh sql thông thường
     * @param string $sql câu lệnh sql
     * @return array|resource|multitype:multitype:
     */
    public function query($sql) {
		$sql = $this->prefixify($sql);
        $this->connect();
		if(DEBUG_MODE)
			$this->addToDebug($sql);
        $result = mysqli_query($this->connId, $sql);
        $this->verifyError();
        if (is_bool($result))
            return $result;
        $rslt = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rslt[] = $row;
        }
        return $rslt;
    }
	
    /**
     * Query lấy một bản ghi
     * @param string $sql câu lệnh sql
     * @return array|NULL
     */
	public function query_one($sql) {
		$result = $this->query($sql);
		if(is_bool($result)) return $result;
		if(count($result))
			return $result[0];
		return null;
	}
	
	/**
	 * Lấy các trường của một bảng trong csdl
	 * @param string $table
	 * @return array mảng các trường
	 */
	public function getFields($table) {
		$cacheKey = false;
		if(1) {
			$cacheKey = md5($_SERVER['HTTP_HOST'] .$table);
			$cacher = NULL;
			if(1 && defined('CACHE_DEFAULT_CACHER')) {
				$cacher = CACHE_DEFAULT_CACHER;
			} else {
				$cacher = 'pzk_filecache';
			}
			$data = $cacher()->get($cacheKey, 1800);
			if($data !== NULL && is_string($data)) {
				$data = unserialize($data);
				return $data;
			}
		}
		$table = str_replace('`', '', $table);
		$tmp = preg_split('/[\. ]/', $table);
		$table = $tmp[0];
		$query = "describe `{$this->prefix}$table`";
		
		$fields = $this->query($query);
		$columns = array();
		foreach($fields as $field) {
			$columns[] = $field['Field'];
		}
		if(1) {
			$cacher = NULL;
			if(1 && defined('CACHE_DEFAULT_CACHER')) {
				$cacher = CACHE_DEFAULT_CACHER;
			} else {
				$cacher = 'pzk_filecache';
			}
			$cacher()->set($cacheKey, serialize($columns));
		}
		return $columns;
	}
	
	/**
	 * Xây dựng insert data
	 * @param string $table bảng
	 * @param array $data mảng dữ liệu chưa được lọc
	 * @return array mảng dữ liệu insert được
	 */
	public function buildInsertData($table, $data) {
		$fields = $this->getFields($table);
		$params = array();
		$result = array();
		foreach($data as $key => $val) {
			if(in_array($key, $fields)) {
				if(is_array($val)) {
					$val = ','.implode(',', $val).',';
				}
				$result[$key] = $val;
			} else {
				$params[$key] = $val;
			}
		}
		if(in_array('params', $fields)) {
			$result['params'] = json_encode($params);
		}
		return $result;
	}
	
	/**
	 * Trả về một entity trong model/entity
	 * @param string $entity tên entity theo kiểu edu.student
	 * @return PzkEntityModel
	 */
	public function getEntity($entity) {
		return pzk_loader()->createModel('entity.' . $entity);
	}
	/**
	 * Trả về entity table
	 * @param string $table tên bảng cơ sở dữ liệu
	 * @return PzkEntityTableModel
	 */
	public function getTableEntity($table) {
		$entity = $this->getEntity('table')->setTable($table);
		return $entity;
	}
	
	public function __call($name, $arguments) {

		//Getting and setting with $this->property($optional);

		if (property_exists(get_class($this), $name)) {


			//Always set the value if a parameter is passed
			if (count($arguments) == 1) {
				/* set */
				$this->$name = $arguments[0];
			} else if (count($arguments) > 1) {
				throw new \Exception("Setter for $name only accepts one parameter.");
			}

			//Always return the value (Even on the set)
			return $this->$name;
		}

		//If it doesn't chech if its a normal old type setter ot getter
		//Getting and setting with $this->getProperty($optional);
		//Getting and setting with $this->setProperty($optional);
		$prefix6 = substr($name, 0, 6);
		$property6 = strtolower(isset($name[6])?$name[6]: '') . substr($name, 7);
		$prefix5 = substr($name, 0, 5);
		$property5 = strtolower(isset($name[5])?$name[5]: '') . substr($name, 6);
		$prefix4 = substr($name, 0, 4);
		$property4 = strtolower(isset($name[4])?$name[4]: '') . substr($name, 5);
		$prefix3 = substr($name, 0, 3);
		$property3 = strtolower(isset($name[3])?$name[3]: '') . substr($name, 4);
		$prefix2 = substr($name, 0, 2);
		$property2 = strtolower(isset($name[2])?$name[2]: '') . substr($name, 3);
		switch ($prefix6) {
			case 'select':
			if($property6 == 'all') {
				return $this->select('*');
			}
			if($property6 == 'none') {
				return $this->select('');
			}
			return $this->addFields(str_replace('__', '.', $property6));
			break;
			case 'update': 
				return $this->update($property6);
			break;
			case 'insert':
				return $this->insert($property6);
			break;
		}
		switch ($prefix5) {
			case 'where':
				return $this->where(array($property5, $arguments[0]));
				break;
			case 'equal':
				return $this->where(array('equal', $property5, $arguments[0]));
				break;
			case 'nlike':
				return $this->where(array('notlike', $property5, $arguments[0]));
				break;
			case 'notin':
				return $this->where(array('notin', $property5, $arguments[0]));
				break;
			case 'isnull':
				return $this->where(array('isnull', $property5, $arguments[0]));
				break;
			case 'nnull':
				return $this->where(array('isnotnull', $property5, $arguments[0]));
				break;
			case 'ljoin':
				return $this->leftJoin($property5, $arguments[0]);
				break;
			case 'rjoin':
				return $this->rightJoin($property5, $arguments[0]);
				break;
		}
		switch ($prefix4) {
			case 'like':
				return $this->where(array('like', $property4, $arguments[0]));
				break;
			case 'from':
				return $this->from($property4);
				break;
			case 'join':
				return $this->join($property4, $arguments[0], isset($arguments[1])?$arguments[1]: null);
				break;
		}
		switch ($prefix3) {
			case 'gte':
				return $this->where(array('gte', $property3, $arguments[0]));
				break;
			case 'lte':
				return $this->where(array('lte', $property3, $arguments[0]));
				break;
		}
		switch ($prefix2) {
			case 'gt':
				return $this->where(array('gt', $property2, $arguments[0]));
				break;
			case 'lt':
				return $this->where(array('lt', $property2, $arguments[0]));
				break;
			case 'in':
				return $this->where(array('in', $property2, $arguments[0]));
				break;
		}
		die('No method: '. $name);
		//return parent::__call($name, $arguments);
	}
	public $debugs = array();
	public function addToDebug($query) {
		if(strpos($query, 'insert into') !== false 
				|| strpos($query, 'update') !== false 
				|| strpos($query, 'delete') !== false) {
			// file_put_contents(BASE_DIR . '/query.log', $query ."\r\n", FILE_APPEND);
		}
		$backtrace = debug_backtrace();
		$rs = '';
		$indexF = 1;
		for($i = 2; $i < count($backtrace) -1; $i++) {
			$arguments = isset($backtrace[$i]['args'])?$backtrace[$i]['args']: null;
			if(!$arguments) $arguments = array();
			foreach($arguments as $index => $argument) {
				if(is_object($argument)) {
					$arguments[$index] = get_class($argument);
				} else {
					if(is_string($argument)) {
						if(strlen($argument) < 255) {
							$arguments[$index] = "$argument";
						} else {
							$arguments[$index] = '{text}';
						}
					} else {
						$arguments[$index] = var_export($argument, true);
					}
					
				}
				
			}
			$datas = implode(', ', $arguments);
			$rs .= $indexF . '. Function: ' . (isset($backtrace[$i]['class'])?$backtrace[$i]['class']:null) . '::' . (isset($backtrace[$i]['function'])?$backtrace[$i]['function']: null) . 
			'( '. $datas .' )' .
			' at file: ' . (isset($backtrace[$i]['file'])?$backtrace[$i]['file']: null) .
			' line :' . (isset($backtrace[$i]['line'])?$backtrace[$i]['line']: null) . "\n";
			$indexF++;
		}
		$this->debugs[] = array('query' => $query, 'backtrace' => $rs);
	}
	public function getDebugs() {
		return $this->debugs;
	}

}

/**
 * Lấy ra database instance
 * @return PzkCoreDatabase
 */
function _db() {
    $db = pzk_element('db')->clear();
	$db->select('*');
	$db->useCB();
	return $db;
}

/**
 * Thực thi câu lệnh sql
 * @param string $sql
 * @return array
 */
function db_query($sql) {
    return _db()->query($sql);
}

function pzk_db() {
	return pzk_element()->getDb();
}