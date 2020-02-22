<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml ..\..\twilight\portfolio.xml?>
<xsl:stylesheet version="1.0" xmlns:twix="http://3amproductions.net/xml/ns/twix/" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" exclude-result-prefixes="xsi twix xhtml dc">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/xml" indent="yes" omit-xml-declaration="no"/>
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
		<portfolio project="{$project}" image="{$image}">
			<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot[position() = $image]" mode="big"/>
			<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot"/>
			<url>
				<xsl:apply-templates select="twix:livesite"/>
			</url>
			<text>
				<xsl:apply-templates select="twix:showcase/twix:description" mode="no-namespace-copy-of"/>
			</text>
		</portfolio>
	</xsl:template>
	
	<xsl:template match="twix:screenshot">
		<small>
			<alt>
				<xsl:text>screenshot of </xsl:text>
				<xsl:apply-templates select="../../twix:title"/>
			</alt>
			<src>
				<xsl:apply-templates select="twix:thumbnail"/>
			</src>
			<href>
				<xsl:text>/portfolio/</xsl:text>
				<xsl:value-of select="../../../@id"/>
				<xsl:text>/</xsl:text>
				<xsl:value-of select="position()"/>
				<xsl:text>/</xsl:text>
			</href>
			<title>
				<xsl:text>enlarge screenshot</xsl:text>
			</title>
		</small>
	</xsl:template>
	
	<xsl:template match="twix:screenshot" mode="big">
		<big_src>
			<xsl:apply-templates select="twix:src"/>
		</big_src>
		<big_alt>
			<xsl:text>screenshot of </xsl:text>
			<xsl:apply-templates select="../../twix:title"/>
		</big_alt>
		<big_title>
			<xsl:text>screenshot of </xsl:text>
			<xsl:apply-templates select="../../twix:title"/>
		</big_title>
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
