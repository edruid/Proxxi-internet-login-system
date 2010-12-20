<?php
class MembershipC extends Controller {
	public function create($params) {
		$this->_access_type('html');
		global $current_user;
		if($current_user == null || !$current_user->has_access('edit_membership')) {
			throw new Exception("Du har inte access att skapa medlemskap.");
		}
		$user = array_shift($params);
		if(!is_object($user)) {
			throw new Exception("Cannot create Membership for non-user: ".var_export($user));
		}
		$membership = $user->Membership(array(
			'@limit' => 1,
			'@order' => 'end:desc',
		));
		$this->_register('membership', array_shift($membership));
		$this->_display('create');
	}

	public function make($params) {
		$this->_access_type('script');
		global $current_user;
		if($current_user == null || !$current_user->has_access('edit_membership')) {
			throw new Exception("Du har inte access att skapa medlemskap.");
		}
		$user = User::from_username(array_shift($params));
		$membership = new Membership();
		$membership->end = ClientData::post('end');
		$membership->user_id = $user->id;
		$membership->commit();
		Message::add_notice('Medlemskapet uppdaterat');
		URL::redirect("/User/edit/{$user->username}");
	}
}
?>
