<?php
require_once('../../config.inc');
require_once('class.transformer.php');

session_start();
if (!$_SESSION['auth'] == true){
	$_SESSION['redirect'] = 'http://3amproductions.net/xml/twilight/index.php';
	header('Location: http://3amproductions.net/login.php');
	exit;
}

$_META['page_title'] = 'Twilight Portfolio Management';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->_IE = true;
$doc->doctype();
$doc->add_profile(array('hcard'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon'));
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->script->set_dir('../../scripts/');
$doc->add_script('footnotelinks.js');
$doc->add_extra('<style type="text/css">dt {text-transform:lowercase; font-weight:bold; }</style>');
$doc->head();
			
?>
<body>
<div id="container">

<div id="header">
<h1 class="vcard"><a href="#vcard-3am" class="include"></a>3AM Productions ||| <span id="note" class="note">We Make Websites</span></h1>
<!-- <a href="#" class="link">en espa<?=$_ENT['n-tilde']?>ol</a> -->
</div><!-- header -->

<ul id="nav" title="Main Navigation">
	<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
	<li><a href="/index.php" class="active" title="go to our homepage">Home</a></li>
	<li><a href="/approach.php" title="follow our web development procedure" rel="next" rev="home">Procedure</a></li>
	<li><a href="/about.php" title="learn more about 3AM" rel="about" rev="home">About</a></li>
	<li><a href="/portfolio.php" title="see some of our previous work" rev="home">Portfolio</a></li>
	<li><a href="/contact.php" title="get in touch with us" rel="contact" rev="home">Contact</a></li>
</ul>
<div id="content">

<div id="leftcolumn">
<h2>Management</h2>
<ul id="management">
	<li><a href="http://3amproductions.net/xml/twilight/tags/"><acronym title="Twilight XML">TWIX</acronym> Tags</a></li>
	<li><a href="http://3amproductions.net/xml/twilight/twilight.php"><acronym title="Twilight XML">TWIX</acronym> Editor</a></li>
	<li><a href="http://pipeline.3amproductions.net" title="Projects in the pipeline">Pipeline</a></li>
	<li><a href="http://activecollab.3amproductions.net" title="ActiveCollab">ActiveCollab</a></li>
	<li><a href="http://3amproductions.net/client" title="Client Workspace">Client Pages</a></li>
</ul>
<dl>
	<dt><acronym title="Twilight XML">TWIX</acronym> Feeds:</dt>
	<dd>
		<ul id="feeds">
			<li><a href="http://3amproductions.net/rss">RSS</a></li>
			<li><a href="http://3amproductions.net/atom">Atom</a></li>
			<li><a href="http://3amproductions.net/rssxhtml">RSS as XHTML</a></li>
			<li><a href="http://3amproductions.net/atomxhtml">Atom as XHTML</a></li>
			<li><a href="http://3amproductions.net/twixrss">RSS from Twix</a> (instead of from Atom)</li>
			<li><a href="http://3amproductions.net/ajax">AJAX as XML</a></li>
			<li><a href="http://3amproductions.net/json">AJAX as JSON</a></li>
		</ul>
	</dd>

	<dt><acronym title="Twilight XML">TWIX</acronym> Schemas:</dt>
	<dd>
		<ul id="schema">
			<li><a href="http://3amproductions.net/xml/ns/twix/index.php/xsd">Schema as XSD</a></li>
			<li><a href="http://3amproductions.net/xml/ns/twix/index.php/html">Schema as XHTML</a></li>
		</ul>
	</dd>
</dl>
</div><!-- leftcolumn -->

<div id="rightcolumn" class="vcard">
<h2>Twilight <acronym title="Portfolio Management">PM</acronym></h2>
<p>Twilight (default <acronym title="eXtensible Markup Language">XML</acronym> namespace prefix: twix) is an <acronym title="eXtensible Markup Language">XML</acronym> based portfolio management system.</p>			
</div><!-- rightcolumn -->

<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
</body>
</html>