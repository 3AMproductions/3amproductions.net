<?php
session_start();

if(isset($_GET['file']))
	$file = $_GET['file'];
elseif(isset($_SERVER['PATH_INFO'])){
	$path = explode("/",$_SERVER['PATH_INFO']);
	$file = $path[1];
}

if (!$_SESSION['auth'] === true){
	$_SESSION['redirect'] = 'http://3amproductions.net/xml/twilight/'.$file;
	header('Location: http://3amproductions.net/login.php');
	exit;
}
if($output = @file_get_contents($file)) echo $output;
else echo "Error";

?>
