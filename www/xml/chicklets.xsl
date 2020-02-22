<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/" exclude-result-prefixes="xhtml xsi atom dc">
	<xsl:template name="chicklets">
		<xsl:param name="format"/>
		<xsl:variable name="feed_format">
			<xsl:choose>
				<xsl:when test="$format != ''">
					<xsl:value-of select="$format"/>
				</xsl:when>
				<xsl:otherwise>rss</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<div id="chicklets" style="float:right;">
			<a href="{atom:link[@rel='self']/@href}" type="{atom:link[@rel='self']/@type}" title="Subscribe">
				<img src="/images/feed64.gif" alt="Subscribe"/>
			</a>
			<ul>
				<li>
					<a href="http://fusion.google.com/add?feedurl=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/google-plus.gif" alt="Google Reader or Homepage"/>
					</a>
				</li>
				<li>
					<a href="http://add.my.yahoo.com/rss?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/yahoo.gif" alt="Add to My Yahoo!"/>
					</a>
				</li>
				<li>
					<a href="http://www.bloglines.com/sub/http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/bloglines2.gif" alt="Subscribe with Bloglines"/>
					</a>
				</li>
				<li>
					<a href="http://www.newsgator.com/ngs/subscriber/subext.aspx?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/newsgator.gif" alt="Subscribe in NewsGator Online"/>
					</a>
				</li>
				<li>
					<a href="http://my.msn.com/addtomymsn.armx?id=rss&amp;ut=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}&amp;ru=http://www.3amproductions.net">
						<img src="/images/chicklets/msn2.gif" alt="Add to My MSN"/>
					</a>
				</li>
				<li>
					<a href="http://www.bitty.com/manual/?contenttype=rssfeed&amp;contentvalue=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/bittybrowser.gif" alt="BittyBrowser"/>
					</a>
				</li>
				<li>
					<a href="http://feeds.my.aol.com/add.jsp?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/myaol.gif" alt="Add to My AOL"/>
					</a>
				</li>
				<li>
					<a href="http://rss2pdf.com?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/rss2pdf.png" alt="Convert RSS to PDF"/>
					</a>
				</li>
				<li>
					<a href="http://www.rojo.com/add-subscription?resource=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/rojo.gif" alt="Subscribe in Rojo"/>
					</a>
				</li>
				<li>
					<a href="http://my.feedlounge.com/external/subscribe?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/feedlounge.gif" alt="Subscribe in FeedLounge"/>
					</a>
				</li>
				<li>
					<a href="http://client.pluck.com/pluckit/prompt.aspx?GCID=C12286x053&amp;a=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}&amp;t=3AM+Productions:+Portfolio">
						<img src="/images/chicklets/pluck.png" alt="Subscribe with Pluck RSS reader"/>
					</a>
				</li>
				<li>
					<a href="http://www.feedfeeds.com/add?feed=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/feedfeeds.gif" alt="Feed Your Feeds"/>
					</a>
				</li>
				<li>
					<a href="http://www.kinja.com/checksiteform.knj?pop=y&amp;add=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/kinja.gif" alt="Kinja Digest"/>
					</a>
				</li>
				<li>
					<a href="http://www.multirss.com/rss/http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/multirss.gif" alt="MultiRSS"/>
					</a>
				</li>
				<li>
					<a href="http://www.r-mail.org/bm.aspx?rss=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/rmail.jpg" alt="RMail"/>
					</a>
				</li>
				<li>
					<a href="http://www.rssfwd.com/rssfwd/preview?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/rssfwd.png" alt="Rss fwd"/>
					</a>
				</li>
				<li>
					<a href="http://www.blogarithm.com/subrequest.php?BlogURL=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/blogarithm.gif" alt="Blogarithm"/>
					</a>
				</li>
				<li>
					<a href="http://www.eskobo.com/?AddToMyPage=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/eskobo.gif" alt="Eskobo"/>
					</a>
				</li>
				<li>
					<a href="http://my.gritwire.com/feeds/addExternalFeed.aspx?FeedUrl=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/gritwire.gif" alt="gritwire"/>
					</a>
				</li>
				<li>
					<a href="http://www.botablog.com/botthisblog.php?blog=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}&amp;name=3AM%20Productions:%20Portfolio">
						<img src="/images/chicklets/botablog.gif" alt="BotABlog"/>
					</a>
				</li>
				<li>
					<a href="javascript:location.href='http://immedi.at/accounts/discover?feed_url='+encodeURIComponent(location.href)">
						<img src="/images/chicklets/monitor_this.png" alt="Monitor_this"/>
					</a>
				</li>
				<li>
					<a href="http://www.simpy.com/simpy/LinkAdd.do?href=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}&amp;title=3AM%20Productions:%20Portfolio">
						<img src="/images/chicklets/simpy.png" alt="Simpify!"/>
					</a>
				</li>
				<li>
					<a href="http://technorati.com/faves?add=http://www.3amproductions.net">
						<img src="/images/chicklets/technorati.gif" alt="Add to Technorati Favorites!"/>
					</a>
				</li>
				<li>
					<a href="http://www.netvibes.com/subscribe.php?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/netvibes.gif" alt="Add to Netvibes"/>
					</a>
				</li>
				<li>
					<a href="http://www.pageflakes.com/subscribe.aspx?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}">
						<img src="/images/chicklets/pageflakes.gif" alt="Add to PageFlakes"/>
					</a>
				</li>
				<li>
					<a href="http://www.protopage.com/add-button-site?url=http://3amproductions.net/xml/twilight/feed.php/{$feed_format}&amp;label=3AM%20Productions:%20Portfolio&amp;type=feed">
						<img src="/images/chicklets/protopage.gif" alt="Add this site to your Protopage"/>
					</a>
				</li>
				<li>
					<div id="twistermc-bookmarks">
						<strong>Bookmark This Site</strong>
						<ul>
							<li>
								<a href="http://del.icio.us/post?url=http://www.3amproductions.net&amp;title=3AM%20Productions">Del.icio.us</a>
							</li>
							<li>
								<a href="http://www.furl.net/storeIt.jsp?u=http://www.3amproductions.net&amp;t=3AM%20Productions">Furl It</a>
							</li>
							<li>
								<a href="http://www.spurl.net/spurl.php?url=http://www.3amproductions.net&amp;title=3AM%20Productions">Spurl</a>
							</li>
							<li>
								<a href="http://www.rawsugar.com/pages/tagger.faces?turl=http://www.3amproductions.net&amp;tttl=3AM%20Productions">Tag!RawSugar</a>
							</li>
							<li>
								<a href="http://simpy.com/simpy/LinkAdd.do?title=3AM%20Productions&amp;href=http://www.3amproductions.net">Simpy This!</a>
							</li>
							<li>
								<a href="http://www.shadows.com/features/tcr.htm?url=http://www.3amproductions.net&amp;title=3AM%20Productions">Shadows Tag!</a>
							</li>
							<li>
								<a href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=http://www.3amproductions.net&amp;Title=3AM%20Productions">Blink It</a>
							</li>
							<li>
								<a href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t=3AM%20Productions&amp;u=http://www.3amproductions.net">My Web</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</xsl:template>
</xsl:stylesheet>
