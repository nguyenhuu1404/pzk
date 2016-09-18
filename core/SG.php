<?php
/**
 * 
 * @author kienhang
 * Setter và Getter class: lớp này dùng để thực thi hàm ảo set, get, has, del, clear<br />
 * Ứng dụng dạng lưu trữ theo cặp key, value như cache file, memcache, redis, session,...<br />
 * @see PzkSGStoreDriverFile
 * @see PzkSGStoreDriverMemcache
 * @see PzkSGStoreDriverRedis
 * @see PzkSGStoreSession
 * @example <code>
 * $sg = new PzkSG();<br />
 * $sg->setName('John Doe');<br />
 * echo $sg->getName(); // will echo 'John Doe';
 * </code>
 */
class PzkSG {
	/**
	 * Hàm lấy giá trị theo khóa
	 * @param $key khóa
	 * @param $timeout thời gian hết hạn của khóa
	 * @return Giá trị theo khóa
	 * @example <code>
	 * $sg = new PzkSG();<br />
	 * $sg->set('name', 'John Doe');<br />
	 * echo $sg->get('name'); // will echo 'John Doe';
	 * echo $sg->get('name', 1800); // will echo 'John Doe'; hết hạn trong nửa tiếng
	 * </code>
	 */
	public function get($key, $timeout = null) {
		return isset($this->$key)?$this->$key : null;
	}
	
	/**
	 * Hàm đặt giá trị theo khóa
	 * @param $key khóa
	 * @param $value giá trị cần đặt
	 * @example <code>
	 * $sg = new PzkSG();<br />
	 * $sg->set('name', 'John Doe');<br />
	 * echo $sg->get('name'); // will echo 'John Doe';
	 * </code>
	 */
	public function set($key, $value) {
		$this->$key = $value;
	}
	
	/**
	 * Hàm kiểm tra xem khóa có tồn tại hay không
	 * @param string $key khóa
	 * @return bool
	 * @example <code>
	 * $sg = new PzkSG();<br />
	 * $sg->set('name', 'John Doe');<br />
	 * echo $sg->get('name'); // will echo 'John Doe';<br />
	 * var_dump($sg->has('name')); // echo true;<br />
	 * var_dump($sg->has('age')); // echo false;<br />
	 * var_dump($sg->hasName()); // echo true;<br />
	 * var_dump($sg->hasAge()); // echo false;<br />
	 * </code>
	 */
	public function has($key) {
		return isset($this->$key);
	}
	
	public function del($key) {
		unset($this->$key);
	}
	
	/**
	 * Ham xoa tat ca cac du lieu trong kho
	 */
	public function clear() {
	}
	
	public function __call($name, $arguments) {
		$prefix = substr($name, 0, 3);
		$property = strtolower($name[3]) . substr($name, 4);
		switch ($prefix) {
			case 'get':
				return $this->get($property, isset($arguments[0])?$arguments[0]: null, isset($arguments[1])?$arguments[1]: null);
				break;
			case 'set':
				//Always set the value if a parameter is passed
				if (count($arguments) != 1) {
					throw new \Exception("Setter for $name requires exactly one parameter.");
				}
				$this->set($property, $arguments[0]);
				//Always return this (Even on the set)
				return $this;
			case 'has':
				return $this->has($property);
				break;
			case 'del':
				return $this->del($property);
				break;
			default:
				throw new \Exception("Property $name doesn't exist.");
				break;
		}
	}
	
	/**
	 * Hàm lấy dữ liệu dựa vào các trường được chỉ định
	 * @example <code>
	 * $sg = new PzkSG();<br />
	 * $sg->getFilterData(); // return all data<br />
	 * $sg->getFilterData('name, category, created');<br /> 
	 * $sg->getFilterData('name', 'category', 'created');<br /> 
	 * $sg->getFilterData(array('name', 'category', 'created'));<br /> 
	 * 	// return array(name => , category => , created => );<br />
	 * 
	 * </code>
	 * @return array|multitype:gia
	 */
	public function getFilterData() {
		$fields = array();
		$arguments = func_get_args();
		if(count($arguments) == 0) {
			if(is_a($this, 'PzkCoreRequest'))
			return (array)$this->query;
			else
				return (array)$this;
		} else if(count($arguments) == 1) {
			if(is_string($arguments[0])) {
				$fields = explodetrim(',', $arguments[0]);
			} else if (is_array($arguments[0])) {
				$fields = $arguments[0];
			}
		} else {
			$fields = $arguments;
		}
		$data = array();
		foreach($fields as $field) {
			$data[$field] = $this->get($field);
		}
		return $data;
	}
}