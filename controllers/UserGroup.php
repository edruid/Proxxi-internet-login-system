<?php
class UserGroupC extends Controller {
	public function edit($params) {
		$this->_access_type('html');
		global $current_user;
		$user = array_shift($params);
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
		global $session, $current_user;
		if(!$session) {
			Message::add_error("Du måste vara inloggad för att ändra gupper.");
			URL::redirect('');
		}
		$user = User::from_username(array_shift($params));
		if($user == null) {
			Message::add_error('Okänd användare');
			URL::redirect('');
		}
		$groups = Group::selection();
		$user_groups_tmp = $user->UserGroup();
		$user_groups = array();
		foreach($user_groups_tmp as $user_group) {
			$user_groups[$user_group->group_id] = $user_group;
		}
		unset($user_groups_tmp);
		foreach($groups as $group) {
			if($group->may_grant($current_user)) {
				if(!array_key_exists($group->id, $user_groups) &&
						ClientData::post($group->id) == 'off') {
					continue;
				}
				if(!array_key_exists($group->id, $user_groups)) {
					$user_group = new UserGroup();
					$user_group->user_id = $user->id;
					$user_group->group_id = $group->id;
				} else {
					$user_group = $user_groups[$group->id];
				}
				switch(ClientData::post($group->id)){
					case 'off':
						$user_group->delete();
						break;
					case 'permanent':
						$user_group->permanent = true;
						$user_group->commit();
						break;
					case 'timed':
						$user_group->permanent = false;
						$user_group->valid_until = ClientData::post("group_{$group->id}/valid_until");
						$user_group->commit();
						break;
					default:
						throw new Exception("Failed to parse data for access: \"$group\". Are you messing with the forms?");
				}
			}
		}
		Message::add_notice("Rättigheter sparade");
		URL::redirect("/User/edit/{$user->username}");
	}
}
?>
