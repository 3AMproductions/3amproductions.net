<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml ..\..\twilight\portfolio.xml?>
<xsl:stylesheet version="1.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:twix="http://3amproductions.net/xml/ns/twix/" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" exclude-result-prefixes="xsi twix xhtml dc">
	<!--<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/xhtml+xml" indent="yes" omit-xml-declaration="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>-->
	<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/xhtml+xml" indent="yes" omit-xml-declaration="yes" />
	<!--<xsl:output method="text" version="1.0" encoding="UTF-8" media-type="text/html" indent="yes" omit-xml-declaration="yes"/>-->
	<xsl:param name="root"/>
	<xsl:param name="tag"/>
	<xsl:variable name="scheme">http://3amproductions.net/xml/tags/</xsl:variable>
	<xsl:variable name="tags" select="twix:portfolio/twix:project/@class | twix:portfolio/twix:project/@status | twix:portfolio/twix:project/@manager"/>
	<xsl:variable name="glossary" select="document('../../tags/glossary.xml')"/>
	<xsl:template match="/">
		<xsl:choose>
			<xsl:when test="$root = 'true'">
				<html>
					<head>
						<title>3AM Productions: Twilight Tag Space</title>
						<link rel="stylesheet" media="screen,projection" href="/styles/main.css" type="text/css" />
						<link rel="stylesheet" media="print" href="/styles/print.css" type="text/css" />
						<link rel="stylesheet" media="handheld" href="/styles/handheld.css" type="text/css" />
						<link type="image/x-icon" rel="shortcut icon" href="/images/favicon.ico"/>
						<link type="image/gif" id="logo" rel="icon" href="/images/favicon.gif"/>
						<link rel="alternate" type="application/rss+xml" title="3AM Productions: Portfolio - Tagged {$tag} (RSS 2.0)" href="http://3amproductions.net/twixrss/{$tag}" />
						<link rel="alternate" type="application/atom+xml" title="3AM Productions: Portfolio - Tagged {$tag} (Atom 1.0)" href="http://3amproductions.net/atom/{$tag}" />
						<style type="text/css">
					h2, #tag_description dt {text-transform:lowercase; }
					em {text-decoration:none; color:#7BB0C0 !important; font-size:1em !important; }
					#tag_description {padding:0 !important; margin:0 !important;}
					#tag_description dt { font-family: "Verdana", "Lucida Sans Unicode", "Century Gothic", sans-serif;
						font-size: 1.5em; text-align: left; margin: 15px 15px 10px 15px; color: #FFFFFF; background: inherit;}
					#tagged_projects {padding-left:15px;}
					#tagged_projects dt {margin-top:1em;}
					#tagged_projects ul {list-style-type:none; padding:0;}
					#tagged_projects li {margin-top:.5em; }
				</style>
					</head>
					<xsl:call-template name="body"/>
				</html>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="body"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template match="/">
		<body>
			<div id="container">
				<div id="header">
					<h1 id="vcard-3am" class="vcard"><a class="include" href="#logo"></a><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We Make Websites</span></h1>
				</div>
				<ul id="nav">
					<li>
						<a href="/index.php" title="go to our homepage" rel="home">Home</a>
					</li>
					<li>
						<a href="/approach.php" title="follow our web development procedure">Procedure</a>
					</li>
					<li>
						<a href="/about.php" title="learn more about 3AM" rel="prev">About</a>
					</li>
					<li>
						<a href="/portfolio.php" title="see some of our previous work">Portfolio</a>
					</li>
					<li>
						<a href="/contact.php" title="get in touch with us">Contact</a>
					</li>
				</ul>
				<div id="content">
					<div id="leftcolumn">
						<xsl:if test="$tag != ''">
							<dl id="tag_description">
								<dt>Tag: <em class="tag">
										<xsl:value-of select="$tag"/>
									</em>
								</dt>
								<xsl:if test="$glossary//tag[@id=$tag]/description">
									<dd>
										<xsl:value-of select="$glossary//tag[@id=$tag]/description"/>
									</dd>
								</xsl:if>
							</dl>
						</xsl:if>
						<h2>All Tags</h2>
						<ul id="all_tags">
							<xsl:for-each select="$tags">
								<xsl:sort/>
								<xsl:variable name="id" select="."/>
								<xsl:if test="generate-id(.)=generate-id($tags[.=$id])">
									<li>
										<a href="{$scheme}{.}" title="See related '{.}' projects">
											<xsl:value-of select="."/>
										</a>
									</li>
								</xsl:if>
							</xsl:for-each>
						</ul>
					</div>
					<!-- leftcolumn -->
					<div id="rightcolumn">
						<xsl:if test="$tag != ''">
							<h2>Projects Tagged <em class="tag">
									<xsl:value-of select="$tag"/>
								</em>
							</h2>
							<dl id="tagged_projects">
								<xsl:apply-templates select="twix:portfolio/twix:project[@class = $tag] | twix:portfolio/twix:project[@status = $tag] | twix:portfolio/twix:project[@manager = $tag]"/>
							</dl>
						</xsl:if>
					</div>
					<!-- rightcolumn -->
				</div>
				<!-- content -->
			</div>
			<!-- container -->
		</body>
	</xsl:template>
	<xsl:template match="twix:project">
		<dt>
			<xsl:choose>
				<xsl:when test="twix:showcase/twix:title">
					<xsl:value-of select="twix:showcase/twix:title"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="twix:organization"/>
				</xsl:otherwise>
			</xsl:choose>
		</dt>
		<xsl:if test="twix:showcase or (twix:livesite and @class != 'private')">
			<dd>
				<ul>
					<xsl:if test="twix:showcase/twix:images/twix:feature/twix:thumbnail">
						<li>
							<img src="{twix:showcase/twix:images/twix:feature/twix:thumbnail}" alt="thumbnail screenshot"/>
						</li>
					</xsl:if>
					<xsl:if test="twix:showcase">
						<li>
							<a href="http://3amproductions.net/portfolio/{@id}" title="" class="portfolio">Portfolio Showcase</a>
						</li>
					</xsl:if>
					<xsl:if test="twix:livesite and @class != 'private'">
						<li>
							<a href="{twix:livesite}" title="" class="livesite">Live Website</a>
						</li>
					</xsl:if>
				</ul>
			</dd>
		</xsl:if>
	</xsl:template>
	<xsl:template match="xhtml:*" mode="no-namespace-copy-of">
		<xsl:element name="{local-name(.)}">
			<xsl:for-each select="@*">
				<xsl:attribute name="{local-name(.)}"><xsl:value-of select="."/></xsl:attribute>
			</xsl:for-each>
			<xsl:apply-templates mode="no-namespace-copy-of"/>
		</xsl:element>
	</xsl:template>
</xsl:stylesheet>
