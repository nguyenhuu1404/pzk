<?php
class PzkCoreNotifier extends PzkObjectLightWeight {
	// active, success, info, warning, danger
	/**
	 * Thêm thông điệp để hiển thị
	 * @param string $message: thông điệp
	 * @param string $type: Kiểu thông điệp, có dạng: active, success, info, warning, danger
	 */
	public function addMessage($message, $type = 'success') {
		$messages = $this->getMessages();
		$messages[] = array('message' => $message, 'type' => $type);
		$this->setMessages($messages);
	}
	/**
	 * Lấy ra các thông điệp
	 * @return array
	 */
	public function getMessages() {
		$messages = pzk_session('messages');
		if(!$messages) {
			$messages = array();
		}
		return $messages;
	}
	/**
	 * Lưu lại các thông điệp
	 * @param array $messages
	 */
	public function setMessages($messages) {
		pzk_session('messages', $messages);
	}
	/**
	 * Clear các thông điệp
	 */
	public function clearMessages() {
		pzk_session('messages', array());
	}
}

/**
 * Lấy và clear hết các thông điệp
 * @return array
 */
function pzk_notifier_messages() {
	$notifier = pzk_element('notifier');
	$messages = $notifier->getMessages();
	$notifier->clearMessages();
	return $messages;
}
/**
 * Trả về đối tượng xử lý thông điệp
 * @return PzkCoreNotifier
 */
function pzk_notifier() {
	return pzk_element('notifier');
}
/**
 * Thêm thông điệp
 * @param string $message thông điệp
 * @param string $type kiểu thông điệp: active, success, info, warning, danger
 */
function pzk_notifier_add_message($message, $type) {
	return pzk_element('notifier')->addMessage($message, $type);
}