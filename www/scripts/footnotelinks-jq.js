/* Following lines used to dynamically include dependent javascript files. Do not alter
php-include jquery-1.2.1.pack.js
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

Ported to JQuery by Jason Karns
------------------------------------------------------------------------------*/
var fnotes = {
    containerID : 'content',// ID of element to collect links from
    targetID : 'footer',//ID of element to add footnotes to
    footnotesID : 'footnotes',//ID of element to create for footnotes
    flag_class : 'footnote-flag',//class to give footnote flags (<sup>)
    flag_element : 'sup',
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
        if (!$(fnotes.containerID).length || !$(fnotes.targetID).length)
            return false;

        // get links
        var coll = $("#" + fnotes.containerID + " a");
        // remove those with ignore_class
        for(var i=0;i<fnotes.ignore_class.length;i++)
            coll = coll.not("."+fnotes.ignore_class[i]);
        // remove internal links?
        if(!fnotes.footnote_internals) coll = coll.filter("[@rel*=external]");
        // remove links without href
        coll = coll.filter(function(i){return ($(this).attr("href"));});

        // get cites
        if(fnotes.footnote_cites){
            var cites = $("#" + fnotes.containerID + " q, #" + fnotes.containerID + " blockquote")
            // remove those with ignore_class
            for(var i=0;i<fnotes.ignore_class.length;i++)
                cites = cites.not("."+fnotes.ignore_class[i]);
            // remove cites without @cite
            cites = cites.filter(function(i){return ($(this).attr("cite"));});
            // add cites to collection
            coll = coll.add(cites);
        }

        var ol = $('<ol/>').attr('class',fnotes.flag_class);
        var myArr = [];
        var thisLink;
        var num = 0;

        coll.each(function(i){
	        thisLink = $(this).attr("href") || $(this).attr("cite");

	        //trim base url
	        for (var k = 0; k < fnotes.base_url.length; k++) {
                var regex = new RegExp("^" + fnotes.base_url[k].toLowerCase());
                thisLink = thisLink.toLowerCase().replace(regex, '');
            }

            var note = $("<"+fnotes.flag_element+"/>").attr("class",fnotes.flag_class);
	        var note_txt;

	        // don't add duplicates to footnotes section
	        var j = fnotes.indexOf(myArr, thisLink);
			if (j < 0 ) {
                ol.append('<li>' + thisLink + '</li>');
                myArr.push(thisLink);
                note_txt = ++num;}
	        else {
	            note_txt = j+1;}

	        note.text(note_txt);
	        fnotes.notes.push(note);

			if (coll[i].tagName.toLowerCase() == 'blockquote') {
				var lastChild = fnotes.lastChildContainingText(coll[i]);
				lastChild.appendChild(note);}
			else {
				coll[i].parentNode.insertBefore(note, coll[i].nextSibling);}
		});

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
    indexOf : function(array, item, i) {
        i || (i = 0);
        var length = array.length;
        if (i < 0) i = length + i;
        for (; i < length; i++)
	        if (array[i] === item) return i;
          return -1;
    }
}
Event.observe(window, 'load', fnotes.collect);
