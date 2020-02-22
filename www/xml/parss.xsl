<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" exclude-result-prefixes="xsi"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:xhtml="http://www.w3.org/1999/xhtml"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<xsl:output method="xml" version="1.0" encoding="UTF-8"
		media-type="application/rss+xml" indent="yes"
		omit-xml-declaration="no"/>
	<xsl:template match="/">
		<rss version="2.0">
			<channel>
				<title>
					<xsl:value-of
						select="/xhtml:html/xhtml:head/xhtml:title" />
				</title>
				<link>http://portableapps.com/node/7364</link>
				<description>
					<xsl:apply-templates select="/xhtml:html/xhtml:body//xhtml:div[contains(concat(' ',@class,' '),' node ')]/xhtml:div[contains(concat(' ',@class,' '),' content ')]/xhtml:p"/>
				</description>
				<generator>HTML Tidy [http://cgi.w3.org/cgi-bin/tidy]; W3C XSLT Servlet [http://www.w3.org/2005/08/online_xslt/]; 3AM PARSS [http://3amproductions.net/xml/parss.xsl]; YubNub [http://yubnub.org]</generator>
				<language><xsl:value-of select="/xhtml:html/@lang"/></language>
				<docs>http://blogs.law.harvard.edu/tech/rss</docs>
				<xsl:apply-templates
					select="/xhtml:html/xhtml:body//xhtml:div[contains(concat(' ',@class,' '),' comment ')]" />
			</channel>
		</rss>
	</xsl:template>
	<xsl:template match="xhtml:div">
		<item>
			<title>
				<xsl:value-of
					select="normalize-space(xhtml:h3/xhtml:a)" />
			</title>
			<link>
				<xsl:text>http://portableapps.com</xsl:text>
				<xsl:value-of select="xhtml:h3/xhtml:a/@href" />
			</link>
			<guid isPermaLink="true">
				<xsl:text>http://portableapps.com</xsl:text>
				<xsl:value-of select="xhtml:h3/xhtml:a/@href" />
			</guid>
			<pubDate>
				<xsl:value-of select="substring-before(substring-after(xhtml:div[contains(concat(' ',@class,' '),' submitted ')],'on '),' - ')"/>
			</pubDate>
			<description>
				<xsl:value-of
					select="normalize-space(xhtml:div[contains(concat(' ',@class,' '),' content ')])" />
			</description>
			<div xmlns="http://www.w3.org/1999/xhtml">
				<xsl:copy-of
					select="xhtml:div[contains(concat(' ',@class,' '),' content ')]/*" />
			</div>
			<content:encoded>
				<xsl:text disable-output-escaping="yes">&lt;![CDATA[</xsl:text>
				<div xmlns="http://www.w3.org/1999/xhtml">
					<xsl:copy-of
						select="xhtml:div[contains(concat(' ',@class,' '),' content ')]/*" />
				</div>
				<xsl:text disable-output-escaping="yes">]]&gt;</xsl:text>
			</content:encoded>
		</item>
	</xsl:template>
	<xsl:template match="xhtml:p">
		<xsl:value-of select="normalize-space(.)"/><xsl:text>
</xsl:text>
	</xsl:template>
</xsl:stylesheet>