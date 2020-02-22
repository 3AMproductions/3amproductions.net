<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml ..\..\twilight\portfolio.xml?>
<xsl:stylesheet version="1.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:twix="http://3amproductions.net/xml/ns/twix/" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" exclude-result-prefixes="xsi twix xhtml dc">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/xhtml+xml" indent="no" omit-xml-declaration="yes"/>
	<!--<xsl:output method="text" version="1.0" encoding="UTF-8" media-type="text/html" indent="yes" omit-xml-declaration="yes"/>-->
	<xsl:param name="create_root"/>
	<xsl:param name="image_num"/>
	<xsl:param name="project_id"/>
	<xsl:variable name="image">
		<xsl:choose>
			<xsl:when test="$image_num != ''">
				<xsl:value-of select="$image_num"/>
			</xsl:when>
			<xsl:otherwise>1</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<xsl:variable name="project">
		<xsl:choose>
			<xsl:when test="$project_id != ''">
				<xsl:value-of select="$project_id"/>
			</xsl:when>
			<xsl:otherwise>threeamv1</xsl:otherwise>
		</xsl:choose>
	</xsl:variable>
	<xsl:template match="/">
		<xsl:choose>
			<xsl:when test="$create_root = 'true'">
				<html>
					<head>
						<title>3AM Productions ||| we make websites</title>
					</head>
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
		<div id="portfolio">
			<h2>Selected Project</h2>
			<xsl:apply-templates select="twix:portfolio/twix:project[@id = $project]" mode="feature"/>
		</div>
		<div id="projects">
			<h2>Other Projects</h2>
			<ul title="Other Projects">
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
	<xsl:template match="twix:project" mode="feature">
		<img src="{twix:showcase/twix:images/twix:screenshot[position() = $image]/twix:src}" alt="screenshot of {twix:showcase/twix:title}" title="screenshot of {twix:showcase/twix:title}"/>
		<h3>
			<xsl:text disable-output-escaping="yes">&amp;rarr; Alternate Images</xsl:text>
		</h3>
		<ul id="alternate" title="Alternate Images">
			<xsl:apply-templates select="twix:showcase/twix:images/twix:screenshot" mode="alternates"/>
		</ul>
		<a href="{twix:livesite}" class="link" title="visit client's site" rel="external">
			<xsl:value-of select="twix:livesite"/>
		</a>
		<p>
			<xsl:apply-templates select="twix:showcase/twix:description" mode="no-namespace-copy-of"/>
		</p>
		<p>
			<a href="{twix:livesite}" title="visit client's site" rel="external">visit site</a>
		</p>
	</xsl:template>
	<xsl:template match="twix:screenshot" mode="alternates">
		<li>
			<a href="/portfolio/{../../../@id}/{position()}/" title="enlarge screenshot">
				<img src="{twix:thumbnail}" alt="screenshot of {../../twix:title}" title="enlarge screenshot"/>
			</a>
		</li>
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
