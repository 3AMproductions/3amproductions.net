/* Following lines used to dynamically include dependent javascript files. Do not alter
php-include jquery-1.2.1.pack.js
php-include showdown.pak.js
*/

var twix = {
	debug : false,
	html_ns : "http://www.w3.org/1999/xhtml",
	twix_ns : "http://3amproductions.net/xml/ns/twix/",
	current_project : "",
	createPortfolio : function(context){
		var xml = document.createDocumentFragment();
		var portfolio = document.createElementNS(twix.twix_ns, "portfolio");
		portfolio.setAttribute("xmlns:xhtml",twix.html_ns);
		var project = null;
		$("div.project", context).each(function(i){
			project = twix.createProject(this, true);
			portfolio.appendChild(project);
		});
		xml.appendChild(portfolio);
		return xml;
	},
	createProject : function(context, noFragment){
		var xml, att, project, el, el2, text;
		twix.current_project = $("input[@name=id]", context).val();
		
		project = document.createElementNS(twix.twix_ns, "project");
		if(twix.debug) console.debug("<project>");
		if(att = twix.createAttribute(context, "id")) project.setAttributeNode(att);
		if(att = twix.createAttribute(context, "class")) project.setAttributeNode(att);
		if(att = twix.createAttribute(context, "status")) project.setAttributeNode(att);
		if(att = twix.createAttribute(context, "manager", true)) project.setAttributeNode(att);
		
		if(el = twix.createNode(context, "started")) project.appendChild(el);
		if(el = twix.createNode(context, "modified")) project.appendChild(el);
		if(el = twix.createNode(context, "launched", true)) project.appendChild(el);
		if(el = twix.createNode(context, "organization")){
			if(att = twix.createAttribute(context, "abbr", true)) el.setAttributeNode(att);
			project.appendChild(el);
		}
		if(el = twix.createContacts(context)) project.appendChild(el);
		if(el = twix.createNode(context, "directory", true)) project.appendChild(el);
		if(el = twix.createNode(context, "subdomain", true)) project.appendChild(el);
		if(el = twix.createNode(context, "livesite", true)) project.appendChild(el);
		if(el = twix.createNotes(context)) project.appendChild(el);
		if(el = twix.createShowcase(context)) project.appendChild(el);

//		if(twix.error.flag)
//			return null;
		if(noFragment)
			return project;
		else {
			xml = document.createDocumentFragment();
			xml.appendChild(project);
			return xml;
		}
	},
	createContacts : function(context){
		var cts = $("fieldset.contact", context);
		var contacts = (cts.length > 0) ? document.createElementNS(twix.twix_ns, "contacts") : null;
		if(twix.debug) console.debug("<contacts>");
		cts.each(function(i){
			var contact = document.createElementNS(twix.twix_ns, "contact");
			if(el = twix.createNode(this, "name")) contact.appendChild(el);
			if(el = twix.createNode(this, "jobtitle", true)) contact.appendChild(el);
			if(el = twix.createNode(this, "role", true)) contact.appendChild(el);
			var emails = $("fieldset.email", this);
			emails.each(function(i){
				if(el = twix.createNode(this, "email")){
					if(att = twix.createAttribute(this, "type")) el.setAttributeNode(att);
					contact.appendChild(el);
				}
			});
			var phones = $("fieldset.phone", this);
			phones.each(function(i){
				if(el = twix.createNode(this, "phone")){
					if(att = twix.createAttribute(this, "type")) el.setAttributeNode(att);
					contact.appendChild(el);
				}
			});
			var addresses = $("fieldset.address", this);
			if(twix.debug) console.debug("Adrs length: ", addresses.length);
			addresses.each(function(i){
				if(el = twix.createNode(this, "address")){
					if(att = twix.createAttribute(this, "type")) el.setAttributeNode(att);
					if(el2 = twix.createNode(this, "street1", true)) el.appendChild(el2);
					if(el2 = twix.createNode(this, "street2", true)) el.appendChild(el2);
					if(el2 = twix.createNode(this, "city", true)) el.appendChild(el2);
					if(el2 = twix.createNode(this, "state", true)){
						if(att = twix.createAttribute(this, "abbr")) el2.setAttributeNode(att);
						el.appendChild(el2);
					}
					if(el2 = twix.createNode(context, "zip", true)) el.appendChild(el2);
					contact.appendChild(el);
				}
			});
			contacts.appendChild(contact);
		});
		return contacts;
	},
	createNotes : function(context){
		var nts = $("fieldset.note", context);
		var notes = (nts.length > 0) ? document.createElementNS(twix.twix_ns, "notes") : null;
		if(twix.debug) console.debug("<notes>");
		nts.each(function(i){
			var note = document.createElementNS(twix.twix_ns, "note");
			if(att = twix.createAttribute(this, "by")) note.setAttributeNode(att);
			if(att = twix.createAttribute(this, "modified")) note.setAttributeNode(att);
			if(el = twix.createNode(this, "note")) note.appendChild(el);
		});
		return notes;
	},
	createShowcase : function(context){
		var shcs = $("fieldset.showcase", context);
		if(twix.debug) console.debug("<showcase>");
		if(shcs.length > 0){
			var showcase = document.createElementNS(twix.twix_ns, "showcase");
			if(el = twix.createNode(shcs, "title", true)) showcase.appendChild(el);
			if(el = twix.createNode(shcs, "description", true)) showcase.appendChild(el);
			var images = document.createElementNS(twix.twix_ns, "images");
			var feature = document.createElementNS(twix.twix_ns, "feature");
			if(el = twix.createNode($("fieldset.feature", shcs), "src", true)) feature.appendChild(el);
			if(el = twix.createNode($("fieldset.feature", shcs), "thumbnail", true)) feature.appendChild(el);
			if(feature.hasChildNodes()) images.appendChild(feature);

			var shots = $("fieldset.screenshot", shcs);
			shots.each(function(i){
				var screenshot = document.createElementNS(twix.twix_ns, "screenshot");
				if(el = twix.createNode(this, "src", true)) screenshot.appendChild(el);
				if(el = twix.createNode(this, "thumbnail", true)) screenshot.appendChild(el);
				if(screenshot.hasChildNodes()) images.appendChild(screenshot);
			});

			if(twix.debug) console.debug("Images & Showcase: ", images.childNodes.length, showcase.childNodes.length);
			if(images.hasChildNodes() && images.childNodes.length == 4) showcase.appendChild(images);
			else if(images.hasChildNodes()) twix.error.notice(shcs, {node : "images", msg : ""});
			if(showcase.hasChildNodes() && showcase.childNodes.length != 3)
				twix.error.notice(shcs, {node : "showcase", msg : ""});
			if(showcase.hasChildNodes())
				return showcase;
		}
		return null;
	},
	createNode : function(context, node, optional){
		var el = document.createElementNS(twix.twix_ns, node);
		var input = $("input[@name="+node+"]", context);
		var select = $("select[@name="+node+"]", context);
		var textarea = $("textarea[@name="+node+"]", context);
		if(twix.debug) console.debug("<"+node+">", input, select, textarea);
		if(input.length > 0 && input.val() != "") el.appendChild(document.createTextNode(input.val()));
		else if(select.length > 0 && select.val() != "") el.appendChild(document.createTextNode(select.val()));
//		else if(textarea.length > 0 && textarea.val() != "") el.appendChild(document.createCDATASection(textarea.val()));
		else if(textarea.length > 0 && textarea.val() != ""){
			if(node == "description"){
//				var xmlString = '<description xmlns="'+twix.html_ns+'">'+textarea.val()+'</description>';
//	/*			var xslString = '<?xml version="1.0" encoding="UTF-8"?>'+
//								'<xsl:stylesheet version="1.0" xmlns:twix="http://3amproductions.net/xml/ns/twix/" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">'+
//								'<xsl:template match="*"><xsl:choose><xsl:when test="name(.)=\'description\'"><twix:description><xsl:apply-templates/></twix:description></xsl:when>'+
//								'<xsl:otherwise><xsl:copy-of select="."/></xsl:otherwise></xsl:choose></xsl:template></xsl:stylesheet>';*/
//				if (window.ActiveXObject){// code for IE
//					var xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
//					xmlDoc.async="false";
//					xmlDoc.loadXML(xmlString);
//	/*				var xslDoc=new ActiveXObject("Microsoft.XMLDOM");
//					xslDoc.async="false";
//					xslDoc.loadXML(xslString);
//					el = xmlDoc.transformNode(xslDoc);*/
//				}
//				else{ // code for Mozilla, Firefox, Opera, etc.
//					var parser=new DOMParser();
//					var xmlDoc=parser.parseFromString(xmlString,"text/xml");
//	/*				var xslDoc=parser.parseFromString(xslString,"text/xml");
//					var xsltProc = new XSLTProcessor();
//					xsltProc.importStylesheet(xslDoc);
//					el = xsltProc.transformToFragment(xmlDoc, el.ownerDocument);
//					if(twix.debug) console.info(el);*/
//				}
//	
//				var root=xmlDoc.documentElement;
//				root = el.ownerDocument.importNode(root,true);
//				while(root.hasChildNodes()){
//					el.appendChild(root.removeChild(root.firstChild));
//				}

				var showdown = new Showdown.converter();
				var html = showdown.makeHtml(textarea.val());
				var xmlString = '<description xmlns="'+twix.html_ns+'">'+html+'</description>';

				var parser=new DOMParser();
				var xmlDoc=parser.parseFromString(xmlString,"text/xml");
				var root=xmlDoc.documentElement;
				root = el.ownerDocument.importNode(root,true);
				root = root.firstChild;
				while(root.hasChildNodes()){
					el.appendChild(root.removeChild(root.firstChild));
				}
			}
			else {
				el.appendChild(document.createTextNode(textarea.val()));
			}
		}
		else if(optional) return null;
		else twix.error.notice(context, {node : node, msg : ""});
		return el;
	},
	createAttribute : function(context, attr, optional){
		var att = document.createAttribute(attr);
		var input = $("input[@name="+attr+"]", context);
		var select = $("select[@name="+attr+"]", context);
		if(twix.debug) console.debug("@"+attr, input, select);
		if(input.length > 0 && input.val() != "") att.value = input.val();
		else if(select.length > 0 && select.val() != "") att.value = select.val();
		else if(optional) return null;
		else twix.error.notice(context, {node : attr, msg : ""});
		return att;
	},
	error : {
		flag : false,
		msgs : new Array(),
		nodes : new Array(),
		notice : function(context, err){
			twix.error.flag = true;
			twix.error.msgs.push("XML Error in project: "+twix.current_project+" with: "+err.node);
			twix.error.nodes.push(err.node);
//			console.error("XML Error with: "+node);
		},
		clear : function(){
			twix.error.flag = false;
			twix.error.msgs = new Array();
			twix.error.nodes = new Array();
		}
	}
}

