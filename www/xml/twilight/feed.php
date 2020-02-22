<?php
require_once('../../config.inc');
require_once('class.transformer.php');

if(isset($_SERVER['PATH_INFO'])){
	$path = explode("/",$_SERVER['PATH_INFO']);
	$format = $path[1];
	switch($format)
	{
		case "ajax":
		case "json":
			$params = array(array('namespace'=>'','name'=>'project_id','value'=>htmlentities($path[2])),
							array('namespace'=>'','name'=>'image_num','value'=>htmlentities($path[3])));
			break;
		case "atom":
		case "twixrss":
			if(!isset($path[2])) break;
			$usetags = true;
			
			$tagsxml = new SimpleXMLElement("<tags></tags>");
			$tags = explode(",",$path[2]);
			foreach($tags as $t){
				$tagsxml->addChild("tag",htmlentities($t));
			}
			$tagsxml->asXML("portfolio.tags.xml");
//			$params = array(array('namespace'=>'','name'=>'tags','value'=>$tagsxml->asXML()));
			$params = array(array('namespace'=>'','name'=>'tagfile','value'=>'../../twilight/portfolio.tags.xml'));
			break;
		case "clean":
			unlink("portfolio.atom.xml");
			unlink("portfolio.rss.xml");
			unlink("portfolio.rss2.xml");
			unlink("portfolio.rss.xhtml");
			unlink("portfolio.atom.xhtml");
			header("Location: http://3amproductions.net/twilight");
			exit; break;
		default:
			break;
	}
}

$proper_mimetype = true;

switch($format)
{
	case "atomrss":
		if(!file_exists('portfolio.atom.xml')){
			$t = new Transformer('portfolio.xml','../ns/twix/twix2atom.xsl','portfolio.atom.xml');
			$t->transform();}
	
		$t = new Transformer('portfolio.atom.xml','../atom2rss.xsl','portfolio.rss2.xml',null,array('portfolio.xml','../ns/twix/twix2atom.xsl'));
		$feed = $t->transform();
		if($feed !== false){
			if($proper_mimetype)
				header("Content-Type: application/rss+xml; charset: UTF-8");
			else
				header("Content-Type: application/xml; charset: UTF-8");
			echo $feed; exit; } break;

	case "rss":// use twix2rss.xsl not atom2rss.xsl
	case "twixrss":// force twix2rss.xsl
		$t = $usetags ? 
				new Transformer('portfolio.xml','../ns/twix/twix2rss.xsl',null,$params) : 
				new Transformer('portfolio.xml','../ns/twix/twix2rss.xsl','portfolio.rss.xml');
		$feed = $t->transform();
		if($feed !== false){
			if($proper_mimetype)
				header("Content-Type: application/rss+xml; charset: UTF-8");
			else
				header("Content-Type: application/xml; charset: UTF-8");
			echo $feed; exit; } break;

	case "atom":
		$t = $usetags ? 
				new Transformer('portfolio.xml','../ns/twix/twix2atom.xsl',null,$params) : 
				new Transformer('portfolio.xml','../ns/twix/twix2atom.xsl','portfolio.atom.xml');
		$feed = $t->transform();
		if($feed !== false){
			if($proper_mimetype)
				header("Content-Type: application/atom+xml; charset: UTF-8");
			else
				header("Content-Type: application/xml; charset: UTF-8");
			echo $feed; exit; } break;

	case "rsshtml":
	case "rssxhtml":
		if(!file_exists('portfolio.rss.xml')){
			$t = new Transformer('portfolio.rss.xml','../ns/twix/twixrss2html.xsl','portfolio.rss.xhtml');
			$t->transform();}

		$t = new Transformer('portfolio.rss.xml','../ns/twix/twixrss2html.xsl','portfolio.rss.xhtml');
		$feed = $t->transform();
		if($feed !== false){
			header("Content-Type: application/xhtml+xml; charset: UTF-8");
			echo $feed; exit; } break;

	case "atomhtml":
	case "atomxhtml":
		if(!file_exists('portfolio.atom.xml')){
			$t = new Transformer('portfolio.xml','../ns/twix/twix2atom.xsl','portfolio.atom.xml');
			$t->transform();}

		$t = new Transformer('portfolio.atom.xml','../ns/twix/twixatom2html.xsl','portfolio.atom.xhtml');
		$feed = $t->transform();
		if($feed !== false){
			header("Content-Type: application/xhtml+xml; charset: UTF-8");
			echo $feed; exit; } break;

	case "ajax":
		$t = new Transformer('portfolio.xml','../ns/twix/twix2ajax-xml.xsl',null,$params);
		$feed = $t->transform();
		if($feed !== false){
			header("Content-Type: text/xml; charset: UTF-8");
			header("X-AJAX-Content-Type: xml");
			echo $feed; exit; } break;

	case "json":
		$t = new Transformer('portfolio.xml','../ns/twix/twix2ajax-json.xsl',null,$params);
		$feed = $t->transform();
		if($feed !== false){
			header("Content-Type: text/plain; charset: UTF-8");
			header("X-AJAX-Content-Type: json");
			echo $feed; exit; } break;
	default:
		header("Location: http://3amproductions.net/xml/twilight/index.php");
		exit; break;
}
echo "<h1>There was an XML error.</h1>";
?>
