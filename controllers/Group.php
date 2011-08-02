<?php
class GroupC extends Controller {
	protected $_default_site = 'index';
	public function index($params) {
		$this->_access_type('html');
		global $current_user;
		if($current_user == null) {
			Message::add_error('Du måste vara inloggad först.');
			URL::redirect('');
		}
		$this->_register('groups', Group::selection(array(
			'@order' => 'name',
		)));
		self::_partial('Layout/html', $this);
	}

	public function edit($params) {
		$this->_access_type('html');
		global $current_user;
		if($current_user == null || !$current_user->has_access('edit_group')) {
			URL::redirect('');
		}
		$group = Group::from_id(array_shift($params));
		if($group == null) {
			Message::add_error("Gruppen du försöker redigera finns inte");
			URL::redirect('/Group/index');
		}
		$this->_register('group', $group);
		self::_partial('Layout/html', $this);
	}

	public function create($params) {
		$this->_access_type('html');
		global $current_user;
		if($current_user == null || !$current_user->has_access('edit_group')) {
			Message::add_error("Du har inte access att skapa nya grupper");
			URL::redirect('');
		}
		self::_partial('Layout/html', $this);
	}

	public function make($params) {
		$this->_access_type('script');
		global $current_user;
		if($current_user == null || !$current_user->has_access('edit_group')) {
			Message::add_error("Du har inte access att skapa nya grupper");
			URL::redirect('');
		}
		try{
			$setting = new Group();
			$setting->name = ClientData::post('name');
			$setting->commit();
			URL::redirect('/Group/index');
		} catch(Exception $e) {
			Message::add_error($e->getMessage());
			URL::redirect('/Group/Create');
		}
	}

	public function modify($params) {
		$this->_access_type('script');
		global $current_user;
		if($current_user == null || !$current_user->has_access('edit_group')) {
			Message::add_error("Du har inte access att redigera grupper");
			URL::redirect('');
		}
		$group = Group::from_id(array_shift($params));
		if(!$group) {
			Message::add_error("Gruppen du försöker redigera finns inte");
			URL::redirect('/Group/index');
		}
		try {
			$group->name= ClientData::post('name');
			$group->commit();
			Message::add_notice("Gruppen updaterad");
			URL::redirect('/Group/index');
		} catch(Exception $e) {
			Message::add_error($e);
			URL::redirect();
		}
	}

	public function view($params) {
		$this->_access_type('html');
		$group = Group::from_id(array_shift($params));
		$params = array(
			'@or' => array(
				'UserGroup.permanent' => true,
				'UserGroup.valid_until:>=' => date('Y-m-d'),
			),
			'UserGroup.group_id' => $group->id,
		);
		$users = User::selection($params);
		self::_declare('User/table', $users);
		$this->_register_global('caption', 'Gruppmedlemmar');
		$this->_register('group', $group);
		self::_partial('Layout/html', $this);
	}
}
?>
