<?php

class Voter extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'voters';
	}

	public function __toString() {
		return (string)$this->name;
	}
}
?>

