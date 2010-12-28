<?php
class UserC extends Controller {
	public function index($input) {
		$this->_access_type('html');
		global $current_user;
		$params = array();
		$params['@order'] = array(
			'surname',
			'first_name',
		);
		if($current_user == null || !$current_user->has_access('view_user')) {
			$params['UserSetting.Setting.code_name'] = 'show_attendance';
			$params['Membership.end:>='] = date('Y-12-31');
		}
		$count = User::count($params);
		$this->_register('count', $count);
		$start = array_shift($input);
		if(is_numeric($start)) {
			$params['@limit'] = array($start, 100);
			$this->_register('start', $start);
		} else {
			$this->_register('start', 0);
		}
		$users = User::selection($params);
		$this->_register('users', $users);
		$this->_register('title', 'Användare');
		$this->_display('index');
		new LayoutC('html');
	}

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
		global $session, $current_user;
		if($session == null){
			URL::redirect('');
		}
		$user = User::from_username(array_shift($params));
		if(!$user) {
			$this->unknown_user($params);
			return;
		}
		if(!$user->may_be_edited($current_user)) {
			throw new Exception("You do not have access to edit $user");
		}
		$this->_register('user', $user);
		$admin = $current_user->has_access('edit_user');
		$this->_register('admin', $admin);
		if($current_user->may_grant()) {
			new UserGroupC('edit', array($user));
		}
		if($current_user->has_access('edit_membership')) {
			new MembershipC('create', array($user));
		}
		if($current_user->id == $user->id) {
			new AvatarC('edit', array($user));
			new UserSettingC('edit', array($user));
		}
		$this->_display('edit');
		new LayoutC('html');
	}

	public function create($params) {
		$this->_access_type('html');
		$this->_register('settings', Setting::selection(array('@order' => 'name')));
		$this->_display('create');
		new LayoutC('html');
	}

	public function make($params) {
		$this->_access_type('script');
		global $db;
		$db->autocommit(false);
		$fields = array(
			'username',
			'first_name',
			'surname',
			'birthdate', 
			'person_id_number',
			'sex',
			'phone1',
			'phone2',
			'email',
			'street_address',
			'area_code',
			'area',
			'password'
		);
		$error = false;
		if(ClientData::post('password') != ClientData::post('confirm_password')) {
			Message::add_error("Lösenorden matchar inte varandra");
			$error = true;
		}
		$user = new User();
		foreach($fields as $field) {
			try{
				$user->$field = ClientData::post($field);
			} catch(UserException $e) {
				Message::add_error($e->getMessage());
				$error = true;
			}
		}
		if(!$error) {
			try{
				$user->commit();
			} catch(UserException $e) {
				Message::add_error($e->getMessage());
				$error = true;
			}
		}
		if(!$error) {
			foreach(Setting::selection() as $setting) {
				if(ClientData::post('setting/'.$setting->code_name) == 'on') {
					try{
						$user_setting = new UserSetting();
						$user_setting->user_id = $user->id;
						$user_setting->setting_id = $setting->id;
						$user_setting->commit();
					} catch(Exception $e) {
						Message::add_error($e->getMessage());
						$error = true;
					}
				}
			}
		}
		if($error) {
			$data = $_POST;
			unset($data['password']);
			unset($data['old_password']);
			unset($data['confirm_password']);
			ClientData::defaults_set($data);
			URL::redirect("/User/create");
		} else {
			$db->commit();
			Message::add_notice("Användare {$user->username} skapad");
			URL::redirect("/User/edit/{$user->username}");
		}
	}

	public function modify($params) {
		$this->_access_type('script');
		$error = false;
		global $session, $current_user;
		if($session == null){
			URL::redirect('');
		}
		if(!$current_user->has_password(ClientData::post('old_password'))) {
			Message::add_error("Fel lösenord.");
			$error = true;
		}
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
				Message::add_notice('Medlemsdatat är uppdaterat.');
				URL::redirect("/User/edit/{$user->username}");
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
