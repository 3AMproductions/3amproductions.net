<?php
require_once('config.inc');
$_META['page_title'] = 'about';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap'),'portfolio','approach');
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
<!-- <a href="#" class="link">en espa&#241;ol</a> -->
</div><!-- header -->
<ul id="nav" title="Main Navigation">
	<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
	<li><a href="/index" title="go to our homepage" rel="home" rev="about">Home</a></li>
	<li><a href="/approach" title="follow our web development procedure" rel="prev" rev="about">Procedure</a></li>
	<li><a href="/about" class="active" title="learn more about 3AM" rel="self">About</a></li>
	<li><a href="/portfolio" title="see some of our previous work" rel="next" rev="about">Portfolio</a></li>
	<li><a href="/contact" title="get in touch with us" rel="contact" rev="about">Contact</a></li>
</ul>
<ul class="subnav" title="Secondary Navigation">
	<li class="vcard"><abbr class="fn" title="Jason Robert Karns"><a class="url" href="/jason" title="see more about Jason" rev="about">Jason</a></abbr></li>
	<li class="vcard"><abbr class="fn" title="Gilbert Joseph Velasquez III"><a class="url" href="/gilbert" title="see more about Gil" rev="about">Gilbert</a></abbr></li>
	<li><a href="/help" title="see more about thesite" rel="help sitemap copyright" rev="about">thesite</a></li></ul>
<div id="content">
<div id="leftcolumn">
<?=$_naked?>
<h2>Details</h2>
<p class="vcard"><span class="fn org">3AM Productions</span> is located in the heart of <abbr id="adr" class="adr geo" title="40.067135;-83.099882"><span class="locality">Columbus</span>, <?=$_ABBR['oh']?></abbr>. We are a detail oriented firm that works hard to bring you solutions that incorporate the latest in web technology to provide the most efficient results.</p>
<p>We understand that small companies who are looking towards the internet did not get into business to create and maintain a web site. Let us, here at <span class="vcard"><span class="fn org">3AM Productions</span></span>, take that responsibility off your shoulders so you can get back to doing what you got in business to do.</p>
</div><!-- leftcolumn -->

<div id="rightcolumn">
<h2 class="vcard">All About <span class="fn org">3AM Productions</span></h2>
<p><span class="vcard"><span class="fn org">3AM Productions</span></span> officially began in the spring of 2005. Shortly before then, <span class="vcard"><a class="fn url" href="/jason" title="see more about Jason" rev="about">Jason Karns</a><a href="#orgname" class="include"></a></span> had been creating and maintaining sites for various people while persuing his degree in Computer Science &amp; Engineering and <span class="vcard"><a class="fn url" href="/gilbert" title="see more about Gil" rev="about">Gilbert Velasquez</a><a href="#orgname" class="include"></a></span> had designed and created a few sites while pursuing his degree in Information Systems. The two of them would constantly confer with each other about various issues in which the other had more experience. It quickly became clear that by working together to make web sites, they could be much more prosperous than apart. In that moment, <span class="vcard"><span class="fn org">3AM Productions</span></span> was born.</p>
<p>Since then, <span class="vcard"><span class="fn org">3AM Productions</span></span> has worked hard to add more and more projects to its portfolio. They were constantly taking on projects for little or no compensation in order to build a name and reputation for themselves, while gaining real world experience in the process. The product of this work is now the company you see before you.</p>
<p><span class="vcard"><span class="fn org">3AM Productions</span></span> is focused on creating web sites that satisfy all your needs and accomplish one simple goal: The web site must truly reflect YOU. We feel that you are unique and that should be reflected in your site. We firmly believe that the site we can make for you would not work for anyone else. We work hard to make sure every letter, every image and every detail represent you in every way. Your web site is your representation to the world. At <span class="vcard"><span class="fn org">3AM Productions</span></span>, we take that very seriously and create a site that fulfills that goal.</p>
<p>We sincerely hope you like what you see here and will consider us for your next web development project. If you would like any more information or would like to contact us for any reason, please feel free to <a href="/contact" title="drop us a line" rel="contact" rev="about">get in touch with us.</a><!-- Thank you for your time.--></p> 
</div><!-- rightcolumn -->

<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
