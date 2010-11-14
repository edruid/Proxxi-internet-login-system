<?php
class MenuC extends Controller {
	public function menu($params) {
		$this->_register('menu', array(
			'user/index' => 'Användare'
		));
		$this->_display('menu');
	}
}
