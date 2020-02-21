<?php
/* @TODO: 
 * 
 * unique POST ID to eliminate refresh/back/forward posts
 *  create ID, print to form, save in db,
 *  $better_token = md5(uniqid(rand(), true));
 * 
 * OR redirect on successful submit to new page (or contact page)
 * 
 *  fix submission including nl2br in result (<br/>)
 * 
 */
require_once('/app/config.inc');

//I hate spambots
if(isset($_POST['human']) and isset($_POST['nonce'])){
	$a = $_POST['human'] . date("H");
	$b = $_POST['human'] . date("H", time() - 3600);
	if(md5($a) != $_POST['nonce'] and md5($b) != $_POST['nonce']){
		header("Location: http://3amproductions.net/contact?spambot=true");
		exit;}
}else{
	$x = rand(0,5);
	$y = rand(0,5);
	$sum = $x + $y;
	$nonce = md5($sum . date("H"));
}

if(isset ($_POST['preview'])) $clean_post = htmlchars($_POST);
if(isset ($_POST['edit']) or isset($_POST['submit'])) $clean_post = array_map('stripslashes',(array_map('htmlentities',array_map('br2nl',$_POST))));
if(!isset ($clean_post['name']) or !isset ($clean_post['email']) or !isset ($clean_post['subject']) or !isset ($clean_post['body']) or !isset ($clean_post['human']) or !isset ($clean_post['nonce'])) $clean_post=array_fill_keys(['name', 'email', 'subject', 'body'], '');

