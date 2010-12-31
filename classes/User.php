<?php

class User extends PersistantBasicObject {

	/**
	 * Used by BasicObject to determine the table name.
	 * @returns the table name for the database relation.
	 */
	protected static function table_name() {
		return 'users';
	}

	public function __toString() {
		return "{$this->first_name} {$this->surname}";
	}

	public function has_password($password) {
		$crypt = crypt($password, $this->password);
		if($crypt == '') {
			return false;
		}
		return $crypt == $this->password;
	}

	public function set_attending($day = null) {
		if($day == null) {
			$day = date('Y-m-d');
		}
		try{
			$attendance = new Attendance();
			$attendance->user_id = $this->id;
			$attendance->day = $day;
			$attendance->commit();
		} catch(Exception $e){
			return $e->getMessage();
		}
		return null;
	}

	public static function from_username($username) {
		return parent::from_field('username', $username);
	}

	public function has_access($access) {
		if(is_numeric($access)) {
			$access = GroupAccess::count(array(
				'access_id' => $access,
				'@or:1' => array(
					'valid_until:<' => date('Y-m-d h:i:s'),
					'permanent' => true,
				),
				'@or:2' => array(
					'Group.UserGroup.valid_until:>=' => date('Y-m-d h:i:s'),
					'Group.UserGroup.permanent' => true,
				),
				'Group.UserGroup.user_id' => $this->id,
			));
		} else {
			$access = Access::count(array(
				'code_name' => $access,
				'@or:1' => array(
					'GroupAccess.valid_until:>=' => date('Y-m-d h:i:s'),
					'GroupAccess.permanent' => true,
				),
				'@or:2' => array(
					'GroupAccess.Group.UserGroup.valid_until:>=' => date('Y-m-d h:i:s'),
					'GroupAccess.Group.UserGroup.permanent' => true,
				),
				'GroupAccess.Group.UserGroup.user_id' => $this->id,
			));
		}
		return 1 <= $access;
	}

	public function has_setting($setting) {
		return Setting::count(array(
			'code_name' => $setting,
			'UserSetting.user_id' => $this->id,
		));
	}

	public function may_grant() {
		$access = Access::count(array(
			'code_name:like' => 'grant_%',
			'@or:1' => array(
				'GroupAccess.valid_until:>=' => date('Y-m-d h:i:s'),
				'GroupAccess.permanent' => true,
			),
			'@or:2' => array(
				'GroupAccess.Group.UserGroup.valid_until:>=' => date('Y-m-d h:i:s'),
				'GroupAccess.Group.UserGroup.permanent' => true,
			),
			'GroupAccess.Group.UserGroup.user_id' => $this->id,
		));
		return 1 <= $access;
	}

	public function in_group($group) {
		return UserGroup::count(array(
			'user_id' => $this->id,
			'group_id' => $group->id,
			'@or' => array(
				'permanent' => true,
				'valid_until:>=' => date('Y-m-d h:i:s'),
			),
		));
	}

	public function is_member($date = null) {
		if($date == null) {
			$date = date('Y-m-d');
		}
		return 0 < count($this->Membership(array(
			'start:<=' => $date,
			'end:>=' => $date,
		)));
	}

	public function may_be_edited($user) {
		return $user != null &&
				($this->id == $user->id ||
				$user->has_access('edit_user'));
	}

