<?php
require_once('config.inc');
$_META['page_title'] = 'gilbert';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard', 'hcalendar', 'xfn','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap','openid-gilbert'),'help','jason');
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->add_script('footnotelinks.js');
$doc->head();
?>
<body id="gilbert">
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
	<li class="vcard"><abbr class="fn" title="Jason Robert Karns"><a class="url" href="/jason" title="see more about Jason" rel="prev met friend co-worker">Jason</a></abbr></li>
	<li class="vcard"><abbr class="fn" title="Gilbert Joseph Velasquez III"><a class="url active" href="/gilbert" title="see more about Gil" rel="me self">Gilbert</a></abbr></li>
	<li><a href="/help" title="see more about thesite" rel="next help copyright sitemap">thesite</a></li>
</ul>

<div id="content">

<div id="leftcolumn" class="vevent">
<?=$_naked?>
<img id="photo" class="photo" src="/images/gilbert.jpg" width="280" height="211" alt="portrait of Gilbert" />
<h2>About</h2>
<ul id="vcard-gil" class="vcard" title="Gilbert's Details">
  <li><a class="include" href="#orgname"></a><a class="include" href="#photo"></a><span class="fn n boldbig"><span class="given-name">Gilbert</span> <span class="additional-name">Joseph</span> <span class="family-name">Velasquez</span> <span class="honorific-suffix">III</span></span></li>
  <li>age of <abbr class="bday bold" title="1984-07-06"><?=(date('md') <= date('md',mktime (0,0,0,7,6,1984))) ? (date("Y")-date("Y",mktime (0,0,0,7,6,1984)))-1 : date("Y")-date("Y",mktime (0,0,0,7,6,1984));?></abbr></li>
  <li>born in <abbr class="bold geo" title="40.7000;74.0000">New York City, <?=$_ABBR['ny']?></abbr></li>
  <li class="adr"><abbr class="type" title="home">resides</abbr> in <abbr class="bold geo" title="39.962208;-83.000676"><span class="locality">Columbus</span>, <?=$_ABBR['oh']?></abbr></li>
  <li class="note">speaks <span class="bold">English</span> &amp; <span class="bold">Spanish</span></li>
  <li class="note">drives an <span class="bold">MkV GTI</span></li>
</ul>
<h2 class="summary category">Education</h2>
<ul class="description" title="Gilbert's Education">
	<li id="vcard-osu" class="vcard"><span class="boldbig fn org location"><abbr class="geo" title="40.0000;-82.9833">The Ohio State University</abbr></span></li>
	<li><abbr class="dtstart" title="2002-09-25">2002</abbr> - <abbr class="dtend" title="2007-06-10">2007</abbr></li>
	<li class="vcard">College: <span class="bold fn org location">Fisher College of Business</span> [ Honors ]</li>
	<li>Major: <span class="bold">Business Administration</span></li>
	<li>Specialization: <span class="bold"><?=$_ABBR['mis']?></span></li>
	<li>Minor: <span class="bold">Latino/a Studies</span></li>
</ul>
</div><!-- leftcolumn -->

<div id="rightcolumn">
<h2>Personal Statement</h2>
<p>I have been involved in technology for about 10 years. When I was younger, my father owned his own transportation company. It was run out of our home and we had to cut costs wherever possible. We had a huge problem when it came time to pay our taxes to Uncle Sam as we had to pay an accountant a lot of money to go through all our statements. I suggested we use a spreadsheet to maintain our own figures to save some money, and the rest, as they say, is history.</p>
<p>Ever since, I've had a passion in using technology to support business functions in a way that will save them money and make them more profitable. I came into <span class="vcard"><abbr class="fn org" title="The Ohio State University">OSU</abbr></span> as an Electrical and Computer Engineering major with the plan of writing business software some day. It wasn't the best fit and I wanted to get more into the business side of things. So now I am majoring in Business Administration with a specialization in Management Information Systems and a particular interest in Project Management and Systems Analysis.</p>
<p>I come from a Spanish speaking home and was raised in the Peruvian tradition. I've traveled to <abbr class="geo" title="-10;-76">Peru</abbr> multiple times and even had <a href="http://www.raura.com/" title="visit employer" rel="external">an intership</a> there over the summer. This has really opened my eyes and mind to the way business works around the world. I feel this has given me a special advantage in that I am able to see things from different perspectives. I do not just view things from one aspect, I understand there may be more than one way to approach a problem, and this results in my being able to find solutions when others may not.</p>
<p>I got into web design before I began at <span class="vcard"><abbr class="fn org" title="The Ohio State University">OSU</abbr></span>. I've always thought outside the box and have been creative when solving problems, much the opposite of <a href="http://en.wikipedia.org/wiki/Functional_fixedness" title="see Wikipedia article on functional fixedness" rel="external">functional fixedness</a>. I feel that I have a good blend of technical knowledge and business skills that allow me to truly understand a business problem and to which I can then apply my technical knowledge to come up with a feasible solution incorporating technology.</p>
<p>So I invite you to look through the 3AM Productions site and <a href="/portfolio" title="see some of our previous work">see the work we've done</a> and how we've helped business and organizations reach their full potential. Feel free to drop us a line and see what we can do for you.</p>
</div><!-- rightcolumn -->

<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
