<?php
class StaticC extends Controller {
	public function stadgar($params) {
		$this->_access_type('html');
		$this->_register('title', 'Stadgar');
		$this->_display('stadgar');
		new LayoutC('html');
	}

	public function internet_rules($params) {
		$this->_access_type('html');
		global $current_user;
		$this->_register('logged', $current_user != null);
		$this->_register('is_18', (
			$current_user != null &&
			(
				substr($current_user->birthdate, 0, 4) < date('Y') - 18 ||
				(
					substr($current_user->birthdate, 0, 4) == date('Y') - 18 &&
					substr($current_user->birthdate, 5) >= date('m-d')
				)
			)
		));
		$this->_register('title', 'Internetavtal');
		$this->_display('internet_rules');
		new LayoutC('html');
	}

	public function rules($params) {
		$this->_access_type('html');
		$this->_register('title', 'Lokalregler');
		$this->_display('rules');
		new LayoutC('html');
	}

	public function pul($params) {
		$this->_access_type('html');
		$this->_register('title', 'Personuppgiftsbehandling');
		$this->_display('pul');
		new LayoutC('html');
	}
}
