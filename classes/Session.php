<?php
class Session extends BasicObject {
	const TIMEOUT = 1800;

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'sessions';
	}

	public static function selection($params = array(), $debug = false) {
		$use_timeout = true;
		foreach($params as $key => $value) {
			if(substr($key, 0, 4) == 'time') {
				$use_timeout = false;
			}
		}
		if($use_timeout) {
			$params['time:>='] = date('Y-m-d H:i:s', time()-self::TIMEOUT);
		}
		return parent::selection($params, $debug);
	}

	public static function from_id($id) {
		static $been_here = false;
		$params = array(
			'session_id' => $id,
			'time:>=' => date('Y-m-d H:i:s', time()-self::TIMEOUT),
		);
		$session = parent::selection($params);
		$session = array_shift($session);
		if(!$been_here && $id == session_id() && $session != null) {
			$been_here = true;
			global $db;
			$null = null;
			$db->prepare_full("
				UPDATE `sessions`
				SET `time` = NOW()
				WHERE session_id = ?", $null, 's', $id);
		}
		return $session;
	}

	public static function clear_old_sessions() {
		$sessions = parent::selection(array(
			'time:<' => date('Y-m-d H:i:s', time()-self::TIMEOUT),
		));
		foreach($sessions as $session){
			$session->delete();
		}
	}

	public function __get($key) {
		switch($key) {
			case 'user_id':
				return $this->_data['user_id'];
			default:
				return parent::__get($key);
		}
	}

	public function __toString() {
		return $this->mac;
	}
}
?>
