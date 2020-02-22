<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml ..\..\twilight\portfolio.xml?>
<xsl:stylesheet version="1.0" xmlns:twix="http://3amproductions.net/xml/ns/twix/" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" exclude-result-prefixes="xsi twix xhtml dc">
	<xsl:output method="text" version="1.0" encoding="UTF-8" media-type="application/json" indent="no" omit-xml-declaration="yes"/>
	<xsl:param name="image_num"/>
	<xsl:param name="project_id"/>

	<xsl:variable name="project">
		<xsl:choose>
			<xsl:when test="twix:portfolio/twix:project[@id = $project_id]">
				<xsl:value-of select="$project_id"/>
			</xsl:when>
			<xsl:otherwise>threeamv1</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<xsl:variable name="image">
		<xsl:choose>
			<xsl:when test="$image_num = ''">
				<xsl:text>1</xsl:text>
			</xsl:when>
			<xsl:when test="$image_num &gt; count(twix:portfolio/twix:project[@id = $project]/twix:showcase/twix:images/twix:screenshot)">
				<xsl:value-of select="count(twix:portfolio/twix:project[@id = $project]/twix:showcase/twix:images/twix:screenshot)"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$image_num"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	
	<xsl:template match="twix:portfolio">
		<xsl:apply-templates select="twix:project[@id = $project]"/>
	</xsl:template>

	<xsl:template match="twix:project">
		<xsl:text>{"portfolio":{"project":"</xsl:text>
		<xsl:value-of select="$project"/>
		<xsl:text>","image":"</xsl:text>
		<xsl:value-of select="$image"/>
		<xsl:text>","text":"</xsl:text>
		<xsl:call-template name="escape">
			<xsl:with-param name="node">
				<xsl:apply-templates select="twix:showcase/twix:description" mode="no-namespace-copy-of"/>
			</xsl:with-param>
		</xsl:call-template>
		<xsl:text>","url":"</xsl:text>
		<xsl:call-template name="escape">
			<xsl:with-param name="node" select="twix:livesite"/>
		</xsl:call-template>
		<xsl:text>","big":{</xsl:text>
		<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot[position() = $image]" mode="big"/>
		<xsl:text>},"small":[</xsl:text>
		<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot"/>
		<xsl:text>]}}</xsl:text>
	</xsl:template>

	<xsl:template match="twix:screenshot">
		<xsl:text>{"src":"</xsl:text>
		<xsl:call-template name="escape">
			<xsl:with-param name="node" select="twix:thumbnail"/>
		</xsl:call-template>
		<xsl:text>","alt":"screenshot of </xsl:text>
		<xsl:apply-templates select="../../twix:title"/>
		<xsl:text>","href":"\/portfolio\/</xsl:text>
		<xsl:value-of select="../../../@id"/>
		<xsl:text>\/</xsl:text>
		<xsl:value-of select="position()"/>
		<xsl:text>\/","title":"enlarge screenshot"}</xsl:text>
		<xsl:if test="position() != last()">
			<xsl:text>,</xsl:text>
		</xsl:if>
	</xsl:template>

	<xsl:template match="twix:screenshot" mode="big">
		<xsl:text>"src":"</xsl:text>
		<xsl:call-template name="escape">
			<xsl:with-param name="node" select="twix:src"/>
		</xsl:call-template>
		<xsl:text>","alt":"screenshot of </xsl:text>
		<xsl:apply-templates select="../../twix:title"/>
		<xsl:text>","title":"screenshot of </xsl:text>
		<xsl:apply-templates select="../../twix:title"/>
		<xsl:text>"</xsl:text>
	</xsl:template>
	
	<xsl:template match="xhtml:*" mode="no-namespace-copy-of">
		<xsl:text>&lt;</xsl:text>
		<xsl:value-of select="local-name(.)"/>
		<xsl:for-each select="@*">
			<xsl:text> </xsl:text>
			<xsl:value-of select="local-name(.)"/>
			<xsl:text>=&quot;</xsl:text>
			<xsl:value-of select="."/>
			<xsl:text>&quot;</xsl:text>
		</xsl:for-each>
		<xsl:text>&gt;</xsl:text>
		<xsl:apply-templates mode="no-namespace-copy-of"/>
		<xsl:text>&lt;/</xsl:text>
		<xsl:value-of select="local-name(.)"/>
		<xsl:text>&gt;</xsl:text>
	</xsl:template>
	
	<xsl:template name="escape">
		<xsl:param name="node"/>
		<!--		<xsl:value-of select="replace(replace(replace(replace(replace(replace('boo','\\','\\\\'),'/','\\/'),'&quot;','\\&quot;'),'&#xA;','\\n'),'&#xD;','\\r'),'&#x9;','\\t')"/>-->
		<xsl:call-template name="replace-string">
			<xsl:with-param name="text">
				<xsl:call-template name="replace-string">
					<xsl:with-param name="text">
						<xsl:call-template name="replace-string">
							<xsl:with-param name="text" select="$node"/>
							<xsl:with-param name="from" select="'&amp;'"/>
							<xsl:with-param name="to" select="'&amp;amp;'"/>
						</xsl:call-template>
					</xsl:with-param>
					<xsl:with-param name="from" select="'&quot;'"/>
					<xsl:with-param name="to" select="'\&quot;'"/>
				</xsl:call-template>
			</xsl:with-param>
			<xsl:with-param name="from" select="'/'"/>
			<xsl:with-param name="to" select="'\/'"/>
		</xsl:call-template>
	</xsl:template>
	
	<!-- reusable replace-string function -->
	<xsl:template name="replace-string">
		<xsl:param name="text"/>
		<xsl:param name="from"/>
		<xsl:param name="to"/>
		<xsl:choose>
			<xsl:when test="contains($text, $from)">
				<xsl:variable name="before" select="substring-before($text, $from)"/>
				<xsl:variable name="after" select="substring-after($text, $from)"/>
				<xsl:variable name="prefix" select="concat($before, $to)"/>
				<xsl:value-of select="$before"/>
				<xsl:value-of select="$to"/>
				<xsl:call-template name="replace-string">
					<xsl:with-param name="text" select="$after"/>
					<xsl:with-param name="from" select="$from"/>
					<xsl:with-param name="to" select="$to"/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="$text"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
<!--
{"portfolio":{"project":"threeamv2","image":"0","text":"This is our current site which we made as an update and also to be apart of the <a href=\"http:\/\/www.cssreboot.com\" title=\"see the reboots\">May 2006 CSS Reboot<\/a>. We have gone with a minimalistic approach giving the user a bold visual experience while seperating the content without the use of heavy images.","url":"http:\/\/www.3amproductions.net","big":{"src":"http:\/\/www.3amproductions.net\/images\/3v2big01.gif","alt":"screenshot of 3AM Productions v2.0","title":"screenshot of 3AM Productions v2.0"},"small":[{"src":"http:\/\/www.3amproductions.net\/images\/3v2alt01.gif","alt":"screenshot of 3AM Productions v2.0","href":"\/portfolio\/threeamv2\/0\/","title":"enlarge screenshot"},{"src":"http:\/\/www.3amproductions.net\/images\/3v2alt02.gif","alt":"screenshot of 3AM Productions v2.0","href":"\/portfolio\/threeamv2\/1\/","title":"enlarge screenshot"},{"src":"http:\/\/www.3amproductions.net\/images\/3v2alt03.gif","alt":"screenshot of 3AM Productions v2.0","href":"\/portfolio\/threeamv2\/2\/","title":"enlarge screenshot"}]}}
-->
