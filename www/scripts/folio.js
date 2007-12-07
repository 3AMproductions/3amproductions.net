/*
php-include lib.dom.js
php-include lib.cssQuery.js.php
php-include lib.prototype.js.php
php-include lib.moofx.js.php
// json needed if not using AJAX-XML (JSON is easier, but XML is smaller)
php-include lib.json.js.php
*/

var folio = {
	folio : this,
	url : '',
	ajax_type : 'xml',//'json' or 'xml'
	err : false,
	processing : false,
	alternates : new Array(),
	req : {},
	ajax : {},
	fader : {},
	init : function(){
		folio.fader = new fx.Opacity('portfolio',{duration:1500,onComplete:folio.complete});
		var alts = cssQuery("#alternate a");
		alts.each(function(link){Event.observe(link, 'click', folio.alternate.bindAsEventListener(link));});
		var links = cssQuery("#projects a[title^='select']");
		links.each(function(link){Event.observe(link, 'click', folio.change.bindAsEventListener(link));});
	},
	alternate : function(e){
		Event.stop(e);
		if(folio.processing) return;
		folio.url = this.href;
		var pars = '';
		var img = cssQuery("#portfolio > img")[0];
		Event.stopObserving(img,'load',folio.loading);
		if ((typeof fnotes != "undefined") && (typeof fnotes != null))
			fnotes.clear();
		folio.ajax = new Ajax.Request(folio.url,{requestHeaders: ['X-AJAX-Content-Type', 'xml'], response: 'xml', method: 'post', parameters: pars, onComplete: folio.altcomplete});
		folio.processing = true;
	},
	change : function(e){
		Event.stop(e);
		if(folio.processing == true || folio.fader.timer != null) return;
		folio.url = this.href;
		var pars = '';
		if ((typeof fnotes != "undefined") && (typeof fnotes != null))
			fnotes.clear();
		folio.ajax = new Ajax.Request(folio.url,{requestHeaders: ['X-AJAX-Content-Type', folio.ajax_type], response: folio.ajax_type, method: 'post', parameters: pars, onLoading: folio.loading, onComplete: folio.complete});
		folio.processing = true;
	},
	loading : function(){
		folio.fader.toggle();
	},
	altcomplete : function(req){
		if(req && req.status){
			if(req.status != 200) window.location = folio.url;
			var xml = req.responseXML.getElementsByTagName('portfolio')[0];
			var img = cssQuery("#portfolio > img")[0];
			Event.stopObserving(img,'load',folio.loading);
			img.setAttribute('src', getNodeValue(xml,'big_src') || '');
			img.setAttribute('alt', getNodeValue(xml,'big_alt') || '');
			req = null;
			folio.processing = false;
		}
	},
	complete : function(req){
		if(req && req.status){
			folio.req = req;
			req = null;
		}
		if(folio.req && folio.req.status && folio.fader.timer == null){
			if(folio.req.status != 200) window.location = folio.url;
			//folio.ajax.options.response
			if(folio.ajax.header("X-AJAX-Content-Type") == "json") folio.jsonResponse();
			else if(folio.ajax.header("X-AJAX-Content-Type") == "xml") folio.xmlResponse();
			folio.req = null;
		}
	},
	jsonResponse : function(){
		var j = JSON.parse(folio.req.responseText);
		var img = cssQuery("#portfolio > img")[0]; 
		img.setAttribute('src', j.portfolio.big.src);
		img.setAttribute('alt', j.portfolio.big.alt);
		img.setAttribute('title', j.portfolio.big.title);
		Event.observe(img,'load',folio.loading);

		var imgs = cssQuery("#alternate img");
		var anchors = cssQuery("#alternate a");
		for(var i=0; i<anchors.length; i++){
			var new_img = imgs[i].cloneNode(false);
			new_img.setAttribute('src', j.portfolio.small[i].src);
			new_img.setAttribute('alt', j.portfolio.small[i].alt);
			new_img.setAttribute('title', j.portfolio.small[i].title);
			imgs[i].parentNode.replaceChild(new_img,imgs[i]);
			anchors[i].setAttribute('href', j.portfolio.small[i].href);
		}

		var a = cssQuery("#portfolio > a")[0];
		a.setAttribute('href',j.portfolio.url);
		a.setAttribute('rel','external');
		if(a.firstChild) a.firstChild.nodeValue = j.portfolio.url;
		else a.appendChild(document.createTextNode(j.portfolio.url)); 

		var a = cssQuery("#portfolio > p > a")[0];
		a.setAttribute('href',j.portfolio.url);
		a.setAttribute('rel','external');

		var p = cssQuery("#portfolio > p")[0];
		p.innerHTML = j.portfolio.text;
		if ((typeof fnotes != "undefined") && (typeof fnotes != null))
			fnotes.collect();
		folio.processing = false;
	},
	xmlResponse : function(){
		var xml = folio.req.responseXML.getElementsByTagName('portfolio')[0];
		var img = cssQuery("#portfolio > img")[0];
		img.setAttribute('src', getNodeValue(xml,'big_src') || '');
		img.setAttribute('alt', getNodeValue(xml,'big_alt') || '');
		img.setAttribute('title', getNodeValue(xml,'big_title') || '');
		Event.observe(img,'load',folio.loading);

		var imgs = cssQuery("#alternate img");
		var anchors = cssQuery("#alternate a");
		var smalls = xml.getElementsByTagName('small');
		for(var i=0; i<anchors.length; i++){
			var new_img = imgs[i].cloneNode(false);
			new_img.setAttribute('src', getNodeValue(smalls[i],'src') || '');
			folio.alternates.push(getNodeValue(smalls[i],'src') || '');
			new_img.setAttribute('alt', getNodeValue(smalls[i],'alt') || '');
			new_img.setAttribute('title', getNodeValue(smalls[i],'title') || '');
			imgs[i].parentNode.replaceChild(new_img,imgs[i]);
			anchors[i].setAttribute('href', getNodeValue(smalls[i],'href') || '');
		}

		var a = cssQuery("#portfolio > a")[0];
		a.setAttribute('href',getNodeValue(xml,'url'));
		a.setAttribute('rel','external');
		if(a.firstChild) a.firstChild.nodeValue = getNodeValue(xml,'url') || '';
		else a.appendChild(document.createTextNode(getNodeValue(xml,'url') || '')); 

		var a = cssQuery("#portfolio > p > a")[0];
		a.setAttribute('href',getNodeValue(xml,'url') || '');
		a.setAttribute('rel','external');

		var p = cssQuery("#portfolio > p")[0];
		while(p.firstChild) p.removeChild(p.firstChild);
		var t = xml.getElementsByTagName('text')[0];
		
		for(var i=0; i<t.childNodes.length; i++){
			var n = domdom.build(t.childNodes[i]);
			if(n != null) p.appendChild(n);
		}
		if ((typeof fnotes != "undefined") && (typeof fnotes != null))
			fnotes.collect();
		folio.processing = false;
	},
	error : function(){
		if(!folio.err) alert("error");
		folio.err = true;
	}
};
Event.observe(window, 'load', folio.init);