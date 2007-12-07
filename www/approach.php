<?php
/* @TODO: 
 * 
 * fix tense
 */
require_once('config.inc');
$_META['page_title'] = 'procedure';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile($_META['profile']);
$doc->add_style('/main.css','screen,projection');
$doc->head();
?>
<body id="procedure">
<div id="container">
<div id="header">
<h1>3AM Productions | We make Websites</h1>
<!-- <a href="#" class="link">en espa&#241;ol</a> -->
</div><!-- header -->
<ul id="nav"><li><a href="index.php" title="go to our homepage" rel="home prev">Home</a></li><li><a href="approach.php" class="location" title="follow our web development procedure">Procedure</a></li><li><a href="about.php" title="learn more about 3AM" rel="next">About</a></li><li><a href="portfolio.php" title="see some of our previous work">Portfolio</a></li><li><a href="contact.php" title="get in touch with us">Contact</a></li></ul><div id="content">

<div id="leftcolumn">
<h2>explained</h2>
<p>While the procedure explained on this page may look like a very rigid, step by step process, it's actually very fluid and can go back and forth between steps. The procedure is changed to meet the needs of each of our clients.</p>
<p id="vcard-3am" class="vcard">That being said, we show it here for you to get a sense of what you would be undertaking and see some of the things you should be thinking of if you're getting a site with us at <span class="fn org">3AM Productions</span>.</p>
<p class="them">To make it easier, all the steps that involve client responsibilities are displayed with this background.</p>
<p>All the steps without the style above involve work that we do here at <span class="vcard"><object class="include" data="#vcard-3am"></object>3AM Productions</span> while designing your web site. During these steps you can kick back and relax while we do the work.</p>
</div><!-- leftcolumn -->

<div id="rightcolumn">
<h2>the procedure</h2>
<div class="them"><h3>Requirements Collection:</h3><p>This is where we would discuss what your goals for your site would be and what you wish to accomplish overall with your site. We listen to your vision of what you want for your site.</p></div>
<div><h3>Conceptual Design:</h3><p>After our conversation, we at <span class="vcard"><object class="include" data="#vcard-3am"></object>3AM Productions</span> get to work to create a conceptual design as to how to divide your content and decide what technologies your site would need to utilize in order to meet your expectations.</p></div>
<div><h3>Visual Design:</h3><p>During this step we create a template of what the major pages of your site would look like. We also create a sitemap that will lay out how all the information on your page will be categorized and where it will be placed.</p></div>
<div class="them"><h3>Data Collection:</h3><p>This is where you would turn over all the objects you want on the site to us. This could be the images you want on your site, the information on the products you want to sell, any audio or video files you may want on the site and everything else that you have that you want to see on the final version of your site.</p></div>
<div><h3>Creation:</h3><p>With the templates made and all the data in our hands, we can start the actual development of your site.</p></div>
<div><h3>Testing:</h3><p>Creation and testing most of the time go hand in hand. As we make some progress in creation, we test it to make sure it works. But in this stage we take an aggressive approach to testing the site in multiple browsers acrosss multiple platforms to make sure that your site will reach the largest audience possible.</p></div>
<div><h3>The Hand Off:</h3><p>Here we will hand over your site to you. Depending on your needs, we can stick around for a while doing maintenance and making changes as you see fit or we can leave you to do with your site as you wish. We're not like other companies that'll pass off the site and run off, we're here with you for the long run ready to answer any questions and help out in any way we can.</p></div>
</div><!-- rightcolumn -->

<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>