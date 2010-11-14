<?php
class Controller {
	protected $_default_site = null;

	public function __construct($site, $data = array()) {
		if(!$site) {
			$site = static::default_site;
			if(!$site) {
				throw new Exception("No default site to visit");
			}
		}
		if(substr($site, 0, 1) == '_') {
			throw new Exception("Trying to access disalowed site");
		}
		if(!method_exists($this, $site)) {
			throw new Exception("No such site: \"$site\"");
		}
		$this->$site($data);
	}
	
	private static function _reg($key) {
		static $data = array();
		$params = func_get_args();
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
		require self::_stack();
	}

	protected function _display($view) {
		$file = get_called_class();
		if(substr($file, -1, 1) == 'C') {
			$file = substr($file, 0, -1);
		}
		if(strstr($view, '/')) {
			throw new Exception("Ileagal character in path");
		}
		$file = "../views/$file/$view.php";
		if(file_exists($file)) {
			self::_stack($file);
		} else {
			throw new Exception("No view exists \"$file\"");
		}
	}
}
