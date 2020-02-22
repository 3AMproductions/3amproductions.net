<?xml-stylesheet href="http://www.w3.org/StyleSheets/base.css" type="text/css"?>
<?xml-stylesheet href="http://www.w3.org/2002/02/style-xsl.css" type="text/css"?>
<?altova_samplexml http://www.3amproductions.net?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:h="http://www.w3.org/1999/xhtml" xmlns:cc="http://web.resource.org/cc/" xmlns:CC="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dt="http://www.w3.org/2001/XMLSchema#">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<title>Stylesheet to extract RDF Creative Common Licenses from XHTML documents</title>
			<link rel="stylesheet" href="http://www.w3.org/StyleSheets/base"/>
		</head>
		<body>
			<div class="head">
				<a href="/">
					<img src="/Icons/w3c_home" alt="W3C"/>
				</a>
			</div>
			<h1>Stylesheet to extract RDF Creative Common Licenses from XHTML documents</h1>
			<p>This transformation produces formalized Creative Commons licenses from informal HTML licenses, per <a href="http://www.w3.org/2003/11/rdf-in-xhtml-proposal">RDF in XHTML proposal</a>. (see also: <a href="http://www.w3.org/2003/11/rdf-in-xhtml-demo">demo</a>.)</p>
			<p>To use this xslt2rdf style sheet, you just need to put a link to the appropriate Creative Common License, with a <code>rel</code> attribute set to <code>cc-license</code> (so that one can e.g. publish a list of links to the CC licenses with a well-defined CC-license).</p>
			<address>
				<a href="http://www.w3.org/People/Connolly/">Dan Connolly</a>  and <a href="/People/Dom/">Dominique Haza&#xeb;l-Massieux</a>
				<br/>
				<small>$Id: grokCC.xsl,v 1.6 2003/12/05 14:19:08 dom Exp $</small>
			</address>
		</body>
	</html>
	<xsl:output method="xml" indent="yes"/>
	<xsl:variable name="rel">
		<xsl:text>cc-license</xsl:text>
	</xsl:variable>
	<xsl:variable name="deed-href">
		<xsl:text>http://creativecommons.org/licenses/</xsl:text>
	</xsl:variable>
	<xsl:variable name="cc-web-resource">
		<xsl:text>http://web.resource.org/cc/</xsl:text>
	</xsl:variable>
	<xsl:variable name="cc-creativecommons">
		<xsl:text>http://creativecommons.org/ns#</xsl:text>
	</xsl:variable>
	<xsl:template match="h:html">
		<rdf:RDF>
			<cc:Work rdf:about="">
				<xsl:apply-templates select="//h:a | //h:link"/>
			</cc:Work>
		</rdf:RDF>
	</xsl:template>
	<xsl:template match="h:a | h:link">
		<!-- tests for occurence of $rel in space delimited list; and assures link points to a cc deed -->
		<xsl:if test="contains(concat(concat(' ',@rel),' '),concat(concat(' ',$rel),' ')) and starts-with(@href,$deed-href)">
			<cc:license>
				<xsl:variable name="rdf-deed-href">
					<xsl:value-of select="@href"/>
					<!-- don't append '/rdf' if they're already linking directly to it -->
					<xsl:if test="not(contains(@href,'/rdf'))">
						<!-- don't add '/' if their link includes a trailing slash:
								this isn't really necessary because extra slashes normally resolve correctly but might as well be proper -->
						<xsl:if test="substring(@href, string-length(@href)) != '/'">
							<xsl:text>/</xsl:text>
						</xsl:if>
						<xsl:text>rdf</xsl:text>
					</xsl:if>
				</xsl:variable>
				<!-- straight copy of creativecommons.org namespaced terms -->
				<!-- <xsl:copy-of select="document($rdf-deed-href)//CC:License"/>-->
				<!-- translate creativecommons.org namespaced terms to web.resource.org namespaced terms -->
				<xsl:apply-templates select="document($rdf-deed-href)//CC:License"/>
			</cc:license>
		</xsl:if>
	</xsl:template>
	<!-- following two templates are only needed if translating from creativecommons.org namespaced terms to web.resource.org namespaced terms -->
	<xsl:template match="CC:License">
		<cc:License rdf:about="{@rdf:about}">
			<xsl:apply-templates/>
		</cc:License>
	</xsl:template>
	<xsl:template match="CC:permits | CC:requires | CC:prohibits">
		<xsl:element name="cc:{local-name(.)}">
			<xsl:attribute name="rdf:resource"><xsl:value-of select="concat($cc-web-resource, substring-after(@rdf:resource,$cc-creativecommons))"/></xsl:attribute>
		</xsl:element>
	</xsl:template>
	<!-- don't pass text thru -->
	<xsl:template match="text()|@*">
</xsl:template>
</xsl:stylesheet>
