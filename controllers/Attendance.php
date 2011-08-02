<?php
class AttendanceC extends Controller {
	protected $_default_site = 'create';
	public function create($params) {
		$this->_access_type('html');
		self::_partial('Layout/html', $this);
	}

	public function make($params) {
		$this->_access_type('script');
		try{
			$attendance = new Attendance();
			$attendance->day = ClientData::post('day');
			$attendance->user = ClientData::post('username');
			$attendance->commit();
		} catch(WarningException $e) {
			Message::add_warning($e->getMessage());
			URL::redirect();
		} catch(Exception $e) {
			Message::add_error($e->getMessage());
			URL::redirect();
		}
		Message::add_notice("{$attendance->User} är nu registrerad som närvarande {$attendance->day}.");
		URL::redirect();
	}

	public function index($params) {
		$this->_access_type('html');
		global $current_user;
		if($current_user == null || (!$current_user->is_member() && !$current_user->has_access('view_user'))) {
			Message::add_error('Du måste vara inloggad och medlem för att se vilka som är i lokalen.');
			URL::redirect('');
		}
		$date = strtotime(array_shift($params));
		if($date == false) {
			$date = time();
		}
		$date = date('Y-m-d', $date);
		$params['Attendance.day'] = $date;
		$count = User::count($params);
		if(!$current_user->has_access('view_user')) {
			$params['UserSetting.Setting.code_name'] = 'show_attendance';
		}
		$users = User::selection($params);
		$this->_register('users', $users);
		$this->_register('date', $date);
		$this->_register('count', $count);
		self::_partial('Layout/html', $this);
	}
}
?>
