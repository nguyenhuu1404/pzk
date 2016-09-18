<?php
class PzkCoreDatabaseArrayCondition extends PzkObject {
	public static $operations = array('column', 'string', 'equal', 'and', 'or', 'ne',
		'like', 'notlike', 'in', 'notin',
		'isnull', 'isnotnull', 'gte', 'lte', 'gt', 'lt', 'sql');
	public function build($cond) {
		if(is_array($cond)) {
			if(!isset($cond[0])) {
				$rs = array('and');
				foreach($cond as $key => $val) {
					$rs[] = array($key, $val);
				}
				return $this->build($rs);
			}
			$op = $cond[0];
			if(in_array($op, self::$operations)) {
				$func = 'mf_'.$op;
				array_shift($cond);
				return call_user_func_array(array($this, $func), $cond);
			} else {
				if(count($cond) >= 2 ) {
					if(!is_array($cond[0]) && !is_array($cond[1])) {
						return call_user_func_array(array($this, 'mf_equal'), $cond);
					} else {
						return call_user_func_array(array($this, 'mf_and'), $cond);
					}
				}
				return $op;
			}
		} else {
			return $cond;
		}
	}
	
	public function mf_sql($sql) {
		return $sql;
	}

	function mf_column($col, $col2 = null) {
		if(!$col2) {
			if(strpos($col, '`') !== false) {
				return @mysql_escape_string($col);
			}
			return '`' . @mysql_escape_string($col) . '`';
		}
		return '`' . pzk_element('db')->prefix. @mysql_escape_string($col) . '`.`' . @mysql_escape_string($col2) . '`';
	}
	function mf_string($str) {
		return '\'' . @mysql_escape_string($str) . '\'';
	}
	
	function mf_equal($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2) || is_null($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'=' . $this->build($exp2) . ')';
	}
	
	function mf_ne($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'!=' . $this->build($exp2) . ')';
	}

	function mf_like($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .' like ' . $this->build($exp2) . ')';
	}

	function mf_notlike($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(is_string($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .' not like ' . $this->build($exp2) . ')';
	}

	function mf_exp($op) {
		$args = func_get_args();
		$op = $args[0];
		array_shift($args);
		$conds = array();
		foreach($args as $exp) {
			$conds[] = $this->build($exp);
		}
		return '(' . implode(' '.$op.' ', $conds) . ')';
	}

	function mf_and() {
		$args = func_get_args();
		array_unshift($args, 'and');
		return call_user_func_array(array($this, 'mf_exp'), $args);
	}

	function mf_or() {
		$args = func_get_args();
		array_unshift($args, 'or');
		return call_user_func_array(array($this, 'mf_exp'), $args);
	}
	
	function mf_in($col, $arr) {
		if(!is_array($arr)) {
			return false;
		}
		$col = $this->mf_makecol($col);
		$arr = $this->mf_string_array($arr);
		return $col. ' in (' . implode(', ', $arr) . ')';
	}
	
	function mf_string_array($arr) {
		$rs = array();
		foreach($arr as $key => $val) {
			$rs[$key] = $this->mf_string($val);
		}
		return $rs;
	}
	
	function mf_notin($col, $arr) {
		if(!is_array($arr)) {
			return false;
		}
		$col = $this->mf_makecol($col);
		$arr = $this->mf_string_array($arr);
		return $col. ' not in (' . implode(', ', $arr) . ')';
	}
	
	function mf_isnull($col) {
		$col = $this->mf_makecol($col);
		return $col. ' is null';
	}
	
	function mf_isnotnull($col) {
		$col = $this->mf_makecol($col);
		return $col. ' is not null';
	}
	
	function mf_makecol($col) {
		if (is_string($col)) {
			return $this->mf_column($col);
		} else if (is_array($col)) {
			return $this->build($col);
		}
	}
	
	function mf_gt($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(!$exp2) { $exp2 = '0'; }
		if(is_string($exp2) || is_numeric($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'>' . $this->build($exp2) . ')';
	}
	function mf_gte($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(!$exp2) { $exp2 = '0'; }
		if(is_string($exp2) || is_numeric($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'>=' . $this->build($exp2) . ')';
	}
	function mf_lt($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(!$exp2) { $exp2 = '0'; }
		if(is_string($exp2) || is_numeric($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'<' . $this->build($exp2) . ')';
	}
	function mf_lte($exp1, $exp2) {
		if(is_string($exp1)) {
			$exp1 = array('column', $exp1);
		}
		if(!$exp2) { $exp2 = '0'; }
		if(is_string($exp2) || is_numeric($exp2)) {
			$exp2 = array('string', $exp2);
		}
		return '(' . $this->build($exp1) .'<=' . $this->build($exp2) . ')';
	}
}