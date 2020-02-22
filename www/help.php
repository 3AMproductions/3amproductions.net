<?php
require_once('config.inc');
$_META['page_title'] = 'accessibility &amp; copyright information';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap'),null,'gilbert');
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->add_script('footnotelinks.js');
$doc->head();
?>
<body id="help">
<div id="container">
<div id="header">
<h1 id="vcard-3am" class="vcard"><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We Make Websites</span><a class="include" href="#logo"></a></h1>
<!-- <a href="#" class="link">en espa<?=$_ENT['n-tilde']?>ol</a> -->
</div><!-- header -->
<!--<h1><a href="/index" title="go to our homepage"><img id="header" src="/images/headerAT.gif" alt="3AM Productions ||| We make Websites"/></a></h1>-->
<ul id="nav" title="Main Navigation">
	<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
	<li><a href="/index" title="go to our homepage" rel="home" rev="help copyright sitemap">Home</a></li>
	<li><a href="/approach" title="follow our web development procedure" rev="help copyright sitemap">Procedure</a></li>
	<li><a href="/about" class="active" title="learn more about 3AM" rel="about" rev="help copyright sitemap">About</a></li>
	<li><a href="/portfolio" title="see some of our previous work" rev="help copyright sitemap">Portfolio</a></li>
	<li><a href="/contact" title="get in touch with us" rel="contact" rev="help copyright sitemap">Contact</a></li>
</ul>
<ul class="subnav" title="Secondary Navigation">
	<li class="vcard"><abbr class="fn" title="Jason Robert Karns"><a class="url" href="/jason" title="see more about Jason" rev="help copyright sitemap">Jason</a></abbr></li>
	<li class="vcard"><abbr class="fn" title="Gilbert Joseph Velasquez III"><a class="url" href="/gilbert" title="see more about Gil" rel="prev" rev="help copyright sitemap">Gilbert</a></abbr></li>
	<li><a href="/help" class="active" title="see more about thesite" rel="self">thesite</a></li>
</ul>
<div id="content">

<div id="leftcolumn">
<?=$_naked?>
<h2 id="sitemap">Sitemap</h2>
<ul class="map" title="Site Map">
	<li><a href="/index" title="go to our homepage" rel="home" rev="help copyright sitemap">Home</a> is where the heart is</li>
	<li><a href="/approach" title="follow our web development procedure" rev="help copyright sitemap">Procedure</a> is how we do things</li>
	<li><a href="/about" title="learn more about 3AM" rel="about" rev="help copyright sitemap">About</a> our company in general
	<ul><li id="vcard-jason" class="vcard"><a href="/jason" class="url" title="see more about Jason" rev="help copyright sitemap">&rarr; <abbr class="fn" title="Jason Robert Karns">Jason</abbr></a> is our <span class="role">technology guy</span><a href="#orgname" class="include"></a></li><li id="vcard-gil" class="vcard"><a href="/gilbert" class="url" title="see more about Gil" rev="help copyright sitemap">&rarr; <abbr class="fn" title="Gilbert Joseph Velasquez III">Gilbert</abbr></a> is our <span class="role">design guy</span><a href="#orgname" class="include"></a></li><li><a href="/help" title="see more about the site">&rarr; TheSite</a> gets down to business</li><!--<li><a href="/philosophy" title="see our philosophy on web development and standards">Philosophy</a></li>--></ul></li>
	<li><a href="/portfolio" title="see some of our previous work" rev="help copyright sitemap">Portfolio</a> of a few things we've created</li>
	<li><a href="/contact" title="get in touch with us" rel="contact" rev="help copyright sitemap">Contact</a> us if you'd like to say something</li>
	<!--<li><a href="/help" title="accessibility &amp; copyright information">Help</a></li>-->
</ul>
<h2 id="copyright">Copyright</h2>
<p>This work is licensed under an <a href="http://creativecommons.org/licenses/by-nc-sa/2.5/" title="creative commons by-nc-sa" rel="license external">Attribution, Noncommercial, Share-Alike</a> license by <span class="vcard"><a class="url fn org" href="http://creativecommons.org" rel="external">Creative Commons</a></span>.</p>
<h3>Terms of Use</h3>
<p>3amproductions, 3amproductions.net, the <?=$_ABBR['uri']?> of this Web site, and all work (as listed in the portfolio), content(s), and specifically the authorship of articles published here and elsewhere, source code, images, design, stylesheets and overall concept herein are intellectual property of <span class="vcard"><span class="fn org">3AM Productions</span></span>. <span class="vcard"><abbr class="fn org" title="3AM Productions">3AM</abbr></span> reserves all rights (<?=$_ABBR['iprs']?>) to this material.</p>
<h3>Commercial Use</h3>
<p>Commercial use of any kind for financial gain is prohibited, unless you have prior written or contractual approval from <span class="vcard"><abbr class="fn org" title="3AM Productions">3AM</abbr></span>. Please <a href="/contact" title="get in touch with us" rel="contact" rev="help copyright sitemap">contact us</a> for more details.</p>
</div><!-- leftcolumn -->

