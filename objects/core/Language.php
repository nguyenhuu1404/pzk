<?php
class PzkCoreLanguage extends PzkObject {
	public $data = array();
	/**
	 * Dịch một đoạn văn bản sang ngôn ngữ khác. dựa vào session language.<br />
	 * Ngôn ngữ mặc định là en<br />
	 * Bản dịch được tìm ở thư mục language/$module/$language<br />
	 * Nếu không tìm thấy thì tìm ở trong thư mục language/global/$language
	 * @param string $module: tên module
	 * @param string $text: văn bản cần dịch
	 * @return string: văn bản đã được dịch
	 */
	public function translateText($module, $text) {
		$language = pzk_session('language') ? pzk_session('language') : 'en';
		$data = $this->load($module . '/' . $language);
		$global = $this->load('global/' . $language);
		if(isset($data[$text])) {
			return $data[$text];
		} else {
			if(isset($global[$text])) {
				return $global[$text];
			} else {
				return $text;
			}
		}
	}
	
	/**
	 * Tải ngôn ngữ của module
	 * @param string $module
	 * @return mixed:
	 */
	public function load($module) {
		if(isset($this->data[$module])) {
			return $this->data[$module];
		} else {
			$this->data[$module] = $this->_loadLanguageData($module);
			return $this->data[$module];
		}
	}
	/**
	 * Tải ngôn ngữ từ file
	 * @param unknown $module
	 * @return multitype:
	 */
	private function _loadLanguageData($module) {
		if(!file_exists('language/' . $module . '.php'))
			return array();
		return require 'language/' . $module . '.php';
	}
}

/**
 * Trả về đối tượng ngôn ngữ
 * @return PzkCoreLanguage
 */
function pzk_language() {
	return pzk_element('language');
}