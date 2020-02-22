<?php
require_once('config.inc');
$_META['page_title'] = 'jason';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard','hcalendar','xfn','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap','openid-jason'),'gilbert');
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->add_script('footnotelinks.js');
$doc->head();
?>
<body id="jason">
<div id="container">
<div id="header">
<h1 id="vcard-3am" class="vcard"><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We Make Websites</span><a class="include" href="#logo"></a></h1>
<!-- <a href="#" class="link">en espa&#241;ol</a> -->
</div><!-- header -->
<ul id="nav" title="Main Navigation">
    <li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
    <li><a href="/index" title="go to our homepage" rel="home">Home</a></li>
    <li><a href="/approach" title="follow our web development procedure">Procedure</a></li>
    <li><a href="/about" class="active" title="learn more about 3AM" rel="about">About</a></li>
    <li><a href="/portfolio" title="see some of our previous work">Portfolio</a></li>
    <li><a href="/contact" title="get in touch with us" rel="contact">Contact</a></li>
</ul>
<ul class="subnav" title="Secondary Navigation">
    <li class="vcard"><abbr class="fn" title="Jason Robert Karns"><a class="url active" href="/jason" title="see more about Jason" rel="me">Jason</a></abbr></li>
    <li class="vcard"><abbr class="fn" title="Gilbert Joseph Velasquez III"><a class="url" href="/gilbert" title="see more about Gil" rel="next met friend co-worker">Gilbert</a></abbr></li>
	<li><a href="/help" title="see more about thesite" rel="help copyright sitemap">thesite</a></li>
</ul>

<div id="content">

<div id="leftcolumn" class="vevent">
<?=$_naked?>
<!--<img src="images/jason.jpg" width="280" height="211" alt="portrait of Jason" />-->
<h2>About</h2>
<ul id="vcard-jason" class="vcard" title="Jason's Details">
  <li><span class="fn n boldbig"><span class="given-name">Jason</span> <span class="additional-name">Robert</span> <span class="family-name">Karns</span></span></li>
  <li>age of <abbr class="bday bold" title="1983-07-22"><?=(date('md') <= date('md',mktime (0,0,0,7,22,1983))) ? (date("Y")-date("Y",mktime (0,0,0,7,22,1983)))-1 : date("Y")-date("Y",mktime (0,0,0,7,22,1983));?></abbr></li>
  <li>born in <abbr class="bold geo" title="39.7500;-84.1833">Dayton, <?=$_ABBR['oh']?></abbr></li>
  <li class="adr"><abbr class="type" title="home">resides</abbr> in <abbr class="bold geo" title="40.067135;-83.099882"><span class="locality">Columbus</span>, <?=$_ABBR['oh']?></abbr></li>
  <li class="note">enjoys <span class="bold">Waterskiing</span> &amp; <span class="bold">Golf</span><a class="include" href="#orgname"></a></li>
</ul>
<h2 class="summary category">Education</h2>
<ul class="description" title="Jason's Education">
	<li id="vcard-osu" class="vcard"><span class="boldbig fn org location"><abbr class="geo" title="40.0000;-82.9833">The Ohio State University</abbr></span></li>
	<li><abbr class="dtstart" title="2002-09-25">2002</abbr> - <abbr class="dtend" title="2007-06-10">2007</abbr></li>
	<li class="vcard">College: <span class="bold fn org location">College of Engineering</span> [ Honors ]</li>
	<li>Major: <span class="bold">Computer Science &amp; Engineering</span></li>
	<li>Specialization: <span class="bold">Software Systems</span></li>
	<li>Minor: <span class="bold">Business Administration</span></li>
</ul>
</div><!-- leftcolumn -->
<div id="rightcolumn">
<h2>Personal Statement</h2>
<p>I have been working with computers ever since my father brought home an Intel 486 when I was in elementary school. I remember trying to learn how to use the darn thing with <?=$_ABBR['pc']?> Tools and <?=$_ABBR['dos']?> until we upgraded to Windows 95. From then on, I spent my time learning as much as I could about computers.</p>
<p>It wasn't until my dad installed our first modem that I became completely enamored with the internet as I watched him play chess with a friend who lived miles away. By the time I entered junior high school, I had begun learning <?=$_ABBR['html']?> and developing personal websites for friends and family. Through high school I expanded my web development skills working on these websites.</p>
<p>When I enrolled in college at <span class="vcard"><span class="fn org">The Ohio State University</span></span>, I knew I wanted to do something with computers and engineering, but I wasn't sure what. Freshman year I was involved in the Fundamentals of Engineering for Honors program. The year-long program culminated in a spring robot design competition where four freshmen engineering students would design, build, test, and complete a fully autonomous robot. I was the lead programmer of the control code for my team's robot and I learned not only how to program a robot, but that programming was what I wanted to do after college.</p>
<p>Ever since freshman year I have been pushing the boundaries of my programming skills both as a software programmer and a web developer. In class I learned C, C++ and Java and would apply the material taught in class (such as modular, component, and object-oriented programming) to my personal projects outside of class.</p>
<p>During this time, I began to learn about web standards, industry best practices in accessibility and usability, and the future technologies of the web. I taught myself <?=$_ABBR['xhtml']?>, <?=$_ABBR['css']?> and JavaScript (<?=$_ABBR['dom']?> Scripting) and began learning about <?=$_ABBR['xml']?> and web services. With my programming skills I taught myself <?=$_ABBR['php']?> and <?=$_ABBR['sql']?> and began creating dynamic, database-driven websites.</p>
<p>With my programming background and experience, desire and interest in new web technologies I can develop rich, cutting-edge internet applications that will enhance one's online presence. With my experience in accessibility, usability, and practice of web standards I can add value to a website or web application. Programming is what I do. Web development is what I enjoy.</p>
</div><!-- rightcolumn -->

<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
