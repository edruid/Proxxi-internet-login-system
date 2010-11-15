<?php
class URL {
	public static function redirect($destination = null) {
		ob_clean();
		if($destination === null) {
			$destination = $_SERVER['HTTP_REFERER'];
		}
		$host = trim($_SERVER['HTTP_HOST'], '/');
		// todo: fix redirect to "bruseiproxxi.org".
		if(!preg_match("/^https?:\/\/$host/i", $destination)) {
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
				$proto='https';
			} else {
				$proto='http';
			}
			$destination = trim($destination, '/');
			$destination = "$proto://$host/$destination";
		}
		header("Location: $destination");
		die();
	}
}
?>
