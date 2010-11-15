<?php
class Network {
	private static function ip2mac($ip) {
		$mac=exec("ip neigh| sed -ne 's/^".$ip." .*lladdr \\(..:..:..:..:..:..\\).*\$/\\1/p'");
		if($mac==""){
			$mac=$ip;
		}
		return $mac;
	}

	public static function get_mac(){
		static $mac = null;
		if($mac == null) {
			$mac = self::ip2mac($_SERVER['REMOTE_ADDR']);
		}
		return $mac;
	}

	public static function is_local($mac = null){
		if($mac == null){
			$mac = self::get_mac();
		}
		return preg_match('/^([0-9A-F]{1,2}:){5}[0-9A-F]{1,2}$/i', $mac);
	}
}
?>
