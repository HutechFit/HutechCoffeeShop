<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="xml" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
            <xsl:apply-templates/>
        </urlset>
    </xsl:template>
    <xsl:template match="setRoute">
        <xsl:variable name="path" select="normalize-space(@route)"/>
        <xsl:if test="$path != ''">
            <url>
                <loc>
                    <xsl:value-of select="concat('https://hutech-coffee.local', $path)"/>
                </loc>
            </url>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>
