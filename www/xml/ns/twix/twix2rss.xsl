<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml C:\Inetpub\wwwroot\3AM\xml\twilight\portfolio.xml?>
<xsl:stylesheet version="1.0" exclude-result-prefixes="twix xhtml xsi" extension-element-prefixes="date"
		xmlns:twix="http://3amproductions.net/xml/ns/twix/" 
		xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
		xmlns:xhtml="http://www.w3.org/1999/xhtml" 
		xmlns:date="http://exslt.org/dates-and-times" 
		xmlns:dc="http://purl.org/dc/elements/1.1/" 
		xmlns:dcterms="http://purl.org/dc/terms/" 
		xmlns:media="http://search.yahoo.com/mrss/" 
		xmlns:content="http://purl.org/rss/1.0/modules/content/"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<xsl:import href="../../../../includes/exslt/date/functions/format-date/date.format-date.function.xsl"/>
	<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/rss+xml" indent="yes" omit-xml-declaration="no"/>
	<xsl:variable name="title">3AM Productions: Portfolio</xsl:variable>
	<xsl:variable name="self">http://3amproductions.net/rss</xsl:variable>
	<xsl:variable name="tagurl">http://3amproductions.net/xml/tags</xsl:variable>
	<!-- <xsl:param name="tags"/>  PHP/XSL can't pass in a DOMNode, use file hack below -->
	<xsl:param name="tagfile"/>
	<xsl:variable name="tags" select="document($tagfile)"/>
	<xsl:template match="twix:portfolio">
		<xsl:processing-instruction name="xml-stylesheet">
			<xsl:text>href="http://3amproductions.net/xml/ns/twix/twixrss2html.xsl" type="text/xsl"</xsl:text>
		</xsl:processing-instruction><xsl:text>