if(isset($_POST['submit'])){
	if(!empty($_POST['name']) or !empty($_POST['email']) or !empty($_POST['subject']) or !empty($_POST['body'])){
		include_once('Zend/Mail.php');
		include_once('class.akismet.php');
		$APIKey =  '13abb6eed38e';
		$BlogURL = 'http://3amproductions.net';

		if (class_exists('Zend_Mail')){
			$mail = new Zend_Mail();
			$mail->setFrom($_POST['email'], $_POST['name']);
			$mail->addTo('3am@3amproductions.net', '3AM Productions');
			$mail->setBodyText($_POST['body']);

			if(class_exists('Akismet')){
				$akismet = new Akismet($BlogURL ,$APIKey);
				$akismet->setCommentAuthor($_POST['name']);
				$akismet->setCommentAuthorEmail($_POST['email']);
				$akismet->setCommentContent($_POST['body']);
				if($akismet->isCommentSpam())
					$mail->setSubject('[SPAM] From web:'.$_POST['subject']);
			}
			if($mail->getSubject() === null)
				$mail->setSubject('From web:'.$_POST['subject']);
			$mail->send();
		}
		else{
			$headers = str_replace("\n",'','From: '.$_POST['name'].' <'.$_POST['email'].'>') . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n\r\n";
			$to = '3AM Productions <3am@3amproductions.net>';
			$body = wordwrap($_POST['body'], 70, "\n", true);
			$subject = str_replace("\n",'','From web:'.$_POST['subject']);
			
			if(class_exists('Akismet')){
				$akismet = new Akismet($BlogURL ,$APIKey);
				$akismet->setCommentAuthor($_POST['name']);
				$akismet->setCommentAuthorEmail($_POST['email']);
				$akismet->setCommentContent($_POST['body']);
				if($akismet->isCommentSpam())
					$subject = '[SPAM] '.$subject;
			}
			mail ($to,$subject,$body,$headers);
		}
	}
	header("Location: http://3amproductions.net/contact?sent=true");
	exit;
}
$_META['page_title'] = 'contact';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap'),null,'portfolio');
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/ie.css','screen,projection',null,null,'IE');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->add_script('hidemail.js');
$doc->add_script('footnotelinks.js');
$doc->head();
?>
<body id="contact">
	<div id="container">
		<div id="header">
			<h1 id="vcard-3am" class="vcard"><span class="fn org"><span id="orgname" class="organization-name">3AM Productions</span></span> ||| <span id="note" class="note">We Make Websites</span><a class="include" href="#logo"></a></h1>
			<!-- <a href="#" class="link">en espa&#241;ol</a> -->
		</div><!-- header -->
		<ul id="nav" title="Main Navigation">
			<li id="skipnav"><a href="#content" title="Skip Navigation">Skip to Content</a></li>
			<li><a href="/index" title="go to our homepage" rel="home" rev="contact">Home</a></li>
			<li><a href="/approach" title="follow our web development procedure" rev="contact">Procedure</a></li>
			<li><a href="/about" title="learn more about 3AM" rel="about" rev="contact">About</a></li>
			<li><a href="/portfolio" title="see some of our previous work" rel="prev" rev="contact">Portfolio</a></li>
			<li><a href="/contact" class="active" title="get in touch with us" rel="self">Contact</a></li>
		</ul>
		<div id="content">
			<div id="leftcolumn">
			<?=$_naked?>
				<h2>How to Contact US</h2>
				<dl title="How to Contact Us">
					<!--<dt>Snail Mail</dt>
					<dd>
						<dl class="personal">
							<dt>3AM Productions</dt>
							<dd>
  								<address><a href="http://maps.google.com/maps?q=5518+Kenneylane+Blvd+Columbus+OH+43235" title="Google Maps to 3AM's HQ" rel="geo external">5518 Kenneylane Blvd<br/>Columbus, <?=$_ABBR['oh']?> 43235</a></address>
							</dd>
						</dl>
					</dd>-->
					<dt>Electronic Mail</dt>
					<dd>
						<dl id="emails" class="personal" title="Email Addresses">
							<dt>Design:</dt>
							<dd><address class="email" title="Email 3AM Design">design[at]3amproductions[dot]net</address></dd>
							<dt>Technology:</dt>
							<dd><address class="email" title="Email 3AM Technology">tech[at]3amproductions[dot]net</address></dd>
							<dt>General:</dt>
							<dd><address class="email" title="Email 3AM Productions">3AM[at]3amproductions[dot]net</address></dd>
						</dl>
					</dd>
				</dl>
			</div><!-- leftcolumn -->
			<div id="rightcolumn">
				<h2 class="vcard">Contact <span class="fn org">3AM Productions</span><a class="include" href="#emails"></a></h2>
				<p id="greeting"><!--?=$greeting?--></p>
				<?php if(isset($_GET['sent']) and $_GET['sent'] == true){ ?>
				<p>Thank you! Your message has been sent successfully!</p>
				<?php }elseif(isset($_GET['spambot']) and $_GET['spambot'] == true){ ?>
				<p>We think you are a spambot because you didn't answer your math question correctly. If you are human, we apologize and you can try again by clicking the 'contact' link above.</p>
				<?php }elseif(isset($clean_post['preview'])){ ?>
				<form method="post">
					<fieldset>
						<input name="name" type="hidden" value="<?=$clean_post['name']?>"/>
						<input name="email" type="hidden" value="<?=$clean_post['email']?>"/>
						<input name="subject" type="hidden" value="<?=$clean_post['subject']?>"/>
						<input name="body" type="hidden" value="<?=$clean_post['body']?>"/>
						<input name="human" type="hidden" value="<?=$clean_post['human']?>"/>
						<input name="nonce" type="hidden" value="<?=$clean_post['nonce']?>"/>
						<input name="page" type="hidden" value="<?=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']?>"/>
					</fieldset>
					<div><em>From:</em> <?=$clean_post['name']?> &lt;<?=$clean_post['email']?>&gt;</div>
					<div><em>Subject:</em> <?=$clean_post['subject']?></div>
					<div class="contactbody"><?=$clean_post['body']?></div>
					<fieldset class="buttons"><input id="edit" name="edit" type="submit" value="Edit"/><input id="submit" name="submit" type="submit" value="Submit"/></fieldset>
				</form>
				
				<?php }else{ ?>
				<form method="post">
					<fieldset>
						<div class="row"><label for="name">Name:</label><input id="name" name="name" type="text" value="<?=$clean_post['name']?>" /></div>
						<div class="row"><label for="email">Email:</label><input id="email" name="email" type="text" value="<?=$clean_post['email']?>" /></div>
						<div class="row"><label for="subject">Subject:</label><input id="subject" name="subject" type="text" value="<?=$clean_post['subject']?>" /></div>
						<div class="row"><label for="body">Body:</label><textarea id="body" name="body" rows="4" cols="35"><?=$clean_post['body']?></textarea></div>
						<?php if(isset($clean_post['human'])){?>
							<input type="hidden" name="human" value="<?=$clean_post['human']?>" />
							<input type="hidden" name="nonce" value="<?=$clean_post['nonce']?>" />
						<?php }else{ ?>
							<div class="row"><label for="human"><?=$x?> + <?=$y?> = </label><input id="human" name="human" type="text" /></div>
							<input type="hidden" name="nonce" value="<?=$nonce?>"/>
						<?php } ?>
					</fieldset>
					<fieldset class="buttons"><input id="preview" name="preview" type="submit" value="Preview"/><input id="page" name="page" type="hidden" value="<?=$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']?>"/></fieldset>
				</form>
				<?php } ?>
			</div><!-- rightcolumn -->
<div id="footer"><?=$_footer?></div><!-- footer -->
</div><!-- content -->
</div><!-- container -->
<?=$_analytics?>
</body>
</html>
