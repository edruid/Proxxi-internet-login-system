<?php
class Controller {
	protected $_default_site = null;

	public static function _access_type($type) {
		if(defined('HTML_ACCESS')) {
			if(HTML_ACCESS != ($type == 'html')) {
				throw new Exception("Trying to change HTML_ACCESS value.");
			}
			return;
		}
		if($type == 'html') {
			define('HTML_ACCESS', true);
		} else {
			define('HTML_ACCESS', false);
		}

		if($type == 'script') {
			$pos = stripos($_SERVER['HTTP_REFERER'], "://{$_SERVER['HTTP_HOST']}");
			if($pos != 4 && $pos != 5) {
				throw new Exception("Referer missmatch. Suspected CSRF attack. Referer is: {$_SERVER['HTTP_REFERER']} host is: {$_SERVER['HTTP_HOST']}");
			}
		}
	}

	public function __construct($site, $data = array()) {
		if(!$site) {
			$site = $this->_default_site;
			if(!$site) {
				throw new Exception("No default site to visit");
			}
		}
		if(substr($site, 0, 1) == '_') {
			throw new Exception("Trying to access disalowed site");
		}
		if(!method_exists($this, $site)) {
			throw new Exception("No such site: \"".get_called_class()."/$site\"");
		}
		$this->$site($data);
	}
	
	private static function _reg($key) {
		static $data = array();
		$params = func_get_args();
		if(count($params) == 3) {
			return $data;
		}
		if(count($params) == 2) {
			$data[$key] = $params[1];
		} else {
			if(array_key_exists($key, $data)) {
				return $data[$key];
			} else {
				return false;
			}
		}
	}

	protected function _register($key, $value) {
		self::_reg($key, $value);
	}

	protected function _get($key) {
		return self::_reg($key);
	}

	private static function _stack($file = null) {
		static $files = array();
		if($file == null) {
			return array_pop($files);
		} else {
			array_push($files, $file);
		}
	}

	public function _print_child() {
		$file = self::_stack();
		if(!$file) {
			return;
		}
		if(!file_exists($file)) {
			throw new Exception("No such file \"$file\"");
		}
		$data= $this->_reg(0,0,0);
		foreach($data as $key => $value) {
			$$key = $value;
		}
		require $file;
	}

	protected static function _display($view) {
		$class = get_called_class();
		if(!$view) {
			self::_stack(null);
			return;
		}
		if(substr($class, -1, 1) == 'C') {
			$class = substr($class, 0, -1);
		}
		if(strstr($view, '/')) {
			throw new Exception("Ileagal character in path");
		}
		$file = "../views/$class/$view.local.php";
		if(file_exists($file)) {
			self::_stack($file);
			return;
		}
		$file = "../views/$class/$view.php";
		if(file_exists($file)) {
			self::_stack($file);
		} else {
			throw new Exception("No view exists \"$file\"");
		}
	}
}
?>
