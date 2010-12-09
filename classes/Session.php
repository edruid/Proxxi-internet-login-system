<?php

class Session extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'sessions';
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
