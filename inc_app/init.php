<?php
// Kill if the server has shorttags disabled
if(ini_get('short_open_tag') == 0)
	die("You have to enable <em>'short_open_tag'</em> in your php.ini");

// Cacha headers och innehåll så att vi kan ändra oss och skicka
// en Location-header även efter att vi börjat eka ut innehåll.
ob_start();

// Sätt den globala $repo_root till sökvägen till svn-repots root-mapp.
if(file_exists('classes'))
	$repo_root = '';
else if(file_exists('../classes'))
	$repo_root = '..';
else if(file_exists('../../classes'))
	$repo_root = '../..';

/**
 * Automatiskt anropad av php on-demand för att include:a filer med klassdefinitioner.
 * Antar att den globala variabeln $repo_root innehåller sökvägen till svn-repots root-mapp.
 */
function __autoload($class)
{
	global $repo_root;
	if(substr($class, -1, 1) == 'C') {
		$controller = substr($class, 0, -1);
		if(file_exists("$repo_root/controllers/$controller.local.php")) {
			require_once("$repo_root/controllers/$controller.local.php");
			return;
		}
		if(file_exists("$repo_root/controllers/$controller.php")) {
			require_once("$repo_root/controllers/$controller.php");
			return;
		}
	}
	if(file_exists($repo_root.'/classes/'.$class.'.local.php')) {
		require_once $repo_root.'/classes/'.$class.'.local.php';
		return;
	}
	if(file_exists($repo_root.'/classes/'.$class.'.php')) {
		require_once $repo_root.'/classes/'.$class.'.php';
		return;
	}
}

/**
 * Klasser som behöver instantieras till en global.
 */
$db = new DatabaseConnectioni("pils", true);
?>
