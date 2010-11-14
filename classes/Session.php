<?php

class Session extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'sessions';
	}

	public static function from_session($session) {
		static::from_field('session', $session);
	}
}
?>

