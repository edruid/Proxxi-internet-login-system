<?php

class Access extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'accesses';
	}

	public function __toString() {
		return (string)$this->name;
	}
}
?>
