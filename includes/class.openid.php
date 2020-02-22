<?php

define("Auth_OpenID_NO_MATH_SUPPORT",true);
$path_extra = dirname(dirname(dirname(__FILE__)));
$path = ini_get('include_path');
$path = $path_extra . ':' . $path;
ini_set('include_path', $path);
/**
 * Require the OpenID consumer code.
 */
require_once "Auth/OpenID/Consumer.php";

/**
 * Require the "file store" module, which we'll need to store OpenID
 * information.
 */
require_once "Auth/OpenID/FileStore.php";

class OpenID{
	var $store_path, $consumer, $store, $openid, $auth_request, $response;
	
	var $cancelled, $success, $failed;
	
	function __construct($openid = null){
		/**
		 * This is where the example will store its OpenID information.  You
		 * should change this path if you want the example store to be created
		 * elsewhere.  After you're done playing with the example script,
		 * you'll have to remove this directory manually.
		 */
		$this->store_path = "/tmp/_php_consumer_test";
		if (!file_exists($this->store_path) &&
		    !mkdir($this->store_path)) {
		    print "Could not create the FileStore directory '$store_path'. ".
		        " Please check the effective permissions.";
		    exit(0);
		}
	
		$this->store = new Auth_OpenID_FileStore($this->store_path);
		
		/**
		 * Create a consumer object using the store object created earlier.
		 */
		$this->consumer = new Auth_OpenID_Consumer($this->store);
		
		$this->openid = $openid;
		$this->cancelled = null;
		$this->success = null;
		$this->failed = null;
	}
	
	function begin(){
		// Begin the OpenID authentication process.
		$this->auth_request = $this->consumer->begin($this->openid);
		return $this->auth_request;
	}

	function addExtensionArg($arg1, $arg2, $arg3){
		$this->auth_request->addExtensionArg($arg1, $arg2, $arg3);
	}
	
	function redirect_url($finish_url){
		$scheme = 'http';
		if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
		    $scheme .= 's';
		}
		$process_url = sprintf("$scheme://%s:%s%s/%s",
						$_SERVER['SERVER_NAME'],
						$_SERVER['SERVER_PORT'],
						dirname($_SERVER['PHP_SELF']),
						$finish_url);

		$trust_root = sprintf("$scheme://%s:%s%s",
						$_SERVER['SERVER_NAME'],
						$_SERVER['SERVER_PORT'],
						dirname($_SERVER['PHP_SELF']));

		// Redirect the user to the OpenID server for authentication.  Store
		// the token for this authentication so we can verify the response.
		return $this->auth_request->redirectURL($trust_root, $process_url);
	}
	
	function complete(){
		$this->response = $this->consumer->complete($_GET);
		
		$this->cancelled = ($this->response->status == Auth_OpenID_CANCEL);
		$this->failed = ($this->response->status == Auth_OpenID_FAILURE);
		$this->success = ($this->response->status == Auth_OpenID_SUCCESS);
	}
}

?>