<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml ..\..\twilight\portfolio.rss.xml?>
<xsl:stylesheet version="1.0" exclude-result-prefixes="xhtml xsi dc dcterms atom media content" extension-element-prefixes="str date"
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
	xmlns:xhtml="http://www.w3.org/1999/xhtml" 
	xmlns:dc="http://purl.org/dc/elements/1.1/" 
	xmlns:dcterms="http://purl.org/dc/terms/" 
	xmlns:content="http://purl.org/rss/1.0/modules/content/" 
	xmlns:media="http://search.yahoo.com/mrss/" 
	xmlns:atom="http://www.w3.org/2005/Atom" 
	xmlns:str="http://exslt.org/strings"
	xmlns:date="http://exslt.org/dates-and-times"
	xmlns:xul="http://www.mozilla.org/keymaster/gatekeeper/there.is.only.xul"
	xmlns:aaa="http://www.w3.org/2005/07/aaa">
	<!-- Use this to parse RFC2822 dates, or use dc:date -->
	<xsl:import href="../../parse-rfc2822.xsl"/>
<!-- It would be nice to use the first .xsl (in includes) but can't reference outside the webroot from browser when doing browser-side transforms. -->
<!-- <xsl:import href="../../../../includes/exslt/date/functions/format-date/date.format-date.function.xsl"/> -->
	<xsl:import href="../../exslt/date/functions/format-date/date.format-date.function.xsl"/>
	<xsl:output method="xml" version="1.0" encoding="UTF-8" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" media-type="application/xhtml+xml" indent="yes" omit-xml-declaration="no"/>
	<xsl:variable name="opera" select="system-property('xsl:vendor') = 'Opera'"/>
	<xsl:variable name="ie" select="system-property('xsl:vendor') = 'Microsoft'"/>
	<xsl:variable name="firefox" select="system-property('xsl:vendor') = 'Transformiix'"/>
	<xsl:variable name="title" select="/rss/channel/title"/>
	<xsl:variable name="link" select="/rss/channel/link"/>
	<xsl:variable name="guid">http://3amproductions.net/rss</xsl:variable>
	<xsl:variable name="scheme">http://3amproductions.net/xml/tags/</xsl:variable>
	<xsl:template match="/rss/channel">
