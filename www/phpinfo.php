<?php
session_start();
if (!$_SESSION['auth'] == true){
	$_SESSION['redirect'] = 'http://3amproductions.net/phpinfo';
	header('Location: http://3amproductions.net/login');
	exit;
}
if(isset($_SERVER['PATH_INFO'])){
	$path = explode("/",$_SERVER['PATH_INFO']);
	if($path[1] === "sec"){
		require_once('/app/config.inc');
		require_once('PhpSecInfo/PhpSecInfo.php');
		phpsecinfo();
		exit;
	}
}
phpinfo(); exit;
?>
