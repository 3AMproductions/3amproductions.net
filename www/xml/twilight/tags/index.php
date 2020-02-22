<?php
require_once('../../../config.inc');
require_once('class.transformer.php');

if(isset($_SERVER['PATH_INFO'])){
	$path = explode("/",$_SERVER['PATH_INFO']);
	$tag = htmlentities($path[1]);
	$params = array(array('namespace'=>'','name'=>'tag','value'=>$tag));
}
$params[] = array('namespace'=>'','name'=>'root','value'=>'false');

$_META['base_title'] = '3AM Productions';
$_META['page_title'] = 'Twilight Tag Space';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('hcard'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom'));
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->script->set_dir('../../../scripts/');
$doc->add_script('footnotelinks.js');
$doc->add_extra('<link rel="alternate" type="application/rss+xml" title="3AM Productions: Portfolio - Tagged '.$tag.' (RSS 2.0)" href="http://3amproductions.net/twixrss/'.$tag.'" />');
$doc->add_extra('<link rel="alternate" type="application/atom+xml" title="3AM Productions: Portfolio - Tagged '.$tag.' (Atom 1.0)" href="http://3amproductions.net/atom/'.$tag.'" />');
$doc->add_extra('<style type="text/css">'."\n\t\t".
		'h2, #tag_description dt {text-transform:lowercase; }'."\n\t\t".
		'em {text-decoration:none; color:#7BB0C0 !important; font-size:1em !important; }'."\n\t\t".
		'#tag_description {padding:0 !important; margin:0 !important;}'."\n\t\t".
		'#tag_description dt { font-family: "Verdana", "Lucida Sans Unicode", "Century Gothic", sans-serif;'."\n\t\t".
		'font-size: 1.5em; text-align: left; margin: 15px 15px 10px 15px; color: #FFFFFF; background: inherit;}'."\n\t\t".
		'#tagged_projects {padding-left:15px;}'."\n\t\t".
		'#tagged_projects dt {margin-top:1em;}'."\n\t\t".
		'#tagged_projects ul {list-style-type:none; padding:0;}'."\n\t\t".
		'#tagged_projects li {margin-top:.5em; }'."\n\t".
		'</style>'."\n\t");
$doc->head();

$t = new Transformer('../portfolio.xml','../../ns/twix/twix2html-tag.xsl',null,$params);
$feed = $t->transform();
if($feed !== false) echo $feed;
else echo "<body><p>SteamClaw has encountered an error.</p></body>";
echo '</html>';
?>
