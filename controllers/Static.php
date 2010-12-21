<?php
class StaticC extends Controller {
	public function stadgar($params) {
		$this->_access_type('html');
		$this->_register('title', 'Stadgar');
		$this->_display('stadgar');
		new LayoutC('html');
	}

	public function rules($params) {
		$this->_access_type('html');
		$this->_register('title', 'Lokalregler');
		$this->_display('rules');
		new LayoutC('html');
	}
}
