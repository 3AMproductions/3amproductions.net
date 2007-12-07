/* Following lines used to dynamically include dependent javascript files. Do not alter
php-include lib.prototype.js.php

// yahoo_event needed if using YAHOO Event lib, not if using Prototype's
//hp-include lib.yahoo_event.js.php
*/

var hidemail = {
  node : 'address',
  at : '[at]',
	dot : '[dot]',
	classname : 'email',
	activate : function(){
    if(!document.createElement) return;
    var emails = document.getElementsByClassName(hidemail.classname,hidemail.node);
		emails.each(function(email){
      if (email.firstChild.nodeValue)
      {
       	var adr = email.firstChild.nodeValue;
      	var title = email.getAttribute('title');
      	var clas = email.className;
      	adr = adr.replace(hidemail.at,"@").replace(hidemail.dot,".");
      	var text = document.createTextNode(adr);
      	var a = document.createElement('a');
      	a.appendChild(text);
      	a.setAttribute('rel', 'contact');
      	a.setAttribute('title', title);
      	a.setAttribute('href', "mailto:" + adr);
      	var parent = email.parentNode;
      	var address = document.createElement('address');
      	address.appendChild(a);
      	address.className = clas;
      	parent.replaceChild(address,email);
			}
		});
    return;
	}
};

//YAHOO.util.Event.addListener(window,'load',hidemail.activate);
Event.observe(window,'load',hidemail.activate);