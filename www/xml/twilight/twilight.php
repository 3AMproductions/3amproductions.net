<?php
require_once('../../config.inc');
require_once('class.transformer.php');
require_once('class.jslink.php');

session_start();
if(!$_SESSION['auth'] == true){
	$_SESSION['redirect'] = 'http://3amproductions.net/xml/twilight/twilight.php';
	header('Location: http://3amproductions.net/login.php');
	exit;
}
if(isset($_SERVER['HTTP_X_TWIX']) and $_SERVER['HTTP_X_TWIX'] == 'update'){
	try{
		if(!isset($HTTP_RAW_POST_DATA))
			throw new Exception("No Raw HTTP POST Data Found");

//		unset($_SESSION['twix']['file']);
		if(!isset($_SESSION['twix']['file']))
			$_SESSION['twix']['file'] = ".backup/" . str_replace(array(" ",":","\"","'","/","\\","http"), "", trim($_SESSION['name'])) . ".xml";

		if(!$handle = fopen($_SESSION['twix']['file'], 'w'))
			throw new Exception("File '".$_SESSION['twix']['file']."' cannot be opened/created.");

		if(fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?>' . $HTTP_RAW_POST_DATA) === FALSE)
			throw new Exception("File '".$_SESSION['twix']['file']."' cannot be written to.");

		fclose($handle);

		libxml_use_internal_errors(true);
		$simpleXml = new SimpleXMLElement($HTTP_RAW_POST_DATA);
		if(is_null($simpleXml)){
			$errors = libxml_get_errors();
			libxml_clear_errors();
			throw new Exception(print_r($errors));
		}

		$simpleXml->addAttribute('modified', date("Y-m-d"));
/*//////////////////////////////////////////// Begin temporary testing code
//		throw new Exception($simpleXml->project[1]->showcase->description);
		$desc = '<?xml version="1.0" encoding="UTF-8"?><description xmlns="http://www.w3.org/1999/xhtml"></description>';
		$desc = $simpleXml->project[1]->showcase->description;
		$desc = new SimpleXMLElement($desc);
		$simpleXml->project[1]->showcase->description = $desc;
*///////////////////////////////////////////// End temporary testing code
		$stringXml = $simpleXml->asXML();
		if($stringXml===false)
			throw new Exception("XML String could not be generated from SimpleXML Object");

		$domXml = new DOMDocument();
		if(is_null($domXml))
			throw new Exception("DOM could not be created");

		if(!$domXml->loadXML($stringXml))
			throw new Exception("DOM could not be loaded from SimpleXML string");

		if(!$domXml->schemaValidate('../ns/twix/twix.xsd'))
			throw new Exception("XML did not validate against the TWIX Schema");

		if(!$domXml->save($_SESSION['twix']['file']))
			throw new Exception("XML was not saved to file properly");

		header('HTTP/1.0 202 Accepted');
		header('Status: 202 Accepted');
		header('Content-type: text/json');
		echo '{msg : "Portfolio temporarily saved.", file : "'.$_SESSION['twix']['file'].'"}';
		exit;
	}
	catch(Exception $e){
		header('HTTP/1.0 500 Internal Server Error');
		header('Status: 500 Internal Server Error');
		header('Content-type: text/json');
		echo '{msg : "'.$e->getMessage().'"}';
		exit;
	}
}
elseif(isset($_SERVER['HTTP_X_TWIX']) and $_SERVER['HTTP_X_TWIX'] == 'commit'){
	try{
		$original = "portfolio.xml";
		$backup = ".backup/portfolio-" . date("Y-m-d\TH-i-s") . ".xml";
		if(!isset($_SESSION['twix']['file']))
			throw new Exception("Filename could not be found in Session");
		if(!@file_exists($_SESSION['twix']['file']))
			throw new Exception("File: '".$_SESSION['twix']['file']."' could not be found");
		if(!@copy($original, $backup))
			throw new Exception("Portfolio could not be backed up");
		if(!@rename($_SESSION['twix']['file'], $original))
			throw new Exception("Portfolio updates could not be committed");

		header('HTTP/1.0 201 Created');
		header('Status: 201 Created');
		header('Content-type: text/json');
		echo '{msg : "Portfolio updates committed.", file : "'.$backup.'"}';
		exit;
	}
	catch(Exception $e){
		header('HTTP/1.0 500 Internal Server Error');
		header('Status: 500 Internal Server Error');
		header('Content-type: text/json');
		echo '{msg : "'.$e->getMessage().'"}';
		exit;
	}
}
$_META['page_title'] = 'portfolio';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->_IE = true;
$doc->doctype();
$doc->add_profile(array('hcard'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon'));
$doc->add_style('/styles/twilight.css','screen,projection');
$doc->add_style('/styles/thickbox.css','screen,projection');
$doc->add_style('/styles/datepicker.css','screen,projection');
//$doc->add_style('/styles/jqmodal.css','screen,projection');
//$doc->add_style('/styles/print.css','print');
//$doc->add_style('/styles/handheld.css','handheld');
$doc->script->set_dir('../../scripts/');
$doc->add_script('twilight.js');
$doc->head();
?>
<body>
<div id="container">
<div id="header">
<h1 id="vcard-3am" class="vcard"><a class="include" href="#logo"></a><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="vcard-note" class="note">We Make Websites</span></h1>
<!-- <a href="#" class="link">en espa&#241;ol</a> -->
</div><!-- header -->
<ul id="nav" title="Main Navigation"><li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li><li><a href="/index.php" title="go to our homepage" rel="home">Home</a></li><li><a href="/approach.php" title="follow our web development procedure">Procedure</a></li><li><a href="/about.php" title="learn more about 3AM" rel="prev about">About</a></li><li><a href="/portfolio.php" class="active" title="see some of our previous work">Portfolio</a></li><li><a href="/contact.php" title="get in touch with us" rel="next contact">Contact</a></li></ul>
<div id="content">
<?php
	$t = new Transformer('portfolio.xml','../ns/twix/twix2html-twilight.xsl','portfolio.xhtml');
	echo $t->transform();
?>
<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
