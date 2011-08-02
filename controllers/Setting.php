<?php
class SettingC extends Controller {
	public function index($params) {
		$this->_access_type('html');
		global $session;
		$this->_register('settings', Setting::selection(array(
			'@order' => 'name',
		)));
		self::_partial('Layout/html', $this);
	}

	public function edit($params) {
		$this->_access_type('html');
		global $session;
		if($session == null || !$session->User->has_access('edit_setting')) {
			Message::add_error("Du har inte access att redigera inställningar");
			URL::redirect('');
		}
		self::_partial('Layout/html', $this);
	}

	public function create($params) {
		$this->_access_type('html');
		global $session;
		if($session == null || !$session->User->has_access('edit_setting')) {
			Message::add_error("Du har inte access att skapa nya inställningar");
			URL::redirect('');
		}
		self::_partial('Layout/html', $this);
	}

	public function make($params) {
		$this->_access_type('script');
		global $session;
		if($session == null || !$session->User->has_access('edit_setting')) {
			Message::add_error("Du har inte access att skapa nya inställningar");
			URL::redirect('');
		}
		try{
			$setting = new Setting();
			$setting->name = ClientData::post('name');
			$setting->code_name = ClientData::post('code_name');
			$setting->commit();
			URL::redirect('/Setting/index');
		} catch(Exception $e) {
			Message::add_error($e->getMessage());
			URL::redirect('/Setting/Create');
		}
	}

	public function modify($params) {
		$this->_access_type('script');
		global $session;
		if($session == null || !$session->User->has_access('edit_setting')) {
			Message::add_error("Du har inte access att redigera inställningar");
			URL::redirect('');
		}
	}
}
?>
