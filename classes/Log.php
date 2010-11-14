<?php

class Log extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'log';
	}
	
	public function __toString() {
		return $this->description;
	}
}
?>

