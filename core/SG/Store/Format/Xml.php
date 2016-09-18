<?php
class PzkSGStoreFormatXml extends PzkSGStore {
	public function set($key, $value) {
		$arr = pzk_array();
		$arr->setData($value);
		$value = $arr->toXml();
		$this->storage->set($key, $value);
	}
	
	public function get($key, $timeout = NULL) {
		$xml = $this->storage->get($key, $timeout);
		$arr = pzk_array();
		$arr->fromXml($xml);
		return $arr->getData();
	}
}