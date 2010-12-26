<?php
class AvatarC extends Controller {
	public function view($params) {
		$this->_access_type('image');
		$user = User::from_username(substr(array_shift($params), 0, -4));
		if($user == null) {
			throw new Exception('No such user');
		}
		$avatar = $user->Avatar();
		if($avatar == null) {
			URL::redirect('/gfx/default.jpg');
		}
		header("Content-type: image/jpeg");
		echo $avatar->avatar;
	}

	public function edit($params) {
		$this->_access_type('html');
		global $current_user;
		$user = array_shift($params);
		if($current_user == null) {
			throw new Exception("Du måste vara inloggad för att byta bild.");
		}
		if($user == null) {
			throw new Exception("Hittade ingen sådan användare.");
		}
		if($user->id != $current_user->id) {
			throw new Exception("Du får inte byta någon annans bild.");
		}
		$this->_display('edit');
	}

	public function modify($params) {
		$this->_access_type('script');
		global $current_user;
		$user = User::from_username(array_shift($params));
		if($current_user == null) {
			throw new Exception("Du måste vara inloggad för att byta bild.");
		}
		if($user == null) {
			throw new Exception("Hittade ingen sådan användare.");
		}
		if($user->id != $current_user->id) {
			throw new Exception("Du får inte byta någon annans bild.");
		}
		try{
			$avatar = $user->Avatar();
			if($avatar == null) {
				$avatar = new Avatar();
				$avatar->user_id = $user->id;
			}
			if(ClientData::post('remove')) {
				$avatar->delete();
				$msg = 'Avataren är borttagen';
			} elseif(ClientData::post('change')) {
				$avatar->avatar = $_FILES['avatar'];
				$avatar->commit();
				$msg = 'Avataren är utbytt';
			}
		} catch(Exception $e) {
			Message::add_error($e->getMessage());
			URL::redirect();
		}
		Message::add_notice($msg);
		URL::redirect();
	}
}
?>
