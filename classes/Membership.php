<?php

class Membership extends BasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'memberships';
	}

	public function __set($key, $value) {
		switch($key) {
			case 'end':
				$value = strtotime($value);
				if($value === false) {
					throw new Exception('Medlemsskapets sluttid är inte ett datum.');
				}
				$value = date('Y-m-d', $value);
		}
		parent::__set($key, $value);
	}

	public function commit() {
		if(!$this->_exists) {
			$this->start = date('Y-m-d');
			$memberships = Membership::selection(array(
				'user_id' => $this->user_id,
				'end:>=' => $this->end,
			));
			$altered = false;
			foreach($memberships as $membership) {
				if($membership->start > $this->end) {
					$membership->delete();
				} else {
					$membership->end = $this->end;
					$membership->commit();
					$altered = true;
				}
			}
			if(!$altered && $this->start <= $this->end) {
				$membership = Membership::selection(array(
					'user_id' => $this->user_id,
					'@order' => 'end:desc',
					'@limit' => 1,
				));
				$membership = array_shift($membership);
				if($membership != null && $this->start <= $membership->end) {
					$this->start = date('Y-m-d', strtotime($membership->end)+25*60*60);
				}
				parent::commit();
			}
		} else {
			parent::commit();
		}
	}
}
?>
