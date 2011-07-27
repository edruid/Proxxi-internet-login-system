<?php

class PollAlternative extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'poll_alternatives';
	}

	public function register_vote($user_id) {
		global $db;
		$null = null;
		$db->prepare_full("CALL register_vote(?, ?)", $null, 'ii', $user_id, $this->id)->close();
	}

	public function __toString() {
		return (string)$this->text;
	}
}
?>
