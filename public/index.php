<?php
require "../includes.php";

// Prepare path
$path_info=$_SERVER['PATH_INFO'];
$untouched_request=$path_info;
$request=explode('/',$path_info);
array_shift($request);
$main=array_shift($request);
if($main == '') {
	$main = "Access";
}
$session = Session::from_id(session_id());
if($session != null) {
	$current_user = $session->User;
} else {
	$current_user = null;
}
$page = $main.'C';
if(!class_exists($page)) {
	die("$main does not exist");
}
$page = new $page(array_shift($request), $request);
$page->_print_child();

?>
