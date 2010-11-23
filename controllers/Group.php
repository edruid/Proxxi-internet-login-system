<?php
class GroupC extends Controller {
	public function index($params) {
		$this->_access_type('html');
		global $session;
		$this->_register('groups', Group::selection(array(
			'@order' => 'name',
		)));
		$this->_display('index');
		new LayoutC('html');
	}

	public function edit($params) {
		$this->_access_type('html');
		global $session;
		if($session == null || !$session->User->has_access('group_editor')) {
			Message::add_error("Du har inte access att redigera grupper");
			URL::redirect('');
		}
		$group = Group::from_id(ClientData::post(array_shift($group)));
		if(!$group) {
			Message::add_error("Gruppen du försöker redigera finns inte");
			URL::redirect('/Group/index');
		}
		$this->_register('group', $group);
		$this->_display('edit');
		new LayoutC('html');
	}

	public function create($params) {
		$this->_access_type('html');
		global $session;
		if($session == null || !$session->User->has_access('group_editor')) {
			Message::add_error("Du har inte access att skapa nya grupper");
			URL::redirect('');
		}
		$this->_display('create');
		new LayoutC('html');
	}

	public function make($params) {
		$this->_access_type('script');
		global $session;
		if($session == null || !$session->User->has_access('group_editor')) {
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
		global $session;
		if($session == null || !$session->User->has_access('group_editor')) {
			Message::add_error("Du har inte access att redigera grupper");
			URL::redirect('');
		}
		$group = Group::from_id(ClientData::post('group_id'));
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
}
?>
