<?php
class UserGroupC extends Controller {
	public function edit($params) {
		$this->_access_type('html');
		$user = $this->_get('user');
		$current_user = $this->_get('current_user');
		if($current_user->has_access('view_access')) {
			$this->_register('groups', Group::selection(array(
				'@order' => 'name',
			)));
			$this->_display('edit');
		} else {
			$this->_display(null);
		}
	}

	public function modify($params) {
		$this->_access_type('script');
		global $session;
		if(!$session) {
			Message::add_error("Du måste vara inloggad för att ändra gupper.");
			URL::redirect('');
		}
		$user = User::from_username(array_shift($params));
		if($user == null) {
			Message::add_error('Okänd användare');
			URL::redirect('');
		}
		$current_user = $session->User;
		$groups = Group::selection();
		$user_groups_tmp = $user->UserGroup();
		$user_groups = array();
		foreach($user_groups_tmp as $user_group) {
			$user_groups[$user_group->group_id] = $user_group;
		}
		unset($user_groups_tmp);
		foreach($groups as $group) {
			if($group->may_grant($current_user)) {
				if(array_key_exists($group->id, $user_groups)) {
					if(ClientData::post($group->code_name) != 'on') {
						$user_groups[$group->id]->delete();
					}
				} else {
					if(ClientData::post($group->code_name) == 'on') {
						$user_group = new UserGroup();
						$user_group->user_id = $user->id;
						$user_group->group_id = $group->id;
						$user_group->commit();
					}
				}
			}
		}
		Message::add_notice("Rättigheter sparade");
		URL::redirect("/User/edit/{$user->username}");
	}
}
?>
