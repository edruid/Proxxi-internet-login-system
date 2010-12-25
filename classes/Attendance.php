<?php

class Attendance extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'attendance';
	}

	public function __set($key, $value) {
		switch($key) {
			case 'day':
				$value = strtotime($value);
				if($value === false) {
					throw new Exception("Datumet är inte formaterat på ett korrekt sätt. Prova med \"YYY-MM-DD\"");
				}
				if($value > time()) {
					throw new Exception("Datumet är i framtiden.");
				}
				$value = date('Y-m-d', $value);
				break;
			case 'user':
				$user = User::from_username($value);
				if($user == null) {
					$user = User::selection(array(
						'@manual_query' => array(
							'where' => "CONCAT(`users`.`first_name`, ' ', `users`.`surname`) = ?",
							'types' => 's',
							'params' => array($value),
						),
					));
					if(count($user) == 1) {
						$user = $user[0];
					}
				}
				if($user == null) {
					throw new Exception("Hittade ingen användare \"$value\".");
				}
				return $this->user_id = $user->id;
				break;
		}
		return parent::__set($key, $value);
	}

	public function commit() {
		if(Attendance::count(array(
					'user_id' => $this->user_id,
					'day' => $this->day,
				)) > 0) {
			throw new WarningException("{$this->User->username} är redan rapporterad som här.");
		}
		return parent::commit();
	}
}
?>
