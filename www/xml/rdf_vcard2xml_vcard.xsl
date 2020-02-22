<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:vCard="http://www.w3.org/2001/vcard-rdf/3.0#" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="default" exclude-result-prefixes="rdf">
	<xsl:strip-space elements="*"/>
	<xsl:output method="xml" indent="yes"/>
	<xsl:template match="rdf:Description">
		<vcard>
			<xsl:attribute name="about"><xsl:value-of select="@rdf:about"/></xsl:attribute>
			<xsl:attribute name="xml:lang"><xsl:value-of select="@xml:lang"/></xsl:attribute>
			<xsl:apply-templates/>
		</vcard>
	</xsl:template>
	<xsl:template match="*">
		<xsl:variable name="name" select="name(.)"/>
		<xsl:element name="{$name}">
			<xsl:apply-templates select="@*"/>
			<xsl:apply-templates/>
		</xsl:element>
	</xsl:template>
	<xsl:template match="//@vCard:* | //@xlink:*">
		<xsl:variable name="name" select="name(.)"/>
		<xsl:attribute name="{$name}"><xsl:value-of select="."/></xsl:attribute>
	</xsl:template>
	<xsl:template match="//*[rdf:type]">
		<xsl:variable name="name" select="name(.)"/>
		<xsl:element name="{$name}">
			<xsl:attribute name="vCard:TYPE"><xsl:apply-templates select="rdf:type" mode="att"/></xsl:attribute>
			<xsl:apply-templates/>
		</xsl:element>
	</xsl:template>
	<xsl:template match="vCard:URL">
		<xsl:variable name="name" select="name(.)"/>
		<xsl:element name="{$name}">
			<xsl:value-of select="@rdf:resource"/>
			<xsl:apply-templates/>
		</xsl:element>
	</xsl:template>
	<xsl:template match="rdf:li | rdf:RDF | rdf:value | rdf:type">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="rdf:type" mode="att">
		<xsl:if test="position() != 1">
			<xsl:text>;</xsl:text>
		</xsl:if>
		<!--
				XPATH 2.0 will use this:
				<xsl:value-of select="upper-case(substring-after(@rdf:resource,'#'))"/>
-->
		<xsl:variable name="lower">abcdefghijklmnopqrstuvwxyz</xsl:variable>
		<xsl:variable name="upper">ABCDEFGHIJKLMNOPQRSTUVWXYZ</xsl:variable>
		<xsl:value-of select="translate(substring-after(@rdf:resource,'#'),$lower,$upper)"/>
	</xsl:template>
	<xsl:template match="rdf:bag | rdf:seq | rdf:alt">
		<xsl:apply-templates select="rdf:li[position() = 1]"/>
		<xsl:for-each select="rdf:li[position() != 1]">
			<xsl:text>, </xsl:text>
			<xsl:apply-templates/>
		</xsl:for-each>
	</xsl:template>
	<xsl:template match="@rdf:parseType"/>
</xsl:stylesheet>
