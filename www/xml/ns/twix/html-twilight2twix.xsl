<?xml version="1.0" encoding="UTF-8"?>
<?altova_samplexml ../../twilight/twilight-html-temp.xml?>
<xsl:stylesheet version="1.0" xmlns:twix="http://3amproductions.net/xml/ns/twix/" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" exclude-result-prefixes="xsl">
	<xsl:output method="xml" version="1.0" encoding="UTF-8" media-type="application/xml" indent="yes" omit-xml-declaration="no"/>
	<xsl:template match="/">
		<xsl:apply-templates select="div[@class='projects'] | div[@class='project']"/>
	</xsl:template>
	<xsl:template match="div[@class='projects']">
		<portfolio>
			<xsl:apply-templates select="div[@class='project']"/>
		</portfolio>
	</xsl:template>
	<xsl:template match="div[@class='project']">
		<project>
			<xsl:attribute name="id"><xsl:value-of select="descendant::input[@name='id']/@value"/></xsl:attribute>
			<xsl:attribute name="class"><xsl:value-of select="descendant::select[@name='class']/descendant::option[@selected='selected']/@value"/></xsl:attribute>
			<xsl:attribute name="status"><xsl:value-of select="descendant::select[@name='status']/descendant::option[@selected='selected']/@value"/></xsl:attribute>
			<xsl:if test="descendant::select[@name='manager']/descendant::option[@selected='selected']">
				<xsl:attribute name="manager"><xsl:value-of select="descendant::select[@name='manager']/descendant::option[@selected='selected']/@value"/></xsl:attribute>
			</xsl:if>
			<started>
				<xsl:value-of select="descendant::input[@name='started']/@value"/>
			</started>
			<modified>
				<xsl:value-of select="descendant::input[@name='modified']/@value"/>
			</modified>
			<xsl:if test="descendant::input[@name='launched']/@value != ''">
				<launched>
					<xsl:value-of select="descendant::input[@name='launched']/@value"/>
				</launched>
			</xsl:if>
			<organization>
				<xsl:if test="descendant::input[@name='abbr']/@value != ''">
					<xsl:attribute name="abbr"><xsl:value-of select="descendant::input[@name='abbr']/@value"/></xsl:attribute>
				</xsl:if>
				<xsl:value-of select="descendant::input[@name='organization']/@value"/>
			</organization>
			<xsl:if test="descendant::fieldset[@class='contact']">
				<contacts>
					<xsl:apply-templates select="descendant::fieldset[@class='contact']"/>
				</contacts>
			</xsl:if>
			<xsl:if test="descendant::input[@name='directory']/@value != ''">
				<directory>
					<xsl:value-of select="descendant::input[@name='directory']/@value"/>
				</directory>
			</xsl:if>
			<xsl:if test="descendant::input[@name='subdomain']/@value != ''">
				<subdomain>
					<xsl:value-of select="descendant::input[@name='subdomain']/@value"/>
				</subdomain>
			</xsl:if>
			<xsl:if test="descendant::input[@name='livesite']/@value != ''">
				<livesite>
					<xsl:value-of select="descendant::input[@name='livesite']/@value"/>
				</livesite>
			</xsl:if>
			<xsl:if test="descendant::fieldset[@class='note']">
				<notes>
					<xsl:apply-templates select="descendant::fieldset[@class='note']"/>
				</notes>
			</xsl:if>
			<xsl:if test="descendant::fieldset[@class='screenshot']">
				<showcase>
					<title>
						<xsl:value-of select="descendant::input[@name='title']/@value"/>
					</title>
					<description>
						<xsl:value-of select="descendant::textarea[@name='description']"/>
					</description>
					<images>
						<xsl:apply-templates select="descendant::fieldset[@class='feature']"/>
						<xsl:apply-templates select="descendant::fieldset[@class='screenshot']"/>
					</images>
				</showcase>
			</xsl:if>
		</project>
	</xsl:template>
	<xsl:template match="fieldset[@class='contact']">
		<contact>
			<name>
				<xsl:value-of select="descendant::input[@name='name']/@value"/>
			</name>
			<xsl:if test="descendant::input[@name='jobtitle']/@value != ''">
				<jobtitle>
					<xsl:value-of select="descendant::input[@name='jobtitle']/@value"/>
				</jobtitle>
			</xsl:if>
			<xsl:if test="descendant::input[@name='role']/@value != ''">
				<role>
					<xsl:value-of select="descendant::input[@name='role']/@value"/>
				</role>
			</xsl:if>
			<xsl:apply-templates select="descendant::fieldset[@class='email']"/>
			<xsl:apply-templates select="descendant::fieldset[@class='phone']"/>
			<xsl:apply-templates select="descendant::fieldset[@class='address']"/>
		</contact>
	</xsl:template>
	<xsl:template match="fieldset[@class='email']">
		<email>
			<xsl:attribute name="type"><xsl:value-of select="descendant::select[@name='type']/descendant::option[@selected='selected']/@value"/></xsl:attribute>
			<xsl:value-of select="descendant::input[@name='email']/@value"/>
		</email>
	</xsl:template>
	<xsl:template match="fieldset[@class='phone']">
		<phone>
			<xsl:attribute name="type"><xsl:value-of select="descendant::select[@name='type']/descendant::option[@selected='selected']/@value"/></xsl:attribute>
			<xsl:value-of select="descendant::input[@name='phone']/@value"/>
		</phone>
	</xsl:template>
	<xsl:template match="fieldset[@class='address']">
		<address>
			<xsl:attribute name="type"><xsl:value-of select="descendant::select[@name='type']/descendant::option[@selected='selected']/@value"/></xsl:attribute>
			<xsl:if test="descendant::input[@name='street1']/@value != ''">
				<street1>
					<xsl:value-of select="descendant::input[@name='street1']/@value"/>
				</street1>
			</xsl:if>
			<xsl:if test="descendant::input[@name='street2']/@value != ''">
				<street2>
					<xsl:value-of select="descendant::input[@name='street2']/@value"/>
				</street2>
			</xsl:if>
			<xsl:if test="descendant::input[@name='city']/@value != ''">
				<city>
					<xsl:value-of select="descendant::input[@name='city']/@value"/>
				</city>
			</xsl:if>
			<xsl:if test="descendant::select[@name='state']/descendant::option[@selected = 'selected']">
				<state>
					<xsl:attribute name="abbr">
					<xsl:value-of select="descendant::select[@name='state']/descendant::option/@abbr"/>
					</xsl:attribute>
					<xsl:value-of select="descendant::select[@name='state']/descendant::option"/>
				</state>
			</xsl:if>
			<xsl:if test="descendant::input[@name='zip']/@value != ''">
				<zip>
					<xsl:value-of select="descendant::input[@name='zip']/@value"/>
				</zip>
			</xsl:if>
		</address>
	</xsl:template>
	<xsl:template match="fieldset[@class='note']">
		<note>
			<xsl:attribute name="modified"><xsl:value-of select="descendant::input[@name='modified']/@value"/></xsl:attribute>
			<xsl:attribute name="by"><xsl:value-of select="descendant::select[@name='by']/descendant::option[@selected='selected']/@value"/></xsl:attribute>
			<xsl:value-of select="descendant::textarea[@name='remarks']"/>
		</note>
	</xsl:template>
	<xsl:template match="fieldset[@class='feature']">
							<feature>
							<xsl:if test="descendant::input[@name='src']/@value != ''">
								<src>
									<xsl:value-of select="descendant::input[@name='src']/@value"/>
								</src>
							</xsl:if>
							<xsl:if test="descendant::input[@name='thumbnail']/@value != ''">
								<thumbnail>
									<xsl:value-of select="descendant::input[@name='thumbnail']/@value"/>
								</thumbnail>
							</xsl:if>
						</feature>
</xsl:template>
	<xsl:template match="fieldset[@class='screenshot']">
		<screenshot>
			<xsl:if test="descendant::input[@name='src']/@value != ''">
				<src>
					<xsl:value-of select="descendant::input[@name='src']/@value"/>
				</src>
			</xsl:if>
			<xsl:if test="descendant::input[@name='thumbnail']/@value != ''">
				<thumbnail>
					<xsl:value-of select="descendant::input[@name='thumbnail']/@value"/>
				</thumbnail>
			</xsl:if>
		</screenshot>
	</xsl:template>
</xsl:stylesheet>
