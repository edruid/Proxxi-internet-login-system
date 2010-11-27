<?php

class Group extends BasicObject {
	protected $_default_site = 'index';

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'groups';
	}

	public function __toString() {
		return (string)$this->name;
	}
}
?>
