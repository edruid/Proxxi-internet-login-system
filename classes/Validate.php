<?
/**
 * Klass som validerar saker
 */
class Validate {
	
	/**
	 * @param string Adress att validera
	 * @return boolean 
 	 */
	static public function email($email, $use_dns_lookup = true){
		$atIndex = strrpos($email, "@");
		if ($atIndex === false) {
			// no @ sign
			return false;
		}
		$domain = substr($email, $atIndex+1);
		$local = substr($email, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		if(($localLen < 1 || $localLen > 64)
			// wrong length before @
			|| ($domainLen < 1 || $domainLen > 255)
			// wrong length after @
			|| (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
					str_replace("\\\\","",$local))
			// local part contains invalid characters unless they are quoted
				&& !preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
				// It wasn't quoted
			|| ($local[0] == '.' || $local[$localLen-1] == '.')
			// .no dots at begining or end of local part
			|| (preg_match('/\\.\\./', $local))
			// no .. dots next to eachother
			|| (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
			// domain name contains invalid characters
			// TODO: check if characters like åäö are actually allowed
			//  or if they are mangled on the way.
			|| (preg_match('/\\.\\./', $domain))
			// no .. double dots allowed
			|| (!preg_match('/\\./', $domain))
			// no topdomain, not really in rfc but good to have
			|| (
				$use_dns_lookup
				&& !(
					checkdnsrr($domain, 'MX') 
					|| checkdnsrr($domain, 'CNAME') 
					|| checkdnsrr($domain, 'A') 
					|| checkdnsrr($domain, 'AAAA')
				)
			)
			// domain not found in dns
		) {
			return false;
		}
		return true;
	}

	/**
	 * Kontrollerar att ett förnamn uppfyller gällande kriterier.
	 * Se källkoden för exakt definition.
	 * @param string Förnamn att validera
	 * @return boolean
	 */
	static public function given_name($string) {
		return (strlen($string)>1);
	}

	/**
	 * Kontrollerar att ett efternamn uppfyller gällande kriterier.
	 * Se källkoden för exakt definition.
	 * @param string Efternamn att validera
	 * @return boolean
	 */
	static public function surname($string) {
		return (strlen($string)>1);
	}

	/**
	 * @param string Telefonnummer att validera
	 * @return boolean 
	 */	
	static public function phonenumber($phone){
		return (preg_match("/^(\+|0)[0-9 -]{5,}$/", $phone)!=0);
	}
	
	/**
	 * Validate a zipcode
	 * @param string Zipcode
	 * @return boolean
	 */
	static public function postal_number($zip){
		return (preg_match("/^[0-9]{3} ?[0-9]{2}$/", $zip) != 0 );
	}
	
	/**
	 * Validate a personal id number.
	 * @param string String with the personal id number
	 * @param array Optionally fill with the parts of the number.
	 * @return boolean
	 */
	static public function personidnumber($pid, &$parts = NULL){
		$pattern = "/([0-9]{2})?([0-9]{6})([+\- ]?)([0-9]{4})/";
		if ( preg_match($pattern, $pid, $matches) == 0 ){
			return false;
		}
		
		if ( func_num_args() > 0 ){
			$parts = array_slice($matches, 1);
		}
		
		$nr = $matches[2] . $matches[4];
		$nr=str_split($nr);
		$sum=0;
		$mult=1.5;
		$dir=1;
		foreach($nr as $digit){
			if(is_numeric($digit)){
				$digit=$digit*($mult+0.5*$dir);
				$dir*=-1;
				if($digit>=10){
					$sum++;
				}
				$sum+=$digit%10;
			}
		}
		
		$is_valid = $sum % 10 == 0;
		return $is_valid;
	}

	static public function password($pwd){
		return strlen($pwd) >= 6 && 
		       !preg_match('/^nitroxy$/i', $pwd);
	}

	static public function file_upload($file_upload, &$error = null) {
		if(!is_uploaded_file($file_upload['tmp_name'])) {
			if($file_upload['error']==UPLOAD_ERR_INI_SIZE || $file_upload['error']==UPLOAD_ERR_FORM_SIZE) { // Bilden är för stor
				$error = "Bilden du försökte ladda upp är för stor. Maximal tillåten filstorlek är 30 kB.";
			} else {
				$error = "Ett okänt fel uppstod när bilden skulle sparas.";
			}
			return false;
		}
		return true;
	}

	private function __construct(){
		
	}
}

?>
