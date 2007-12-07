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
moo.fx pack, effects extensions for moo.fx.
by Valerio Proietti (http://mad4milk.net) MIT-style LICENSE
for more info visit (http://moofx.mad4milk.net).
Tuesday, March 07, 2006
v 1.2.3
*/

fx.Scroll=Class.create();fx.Scroll.prototype=Object.extend(new fx.Base(),{initialize:function(options){this.setOptions(options);},scrollTo:function(el){var dest=Position.cumulativeOffset($(el))[1];var client=window.innerHeight||document.documentElement.clientHeight;var full=document.documentElement.scrollHeight;var top=window.pageYOffset||document.body.scrollTop||document.documentElement.scrollTop;if(dest+client>full)this.custom(top,dest-client+(full-dest));else this.custom(top,dest);},increase:function(){window.scrollTo(0,this.now);}});fx.Text=Class.create();fx.Text.prototype=Object.extend(new fx.Base(),{initialize:function(el,options){this.el=$(el);this.setOptions(options);if(!this.options.unit)this.options.unit="em";},increase:function(){this.el.style.fontSize=this.now+this.options.unit;}});fx.Combo=Class.create();fx.Combo.prototype={setOptions:function(options){this.options={opacity:true,height:true,width:false}
Object.extend(this.options,options||{});},initialize:function(el,options){this.el=$(el);this.setOptions(options);if(this.options.opacity){this.o=new fx.Opacity(el,options);options.onComplete=null;}
if(this.options.height){this.h=new fx.Height(el,options);options.onComplete=null;}
if(this.options.width)this.w=new fx.Width(el,options);},toggle:function(){this.checkExec('toggle');},hide:function(){this.checkExec('hide');},clearTimer:function(){this.checkExec('clearTimer');},checkExec:function(func){if(this.o)this.o[func]();if(this.h)this.h[func]();if(this.w)this.w[func]();},resizeTo:function(hto,wto){if(this.h&&this.w){this.h.custom(this.el.offsetHeight,this.el.offsetHeight+hto);this.w.custom(this.el.offsetWidth,this.el.offsetWidth+wto);}},customSize:function(hto,wto){if(this.h&&this.w){this.h.custom(this.el.offsetHeight,hto);this.w.custom(this.el.offsetWidth,wto);}}}
fx.Accordion=Class.create();fx.Accordion.prototype={setOptions:function(options){this.options={delay:100,opacity:false}
Object.extend(this.options,options||{});},initialize:function(togglers,elements,options){this.elements=elements;this.setOptions(options);var options=options||'';elements.each(function(el,i){options.onComplete=function(){if(el.offsetHeight>0)el.style.height='1%';}
el.fx=new fx.Combo(el,options);el.fx.hide();});togglers.each(function(tog,i){tog.onclick=function(){this.showThisHideOpen(elements[i]);}.bind(this);}.bind(this));},showThisHideOpen:function(toShow){this.elements.each(function(el,i){if(el.offsetHeight>0&&el!=toShow)this.clearAndToggle(el);}.bind(this));if(toShow.offsetHeight==0)setTimeout(function(){this.clearAndToggle(toShow);}.bind(this),this.options.delay);},clearAndToggle:function(el){el.fx.clearTimer();el.fx.toggle();}}
var Remember=new Object();Remember=function(){};Remember.prototype={initialize:function(el,options){this.el=$(el);this.days=365;this.options=options;this.effect();var cookie=this.readCookie();if(cookie){this.fx.now=cookie;this.fx.increase();}},setCookie:function(value){var date=new Date();date.setTime(date.getTime()+(this.days*24*60*60*1000));var expires="; expires="+date.toGMTString();document.cookie=this.el+this.el.id+this.prefix+"="+value+expires+"; path=/";},readCookie:function(){var nameEQ=this.el+this.el.id+this.prefix+"=";var ca=document.cookie.split(';');for(var i=0;c=ca[i];i++){while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(nameEQ)==0)return c.substring(nameEQ.length,c.length);}
return false;},custom:function(from,to){if(this.fx.now!=to){this.setCookie(to);this.fx.custom(from,to);}}}
fx.RememberHeight=Class.create();fx.RememberHeight.prototype=Object.extend(new Remember(),{effect:function(){this.fx=new fx.Height(this.el,this.options);this.prefix='height';},toggle:function(){if(this.el.offsetHeight==0)this.setCookie(this.el.scrollHeight);else this.setCookie(0);this.fx.toggle();},resize:function(to){this.setCookie(this.el.offsetHeight+to);this.fx.custom(this.el.offsetHeight,this.el.offsetHeight+to);},hide:function(){if(!this.readCookie()){this.fx.hide();}}});fx.RememberText=Class.create();fx.RememberText.prototype=Object.extend(new Remember(),{effect:function(){this.fx=new fx.Text(this.el,this.options);this.prefix='text';}});Array.prototype.each=function(func){for(var i=0;ob=this[i];i++)func(ob,i);}
fx.expoIn=function(pos){return Math.pow(2,10*(pos-1));}
fx.expoOut=function(pos){return(-Math.pow(2,-10*pos)+1);}
fx.quadIn=function(pos){return Math.pow(pos,2);}
fx.quadOut=function(pos){return-(pos)*(pos-2);}
fx.circOut=function(pos){return Math.sqrt(1-Math.pow(pos-1,2));}
fx.circIn=function(pos){return-(Math.sqrt(1-Math.pow(pos,2))-1);}
fx.backIn=function(pos){return(pos)*pos*((2.7)*pos-1.7);}
fx.backOut=function(pos){return((pos-1)*(pos-1)*((2.7)*(pos-1)+1.7)+1);}
fx.sineOut=function(pos){return Math.sin(pos*(Math.PI/2));}
fx.sineIn=function(pos){return-Math.cos(pos*(Math.PI/2))+1;}
fx.sineInOut=function(pos){return-(Math.cos(Math.PI*pos)-1)/2;}