	public function __set($key, $value) {
		switch($key) {
			case 'username':
				$value = strtolower($value);
				if($value=='') {
					throw new UserException('Du måste ha ett användarnamn!');
				}
				if(!preg_match('/\A[a-zåäö][-_a-zåäö0-9]*\Z/', $value)) {
					throw new UserException('Användarnamnet får bara innehålla a-ö, 0-9, _ och -');
				}
				if((!$this->_exists || $this->username != $value) && User::from_username($value) != null) {
					throw new UserException('Användarnamnet är upptaget');
				}
				break;
			case 'first_name':
				if($value=='') {
					throw new UserException('Du måste ha ett förnamn!');
				}
				break;
			case 'surname':
				if($value=='') {
					throw new UserException('Du måste ha ett efternamn!');
				}
				break;
			case 'sex':
				if($value != 'male' && $value != 'female') {
					throw new UserException('Är du man eller kvinna?');
				}
				break;
			case 'birthdate':
				$date = date_create($value);
				if($date == false) {
					throw new UserException("Födelsedatumet har ett okänt format YYYY-MM-DD fungerar.");
				}
				if($date > date_create('now')) {
					throw new UserException("Födelsedatumet kan inte vara i framtiden.");
				}
				$value = $date->format('Y-m-d');
				break;
			case 'person_id_number':
				if(!preg_match('/\A[0-9]{4}\Z/', $value)) {
					throw new UserException('Personnumret validerar inte');
				}
				break;
			case 'email':
				if(!Validate::email($value)) {
					throw new UserException('Epostadressen validerar inte');
				}
				break;
			case 'phone2':
				if($value == '') {
					break;
				}
				//fallthrough
			case 'phone1':
				if(!preg_match('/\A[0+][-0-9 ]{5,15}\Z/', $value)) {
					if($key == 'phone1') {
						throw new UserException('Telefonnumret validerar inte');
					} else {
						throw new UserException('Alternativa telefonnumret validerar inte (får lämnas blankt dock)');
					}
				}
				break;
			case 'street_address':
				if($value == ''){
					throw new UserException('Gatuadress saknas');
				}
				break;
			case 'area_code':
				if(!preg_match('/\A[1-9][0-9]{2} ?[0-9]{2}\Z/', $value )) {
					throw new UserException('Postnummer validerar inte');
				}
				$value = str_replace(' ', '', $value);
				break;
			case 'area':
				if($value == ''){
					throw new UserException('Postadress saknas');
				}
				break;
			case 'password':
				if($value == '') {
					return;
				}
				if(strlen($value) < 5) {
					throw new UserException('Lösenordet är för kort');
				}
				require_once("../lib/createlm.php");
				$hsh = new smbHash();
				parent::__set('nthash', $hsh->nthash($value));
				$value = crypt($value, '$5$rounds=5000$'.rand());
				break;
			case 'nthash':
				throw new Exception('Do not set nthash directly! Set it via password');
				break;
			default:
				// TODO: set settings?
				break;
		}
		parent::__set($key, $value);
	}

	public function has_avatar() {
		return 1 == Avatar::count(array(
			'user_id' => $this->id,
		));
	}

	public function member_fee($year = null) {
		if($year == null) {
			$year = date('Y');
		} else {
			$year = substr($year, 0, 4);
		}
		$age = $year - substr($this->birthdate, 0, 4);
		if($year < 2007) {
			return 20;
		} elseif($year < 2011) {
			if($age <= 25) {
				return 20;
			} else {
				return 100;
			}
		} else {
			if($age <= 25) {
				return 50;
			} else {
				return 100;
			}
		}
	}

	public function __get($key) {
		switch($key) {
			case 'avatar_url':
				if($this->has_avatar()) {
					return "/Avatar/view/{$this->username}.jpg";
				} else {
					return "/gfx/default.jpg";
				}
			case 'personnummer':
				return str_replace('-', '', $this->birthdate)."-{$this->person_id_number}";
			default:
				return parent::__get($key);
		}
	}

	public function Avatar() {
		$avatar = parent::Avatar();
		return array_shift($avatar);
	}

	public function commit() {
		if(!Validate::personidnumber(str_replace('-', '', $this->birthdate).'-'.$this->person_id_number)) {
			throw new UserException("Personnumret validerar inte");
		}
		$params = array(
			'birthdate' => $this->birthdate,
			'person_id_number' => $this->person_id_number,
		);
		if($this->_exists) {
			$params['user_id:!='] = $this->user_id;
		}
		if(0 < User::count($params)) {
			throw new UserException('Personnumret finns redan i registret. Kontakta en admin för att få tillgång till ditt konto.');
		}
		parent::commit();
	}
}

class UserException extends Exception {}
?>