<div id="rightcolumn">
<h2 id="accessibility">Accessibility Statement</h2>
<p>While the accessibility statement below fully applies to this website, it also applies (in whole or in part) to the websites developed by <span class="vcard"><span class="fn org">3AM Productions</span></span>.</p>
<h3>Access Keys</h3>
	<p>Most browsers support jumping to specific links by typing keys defined on the web site.  On Windows, you can press <kbd>ALT</kbd> + an access key; on Macintosh, you can press <kbd>CTRL</kbd> + an access key. However, at present there is no way to keep site-defined accesskeys from conflicting with a user's macros or with the browser itself. It is for this reason that we do not use accesskeys. They are a good idea, but at the moment they are simply not practical. For more information, see why <span class="vcard"><span class="fn">Dave Shea</span> <a class="url" href="http://www.mezzoblue.com/archives/2003/12/29/i_do_not_use/" title="Dave Shea does not use accesskeys" rel="external">does not use accesskeys</a></span>.</p>
<h3>Standards Compliance</h3>
	<p>All pages on this site conform to the following guidelines. However, compliance with these guidelines is a judgment call; many accessibility features can be measured, but many can not. We have reviewed all the guidelines and believe that all these pages are in compliance.</p>
	<ul title="Standards Compliance">
	<li><a href="http://webxact.watchfire.com/" rel="external">WebXACT <?=$_ABBR['aaa']?> approved</a>, complying with <a href="http://bobby.watchfire.com/bobby/html/en/browsereport.jsp" rel="external">all the Bobby guidelines</a>.</li>
	<li><?=$_ABBR['wcag']?> <?=$_ABBR['aaa']?> approved, complying wih <a href="http://www.w3.org/TR/WAI-WEBCONTENT/full-checklist.html" rel="external">all priority 1, 2, and 3 guidelines</a> of the <a href="http://www.w3.org/TR/WCAG10/" rel="external"><?=$_ABBR['w3c']?> Web Content Accessibility Guidelines</a>.</li>
	<li><a href="http://www.contentquality.com/mynewtester/cynthia.exe?rptmode=-1&amp;url1=http://<?=$_SERVER['SERVER_NAME']?><?=$_SERVER['PHP_SELF']?>" rel="validate external">Section 508 approved</a>, complying with all of the <?=$_ABBR['us']?> Federal Government <a href="http://www.section508.gov/" rel="external">Section 508 Guidelines</a>.</li>
	</ul>
	<p>All pages on this site use structured semantic markup. <code>H2</code> tags are used for main titles, <code>H3</code> tags for subtitles.  For example, on this page, JAWS users can skip to the next section within the accessibility statement by pressing <kbd>ALT+INSERT+3</kbd>.</p>
	<p>In addition to semantic markup, this site makes extensive use of <a href="http://microformats.org" title="Microformat Community Website" rel="external">microformats</a> to allow for advanced information retrieval, extraction, and indexing.</p>
	<p>This website is compliant with many other standards as well, including <?=$_ABBR['xhtml']?> and <?=$_ABBR['css']?>.<!-- More information about these other standards is available on our <a href="/philosophy" title="see our philosophy on web development and standards">philosophy</a> page.--></p>
<h3>Navigation Aids</h3>
	<ol title="Navigation Aids">
	<li>All pages have <code>REL=previous, next, up,</code> and <code>home</code> links to aid navigation in text-only browsers.  Netscape 6 and Mozilla users can also take advantage of this feature by selecting the View menu, Show/Hide, Site Navigation Bar, Show Only As Needed (or Show Always).</li>
	<li>Located on this page, you can also find a sitemap that shows the structure of this website. It is displayed as a nested list portraying the logical breakdown and nesting of the pages in this site.</li>
	</ol>
<h3>Links</h3>
	<ol title="Links">
	<li>Many links have title attributes which describe the link in greater detail, unless the text of the link already fully describes the target (such as the headline of an article).</li>
	<li>Links are written to make sense out of context.</li>
	</ol>
<h3>Images</h3>
	<ol title="Images">
	<li>All content images used in this site include descriptive <code>ALT</code> attributes.  Purely decorative graphics include null <code>ALT</code> attributes.</li>
	<li>Complex images include <code>LONGDESC</code> attributes or inline descriptions to explain the significance of each image to non-visual readers.</li>
	</ol>
<h3>Visual Design</h3>
	<ol title="Visual Design">
	<li>This site uses cascading style sheets for visual layout.</li>
	<li>This site uses only relative font sizes, compatible with the user-specified "text size" option in visual browsers.</li>
	<li>If your browser or browsing device does not support stylesheets at all, the content of each page is still readable.</li>
	</ol>
<h3>Online Services &amp; Tools</h3>
	<ol title="Online Services &amp; Tools">
	<li><a href="http://webxact.watchfire.com/" rel="external">WebXACT</a>, a free service to analyze web pages for compliance to accessibility guidelines.</li>
	<li><a href="http://www.cynthiasays.com/" rel="external">CynthiaSays</a>, a free web content accessibility validation designed to identify errors in content related to Section 508 standards and/or the <?=$_ABBR['wcag']?> guidelines</li>
	<li><a href="http://www.delorie.com/web/wpbcv.html" rel="external">Web Page Backward Compatibility Viewer</a>, a tool for viewing your web pages without a variety of modern browser features.</li>
	<li><a href="http://www.delorie.com/web/lynxview.html" rel="external">Lynx Viewer</a>, a free service for viewing what your web pages would look like in Lynx.</li>
	</ol>
</div><!-- rightcolumn -->

<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
