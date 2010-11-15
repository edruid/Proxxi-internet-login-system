<?php
class LayoutC extends Controller {
	public function html($params) {
		$this->_access_type('html');
		global $session;
		if(!$this->_get('title')) {
			$this->_register('title', 'Pils');
		} else {
			$this->_register('title', 'Pils - '.$this->_get('title'));
		}
		$this->_register('session', $session);
		$this->_display('html');
	}
}
