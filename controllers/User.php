<?php
class UserC extends Controller {
	public function view($params) {
		$this->_access_type('html');
		$user = User::from_username(array_shift($params));
		if(!$user) {
			$this->unknown_user($params);
			return;
		}
		$this->_register('title', $user->username);
		$this->_register('user', $user);
		$this->_display('view');
		new LayoutC('html');
	}

	public function edit($params) {
		$this->_access_type('html');
		global $session;
		if($session == null){
			URL::redirect('');
		}
		$current_user = $session->User;
		$user = User::from_username(array_shift($params));
		if(!$user) {
			$this->unknown_user($params);
			return;
		}
		if(!$user->may_be_edited($current_user)) {
			throw new Exception("You do not have access to edit $user");
		}
		$this->_register('current_user', $current_user);
		$this->_register('user', $user);
		$this->_display('edit');
		new LayoutC('html');
	}

	public function modify($params) {
		$this->_access_type('script');
		global $session;
		if($session == null){
			URL::redirect('');
		}
		$current_user = $session->User;
		$user = User::from_id(ClientData::post('user'));
		if(!$user) {
			URL::redirect('User/unknown_user');
		}
		if(!$user->may_be_edited($current_user)) {
			throw new Exception("You do not have access to edit $user");
		}
		$fields = array(
			'phone1', 
			'phone2',
			'email',
			'street_address',
			'area_code',
			'area',
			'password',
		);
		if($current_user->has_access('edit_user')) {
			$fields[] = 'username';
			$fields[] = 'first_name';
			$fields[] = 'surname';
			$fields[] = 'birthdate';
			$fields[] = 'person_id_number';
			$fields[] = 'sex';
		}
		$error = false;
		if(ClientData::post('password') != ClientData::post('confirm_password')) {
			$error = true;
			Message::add_error("Lösenorden matchar inte varandra");
		}
		foreach($fields as $field) {
			try{
				$user->$field = ClientData::post($field);
			} catch(UserException $e) {
				$error = true;
				Message::add_error($e->getMessage());
			}
		}
		if(!$error) {
			try{
				$user->commit();
				URL::redirect("/User/view/{$user->username}");
			} catch(UserException $e) {
				Message::add_error($e->getMessage());
			}
		}
		$data = $_POST;
		unset($data['password']);
		unset($data['old_password']);
		unset($data['confirm_password']);
		ClientData::session_set('_POST', $post);
		URL::redirect("/User/edit/{$user->username}");
	}
}
?>
