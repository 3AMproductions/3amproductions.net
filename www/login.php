<?php
//TODO: include this login on homepage
require_once('config.inc');
session_start();
if($_REQUEST['logout']){
	$redirect = is_null($_SESSION['redirect']) ? "http://3amproductions.net/" : $_SESSION['redirect'];
	$_SESSION['auth'] = false;
	$_SESSION['client_auth'] = false;
	if (isset($_COOKIE[session_name()]))
		setcookie(session_name(), '', time()-42000, '/');
	session_destroy();
	header("Location: ".$redirect);
	exit;
}
if($_POST['login']){
	if(!empty($_POST['openid'])){
		require_once('class.openid.php');
		$OpenID = new OpenID($_POST['openid']);

		if ($OpenID->begin()) {
			$OpenID->addExtensionArg('sreg', 'optional', 'email');
			header("Location: ".$OpenID->redirect_url(trim($_SERVER['PHP_SELF'])));
		}
		else {
			$openid_err = "OpenId Authentication error. Invalid URL.";
		}
	}
	else {
		require_once 'Zend/Db.php';
		$params = array ('host'=>'db.3amproductions.net','username'=>'client','password'=>'client','dbname'=>'clients');
		$db = Zend_Db::factory('PDO_MYSQL', $params);
		if(!$db){
			require_once('Zend/Mail.php');
			$mail = new Zend_Mail();
			$mail->setFrom($_POST['3am@3amproductions.net'], $_POST['3AM Client Page']);
			$mail->addTo('3am@3amproductions.net', '3AM Productions');
			$mail->setSubject('Error at 3AM Client Page');
			$mail->setBodyText('Error connecting to clients db. Session Data:'.print_r($_SESSION));
			$mail->send();
			die ("ERROR: Can't connect to database.");
		}
		require_once 'Zend/Db/Table.php';
		Zend_Db_Table::setDefaultAdapter($db);
		
		class Clients extends Zend_Db_Table {protected $_primary = 'username';}
		$table = new Clients();
	
		try{
			//$row = $table->find($db->quote($_POST['user']));
			$where = $db->quoteInto('username = ?', $_POST['user']);
			$row = $table->fetchRow($where);
			if($row->username == "")
				throw new Exception("Invalid Username");
			if($row->password != md5($_POST['pass']))
				throw new Exception("Incorrect Password");

			$_SESSION['name'] = $row->name;
			$_SESSION['email'] = $row->email;
			$_SESSION['subdomain'] = $row->subdomain;
			$_SESSION['client_auth'] = true;
			
			$redirect = empty($_SESSION['redirect']) ? "http://3amproductions.net/client" : $_SESSION['redirect'];
			header("Location: ".$redirect);
			exit;
		}
		catch(Zend_Db_Table_Row_Exception $e){
			$login_err = $e->getMessage();
		}
		catch(Exception $e){
			$login_err = $e->getMessage();
		}
	}
}
if(!empty($_GET['openid_mode'])){
	require_once('class.openid.php');
	$OpenID = new OpenID();
	$OpenID->complete();

	if ($OpenID->cancelled) {
		$openid_err = 'OpenId authentication cancelled.';
	} else if ($OpenID->failed) {
    	$openid_err = 'OpenId authentication failed: ' . $OpenID->response->message;
	} else if ($OpenID->success) {
	    $openid = htmlspecialchars($OpenID->response->identity_url, ENT_QUOTES);
		$_SESSION['name'] = $openid; 
		$_SESSION['openid_url'] = $openid;
	    if ($OpenID->response->endpoint->canonicalID) $_SESSION['openid_xri'] = $OpenID->response->endpoint->canonicalID;

	    $sreg = $OpenID->response->extensionResponse('sreg');
	    if (!empty($sreg['email'])) $_SESSION['email'] = $sreg['email'];
	    if (!empty($sreg['postcode'])) $_SESSION[''] = $sreg['postcode'];

		$whitelist = array('http://jason.karns.name/','http://renegadelatino.com/','http://3amproductions.net/');
		if(!in_array($openid,$whitelist)){
			$openid_err = "OpenId authorization error: Your OpenId is not authorized for 3AM access.";
		} else {
			$_SESSION['auth'] = true;
			$_SESSION['track'] = false;
			$_SERVER['PHP_AUTH_USER'] = "pimp3am";
			$_SERVER['PHP_AUTH_PW'] = "money";
            $redirect = empty($_SESSION['redirect']) ? "http://3amproductions.net" : $_SESSION['redirect'];
			header("Location: ".$redirect);
			exit;
		}
	}
}



$_META['base_title'] = '3AM Productions';
$_META['page_title'] = 'login';
$doc = new HTDoc($_META['lang'], $_META['charset'], $_META['org'], $_META['domain'], $_META['base_title'], $_META['author'], $_META['page_title'], $_META['description'], $_META['keywords'], $_META['category'], $_META['title_separator']);
$doc->doctype();
$doc->add_profile(array('grddl','hcard','rel-license','rel-tag','3am-xmdp'));
$doc->add_meta(array('main','dc','dmoz','geo','tgn','icbm','icra','foaf','cc','xmdp','nav','favicon','rss','atom','grddl','sitemap'));
$doc->add_style('/styles/main.css','screen,projection');
$doc->add_style('/styles/print.css','print');
$doc->add_style('/styles/handheld.css','handheld');
$doc->head();
?>
<body>
<p>Redirecting to: <?=$_SESSION['redirect']?></p>
<form action="<?=trim($_SERVER['PHP_SELF'],"/")?>" method="post">
	<fieldset>
		<p class="error"><?=$login_err?></p>
		<div class="row"><label for="user">Username:</label><input id="user" name="user" type="text" value="<?=$clean_post['user']?>"/></div>
		<div class="row"><label for="pass">Password:</label><input id="pass" name="pass" type="password" value="<?=$clean_post['pass']?>"/></div>
	</fieldset>
	<p>OR:</p>
	<fieldset>
		<p class="error"><?=$openid_err?></p>
		<div class="row"><label for="openid">OpenID:</label><input id="openid" name="openid" class="openid" type="text" value="<?=$clean_post['openid']?>"/></div>
	</fieldset>
	<fieldset class="buttons"><input id="login" name="login" type="submit" value="Login"/></fieldset>
</form>
</body>
</html>