<!-- 		<xsl:text><![CDATA[
		<!DOCTYPE html [
			<!ENTITY % htmlDTD
				PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
				"DTD/xhtml1-strict.dtd">
			%htmlDTD;
			<!ENTITY % globalDTD
				SYSTEM "chrome://global/locale/global.dtd">
			%globalDTD;
			<!ENTITY % feedDTD
				SYSTEM "chrome://browser/locale/feeds/subscribe.dtd">
			%feedDTD;
		]>
		]]>
		</xsl:text> -->
		<html>
			<head profile="http://microformats.org/wiki/hatom#XMDP_Profile http://microformats.org/wiki/rel-license#XMDP_profile http://microformats.org/wiki/hcard-profile http://microformats.org/wiki/rel-tag http://3amproductions.net/xml/xmdp.php">
				<title>
					<xsl:value-of select="$title"/>
					<xsl:if test="$ie"> - IE-3am</xsl:if>
					<xsl:if test="$opera"> - Opera-3am</xsl:if>
					<xsl:if test="$firefox"> - Firefox-3am</xsl:if>
				</title>
				<xsl:if test="$firefox">
					<link rel="stylesheet" href="chrome://browser/skin/feeds/subscribe.css" type="text/css" media="all"/>
					<script type="application/x-javascript" src="chrome://browser/content/feeds/subscribe.js"/>
 				</xsl:if>
				<link rel="alternate" href="{$guid}" title="{$title}" type="application/rss+xml" />
				<link rel="alternate" href="http://3amproductions.net/atom" type="application/atom+xml" title="3AM Productions: Portfolio"/>
				<link rel="alternate" href="http://3amproductions.net/portfolio" type="application/xhtml+xml" title="3AM Productions: Portfolio"/>
				<!-- <script type="text/javascript" src="/scripts/lib.prototype.js.php"></script>
				<script type="text/javascript" src="/scripts/lib.dom.js"></script>
				<script type="text/javascript" src="/scripts/footnotelinks.js"></script> -->
				<link rel="stylesheet" media="projection,screen" href="/styles/twix.feed.html.css" type="text/css" />
				<link rel="stylesheet" media="print" href="/styles/print.css" type="text/css" />
				<link rel="stylesheet" media="handheld" href="/styles/handheld.css" type="text/css" />
				<link rel="shortcut icon" href="{image/url}" type="image/x-icon" />
			</head>
			<body class="hfeed">
				<xsl:if test="$firefox">
					<!-- <xsl:attribute name="onload">SubscribeHandler.init();</xsl:attribute> -->
					<xsl:attribute name="onunload">SubscribeHandler.uninit();</xsl:attribute>
					<div id="feedHeaderContainer">
						<!-- <div id="feedHeader" dir="&#38;locale.dir;"> -->
						<div id="feedHeader" dir="ltr">
							<div id="feedIntroText">
								<!-- <p id="feedSubscriptionInfo1">&#38;feedSubscriptionInfo1a;<strong>&#38;feedName;</strong>&#38;feedSubscriptionInfo1b;</p> -->
								<p id="feedSubscriptionInfo1">This is a “<strong>feed</strong>” of frequently changing content on this site.</p>
								<!-- <p id="feedSubscriptionInfo2">&#38;feedSubscriptionInfo2;</p> -->
								<p id="feedSubscriptionInfo2">You can subscribe to this feed to receive updates when this content changes.</p>
							</div>
						
							<!-- XXXmano this has to be in one line. Otherwise you would see how much XUL-in-XHTML sucks, see bug 348830 -->
							<!-- <div id="feedSubscribeLine"><xul:vbox><xul:hbox align="center"><xul:description id="subscribeUsingDescription">&#38;subscribeUsing;</xul:description><xul:menulist id="handlersMenuList" aaa:labelledby="subscribeUsingDescription"><xul:menupopup menugenerated="true" id="handlersMenuPopup"><xul:menuitem id="liveBookmarksMenuItem" label="&#38;feedLiveBookmarks;" class="menuitem-iconic" image="chrome://browser/skin/page-livemarks.png" selected="true"/><xul:menuseparator/></xul:menupopup></xul:menulist></xul:hbox><xul:hbox><xul:checkbox id="alwaysUse" checked="false"/></xul:hbox><xul:hbox align="center"><xul:spacer flex="1"/><span><xul:button label="&#38;feedSubscribeNow;" id="subscribeButton"/></span></xul:hbox></xul:vbox></div></div> -->
							<div id="feedSubscribeLine"><xul:vbox><xul:hbox align="center"><xul:label value="Subscribe to this feed using " id="subscribeUsingDescription"/><xul:menulist id="handlersMenuList" aaa:labelledby="subscribeUsingDescription"><xul:menupopup menugenerated="true" id="handlersMenuPopup"><xul:menuitem id="liveBookmarksMenuItem" label="Live Bookmarks" class="menuitem-iconic" image="chrome://browser/skin/page-livemarks.png" selected="true"/><xul:menuseparator/></xul:menupopup></xul:menulist></xul:hbox><xul:hbox><xul:checkbox id="alwaysUse" checked="false"/></xul:hbox><xul:hbox align="center"><xul:spacer flex="1"/><span><xul:button label="Subscribe Now" id="subscribeButton"/></span></xul:hbox></xul:vbox></div></div>
					</div>
					
					<!-- XXXben - get rid of me when the feed processor is bug free! -->
					<!-- <div id="feedError" style="display:none;" dir="&#38;locale.dir;">-->
					<div id="feedError" style="display:none;" dir="ltr">
						<!-- <h1>&#38;error.title;</h1> -->
						<h1>Error Processing Feed</h1>
						<!-- <p>&#38;error.message;</p> -->
						<p>There was an error processing this feed. It's our fault. :-( You can still subscribe to the feed if you know what it is. For reference, the error was:</p>
						<p id="errorCode"/>
					</div>
					<!-- <div id="feedBody">
						<div id="feedTitle">
							<a id="feedTitleLink">
								<img id="feedTitleImage"/>
							</a>
							<div id="feedTitleContainer">
								<h1 id="feedTitleText"/>
								<h2 id="feedSubtitleText"/>
							</div>
						</div>
						<div id="feedContent"/>
					</div> -->
				</xsl:if>
				<div id="header">
					<h1 id="vcard-3am" class="vcard"><a class="include" href="#logo"></a><a class="include" href="#url"></a><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We Make Websites</span></h1>
				</div>
				<ul id="nav" title="Main Navigation">
					<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
					<li><a href="/index" id="url" class="url" title="go to our homepage" rel="home">Home</a></li>
					<li><a href="/approach" title="follow our web development procedure">Procedure</a></li>
					<li><a href="/about" title="learn more about 3AM" rel="prev about">About</a></li>
					<li><a href="/portfolio" class="active" title="see some of our previous work">Portfolio</a></li>
					<li><a href="/contact" title="get in touch with us" rel="next contact">Contact</a></li>
				</ul>
				<div id="content">
					<h1>
						<xsl:value-of select="$title"/>
					</h1>
					<p><a class="addthis" href="http://www.addthis.com/feed.php?pub=ZDUU69DWLFL07CV4&amp;h1=http%3A%2F%2F3amproductions.net%2Frss&amp;t1=" title="Subscribe using any feed reader!"><img src="http://s9.addthis.com/button2-fd.png" width="160" height="24" alt="AddThis Feed Button" /></a>This 
						is an <acronym title="Really Simple Syndication">RSS</acronym> feed of our <a href="http://3amproductions.net/portfolio" type="application/xhtml+xml" title="{$title}">portfolio</a>.
						For more information on feeds, see the <a href="http://en.wikipedia.org/wiki/Web_feed" title="Wikipedia - Web Feeds">wikipedia entry</a> or FeedBurner's <a href="http://www.feedburner.com/fb/a/feed101" title="FeedBurner - Feed 101">Feed 101</a>.
						To subscribe to this feed in your favorite reader, you can use the <a href="http://addthis.com/" title="Feed Widgets">AddThis</a> widget to the right.
						You can also get <a href="http://3amproductions.net/atom" title="{$title}" type="'application/atom+xml">this feed in Atom format</a>.</p>
					<h2><xsl:apply-templates select="description"/></h2>
					<xsl:apply-templates select="item"/>
				</div>
				<div id="footer">
					<span>Last Modified:
						<xsl:call-template name="date">
							<xsl:with-param name="class">modified</xsl:with-param>
							<xsl:with-param name="date" select="lastBuildDate"/>
							<!-- <xsl:with-param name="date" select="dc:date"/> -->
							<xsl:with-param name="rfc2822">true</xsl:with-param>
						</xsl:call-template>
					</span>
					<span class="generator">Generated by: <xsl:value-of select="generator"/></span>
					<span class="copyright"><xsl:apply-templates select="copyright"/></span>
				</div>
			</body>
		</html>
	</xsl:template>
	<xsl:template match="item">
		<div class="project hentry">
			<h3 class="entry-title"><xsl:apply-templates select="title"/></h3>
			<div class="entry-content">
				<xsl:apply-templates select="xhtml:div/xhtml:p"/>
				<ul><xsl:apply-templates select="media:group"/></ul>
			</div>
			<dl>
				<dt>Permalink</dt>
				<dd class="permalink"><a href="{link}" title="Permalink for {title}" rel="bookmark" type="application/xhtml+xml"><xsl:value-of select="link"/></a></dd>
				<dt>Started</dt>
				<dd>
					<xsl:call-template name="date">
						<xsl:with-param name="class">published</xsl:with-param>
						<xsl:with-param name="date" select="pubDate"/>
						<!-- <xsl:with-param name="date" select="dc:date"/>	-->
						<xsl:with-param name="rfc2822">true</xsl:with-param>
					</xsl:call-template>
				</dd>
				<!-- There is no 'updated' in RSS, use dcterms:modified -->
				<dt>Updated</dt>
				<dd>
					<xsl:call-template name="date">
						<xsl:with-param name="class">updated</xsl:with-param>
						<xsl:with-param name="date" select="dcterms:modified"/>
					</xsl:call-template>
				</dd>
				<dt>Tagged</dt>
				<dd>
					<ul class="tags">
						<xsl:apply-templates select="category"/>
					</ul>
				</dd>
				<dt>Authors</dt>
				<xsl:apply-templates select="author"/>
				<dd>
					<ul class="authors">
						<li><address class="author vcard"><a class="url fn" href="http://3amproductions.net/jason">Jason Karns</a></address></li>
						<li><address class="author vcard"><a class="url fn" href="http://3amproductions.net/gilbert">Gilbert Velasquez</a></address></li>
					</ul>
				</dd>
			</dl>
		</div>
	</xsl:template>
	<xsl:template match="category">
		<li><a href="{@domain}" title="Tagged: {.}" rel="tag"><xsl:value-of select="."/></a></li>
	</xsl:template>
	<!-- Unused: RSS doesn't have a useful author element -->
	<xsl:template match="author">
		<dd><address class="author vcard"><a class="url fn" href="{substring-before(.,' ')}"><xsl:value-of select="substring-before(substring-after(.,'('),')')"/></a></address></dd>
	</xsl:template>
	<xsl:template match="media:group">
		<li><img src="{media:content/@url}" alt="screenshot of {../title}" title="screenshot of {../title}" /></li>
	</xsl:template>
	<xsl:template match="xhtml:p">
		<p class="entry-summary"><xsl:apply-templates mode="no-namespace-copy-of"/></p>
	</xsl:template>
	<xsl:template name="date">
		<xsl:param name="class"/>
		<xsl:param name="date"/>
		<xsl:param name="rfc2822"/>
		<!-- if using dc:date, no need to parse rfc2822 dates -->
		<xsl:variable name="date1">
			<xsl:choose>
				<xsl:when test="$rfc2822">
					<xsl:call-template name="rfc2822">
						<xsl:with-param name="date" select="$date"/>
					</xsl:call-template>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="$date"/>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<abbr>
			<xsl:if test="$class">
				<xsl:attribute name="class">
					<xsl:value-of select="$class"/>
				</xsl:attribute>
			</xsl:if>
			<xsl:if test="$date1">
				<xsl:attribute name="title">
					<xsl:value-of select="$date1"/>
				</xsl:attribute>
			</xsl:if>
			<xsl:choose>
				<xsl:when test="function-available('date:format-date')">
					<xsl:value-of select="date:format-date($date1, 'EEEE, MMMM d, yyyy')"/>
				</xsl:when>
				<xsl:otherwise>
					<!-- <xsl:value-of select="$date1"/> -->
					<xsl:call-template name="date:format-date">
						<xsl:with-param name="date-time" select="$date1" />
						<xsl:with-param name="pattern" select="'EEEE, MMMM d, yyyy'" />
					</xsl:call-template>
				</xsl:otherwise>
			</xsl:choose>
		</abbr>
	</xsl:template>
	<xsl:template match="xhtml:*" mode="no-namespace-copy-of">
		<!-- <xsl:element name="{name()}" namespace="{namespace-uri()}"> -->
		<xsl:element name="{name()}" namespace="http://www.w3.org/1999/xhtml">
			<xsl:copy-of select="@*"/>
			<xsl:apply-templates/>
		</xsl:element>
	</xsl:template>
</xsl:stylesheet>
