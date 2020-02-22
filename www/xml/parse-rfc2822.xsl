<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" exclude-result-prefixes="xsi">
	<xsl:template name="rfc2822">
		<xsl:param name="date"/>

		<!-- normalize space -->
		<xsl:variable name="date1" select="normalize-space($date)"/>

		<!-- strip day of week, if exists -->
		<xsl:variable name="date2">
			<xsl:choose>
				<xsl:when test="substring-after($date1,',')"><xsl:value-of select="normalize-space(substring-after($date1,','))"/></xsl:when>
				<xsl:otherwise><xsl:value-of select="$date1"/></xsl:otherwise>
			</xsl:choose>
		</xsl:variable>

		<!-- parse day of month -->
		<xsl:variable name="day"><xsl:value-of select="substring-before($date2,' ')"/></xsl:variable>
		<xsl:variable name="date3"><xsl:value-of select="substring-after($date2,' ')"/></xsl:variable>

		<!-- parse month -->
		<xsl:variable name="month-name"><xsl:value-of select="translate(substring-before($date3,' '),'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz')"/></xsl:variable>
		<xsl:variable name="date4"><xsl:value-of select="substring-after($date3,' ')"/></xsl:variable>
		<xsl:variable name="month">
			<xsl:choose>
				<xsl:when test="$month-name = 'jan'"><xsl:text>01</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'feb'"><xsl:text>02</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'mar'"><xsl:text>03</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'apr'"><xsl:text>04</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'may'"><xsl:text>05</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'jun'"><xsl:text>06</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'jul'"><xsl:text>07</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'aug'"><xsl:text>08</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'sep'"><xsl:text>09</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'oct'"><xsl:text>10</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'nov'"><xsl:text>11</xsl:text></xsl:when>
				<xsl:when test="$month-name = 'dec'"><xsl:text>12</xsl:text></xsl:when>
			</xsl:choose>
		</xsl:variable>
		
		<!-- parse year -->
		<xsl:variable name="year"><xsl:value-of select="substring-before($date4,' ')"/></xsl:variable>
		<xsl:variable name="date5"><xsl:value-of select="substring-after($date4,' ')"/></xsl:variable>

		<!-- parse hour -->
		<xsl:variable name="hour"><xsl:value-of select="substring-before($date5,':')"/></xsl:variable>
		<xsl:variable name="date6"><xsl:value-of select="substring-after($date5,':')"/></xsl:variable>

		<!-- parse minute -->
		<xsl:variable name="minute">
			<xsl:choose>
				<xsl:when test="substring-before($date6,':')"><xsl:value-of select="substring-before($date6,':')"/></xsl:when>
				<xsl:otherwise><xsl:value-of select="substring-before($date6,' ')"/></xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<xsl:variable name="date7">
			<xsl:choose>
				<xsl:when test="substring-before($date6,':')"><xsl:value-of select="substring-after($date6,':')"/></xsl:when>
				<xsl:otherwise><xsl:value-of select="substring-after($date6,' ')"/></xsl:otherwise>
			</xsl:choose>
		</xsl:variable>

		<!-- parse second (if exists) -->
		<xsl:variable name="second">
			<xsl:choose>
				<xsl:when test="substring-before($date6,':')"><xsl:value-of select="substring-before($date7,' ')"/></xsl:when>
				<xsl:otherwise><xsl:text>00</xsl:text></xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<xsl:variable name="date8"><xsl:value-of select="substring-after($date7,' ')"/></xsl:variable>

		<!-- ignore timezone -->
		<xsl:variable name="timezone"><xsl:value-of select="substring($date,27)"/></xsl:variable>

		<!-- output date -->
		<xsl:value-of select="$year"/>
		<xsl:text>-</xsl:text>
		<xsl:value-of select="$month"/>
		<xsl:text>-</xsl:text>
		<xsl:value-of select="$day"/>
		<xsl:text>T</xsl:text>
		<xsl:value-of select="$hour"/>
		<xsl:text>:</xsl:text>
		<xsl:value-of select="$minute"/>
		<xsl:text>:</xsl:text>
		<xsl:value-of select="$second"/>
		<!-- default to EST timezone -->
		<xsl:text>-05:00</xsl:text>
	</xsl:template>
</xsl:stylesheet>
