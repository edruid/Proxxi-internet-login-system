<?php
abstract class PersistantBasicObject extends BasicObject {
	private $_persistant_data = array();

	protected static function load_class() {
		$class_name = 'Persistant'.get_called_class();
		if(!class_exists($class_name)) {
			eval("
				class $class_name extends BasicObject {
					protected static function table_name() {
						return 'persistant_".static::table_name()."';
					}
				}
			");
		}
	}

	protected static function persistant_fields() {
		$class_name = 'Persistant'.get_called_class();
		static::load_class($class_name);
		$fields = static::columns($class_name);
		foreach($fields as $i => $field) {
			if(substr($field, 0, 1) == '_') {
				unset($fields[$i]);
			}
		}
		return $fields;
	}

	protected static function is_persistant($field) {
		if($field == '_modified_time') {
			return false;
		}
		return static::in_table($field, static::persistant_table_name());
	}

	public function commit() {
		if(count($this->_persistant_data) > 0) {
			$class_name = 'Persistant'.get_called_class();
			static::load_class($class_name);
			$persist = new $class_name();
			foreach($this->persistant_fields() as $field) {
				if(array_key_exists($field, $this->_persistant_data)) {
					$persist->$field = $this->_persistant_data[$field];
				} else {
					$persist->$field = $this->$field;
				}
			}
			$persist->commit();
		}
		parent::commit();
	}

	public function __set($key, $value) {
		if(static::is_persistant($key)) {
			if($this->$key != $value) {
				$this->_persistant_data[$key] = $this->$key;
				if(is_array($this->_persistant_data) &&
						array_key_exists($key, $this->_persistant_data) &&
						$this->_persistant_data[$key] == $value) {
					unset($this->_persistant_data[$key]);
				}
			}
		}
		parent::__set($key, $value);
	}

	protected static function persistant_table_name() {
		return "persistant_".static::table_name();
	}
}
?>
