<?php
class ErrorC extends Controller {
	public function index($params) {
		$this->_access_type('html');
		$this->_display('index');
	}
}
