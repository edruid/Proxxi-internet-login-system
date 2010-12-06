<?php
class AccessC extends Controller {
	protected $_default_site = 'index';
	public function index($params) {
		$this->_access_type('html');
		global $session;
		$this->_register('accesses', Access::selection(array(
			'@order' => 'name',
		)));
		if($session) {
			$current_user = $session->User;
			$this->_register('current_user', $current_user);
		}
		$this->_display('index');
		new LayoutC('html');
	}

	public function edit($params) {
		$this->_access_type('html');
		global $session;
		if($session == null || !$session->User->has_access('edit_access')) {
			Message::add_error("Du har inte access att redigera rättigheter");
			URL::redirect('');
		}
		$access = Access::from_code_name(array_shift($params));
		if($access == null) {
			Message::add_error("Rättigheten du försöker redigera finns inte");
			URL::redirect('/Access/index');
		}
		$this->_register('access', $access);
		$this->_display('edit');
		new LayoutC('html');
	}

	public function create($params) {
		$this->_access_type('html');
		global $session;
		if($session == null) {
			Message::add_error("Du måste vara inloggad för att skapa nya rättigheter");
			URL::redirect('');
		}
		$current_user = $session->User;
		if(!$current_user->has_access('edit_access')) {
			Message::add_error("Du har inte access att skapa nya rättigheter");
			URL::redirect('');
		}
		$this->_register('current_user', $current_user);
		$this->_display('create');
		new LayoutC('html');
	}

	public function make($params) {
		$this->_access_type('script');
		global $session;
		if($session == null || !$session->User->has_access('edit_access')) {
			Message::add_error("Du har inte access att skapa nya rättigheter");
			URL::redirect('');
		}
		try{
			$setting = new Access();
			$setting->name = ClientData::post('name');
			$setting->code_name = ClientData::post('code_name');
			$setting->commit();
			URL::redirect('/Access/index');
		} catch(Exception $e) {
			Message::add_error($e->getMessage());
			URL::redirect('/Access/create');
		}
	}

	public function modify($params) {
		$this->_access_type('script');
		global $session;
		if($session == null || !$session->User->has_access('edit_access')) {
			Message::add_error("Du har inte access att redigera rättigheter");
			URL::redirect('');
		}
		$access = Access::from_id(ClientData::post('access_id'));
		if(!$access) {
			Message::add_error("Rättigheten du försöker redigera finns inte");
			URL::redirect('/Access/index');
		}
		try {
			$access->name= ClientData::post('name');
			$access->commit();
			Message::add_notice("Rättigheten updaterad");
			URL::redirect('/Access/index');
		} catch(Exception $e) {
			Message::add_error($e);
			URL::redirect();
		}
	}
}
?>
