<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml C:\Inetpub\wwwroot\3AM\xml\twilight\portfolio.xml?>
<xsl:stylesheet version="1.0" exclude-result-prefixes="xsi xhtml atom twix dc" 
	xmlns="http://www.w3.org/2005/Atom" 
	xmlns:atom="http://www.w3.org/2005/Atom" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
	xmlns:twix="http://3amproductions.net/xml/ns/twix/" 
	xmlns:xhtml="http://www.w3.org/1999/xhtml" 
	xmlns:dc="http://purl.org/dc/elements/1.1/" 
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/atom+xml" indent="yes" omit-xml-declaration="no"/>
	<xsl:variable name="scheme">http://3amproductions.net/xml/tags/</xsl:variable>
	<!--	<xsl:param name="tags"/>  PHP/XSL can't pass in a DOMNode, use file hack below -->
	<xsl:param name="tagfile"/>
	<xsl:variable name="tags" select="document($tagfile)"/>
	<xsl:template match="twix:portfolio">
		<xsl:processing-instruction name="xml-stylesheet">
			<xsl:text>href="http://3amproductions.net/xml/ns/twix/twixatom2html.xsl" type="text/xsl"</xsl:text>
		</xsl:processing-instruction><xsl:text>
</xsl:text><xsl:comment>This is a comment that has been inserted because of the arrogance of IE7 and FireFox 2 developers that have decided that they don't need to honour a xml stylesheet instruction. Luckily the designers of these browsers use very brittle sniffing techniques that can be overridden by consuming the first 512 bytes of an xml file. This comment provides these essential 512 bytes of crud and destroys the nice simplicity and cleanliness of my Atom feed. This is a comment that has been inserted because of the arrogance of IE7 and FireFox 2 developers that have decided that they don't need to honour a xml stylesheet instruction. Luckily the designers of these browsers use very brittle sniffing techniques that can be overridden by consuming the first 512 bytes of an xml file. This comment provides these essential 512 bytes of crud and destroys the nice simplicity and cleanliness of my Atom feed. This is a comment that has been inserted because of the arrogance of IE7 and FireFox 2 developers that have decided that they don't need to honour a xml stylesheet instruction. Luckily the designers of these browsers use very brittle sniffing techniques that can be overridden by consuming the first 512 bytes of an xml file. This comment provides these essential 512 bytes of crud and destroys the nice simplicity and cleanliness of my Atom feed.</xsl:comment>
		<feed>
			<id>
				<xsl:text>tag:3amproductions.net,2006-09-01:/portfolio/</xsl:text>
			</id>
			<title>3AM Productions: Portfolio</title>
			<subtitle>See how things look different @3AM.</subtitle>
			<link rel="self" href="http://3amproductions.net/atom" type="application/atom+xml"/>
			<link rel="alternate" href="http://3amproductions.net/portfolio" type="application/xhtml+xml"/>
			<link rel="via" href="http://3amproductions.net/portfolio" type="application/xhtml+xml"/>
			<link rel="alternate" href="http://3amproductions.net/rss" type="application/rss+xml"/>
			<link rel="related" href="http://3amproductions.net" type="application/xhtml+xml"/>
			<updated>
				<xsl:value-of select="@modified"/>
				<xsl:text>T03:00:00-05:00</xsl:text>
			</updated>
			<author>
				<name>Jason Karns</name>
				<uri>http://3amproductions.net/jason</uri>
			</author>
			<author>
				<name>Gilbert Velasquez</name>
				<uri>http://3amproductions.net/gilbert</uri>
			</author>
			<generator uri="http://3amproductions.net/xml/twilight/" version="0.1">Twilight Portfolio Management @3AM</generator>
			<icon>http://3amproductions.net/images/favicon.ico</icon>
			<logo>http://3amproductions.clientsection.com/logos/0015/4020/logo.gif</logo>
			<rights type="text">&#169; 2005 Copyright 3AM Productions; &#10;Creative Commons License: &#10;Attribution Non-commercial Share Alike; &#10;http://creativecommons.org/licenses/by-nc-sa/2.5/</rights>
			<xsl:choose>
				<xsl:when test="$tags//tag">
					<xsl:apply-templates select="twix:project[@class = $tags//tag] | twix:project[@status = $tags//tag] | twix:project[@manager = $tags//tag]"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:apply-templates select="twix:project[twix:showcase][@class != 'private']"/>
				</xsl:otherwise>
			</xsl:choose>
		</feed>
	</xsl:template>
	<xsl:template match="twix:project">
		<entry>
			<id>
				<xsl:text>tag:3amproductions.net,</xsl:text>
				<xsl:value-of select="twix:started"/>
				<xsl:text>:/portfolio/</xsl:text>
				<xsl:value-of select="@id"/>
			</id>
			<title>
				<xsl:choose>
					<xsl:when test="twix:showcase/twix:title">
						<xsl:value-of select="twix:showcase/twix:title"/>
					</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="twix:organization"/>
					</xsl:otherwise>
				</xsl:choose>
			</title>
			<link rel="alternate" type="application/xhtml+xml" href="http://3amproductions.net/portfolio/{@id}"/>
			<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot" mode="enclosure"/>
			<summary type="text">
				<xsl:apply-templates select="twix:showcase/twix:description"/>
			</summary>
			<content type="xhtml">
				<div xmlns="http://www.w3.org/1999/xhtml">
					<p>
						<xsl:copy-of select="twix:showcase/twix:description/node()"/>
						<xsl:if test="twix:livesite">
							<br/><a href="{twix:livesite}" class="livesite" title="{twix:showcase/twix:title}">Live Site</a>
						</xsl:if>
					</p>
					<ul>
						<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot"/>
						<!--Shouldn't need the for-each, but namespaces were messing up when calling apply-templates.
						<xsl:for-each select="twix:showcase/twix:images/twix:screenshot">
							<li>
								<img src="{twix:src}" alt="screenshot of {../../twix:title}" title="screenshot of {../../twix:title}"/>
							</li>
						</xsl:for-each>-->
					</ul>
				</div>
			</content>
			<category scheme="{$scheme}" term="{@class}"/>
			<category scheme="{$scheme}" term="{@status}"/>
			<xsl:if test="@manager">
				<category scheme="{$scheme}" term="{@manager}"/>
			</xsl:if>
			<published>
				<xsl:value-of select="twix:started"/>
				<xsl:text>T03:00:00-05:00</xsl:text>
			</published>
			<updated>
				<xsl:value-of select="twix:modified"/>
				<xsl:text>T03:00:00-05:00</xsl:text>
			</updated>
		</entry>
	</xsl:template>
	<xsl:template match="twix:screenshot" mode="enclosure">
		<link rel="enclosure" length="3000" type="image/gif" title="screenshot of {../../twix:title}" href="{twix:src}"/>
	</xsl:template>
	<xsl:template match="twix:screenshot">
		<li xmlns="http://www.w3.org/1999/xhtml">
			<img src="{twix:src}" alt="screenshot of {../../twix:title}" title="screenshot of {../../twix:title}"/>
		</li>
	</xsl:template>
</xsl:stylesheet>
