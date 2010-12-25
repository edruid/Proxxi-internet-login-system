<?php
class SessionC extends Controller {
	public function create($params) {
		$this->_access_type('html');
		$this->_display('create');
	}

	public function make($params) {
		$this->_access_type('script');
		if(Session::from_id(session_id()) != null) {
			Message::add_warning('Du är redan inloggad. Logga ut först för att logga in som någon annan.');
			URL::redirect($_SERVER['HTTP_REFERER']);
		}
		$user = User::from_username(ClientData::post('username'));
		if(!$user || !$user->has_password(ClientData::post('password'))) {
			Message::add_error('Fel användarnamn eller lösenord');
			URL::redirect($_SERVER['HTTP_REFERER']);
		}
		Session::clear_old_sessions();
		$session = new Session();
		$session->user_id = $user->id;
		$session->session_id = session_id();
		$session->mac = Network::get_mac();
		$session->internet = $user->has_access('internet') && Network::is_local($session->mac);
		$session->commit();
		Message::add_notice("Välkommen {$user->first_name}");
		URL::redirect($_SERVER['HTTP_REFERER']);
	}

	public function delete($params) {
		$this->_access_type('script');
		$session = Session::from_id(session_id());
		$session->delete();
		session_destroy();
		URL::redirect('');
	}
}
?>
