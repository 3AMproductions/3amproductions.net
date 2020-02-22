<?php
require_once('config.inc');
require_once('class.transformer.php');
require_once('class.jslink.php');
$_GET = $_REQUEST;
$p= htmlentities((!isset($_GET['p'])) ? 'threeamv1' : $_GET['p']);
$i= htmlentities((!isset($_GET['i'])) ? 1 : $_GET['i']);
$params = array(array('namespace'=>'','name'=>'project_id','value'=>$p),
	array('namespace'=>'','name'=>'image_num','value'=>$i));

if($_GET['ajax'] == "true" or $_SERVER['HTTP_X_AJAX_CONTENT_TYPE'] == 'xml'){
	header("Content-Type: application/xml; charset: UTF-8");
	header("X-AJAX-Content-Type: xml");
	//echo twix_transform('xml/twilight/portfolio.xml','xml/ns/twix/twix2ajax-xml.xsl','xml/twilight/portfolio.ajax.xml',$params,false);
	$t = new Transformer('xml/twilight/portfolio.xml','xml/ns/twix/twix2ajax-xml.xsl',null,$params);
	echo $t->transform();
	exit();
}
if($_GET['json'] == "true" or $_SERVER['HTTP_X_AJAX_CONTENT_TYPE'] == 'json'){
 	header("Content-Type: application/json; charset: UTF-8");
	header("X-AJAX-Content-Type: json");
	//echo twix_transform('xml/twilight/portfolio.xml','xml/ns/twix/twix2ajax-json.xsl','xml/twilight/portfolio.ajax.json',$params,false);
	$t = new Transformer('xml/twilight/portfolio.xml','xml/ns/twix/twix2ajax-json.xsl',null,$params);
	echo $t->transform();
	exit;
}
//else

$_META['page_title'] = 'portfolio';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap'),'contact','about');
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->add_script('folio.js');
$doc->add_script('footnotelinks.js');
$doc->head();
?>
<body>
<div id="container">
<div id="header">
<h1 id="vcard-3am" class="vcard"><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We Make Websites</span><a class="include" href="#logo"></a></h1>
<!-- <a href="#" class="link">en espa&#241;ol</a> -->
</div><!-- header -->
<ul id="nav" title="Main Navigation">
	<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
	<li><a href="/index" title="go to our homepage" rel="home">Home</a></li>
	<li><a href="/approach" title="follow our web development procedure">Procedure</a></li>
	<li><a href="/about" title="learn more about 3AM" rel="prev about">About</a></li>
	<li><a href="/portfolio" class="active" title="see some of our previous work">Portfolio</a></li>
	<li><a href="/contact" title="get in touch with us" rel="next contact">Contact</a></li>
</ul>
<div id="content" class="loading">
<?=$_naked?>
<?php
	//echo twix_transform("xml/twilight/portfolio.xml","xml/ns/twix/twix2html-3am.xsl","portfolio.3am.html",$params,false);
	$t = new Transformer('xml/twilight/portfolio.xml','xml/ns/twix/twix2html-3am.xsl',null,$params);
	echo $t->transform();
?>
<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
