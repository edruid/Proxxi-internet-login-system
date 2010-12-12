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

	public function has_access($access) {
		$data = GroupAccess::selection(array(
			'group_id' => $this->id,
			'Access.code_name' => $access,
			'@or' => array(
				'permanent' => 1,
				'valid_until:>=' => date('Y-m-d h:i:s'),
			)
		));
		return array_shift($data);
	}

	public function may_grant($user) {
		if($user == null) {
			return false;
		}
		return $user->has_access($this->access_id);
	}
}
?>
