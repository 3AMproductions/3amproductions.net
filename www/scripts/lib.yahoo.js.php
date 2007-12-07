<?php
ob_start ('ob_gzhandler');
header('Content-type: text/javascript; charset: UTF-8');
header('Cache-Control: must-revalidate');
$offset = 60 * 60 * 24 * 30;
$ExpStr = "Expires: " .
gmdate('D, d M Y H:i:s',
time() + $offset) . ' GMT';
header($ExpStr);
?>

/*
Copyright (c) 2006 Yahoo! Inc. All rights reserved.
version 0.9.0

Minimized by JSMin http://www.crockford.com/javascript/jsmin.html
*/

var YAHOO=function(){return{util:{},widget:{},example:{},namespace:function(sNameSpace){if(!sNameSpace||!sNameSpace.length){return null;}
var levels=sNameSpace.split(".");var currentNS=YAHOO;for(var i=(levels[0]=="YAHOO")?1:0;i<levels.length;++i){currentNS[levels[i]]=currentNS[levels[i]]||{};currentNS=currentNS[levels[i]];}
return currentNS;}};}();