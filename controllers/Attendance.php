<?php
class AttendanceC extends Controller {
	public function create($params) {
		$this->_access_type('html');
		$this->_display('create');
		new LayoutC('html');
	}

	public function make($params) {
		$this->_access_type('script');
		try{
			$attendance = new Attendance();
			$attendance->day = ClientData::post('day');
			$attendance->user = ClientData::post('username');
			$attendance->commit();
		} catch(Exception $e) {
			Message::add_error($e->getMessage());
			URL::redirect();
		}
		Message::add_notice("{$attendance->User} är nu registrerad som närvarande {$attendance->day}.");
		URL::redirect();
	}
}
?>
