<?php
class UserSettingC extends Controller {
	public function edit($params) {
		$this->_access_type('html');
		global $current_user;
		$user = array_shift($params);
		if($user->id == $current_user->id) {
			$this->_register('settings', Setting::selection(array(
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
			Message::add_error("Du måste vara inloggad för att ändra settings.");
			URL::redirect('');
		}
		$user = $session->User;
		$settings = Setting::selection();
		$user_settings_tmp = $user->UserSetting();
		$user_settings = array();
		foreach($user_settings_tmp as $user_setting) {
			$user_settings[$user_setting->setting_id] = $user_setting;
		}
		unset($user_settings_tmp);
		foreach($settings as $setting) {
			if(array_key_exists($setting->id, $user_settings)) {
				if(ClientData::post($setting->code_name) != 'on') {
					$user_settings[$setting->id]->delete();
				}
			} else {
				if(ClientData::post($setting->code_name) == 'on') {
					$user_setting = new UserSetting();
					$user_setting->user_id = $user->id;
					$user_setting->setting_id = $setting->id;
					$user_setting->commit();
				}
			}
		}
		Message::add_notice("Inställningar updaterade");
		URL::redirect("/User/edit/{$user->username}");
	}
}
?>
