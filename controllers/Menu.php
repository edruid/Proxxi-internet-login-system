<?php
class MenuC extends Controller {
	public function menu($params) {
		$this->_access_type('html');
		$this->_register('menu', array(
			'user/index' => 'Användare'
		));
	}
}
