<?php
require_once('/app/config.inc');
$_META['base_title'] = '3AM Productions';
$_META['page_title'] = 'we make websites';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','openid','favicon','rss','atom','grddl','sitemap'),'approach');
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->add_script('footnotelinks.js');
$doc->head();
?>
<body>
<div id="container">

<div id="header">
<h1 id="vcard-3am" class="vcard"><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We Make Websites</span><a class="include" href="#logo"></a></h1>
<!-- <a href="#" class="link">en espa<?=$_ENT['n-tilde']?>ol</a> -->
</div><!-- header -->

<ul id="nav" title="Main Navigation">
	<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
	<li><a href="/index" class="active" title="go to our homepage" rel="self">Home</a></li>
	<li><a href="/approach" title="follow our web development procedure" rel="next" rev="home">Procedure</a></li>
	<li><a href="/about" title="learn more about 3AM" rel="about" rev="home">About</a></li>
	<li><a href="/portfolio" title="see some of our previous work" rev="home">Portfolio</a></li>
	<li><a href="/contact" title="get in touch with us" rel="contact" rev="home">Contact</a></li>
</ul>
<div id="content">

<div id="leftcolumn">
<?=$_naked?>
<h2>Welcome to Three AM</h2>
<p><span class="vcard"><span class="fn org">3AM Productions</span> is a <span class="note">web design firm</span></span> created by <span class="vcard"><a class="fn url" href="/gilbert" title="see more about Gilbert" rev="home">Gilbert Velasquez</a><a href="#orgname" class="include"></a></span> and <span class="vcard"><a class="fn url" href="/jason" title="see more about Jason" rev="home">Jason Karns</a><a href="#orgname" class="include"></a></span>. We are a small business that works for small business. We specialize in making standards compliant web sites that truly reflect your needs and accomplish your goals.</p>
<p>Our services encompass the entire spectrum of your possible web site needs. We offer graphic design, e-commerce sites, web-based applications, brand identity and more. We invite you to take a look around and see how <a href="/portfolio" title="see some of our previous work" rev="home">things look different at 3AM.</a></p>
</div><!-- leftcolumn -->

<div id="rightcolumn" class="vcard">
<h2>Current Work in Progress</h2>
<a href="/portfolio/renegade" title="see one of the sites in our portfolio" rev="home"><img src="/images/feature.gif" alt="screenshot of www.RenegadeLatino.com" title="screenshot of 3AM client: RenegadeLatino" height="96" width="386" /></a>
<a href="http://www.renegadelatino.com" class="link fn org url" title="visit one of our previous clients" rel="external">RenegadeLatino</a>
<p>'RenegadeLatino' is our client's personal site. We were commissioned to create a design to reflect the dual identity of the client while maintaining a 'dark' scheme. The site also includes interactive features, such as the navigation, to engage the visitor in a more 'hands on' experience.</p>
<p><a href="/portfolio" title="see some of our previous work" rev="home">see more projects</a></p>
</div><!-- rightcolumn -->

<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
