/* Following lines used to dynamically include dependent javascript files. Do not alter
php-include lib.prototype.js.php
php-include lib.dom.js
*/
/*------------------------------------------------------------------------------
Function:       footnoteLinks()
Author:         Aaron Gustafson (aaron at easy-designs dot net)
Creation Date:  8 May 2005
Version:        1.3
Homepage:       http://www.easy-designs.net/code/footnoteLinks/
License:        Creative Commons Attribution-ShareAlike 2.0 License
                http://creativecommons.org/licenses/by-sa/2.0/
Note:           If you change or improve on this script, please let us know by 
                emailing the author (above) with a link to your demo page.
------------------------------------------------------------------------------*/
var fnotes = {
	containerID : 'content',// ID of element to collect links from
	targetID : 'footer',//ID of element to add footnotes to
	footnotesID : 'footnotes',//ID of element to create for footnotes
	flag_class : 'footnote-flag',//class to give footnote flags (<sup>)
	flag_element : 'sup',
//	ignore_class : 'nocite',//class of links to ignore
	ignore_class : ['nocite','include'],//class of links to ignore
	footnoted_class : 'footnoted',//class to give html element when done
	header : 'h2',//element to use as footnotes header
	footnote_cites : true,//should cite blockquote's and q's with @cite?
	footnote_internals : true,//should footnote internal links? (links without rel=external)
	base_url : ["http://3amproductions.net"],// array of base url(s) to strip out of links
	notes : [],
	collect : function() {
		// check for compatibility and for expected container and target
		if (!document.getElementById || !document.getElementsByTagName || !document.createElement)
			return false;
		if (!$(fnotes.containerID) || !$(fnotes.targetID))
			return false;
		var container = $(fnotes.containerID);
		var target = $(fnotes.targetID);
		// create collection of possible elements to footnote
		var coll = $A(container.getElementsByTagName('a'));
		if(fnotes.footnote_cites){
			coll = $A(coll.concat($A(container.getElementsByTagName('q'))));
			coll = $A(coll.concat($A(container.getElementsByTagName('blockquote'))));}
		var ol = document.createElement('ol');
		ol.className = fnotes.flag_class;
		var myArr = [];
		var thisLink;
		var num = 0;
		for (var i=0; i<coll.length; i++) {
			var thisClass = coll[i].className;
			// skip element if no @href/@cite, or if internal link
			if ((coll[i].getAttribute('href') || coll[i].getAttribute('cite')) && 
//				(thisClass == '' || thisClass.indexOf(fnotes.ignore_class) == -1))
				(thisClass == '' || fnotes.noIgnoreClass(thisClass)))
			{
				if((fnotes.footnote_internals == false) && (coll[i].nodeName.toLowerCase() == 'a'))
					if(!coll[i].getAttribute('rel') || coll[i].getAttribute('rel').indexOf('external') < 0)
						continue;
				thisLink = coll[i].getAttribute('href') ? coll[i].href : coll[i].cite;
				for(var k=0; k<fnotes.base_url.length; k++){
					if(thisLink.toLowerCase().indexOf(fnotes.base_url[k].toLowerCase()) == 0){
						var t = thisLink.substring(fnotes.base_url[k].length);
						if(t.length > 1) thisLink = t;
						break;}}
				var note = document.createElement(fnotes.flag_element);
				note.className = fnotes.flag_class;
				var note_txt;
				// don't add duplicates to footnotes section
				var j = $A(myArr).indexOf(thisLink);
				if (j < 0 ) {
					var li = document.createElement('li');
					var li_txt = document.createTextNode(thisLink);
					li.appendChild(li_txt);
					ol.appendChild(li);
					myArr.push(thisLink);
					num++;
					note_txt = document.createTextNode(num);}
				else {
					note_txt = document.createTextNode(j+1);}
				note.appendChild(note_txt);
				fnotes.notes.push(note);
				if (coll[i].tagName.toLowerCase() == 'blockquote') {
					var lastChild = fnotes.lastChildContainingText(coll[i]);
					lastChild.appendChild(note);}
				else {
					coll[i].parentNode.insertBefore(note, coll[i].nextSibling);}
			}
		}
		// only add footnote section if there are footnotes
		if(num > 0) {
			if($(fnotes.footnotesID))
				$(fnotes.footnotesID).parentNode.removeChild($(fnotes.footnotesID));
			var f = document.createElement('div');
			f.setAttribute('id',fnotes.footnotesID);
			var h = document.createElement(fnotes.header);
			h.className = fnotes.flag_class;
			h.appendChild(document.createTextNode('Links'));
			f.appendChild(h);
			f.appendChild(ol);
			target.appendChild(f);
			if(fnotes.footnoted_class != '')
				$(document.getElementsByTagName('html')[0]).addClassName(fnotes.footnoted_class);}
		return true;
	},
	clear : function(){
		for (var i=0; i<fnotes.notes.length; i++) {
			$(fnotes.notes[i]).parentNode.removeChild($(fnotes.notes[i]));}
		fnotes.notes.clear();
	},
	lastChildContainingText : function(n) {
		var testChild = n.lastChild;
		var contentCntnr = ['p','li','dd'];
		while (testChild.nodeType != 1) {
			testChild = testChild.previousSibling;} 
		var tag = testChild.tagName.toLowerCase();
		var tagInArr = $A(contentCntnr).indexOf(tag);
		if (tagInArr < 0) {
			testChild = fnotes.lastChildContainingText(testChild);}
		return testChild;
	},
	noIgnoreClass : function(theClass) {
		var hasClass = false;
		$A(fnotes.ignore_class).each(function(el, i){
			if(theClass.indexOf(el) != -1)
				hasClass = true;
		});
		return !hasClass;
	}
}
Event.observe(window, 'load', fnotes.collect);