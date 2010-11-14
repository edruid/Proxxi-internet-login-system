<?php
class UserC extends Controller {
	public function view($params) {
		$user = User::from_username(array_shift($params));
		if(!$user) {
			$this->_register('title', "Okänd användare");
			$this->_display('unknown_user');
			new LayoutC('html');
			return;
		}
		$this->_register('title', $user->username);
		$this->_register('user', $user);
		$this->_display('view');
		new LayoutC('html');
	}

}
