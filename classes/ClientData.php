<?
class ClientData {
	public static function clean($data) {
		if(HTML_ACCESS) {
			if(is_array($data)) {
				foreach($data as $key => $value) {
					$data[$key] = self::clean($value);
				}
				return $data;
			} else {
				return htmlspecialchars($data, ENT_QUOTES, 'utf-8');
			}
		} else {
			return $data;
		}
	}

	public static function post($string) {
		if(isset($_POST[$string])) {
			return self::clean($_POST[$string]);
		}
		return false;
	}
	public static function request($string) {
		if(isset($_REQUEST[$string])) {
			return self::clean($_REQUEST[$string]);
		}
		return false;
	}

	public static function session($string) {
		if(isset($_SESSION[$string])) {
			return self::clean($_SESSION[$string]);
		}
		return false;
	}

	public static function session_set($string,$value) {
		if($value == null) {
			unset($_SESSION[$string]);
		} else {
			$_SESSION[$string]=$value;
		}
	}

	public static function defaults_set($data = null) {
		if($data == null) {
			$data = $_POST;
		}
		self::session_set('_defaults', $data);
	}

	public static function clear_defaults() {
		self::session_set('_defaults', null);
	}

	public static function defaults($key) {
		if(!isset($_SESSION['_defaults'])) {
			return null;
		}
		if(!isset($_SESSION['_defaults'][$key])) {
			return null;
		}
		return self::clean($_SESSION['_defaults'][$key]);
	}
}
?>
