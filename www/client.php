<?php
require_once('/app/config.inc');
session_start();
if (!$_SESSION['auth'] === true and !$_SESSION['client_auth'] === true){
	$_SESSION['redirect'] = 'http://3amproductions.net/client';
	header('Location: http://3amproductions.net/login');
	exit;
}

function dirTree($dir,$path=null){
	if(is_null($path)) $path = $dir.'/';
	$d = dir($path);
	$subdirs = null;
	while (false !== ($entry = $d->read())){
		if($entry == '.' || $entry == '..') continue;
		if(is_dir($path.$entry)){
			$subdirs .= dirTree($entry,$path.$entry.'/');
		}
	}
	$d->rewind();
	$files = null;
	while(false !== ($entry = $d->read())){
		if($entry == '.' || $entry == '..') continue;
		if(!is_dir($path.$entry)){
			$filename = str_replace(' ' , '%20' , $path.$entry);
			$files .= '<li><a href="http://'.$filename.'" title="open file" rel="nofollow">'.$entry."</a></li>\n";
		}
	}
	$d->close();
	return '<ul title="Directory Contents"><li>'.$dir.$subdirs.(is_null($files)? '': '<ul>'.$files.'</ul>').'</li></ul>';
}
function printDir(){
	$cwd = getcwd();
	chdir('../');
	if($_SESSION['client_auth'] === true)
		$tree = dirTree($_SESSION['subdomain'].'.3amproductions.net');
	elseif($_SESSION['auth'] === true)
		$tree = dirTree('3amproductions.net');
	chdir($cwd);
	return $tree;
}

if(isset($_POST['sendmail'])){
	require_once('Zend/Mail.php');
	$mail = new Zend_Mail();
	$mail->setFrom($_SESSION['email'], $_SESSION['name']);
	$mail->addTo('3am@3amproductions.net', '3AM Productions');
	$mail->setSubject('From web - client workspace:'.$_POST['subject']);
	$mail->setBodyText($_POST['body']);
	$mail->send();
	$message_sent = true;
}

$_META['page_title'] = 'client workspace';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap'));
$doc->add_profile(array('grddl','hcard','rel-license','rel-tag','3am-xmdp'));
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->add_script('footnotelinks.js');
$doc->add_script('hidemail.js');
$doc->head();
?>
<body>
<div id="container">
<div id="header">
<h1 id="vcard-3am" class="vcard"><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We make Websites</span><a class="include" href="#logo"></a></h1>
</div><!--header-->
<ul id="nav" title="Main Navigation">
	<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
	<li><a href="/index" title="go to our homepage" rel="home">Home</a></li>
	<li><a href="/approach" title="follow our web development procedure">Procedure</a></li>
	<li><a href="/about" title="learn more about 3AM" rel="about">About</a></li>
	<li><a href="/portfolio" title="see some of our previous work">Portfolio</a></li>
	<li><a href="/contact" title="get in touch with us" rel="contact">Contact</a></li>
</ul>
<div id="content">
<div id="leftcolumn">
<h2>your current pages</h2>
<?=printDir()?>
</div><!--leftcolumn-->

<div id="rightcolumn">
<h2>welcome to your 3am workspace</h2>
<p>This page is here to show you the progress that is being made on your site. The column to the left displays a list of pages that are currently being worked on for your site. As we work on your site, various pages will be added and removed and as a result the list on the left will continually be changing. Do not be surprised if a page that was there before is no longer there. It is all a part of the process.</p>
<h2 class="vcard">Contact <span class="fn org">3AM Productions</span></h2>
<p>Feel free to send us a message using the contact form below if you have any questions or comments. We will be in touch with you as soon as we can.</p>
				<p id="greeting"><?=$greeting?></p>
				<?php if(isset($message_sent) and $message_sent){?>
				<p>Thank you! Your message has been sent successfully!</p>
				<?php }else{ ?>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<fieldset>
						<div class="row"><label for="subject">Subject:</label><input id="subject" name="subject" type="text" value=""/></div>
						<div class="row"><label for="body">Body:</label><textarea id="body" name="body" rows="4" cols="35"></textarea></div>
					</fieldset>
					<fieldset class="buttons"><input id="sendmail" name="sendmail" type="submit" value="Send"/><input id="page" name="page" type="hidden" value="<?=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']?>"/></fieldset>
				</form>
				<?php } ?>
			</div><!-- rightcolumn -->
<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
