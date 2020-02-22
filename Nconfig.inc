<?php
/*
 * Created on Apr 30, 2006
 * 
 * Contains ini, ob, locale, and global var/array settings and initializers.
 * 
 */
//ob_start("ob_gzhandler");
session_start();

ini_set('date.timezone','America/New_York');
ini_set('file_uploads','0');
ini_set('memory_limit','8388608');
ini_set('upload_max_filesize','262144');
//ini_set('save_path','');
//ini_set('upload_tmp_dir','');
//ini_set('include_path', ini_get('include_path').':/home/pimp3am/includes:/home/pimp3am/ZendFramework/0.1.5/library');
ini_set('include_path', ini_get('include_path').':/home/pimp3am/includes:/home/pimp3am/ZendFramework/1.0.0/library');

if(isset($_GET['showconfig'])){ if($_GET['showconfig'] == "phpinfo"){ header("Location: http://3amproductions.net/phpinfo"); exit;}}
if(isset($_GET['track'])){if($_GET['track'] == "no"){$_SESSION['track'] = false;}elseif($_GET['track'] == "yes"){$_SESSION['track'] = true;}}

require_once('lib.functions.php');
require_once('Nclass.htdoc.php');
require_once('lib.html.php');

/****** META defaults **********************************************/
    $org = '3AM Productions';
	$domain = '3amproductions.net';
	$author = 'Gilbert J. Velasquez &amp; Jason R. Karns';
    $description = 'Dedicated to the latest Web Standards in Accessibility, Design and Programming using Client Server technology to maximize usability and profitability.';
    $keywords = 'xhtml,php,css,mysql,dom,javascript,ajax,db,database,rss,xml,html,standards,accessibility,usability,security,small business,open source,code,software,web applications,consulting,3am,productions,3am productions,web design,database-driven,dynamic';
    $category = 'Computers/Internet/Web_Design_and_Development/Designers/Basic_Service/';
    $copyright = '&#169; ==COPYRIGHT==, '.$author.', '.$org.', '.$domain.', All Rights Reserved';
    
    $META_DEFAULTS = array(
        'lang' => 'en-US',
        'charset' => 'utf-8',
        'base_title' => '3AM',
        'title_separator' =>  ' ||| '
        );
    $META_FLAGS = array(
        'media_type' => '==MEDIA_TYPE==',
        'charset' => '==CHARSET==',
        'lang' => '==LANG==',
        'copyright' => '==COPYRIGHT==',
        'created' => '==CREATED==',
        'updated' => '==UPDATED==',
        'title' => '==TITLE==',
        'uri' => '==URI=='
        );

    $_NAV = array(
        'index' => array('href'=>'index', 'title'=>'go to our homepage'),
        'approach' => array('href'=>'approach', 'title'=>'follow our web development procedure'),
        'about' => array('href'=>'about', 'title'=>'learn more about 3AM'),
        'portfolio' => array('href'=>'portfolio', 'title'=>'see some of our previous work'),
        'contact' => array('href'=>'contact', 'title'=>'get in touch with us'),
        'gilbert' => array('href'=>'gilbert', 'title'=>'see more about Gilbert'),
        'jason' => array('href'=>'jason', 'title'=>'see more about Jason'),
        'help' => array('href'=>'help', 'title'=>'see more about thesite')
    );

    $_META = array(
    'main' => array(
        '<!-- Standard HTML Metadata -->',
        '<meta http-equiv="Content-Type" content="==MEDIA_TYPE==; charset===CHARSET==" />',
        '<meta http-equiv="Content-Language" content="==LANG==" scheme="RFC3066" />',
        '<meta name="Resource-Type" content="Text" scheme="DCMIType" />',
        '<meta name="Description" content="'.$description.'" />',
        '<meta name="Keywords" content="'.$keywords.'" />',
        '<meta name="Category" content="'.$category.'" />',
        '<meta name="Distribution" content="Global" />',
        '<meta name="Rating" content="General" />',
        '<meta name="Robots" content="index,follow" />',
        '<meta name="Author" content="'.$author.'" />',
        '<meta name="Organization" content="'.$org.'" />',
        '<meta name="Copyright" content="'.$copyright.'" />',
        '<meta name="Date" content="==CREATED==" scheme="W3CDTF" />',
        '<meta name="Updated" content="==UPDATED==" scheme="W3CDTF" />'
        ),
    'dc' => array(
        '<!-- Dublin Core Metadata - http://dublincore.org/documents/1998/09/dces/# -->',
        '<link type="application/rdf+xml" rel="schema.dc" title="Dublin Core Meta Data Schema" href="http://purl.org/dc/elements/1.1/" />',
        '<meta name="dc.title" content="==TITLE==" />',
        '<meta name="dc.creator" content="'.$author.'" />',
        '<meta name="dc.description" content="'.$description.'" />',
        '<meta name="dc.subject" content="'.$keywords.'" />',
        '<meta name="dc.publisher" content="'.$org.'" />',
        '<meta name="dc.contributors" content="'.$author.'" />',
        '<meta name="dc.date" content="==CREATED==" scheme="W3CDTF" />',
        '<meta name="dc.type" content="Text" scheme="DCMIType" />',
        '<meta name="dc.format" content="==MEDIA_TYPE==" scheme="IMT" />',
        '<meta name="dc.identifier" content="==URI==" scheme="URI" />',
//              '<!-- <meta name="dc.source" content="" scheme="URI" /> -->',
        '<meta name="dc.language" content="==LANG==" scheme="RFC3066" />',
//              '<!-- <meta name="dc.relation" content="URI" /> -->',
        '<meta name="dc.coverage" content="Columbus, US-OH" />',
        '<meta name="dc.rights" content="'.$copyright.'" />'
        ),
    'dmoz' => array(
        '<!-- DMOZ Directory - http://dmoz.org/ -->',
        '<meta name="dmoz.id" content="'.$category.'" />'
        ),
    'geo' => array(
        '<!-- GeoURL - http://geourl.org -->',
        '<link type="application/rdf+xml" rel="schema.geo meta" title="Geo Meta Data Schema" href="http://www.w3.org/2003/01/geo/wgs84_pos#" />',
        '<meta name="geo.position" content="40.067135;-83.099882" scheme="GEO" />',
        '<meta name="geo.placename" content="1591 Presidential Dr, Apt B1, Columbus, OH 43212" scheme="GEO" />',
        '<meta name="geo.region" content="US-OH" scheme="GEO" />',
        '<meta name="geo.country" content="US" scheme="ISO3166" />'
        ),
    'tgn' => array(
        '<!-- Getty Thesaraus of Geographical Names - http://www.getty.edu/research/conducting_research/vocabularies/tgn -->',
        '<meta name="tgn.id" content="7013645" scheme="TGN" />',
        '<meta name="tgn.name" content="Columbus" scheme="TGN" />',
        '<meta name="tgn.nation" content="United States" scheme="TGN" />'
        ),
    'icbm' => array(
        '<!-- - http://geourl.org -->',
        '<meta name="ICBM" content="40.067135, -83.099882" scheme="ICBM" />'
        ),
    'icra' => array(
        '<!-- Internet Content Rating Association - http://www.icra.org -->',
        '<link type="application/rdf+xml" rel="meta" title="ICRA labels" href="/xml/labels.rdf" />'
        ),
    'foaf' => array(
        '<!-- Friend Of A Friend - http://www.foaf-project.org -->',
        '<link rel="meta" type="application/rdf+xml" title="FOAF" href="/xml/foaf.rdf" />'
        ),
    'cc' => array(
        '<!-- Creative Commons Licensing - http://creativecommons.org -->',
//              '<link type="application/rdf+xml" rel="meta license cc-license" title="Creative Commons License" href="http://creativecommons.org/licenses/by-nc-sa/2.5/rdf" />',
        '<link type="text/html" rel="meta license cc-license" title="Creative Commons License" href="http://creativecommons.org/licenses/by-nc-sa/2.5/" />'
        ),
    'xmdp' => array(
        '<!-- Xhtml Meta Data Profiles - http://gmpg.org/xmdp -->',
        '<link type="==MEDIA_TYPE==" rel="alternate meta" title="XMDP: XHTML Metadata Profile" href="/xmdp" />'
        ),
    'favicon' => array(
        '<!-- Favicon -->',
        '<link type="image/x-icon" rel="shortcut icon" href="/images/favicon.ico" />',
        '<link id="logo" class="logo" type="image/gif" rel="icon" href="/images/favicon.gif" />'
        ),
    'nav' => array(
        '<!-- Site Navigation Links -->',
        '<link type="==MEDIA_TYPE==" rel="home" title="Home" href="/" />',
        '<link type="==MEDIA_TYPE==" rel="about" title="About" href="/about" />',
        '<link type="==MEDIA_TYPE==" rel="contact" title="Contact" href="/contact" />',
//              '<!-- <link type="==MEDIA_TYPE==" rel="search" title="Search" href="/search" /> -->',
        '<link type="==MEDIA_TYPE==" rel="sitemap" title="Site Map" href="/help" />',
        '<link type="==MEDIA_TYPE==" rel="help" title="Help" href="/help" />',
        '<link type="==MEDIA_TYPE==" rel="copyright" title="Copyright Information" href="/help" />',
        ),
    'openid' => array(
        '<!-- OpenID - http://openid.net -->',
        '<link rel="openid.server" href="http://www.myopenid.com/server" />',
        '<link rel="openid.delegate" href="http://3am.myopenid.com/" />',
        '<meta http-equiv="X-XRDS-Location" content="http://3am.myopenid.com/xrds" />'
        ),
    'openid-jason' => array(
        '<!-- OpenID delegation for Jason -->',
        '<link rel="openid.server" href="http://www.myopenid.com/server" />',
        '<link rel="openid.delegate" href="http://jason.karns.name" />'
        ),
    'openid-gilbert' => array(
        '<!-- OpenID delegation for Gilbert -->',
        '<link rel="openid.server" href="http://www.myopenid.com/server" />',
        '<link rel="openid.delegate" href="http://renegadelatino.myopenid.com/" />',
        '<meta http-equiv="X-XRDS-Location" content="http://renegadelatino.myopenid.com/xrds" />'
        ),
    'microid' => array(
        '<!-- MicroID - http://microid.org -->',
        // 3am@3amproductions.net, http://3amproductions.net
        '<meta name="microid" content="mailto+http:sha1:3d8dd38eae9553ef9667d67380595d144a980adc" />'
        ),
    'atom' => array(
        '<!-- Atom Portfolio Feed - http://intertwingly.net/moin-1.2.1/wiki/cgi-bin/moin.cgi/FrontPage -->',
        '<link rel="alternate" type="application/atom+xml" title="3AM Productions: Portfolio (Atom 1.0)" href="/atom" />'
        ),
    'errorlogfeed' => array(
        '<!-- Atom Error Log Feed - http://intertwingly.net/moin-1.2.1/wiki/cgi-bin/moin.cgi/FrontPage -->',
        '<link rel="alternate" type="application/atom+xml" title="3AM Productions: Error Log" href="/error/feed" />'
        ),
    'rss' => array(
        '<!-- RSS Portfolio Feed - http://cyber.law.harvard.edu/rss/rss.html -->',
        '<link rel="alternate" type="application/rss+xml" title="3AM Productions: Portfolio (RSS 2.0)" href="/rss" />'
        ),
    'grddl' => array(
        '<!-- Gleaning Resource Descriptions from Dialects of Languages - http://www.w3.org/2003/g/data-view-->',
        '<link rel="transformation" href="http://www.w3.org/2003/12/rdf-in-xhtml-xslts/grokGeoURL.xsl" title="Extract GeoURL data as RDF" type="application/xslt+xml" />',
        '<link rel="transformation" href="http://www.w3.org/2000/06/dc-extract/dc-extract.xsl" title="Extract Dublin Core Metadata as RDF" type="application/xslt+xml" />',
        '<link rel="transformation" href="http://www.w3.org/2003/12/rdf-in-xhtml-xslts/grokCC.xsl" title="Extract Creative Commons License data as RDF" type="application/xslt+xml" />',
        '<link rel="transformation" href="http://www.w3.org/2003/12/rdf-in-xhtml-xslts/grokFOAF.xsl" title="Extract FOAF data as RDF" type="application/xslt+xml" />',
        '<link rel="transformation" href="http://www.w3.org/2006/vcard/hcard2rdf.xsl" title="Extract hCard data as RDF" type="application/xslt+xml" />',
        '<link rel="transformation" href="http://www.w3.org/2002/12/cal/glean-hcal.xsl" title="Extract hCalendar data as RDF" type="application/xslt+xml" />'
        ),
    'sitemap' => array(
        '<!-- sitemap.xml and ror.xml - http://sitemap.org - http://rorweb.com -->',
        '<link rel="sitemap" type="application/xml" title="Sitemap.xml" href="/sitemap.xml" />',
        '<link rel="sitemap" type="application/rss+xml" title="ROR Sitemap" href="/ror.xml" />'
        )
    );

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
    // ShortStat
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