<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:vCard="http://www.w3.org/2001/vcard-rdf/3.0#" xml:space="default">
	<xsl:strip-space elements="*"/>
	<xsl:output media-type="text/vcard" method="text" omit-xml-declaration="yes" indent="no"/>
	<xsl:template match="//rdf:Description">
		<xsl:text>BEGIN:VCARD
VERSION:2.1</xsl:text>
		<xsl:apply-templates select="@rdf:about"/>
		<xsl:apply-templates/>
		<xsl:text>
END:VCARD
</xsl:text>
	</xsl:template>
	<xsl:template match="@rdf:about">
		<xsl:text>
UID:</xsl:text>
		<xsl:value-of select="."/>
	</xsl:template>
	<xsl:template match="vCard:N">
		<xsl:text>
N:</xsl:text>
		<xsl:apply-templates select="vCard:Family"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Given"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Other"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Prefix"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Suffix"/>
	</xsl:template>
	<xsl:template match="vCard:FN | vCard:BDAY | vCard:TITLE | vCard:ROLE | vCard:GEO | vCard:TZ | vCard:ORG">
		<xsl:text>
</xsl:text>
		<xsl:value-of select="local-name(.)"/>
		<xsl:text>:</xsl:text>
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="vCard:EMAIL | vCard:TEL">
		<xsl:text>
</xsl:text>
		<xsl:value-of select="local-name(.)"/>
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="vCard:ADR">
		<xsl:text>
ADR</xsl:text>
		<xsl:apply-templates select="rdf:type"/>
		<xsl:text>:</xsl:text>
		<xsl:apply-templates select="vCard:Pobox"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Extadd"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Street"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Locality"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Region"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Pcode"/>
		<xsl:text>;</xsl:text>
		<xsl:apply-templates select="vCard:Country"/>
	</xsl:template>
	<xsl:template match="vCard:Orgunit">
		<xsl:text>;</xsl:text>
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="vCard:PHOTO">
		<xsl:text>
PHOTO</xsl:text>
		<xsl:call-template name="media"/>
	</xsl:template>
	<xsl:template match="vCard:LOGO">
		<xsl:text>
LOGO</xsl:text>
		<xsl:call-template name="media"/>
	</xsl:template>
	<xsl:template match="vCard:SOUND">
		<xsl:text>
SOUND</xsl:text>
		<xsl:call-template name="media"/>
	</xsl:template>
	<xsl:template name="media">
		<xsl:apply-templates select="@vCard:TYPE"/>
		<xsl:choose>
			<xsl:when test="@rdf:resource">
				<xsl:text>;VALUE=URL:</xsl:text>
				<xsl:value-of select="@rdf:resource"/>
			</xsl:when>
			<xsl:otherwise>
				<xsl:apply-templates select="@vCard:ENCODING"/>
			</xsl:otherwise>
		</xsl:choose>
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="vCard:PHOTO/text() | vCard:SOUND/text() | vCard:LOGO/text()">
		<xsl:text>:</xsl:text>
		<xsl:value-of select="."/>
	</xsl:template>
	<xsl:template match="vCard:URL">
		<xsl:text>
URL</xsl:text>
		<xsl:apply-templates select="rdf:type"/>
		<xsl:text>:</xsl:text>
		<xsl:apply-templates select="@rdf:resource"/>
	</xsl:template>
	<xsl:template match="vCard:LABEL">
		<xsl:text>
LABEL:</xsl:text>
		<xsl:apply-templates select="rdf:type"/>
		<xsl:apply-templates select="@vCard:ENCODING"/>
		<xsl:apply-templates select="rdf:value"/>
	</xsl:template>
	<xsl:template match="@vCard:ENCODING">
		<!-- used by KEY, LOGO, PHOTO, SOUND, LABEL -->
		<xsl:text>;ENCODING=</xsl:text>
		<xsl:value-of select="."/>
	</xsl:template>
	<xsl:template match="@vCard:TYPE">
		<!-- used only by UID, LOGO, PHOTO, SOUND -->
		<xsl:text>;TYPE=</xsl:text>
		<xsl:value-of select="."/>
	</xsl:template>
	<xsl:template match="rdf:type">
		<xsl:text>;</xsl:text>
		<!--	XPATH 2.0 will use this: <xsl:value-of select="upper-case(substring-after(@rdf:resource,'#'))"/>-->
		<xsl:variable name="lower">abcdefghijklmnopqrstuvwxyz</xsl:variable>
		<xsl:variable name="upper">ABCDEFGHIJKLMNOPQRSTUVWXYZ</xsl:variable>
		<xsl:value-of select="translate(substring-after(@rdf:resource,'#'),$lower,$upper)"/>
	</xsl:template>
	<xsl:template match="rdf:value">
		<xsl:text>:</xsl:text>
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="rdf:bag | rdf:seq | rdf:alt">
		<xsl:apply-templates select="rdf:li[position() = 1]"/>
		<xsl:for-each select="rdf:li[position() != 1]">
			<xsl:text>, </xsl:text>
			<xsl:apply-templates/>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>
