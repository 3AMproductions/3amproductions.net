<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml ..\..\twilight\portfolio.xml?>
<xsl:stylesheet version="1.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:twix="http://3amproductions.net/xml/ns/twix/" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" exclude-result-prefixes="xsi twix xhtml dc">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/xhtml+xml" indent="no" omit-xml-declaration="yes"/>
	<!--<xsl:output method="text" version="1.0" encoding="UTF-8" media-type="text/html" indent="yes" omit-xml-declaration="yes"/>-->
	<xsl:param name="create_root"/>
	<xsl:template match="/">
		<xsl:choose>
			<xsl:when test="$create_root = 'true'">
				<html>
					<body>
						<xsl:call-template name="root"/>
					</body>
				</html>
			</xsl:when>
			<xsl:otherwise>
				<xsl:call-template name="root"/>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template name="root">
		<div id="projects">
			<h1>3AM Projects</h1>
			<ul>
				<xsl:apply-templates select="twix:portfolio/twix:project[twix:showcase][@class != 'private']"/>
			</ul>
		</div>
	</xsl:template>
	<xsl:template match="twix:project">
		<li>
			<a href="/portfolio/{@id}/" title="select project: {twix:showcase/twix:title}">
				<img src="{twix:showcase/twix:images/twix:feature/twix:thumbnail}" alt="screenshot of {twix:showcase/twix:title}" title="select project: {twix:showcase/twix:title}"/>
			</a>
		</li>
		<li>
			<xsl:attribute name="class"><xsl:text>link</xsl:text></xsl:attribute>
			<xsl:choose>
				<xsl:when test="twix:livesite != ''">
					<a href="{twix:livesite}" title="visit {twix:showcase/twix:title}" rel="external">
						<xsl:value-of select="twix:showcase/twix:title"/>
					</a>
				</xsl:when>
				<xsl:otherwise>
					<xsl:value-of select="twix:showcase/twix:title"/>
				</xsl:otherwise>
			</xsl:choose>
		</li>
	</xsl:template>
</xsl:stylesheet>
