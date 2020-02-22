<?php
require_once('../../../config.inc');
require_once('class.transformer.php');

if(isset($_SERVER['PATH_INFO'])){
	$path = explode("/",$_SERVER['PATH_INFO']);
	$format = $path[1];
	$params = array();
}

switch($format)
{
	case "xsd":
		$feed = @file_get_contents("twix.xsd");
		if($feed !== false){
			header("Content-Type: application/xml; charset: UTF-8");
			echo $feed; exit; } break;

	case "html":
	case "xhtml":
		//$feed = twix_transform("twix.xsd","../../xs3p.xsl","twix.xsd.html");
		$t = new Transformer('twix.xsd','../../xs3p.xsl','twix.xsd.html');
		$feed = $t->transform();
		if($feed !== false){
			header("Content-Type: application/xhtml+xml; charset: UTF-8");
			echo $feed; exit; } break;

	default:
		header("Location: http://3amproductions.net/xml/twilight/index.php");
		exit; break;
}
echo "<h1>There was an XML error.</h1>";
?>