</xsl:text><xsl:comment>This is a comment that has been inserted because of the arrogance of IE7 and FireFox 2 developers that have decided that they don't need to honour a xml stylesheet instruction. Luckily the designers of these browsers use very brittle sniffing techniques that can be overridden by consuming the first 512 bytes of an xml file. This comment provides these essential 512 bytes of crud and destroys the nice simplicity and cleanliness of my Atom feed. This is a comment that has been inserted because of the arrogance of IE7 and FireFox 2 developers that have decided that they don't need to honour a xml stylesheet instruction. Luckily the designers of these browsers use very brittle sniffing techniques that can be overridden by consuming the first 512 bytes of an xml file. This comment provides these essential 512 bytes of crud and destroys the nice simplicity and cleanliness of my Atom feed. This is a comment that has been inserted because of the arrogance of IE7 and FireFox 2 developers that have decided that they don't need to honour a xml stylesheet instruction. Luckily the designers of these browsers use very brittle sniffing techniques that can be overridden by consuming the first 512 bytes of an xml file. This comment provides these essential 512 bytes of crud and destroys the nice simplicity and cleanliness of my Atom feed.</xsl:comment>
		<rss version="2.0">
			<channel>
				<title>
					<xsl:value-of select="$title"/>
				</title>
				<link>http://3amproductions.net/portfolio</link>
				<description>See how things look different @3AM.</description>
				<xsl:if test="function-available('date:format-date')">
					<lastBuildDate>
						<xsl:value-of select="date:format-date(@modified, 'EEE, dd MMM yyyy')"/>
						<xsl:text> 03:00:00 -0500</xsl:text>
					</lastBuildDate>
				</xsl:if>
				<dc:date>
					<xsl:value-of select="@modified"/>
					<xsl:text>T03:00:00-05:00</xsl:text>
				</dc:date>
				<copyright>&#169; 2005 Copyright 3AM Productions; &#10;Creative Commons License: &#10;Attribution Non-commercial Share Alike; &#10;http://creativecommons.org/licenses/by-nc-sa/2.5/</copyright>
				<image>
					<url>http://3amproductions.net/images/favicon.gif</url>
					<title>3AM Productions: Portfolio</title>
					<link>http://3amproductions.net/portfolio</link>
					<width>16</width>
					<height>16</height>
				</image>
				<generator>Twilight Portfolio Management @3AM</generator>
				<language>en-US</language>
				<rating/>
				<docs>http://blogs.law.harvard.edu/tech/rss</docs>
				<xsl:choose>
					<xsl:when test="$tags//tag">
						<xsl:apply-templates select="twix:project[@class = $tags//tag] | twix:project[@status = $tags//tag] | twix:project[@manager = $tags//tag]"/>
					</xsl:when>
					<xsl:otherwise>
						<xsl:apply-templates select="twix:project[twix:showcase][@class != 'private']"/>
					</xsl:otherwise>
				</xsl:choose>
			</channel>
		</rss>
	</xsl:template>
	<xsl:template match="twix:project">
		<item>
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
			<link>
				<xsl:text>http://3amproductions.net/portfolio/</xsl:text>
				<xsl:value-of select="@id"/>
			</link>
			<guid isPermaLink="false">
				<xsl:text>tag:3amproductions.net,</xsl:text>
				<xsl:value-of select="twix:started"/>
				<xsl:text>:/portfolio/</xsl:text>
				<xsl:value-of select="@id"/>
			</guid>
			<description>
				<xsl:apply-templates select="twix:showcase/twix:description"/>
			</description>
			<xsl:call-template name="xhtml-div" />
			<content:encoded>
				<xsl:text disable-output-escaping="yes">&lt;![CDATA[</xsl:text>
					<xsl:call-template name="xhtml-div" />
				<xsl:text disable-output-escaping="yes">]]&gt;</xsl:text>
			</content:encoded>
			<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot" mode="media-group"/>
			<!-- 
			<author>http://3amproductions.net/jason (Jason Karns)</author>
			<author>http://3amproductions.net/gilbert (Gilbert Velasquez)</author>
			 -->
			<xsl:if test="function-available('date:format-date')">
				<pubDate>
					<xsl:value-of select="date:format-date(twix:started, 'EEE, dd MMM yyyy')"/>
					<xsl:text> 03:00:00 -0500</xsl:text>
				</pubDate>
			</xsl:if>
			<dcterms:modified>
				<xsl:value-of select="twix:modified"/>
				<xsl:text>T03:00:00-05:00</xsl:text>
			</dcterms:modified>
			<category domain="{$tagurl}/{@class}">
				<xsl:value-of select="@class"/>
			</category>
			<category domain="{$tagurl}/{@status}">
				<xsl:value-of select="@status"/>
			</category>
			<xsl:if test="@manager">
				<category domain="{$tagurl}/{@manager}">
					<xsl:value-of select="@manager"/>
				</category>
			</xsl:if>
			<source url="{$self}">
				<xsl:value-of select="$title"/>
			</source>
		</item>
	</xsl:template>
	<xsl:template name="xhtml-div">
		<div xmlns="http://www.w3.org/1999/xhtml">
			<p>
				<xsl:copy-of select="twix:showcase/twix:description/node()"/>
				<xsl:if test="twix:livesite">
					<br/><a href="{twix:livesite}" class="livesite" title="{twix:showcase/twix:title}">Live Site</a>
				</xsl:if>
			</p>
			<ul>
				<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot" mode="list-item"/>
			</ul>
		</div>
	</xsl:template>
	<xsl:template match="twix:screenshot" mode="media-group">
		<xsl:variable name="mimetype">
			<xsl:choose>
				<xsl:when test="contains(twix:src,'.gif')">
					<xsl:text>image/gif</xsl:text>
				</xsl:when>
				<xsl:when test="contains(twix:src,'.png')">
					<xsl:text>image/png</xsl:text>
				</xsl:when>
				<xsl:when test="contains(twix:src,'.jpg') or contains(twix:src,'.jpeg')">
					<xsl:text>image/jpeg</xsl:text>
				</xsl:when>
			</xsl:choose>
		</xsl:variable>
		<media:group>
			<media:content url="{twix:src}" type="{$mimetype}" medium="image" expression="full" height="250" width="480"/>
			<media:thumbnail url="{concat(substring-before(twix:src,'big'),'alt',substring-after(twix:src,'big'))}" height="75" width="150"/>
		</media:group>
	</xsl:template>
	<xsl:template match="twix:screenshot" mode="list-item">
		<li xmlns="http://www.w3.org/1999/xhtml">
			<img src="{twix:src}" alt="screenshot of {../../twix:title}" title="screenshot of {../../twix:title}"/>
		</li>
	</xsl:template>
</xsl:stylesheet>
