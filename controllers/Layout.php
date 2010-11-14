<?php
class LayoutC extends Controller {
	public function html($params) {
		if(!$this->_get('title')) {
			$this->_register('title', 'Pils');
		} else {
			$this->_register('title', 'Pils - '.$this->_get('title'));
		}
		$this->_register('session', Session::from_session(session_id()));
		$this->_display('html');
	}
}
