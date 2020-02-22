<?php
/*
 * Created on Apr 30, 2006
 * 
 * Contains ini, ob, locale, and global var/array settings and initializers.
 * 
 */
ob_start("ob_gzhandler");
session_start();

ini_set('date.timezone','America/New_York');

ini_set('file_uploads','0');
ini_set('memory_limit','8388608');
ini_set('upload_max_filesize','262144');
//ini_set('save_path','');
//ini_set('upload_tmp_dir','');

if(isset($_SERVER['OS']) and (stripos($_SERVER['OS'],'windows') !== false));
//else ini_set('include_path', ini_get('include_path').':/home/pimp3am/includes:/home/pimp3am/ZendFramework/0.1.5/library');
else ini_set('include_path', ini_get('include_path').':/app/includes:/app/vendor/ZendFramework/1.0.0/library');
if(isset($_GET['showconfig'])){ if($_GET['showconfig'] == "phpinfo"){ header("Location: http://3amproductions.net/phpinfo"); exit;}}
if(isset($_GET['md5'])){echo md5($_GET['md5']); exit;}
if(isset($_GET['track'])){if($_GET['track'] == "no"){$_SESSION['track'] = false;}elseif($_GET['track'] == "yes"){$_SESSION['track'] = true;}}
require_once('lib.functions.php');
require_once('class.htdoc.php');
require_once('lib.html.php');// must precede META defaults

/****** META defaults ******** must follow lib.html.php ************/
	$_META['lang'] = 'en-US';
	$_META['charset'] = 'utf-8';
	$_META['org'] = '3AM Productions';
	$_META['domain'] = '3AMProductions.net';
	$_META['base_title'] = '3AM';
	$_META['author'] = 'Gilbert J. Velasquez &amp; Jason R. Karns';
	$_META['description'] = 'Dedicated to the latest Web Standards in Accessibility, Design and Programming using Client Server technology to maximize usability and profitability.';
	$_META['keywords'] = 'xhtml,php,css,mysql,dom,javascript,ajax,db,database,rss,xml,html,standards,accessibility,usability,security,small business,open source,code,software,web applications,consulting,3am,productions,3am productions,web design,database-driven,dynamic';
	$_META['category'] = 'Computers/Internet/Web_Design_and_Development/Designers/Basic_Service/';
	$_META['title_separator'] =  ' ||| ';
/*******************************************************************/

//$_footer = '<h6><a href="http://validator.w3.org/check?verbose=1&amp;uri='.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'" title="validate our markup" rel="validate">'.$_ABBR['xhtml'].'</a> | ';
//$_footer .= '<a href="http://jigsaw.w3.org/css-validator/validator?profile=css3&amp;warning=2&amp;uri='.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'" title="validate our style" rel="validate">'.$_ABBR['css'].'</a> | ';
//$_footer .= '<a href="http://www.contentquality.com/mynewtester/cynthia.exe?rptmode=-1&amp;url1=http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'" title="validate our accessibility" rel="validate">'.$_ABBR['508'].'</a></h6>';
$_footer = '<ul><li><a href="http://validator.w3.org/check?verbose=1&amp;uri=http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'" title="validate our markup" class="nocite" rel="validate external">'.$_ABBR['xhtml'].'</a></li>'."\n";
$_footer .= '<li><a href="http://jigsaw.w3.org/css-validator/validator?profile=css3&amp;warning=2&amp;uri='.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'" title="validate our style" class="nocite" rel="validate external">'.$_ABBR['css'].'</a></li>'."\n";
$_footer .= '<li><a href="http://www.contentquality.com/mynewtester/cynthia.exe?rptmode=-1&amp;url1=http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'" title="validate our accessibility" class="nocite" rel="validate external">'.$_ABBR['508'].'</a></li>'."\n";
$_footer .= '<li id="jumptop"><a href="#nav" title="jump to top" class="nocite">top</a></li>'."\n";
if(isset($_SESSION['auth']) and $_SESSION['auth'] === true){
	$_SESSION['redirect'] = 'http://'.$_SERVER['SERVER_NAME'];
	$_footer .= '<li><a href="http://'.$_SERVER['SERVER_NAME'].'/login?logout=true" title="Logout of 3AM" class="nocite">Logout</a></li>';
}
$_footer .= '</ul>';

$_naked = is_naked_day() ? '<h2>What happened to the design?</h2><p>To know more about why styles are disabled on this website visit the <a href="http://naked.dustindiaz.com" title="Web Standards Naked Day Host Website">Annual CSS Naked Day</a> website for more information.</p>' : '';

if(isset($_SESSION['track']) and !$_SESSION['track'])
	$_analytics = null;
else {
	include_once('/home/pimp3am/stats.3amproductions.net/shortstat/inc.stats.php');
	// Google Analytics
	$_analytics = '<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script><script type="text/javascript">_uacct = "UA-313109-1";urchinTracker();</script>'."\n";
	//103 Bees
//	$_analytics .= '<!-- 103bees.com "bee" code v1.11 - please do not make any changes! --><script type="text/javascript" src="http://103bees.com/bees/?bee=1503&amp;fid=1723"></script><!-- 103bees.com "bee" code -->'."\n";
	// ClickDensity
//	$_analytics .= '<script type="text/javascript" src="http://j.clickdensity.com/cr.js"></script><script type="text/javascript">//<![CDATA[ var clickdensity_siteID = 3154; var clickdensity_keyElement = \'note\'; //]]></script>'."\n";
	// Crazy Egg
//	$_analytics .= '<script type="text/javascript" src="http://cetrk.com/pages/scripts/0000/5979.js"> </script>';
}

?>
