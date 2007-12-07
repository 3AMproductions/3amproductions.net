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
// EventSelectors 
// Copyright (c) 2005-2006 Justin Palmer (http://encytemedia.com)
// Examples and documentation (http://encytemedia.com/event-selectors)
// 
/* ------------------------------------------------------------ */

var EventSelectors={version:'1.0_pre',cache:[],start:function(rules){this.rules=rules||{};this.timer=new Array();this._extendRules();this.assign(this.rules);},assign:function(rules){var observer=null;this._unloadCache();rules._each(function(rule){var selectors=$A(rule.key.split(','));selectors.each(function(selector){var pair=selector.split(':');var event=pair[1];$$(pair[0]).each(function(element){if(pair[1]==''||pair.length==1)return rule.value(element);if(event.toLowerCase()=='loaded'){this.timer[pair[0]]=setInterval(this._checkLoaded.bind(this,element,pair[0],rule),15);}else{observer=function(event){var element=Event.element(event);if(element.nodeType==3)
element=element.parentNode;rule.value($(element),event);}
this.cache.push([element,event,observer]);Event.observe(element,event,observer);}}.bind(this));}.bind(this));}.bind(this));},_unloadCache:function(){if(!this.cache)return;for(var i=0;i<this.cache.length;i++){Event.stopObserving.apply(this,this.cache[i]);this.cache[i][0]=null;}
this.cache=[];},_checkLoaded:function(element,timer,rule){var node=$(element);if(element.tagName!='undefined'){clearInterval(this.timer[timer]);rule.value(node);}},_extendRules:function(){Object.extend(this.rules,{_each:function(iterator){for(key in this){if(key=='_each')continue;var value=this[key];var pair=[key,value];pair.key=key;pair.value=value;iterator(pair);}}});}}
