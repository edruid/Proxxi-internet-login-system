<?php
class GroupAccessC extends Controller {
	public function index($params) {
		$this->_access_type('html');
		global $session;
		$this->_register('group_accesses', GroupAccess::selection(array(
			'@order' => 'name',
		)));
		$this->_display('index');
		new LayoutC('html');
	}

	public function edit($params) {
		$this->_access_type('html');
		global $session;
		if($session == null || !$session->User->has_access('group_access_editor')) {
			Message::add_error("Du har inte access att redigera grupp accesser");
			URL::redirect('');
		}
		$group = Group::from_id(array_shift($params));
		if($group == null) {
			Message::add_error("Okänd grupp.");
			URL::redirect('/Group/index');
		}
		$accesses = Access::selection(array(
			'@order' => 'name',
		));
		$this->_register('accesses', $accesses);
		$this->_display('edit');
	}

	public function modify($params) {
		$this->_access_type('script');
		global $session;
		if($session == null || !$session->User->has_access('group_access_editor')) {
			Message::add_error("Du har inte access att redigera grupp accesser");
			URL::redirect('');
		}
		$group = Group::from_id(array_shift($params));
		$group_accesses_tmp = $group->GroupAccess();
		foreach($group_accesses_tmp as $group_access) {
			$group_accesses[$group_access->access_id] = $group_access;
		}
		$accesses = Access::selection();
		foreach($accesses as $access) {
			if(!array_key_exists($access->id, $group_accesses) && ClientData::post('permanent') == 'off') {
				continue;
			}
			if(!array_key_exists($access->id, $group_accesses)) {
				$group_access = new GroupAccess();
				$group_access->group_id = $group->id;
				$group_access->access_id = $access->id;
			} else {
				$group_access = $group_accesses[$access->id];
			}
			switch(ClientData::post($access->code_name)) {
				case 'off':
					$group_access->delete();
					break;
				case 'permanent':
					$group_access->permanent = true;
					$group_access->commit();
					break;
				case 'timed':
					$group_access->permanent = false;
					$group_access->valid_until = ClientData::post("{$access->code_name}/valid_until");
					$group_access->commit();
					break;
				default:
					$t = ClientData::post('permanent');
					var_dump($t);
					throw new Exception("Failed to parse data for access: \"$access\". Are you messing with the forms?");
			}
		}
		Message::add_notice("Ändringar sparade");
		URL::redirect("/Group/edit/$group->id");
	}
}
?>
