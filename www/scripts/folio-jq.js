/*
php-include jquery-1.2.1.pack.js
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
		$("#alternate a").click(folio.alternate);
		$("#projects a[title^='select']").click(folio.change);
	},
	alternate : function(event){
		event.preventDefault();
		if(folio.processing) return;
		folio.url = this.href;
		$("#portfolio > img").unbind('load',folio.loading);
		if ((typeof fnotes != "undefined") && (typeof fnotes != null))
			fnotes.clear();
		folio.ajax = $.ajax({
			type: "GET",
            url: folio.url,
            dataType: folio.ajax_type,
            complete:folio.altcomplete,
            beforeSend:function(req){req.setRequestHeader('X-AJAX-Content-Type', folio.ajax_type);}});
		folio.processing = true;
	},
	change : function(event){
		event.preventDefault();
		if(folio.processing == true || folio.fader.timer != null) return;
		folio.url = this.href;
		if ((typeof fnotes != "undefined") && (typeof fnotes != null))
			fnotes.clear();
		folio.ajax = $.ajax({
			type: "GET",
            url: folio.url,
            dataType: folio.ajax_type,
            complete: folio.complete,
            beforeSend: function(req){
                req.setRequestHeader('X-AJAX-Content-Type', folio.ajax_type);
                folio.loading();}});
		folio.processing = true;
	},
	loading : function(){
		folio.fader.toggle();
	},
	altcomplete : function(req){
		if(req && req.status){
			if(req.status != 200) window.location = folio.url;
            // XML response
            var xml = $(req.responseXML);
            $('#portfolio > img')
                .unbind('load',folio.loading)
                .attr('src',$("big_src",xml).text())
                .attr('alt',$("big_alt",xml).text());
            // TODO - JSON response
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
			if(folio.req.responseXML) folio.xmlResponse();
			else folio.jsonResponse();
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
		var xml = $(folio.req.responseXML);
        $('#portfolio > img')
            .attr('src',$('big_src',xml).text())
            .attr('alt',$('big_alt',xml).text())
            .attr('title',$('big_title',xml).text())
            .load(folio.loading);

        $('#alternate a').each(function(i){
            $('img',this).remove().clone()
                .attr('src',$('small src',xml).eq(i).text())
                .attr('alt',$('small alt',xml).eq(i).text())
                .attr('title',$('small title',xml).eq(i).text())
                .appendTo(this);
            $(this).attr('href',$('small href',xml).eq(i.text()));
            folio.alternates.push($('small src',xml).eq(i).text());
        });

        /********** Progress **********/
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
