<?php
class LayoutC extends Controller {
	public function html($params) {
		$this->_access_type('html');
		global $session, $current_user;
		if(!$this->_get('title')) {
			$this->_register_global('title', 'Pils');
		} else {
			$this->_register_global('title', 'Pils - '.$this->_get('title'));
		}
		$this->_register_global('session', $session);
		$this->_register_global('current_user', $current_user);
		$this->_register('content', $params->_path);
	}
}
?>
