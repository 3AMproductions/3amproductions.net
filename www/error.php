<?php
require_once('config.inc');
$_META['page_title'] = 'error';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap'));
$doc->add_meta('errorlogfeed');
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->add_script('footnotelinks.js');
$doc->head();

if(isset($_SERVER['PATH_INFO'])){
	require_once('Zend/Feed.php');
	
    // display error log info
    try {
        // parse timestamp or tag info from path
        $path = explode("/",$_SERVER['PATH_INFO']);
        
        if(($tmp = array_search("tags",$path)) !== false)
            $feed = "tags/".$path[++$tmp];
        else
            $feed = (strlen($path[2]) > 0) ? $path[2] : null;
    	
        $feed = Zend_Feed::import('http://3amproductions.net/error/feed/'.$feed);
        
    	foreach ($feed as $entry) {
//            if(!is_null($timestamp)) preg_match('/.*feed\/([0-9]+)\/?/', $entry->id(), $entry_timestamp);
//    		if(is_null($timestamp) or ($entry_timestamp[1] == $timestamp))
//    		{
    			$content .= '<li class="hentry vevent">' .
                            '<h2 class="entry-title summary">'.$entry->title().'</h2>'.
//    			            '<p class="entry-summary description">'.nl2br($entry->summary()).'</p>' .
                            $entry->content().
                            '<a href="'.$entry->id().'" rel="bookmark">'.permalink.'</a>'.
                            '</li>';
//    			if(!is_null($timestamp)) break;
//    		}
    	}
        if(!isset($content)){
        	$content = '<h2>Error Log Cleared - Requested Entry Not Found</h2>'.
                       '<p>The Apache error.log and access.log files are purged nightly. It seems the error log entry you requested is no longer in the error log. However, it can be found manually by looking in the stored access and error logs under logs/3amproductions.net/ in the webserver root.</p>';
        }
        else {
        	$content = '<address class="author"><a class="include" href="#vcard-3am"></a></address><ol class="hfeed vcalendar">'.$content.'</ol>';
        }
    } catch (Zend_Http_Client_Exception $e) {
    	$content = '<h2>Zend Http Client Exception</h2>'.
                   '<p>'.$e->getMessage().'</p>';
    }
    $stats = '<br/><br/><h2>Stats and Logs</h2><ul>'.
             '<li><a href="/shortstat/" title="ShortStats">ShortStat</a></li>'.
             '<li><a href="/webalizer" title="Webalizer Stats">Webalizer</a></li>'.
             '<li><a href="/stats" title="Stats provided by DreamHost">Analog</a></li>'.
             '</ul>';
}
else{
	// display error help suggestions
	$request = $_SERVER['SCRIPT_URL'];
	$status = $_SERVER['REDIRECT_STATUS'];
	switch ($status){
		case "400": header("HTTP/1.1 400 Bad Request"); break;
		case "401": header("HTTP/1.1 401 Unauthorized"); break;
		case "403": header("HTTP/1.1 403 Forbidden"); break;
		case "404": header("HTTP/1.1 404 Not Found"); break;
		case "410": header("HTTP/1.1 410 Gone"); break;
		case "500": header("HTTP/1.1 500 Internal Server Error"); break;
		case "501": header("HTTP/1.1 501 Not Implemented"); break;
		case "502": header("HTTP/1.1 502 Bad Gateway"); break;
		case "503": header("HTTP/1.1 503 Service Unavailable"); break;
	}
	
	//require_once('Zend/Mail.php');
	//$mail = new Zend_Mail();
	//$mail->setFrom('3am-error@3amproductions.net', '3AM Error Handler');
	//$mail->addTo('3am@3amproductions.net', '3AM Productions');
	//$mail->setSubject('3AM Error');
	//$mail->setBodyText('File: '.$request."\n".
	//					'Error: '.$status."\n".
	//					'$_SERVER:'."\n".print_r($_SERVER,true).
	//                    '$_GET'."\n".print_r($_GET,true).
	//                    '$_POST'."\n".print_r($_POST,true).
	//                    '$_COOKIE'."\n".print_r($_COOKIE,true).
	//                    '$_FILES'."\n".print_r($_FILES,true).
	//                    '$_ENV'."\n".print_r($_ENV,true).
	//                    '$_SESSION'."\n".print_r($_SESSION,true));
	//$mail->send();
	
	$suggest = array('index','about','approach','client','contact','gilbert','help','jason','login','portfolio','rss','atom','xmdp');
	$suggest = array_combine($suggest, $suggest);
	$alternate = array('home'=>'index', 'procedure'=>'approach', 'twilight'=>'twilight', 'feed'=>'atom', 'tag'=>'tags', 'gil'=>'gilbert', 'folio'=>'portfolio'); 
	
	$best = false;
	$next = false;
	$other = array();
	
	foreach ($suggest as $k => $v) if(strpos($request, $k) !== false) $best = $v;
	foreach ($alternate as $k => $v) if(strpos($request, $k) !== false) $next = $v;
	foreach (array_merge($suggest,$alternate) as $k => $v) {$lev = levenshtein($request, $k); $other[$v] = $lev;}
	
	asort($other);
	$other = array_chunk($other,3,true);
	$other = $other[0];

	switch ($status){
		case "400": $content = "<h2>Error: 400 - Bad Request</h2><p>Don't worry. It's not your fault. We have been notified of the error and are working on it.</p>"; break;
		case "401": $content = "<h2>Error: 401 - Unauthorized</h2><p>We have been notified of the error and are working on it.</p>"; break;
		case "403": $content = "<h2>Error: 403 - Forbidden</h2><p>We have been notified of the error and are working on it.</p>"; break;
		case "404": $content = "<h2>Error: 404 - File Not Found</h2><p>It seems we cannot find '".$request."'.<br/>May we suggest:</p><dl>";
			if($best) $content .= '<dt>Best Match</dt><dd><a href="http://3amproductions.net/'.$best.'">'.$best.'</a></dd>';
			if($next) $content .= '<dt>Next Best Match</dt><dd><a href="http://3amproductions.net/'.$next.'">'.$next.'</a></dd>';
			if($other and is_array($other)){ $content .= '<dt>Other Suggestions</dt>'; foreach($other as $k => $v) $content .= '<dd><a href="http://3amproductions.net/'.$k.'">'.$k.'</a></dd>';} $content .= "</dl>"; break;
		case "410": $content = "<h2>Error: 410 - Gone</h2><p>The resource you requested '".$request."' is no longer available.</p>"; break;
		case "500": $content = "<h2>Error: 500 - Internal Server Error</h2><p>Don't worry. It's not your fault. We have been notified of the error and are working on it.</p>"; break;
		case "501": $content = "<h2>Error: 501 - Not Implemented</h2><p>Don't worry. It's not your fault. We have been notified of the error and are working on it.</p>"; break;
		case "502": $content = "<h2>Error: 502 - Bad Gateway</h2><p>Don't worry. It's not your fault. We have been notified of the error and are working on it.</p>"; break;
		case "503": $content = "<h2>Error: 503 - Service Unavailable</h2><p>Don't worry. It's not your fault. We have been notified of the error and are working on it.</p>"; break;
	}
}

?>
<body id="error">
<div id="container">
<div id="header">
<h1 id="vcard-3am" class="vcard"><a class="include" href="#logo"></a><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We Make Websites</span></h1>
<!-- <a href="#" class="link">en espa<?=$_ENT['n-tilde']?>ol</a> -->
</div><!-- header -->
<ul id="nav" title="Main Navigation">
	<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
	<li><a href="/index" title="go to our homepage">Home</a></li>
	<li><a href="/approach" title="follow our web development procedure" rel="next" rev="home">Procedure</a></li>
	<li><a href="/about" title="learn more about 3AM" rel="about" rev="home">About</a></li>
	<li><a href="/portfolio" title="see some of our previous work" rev="home">Portfolio</a></li>
	<li><a href="/contact" title="get in touch with us" rel="contact" rev="home">Contact</a></li>
</ul>
<div id="content">
<div id="leftcolumn">
<?=$content?>
</div><!-- leftcolumn -->
<div id="rightcolumn">
<?=$stats?>
</div><!-- rightcolumn -->
<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
