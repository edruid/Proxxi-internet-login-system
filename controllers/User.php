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
		self::_partial('Layout/html', $this);
	}

	public function table($params) {
		$this->_register('users', array_shift($params));
		$this->_register('caption', array_shift($params));
	}

	public function view($params) {
		$this->_access_type('html');
		global $current_user;
		if($current_user == null) {
			Message::add_error('Logga in för att få titta på medlemmar');
			URL::redirect('');
		}
		$username = array_shift($params);
		if(!$current_user->is_member() && !$current_user->has_access('view_user') && $current_user->username != $username) {
			Message::add_error('Du måste vara medlem för att se andra medlemmar');
			URL::redirect('');
		}
		$user = User::from_username($username);
		if(!$user) {
			$this->unknown_user($params);
			return;
		}
		$this->_register('title', $user->username);
		$this->_register('user', $user);
		self::_partial('Layout/html', $this);
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
		self::_partial('Layout/html', $this);
	}

	public function create($params) {
		$this->_access_type('html');
		$this->_register('eulas', User::get_eulas());
		self::_partial('Layout/html', $this);
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
			'co',
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
		foreach(User::get_eulas() as $eula) {
			if(ClientData::post("eula/{$eula->code_name}") != 'on') {
				$error = true;
				Message::add_error("Du måste godkänna föreningens {$eula->name} för att bli medlem");
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
			'co',
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

	public function export($params) {
		$this->_access_type('html');
		global $current_user;
		if($current_user == null || !$current_user->has_access('view_user')) {
			Message::add_error('Du har inte access att se allt medlemsdata.');
			URL::redirect('');
		}
		$date = array_shift($params);
		if(preg_match('/^[0-9]{4}$/', $date)) {
			$date = "$date-12-31";
		} elseif(!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date)) {
			$date = date('Y-12-31');
		}
		$memberships = Membership::selection(array(
			'@order' => 'User.birthdate',
			'end:>=' => $date,
			'start:<=' => $date,
		));
		$this->_register('date', $date);
		$this->_register('memberships', $memberships);
		$this->_register('title', 'Användarexport');
		self::_partial('Layout/html', $this);
	}
}
?>
