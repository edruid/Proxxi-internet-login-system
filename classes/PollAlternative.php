<?php

class PollAlternative extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'poll_alternatives';
	}

	public function __toString() {
		return (string)$this->text;
	}
}
?>
