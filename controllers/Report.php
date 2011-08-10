<?php
class ReportC extends Controller {
	public function stockholms_kommun($params) {
		$year = array_shift($params);
		if($year == null) {
			$year = date('Y');
		}
		$days = array_shift($params);
		if($days == null) {
			$days = 10;
		}
		$this->_register('year', $year);
		$this->_register('lokalbidrag', Report::lokalbidrag($year, $days));
		$this->_register('attendance_grant', Report::attendance_grant($year, $days));
		self::_partial('Layout/html', $this);
	}
}
?>
