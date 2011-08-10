<?php

class Poll extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'polls';
	}

	public function __toString() {
		return (string)$this->name;
	}

	public function has_voted($user) {
		return 0 < Voter::count(array(
			'user_id' => $user->id, 
			'poll_id' => $this->id,
		));
	}

	public function may_vote($user) {
		return $this->vote_until >= date('Y-m-d H:i:s') &&
			$user != null &&
			!$this->has_voted($user) &&
			$user->is_member();
	}
}
?>
