function getNodeValue(obj,tag)
{
 	if(obj.getElementsByTagName(tag)[0].firstChild)
	  return obj.getElementsByTagName(tag)[0].firstChild.nodeValue;
	else return null;
}

var domdom = {
	build : function(el){
		switch(el.nodeType){
			case 1: //ELEMENT_NODE
				var n = document.createElement(el.nodeName);
				for(var i=0; i<el.attributes.length; i++){
					n.setAttributeNode(domdom.build(el.attributes[i]));}
				for(var i=0; i<el.childNodes.length; i++){
					var t = domdom.build(el.childNodes[i]);
					if(t != null) n.appendChild(t);}
				return n;
			case 2: //ATTRIBUTE_NODE
				var a = document.createAttribute(el.nodeName);
				a.nodeValue = el.nodeValue;
				return a;
			case 3: //TEXT_NODE
				return document.createTextNode(el.nodeValue);
			case 4: //CDATA_SECTION_NODE
			case 5: //ENTITY_REFERENCE_NODE
			case 6: //ENTITY_NODE
			case 7: //PROCESSING_INSTRUCTION_NODE
			case 8: //COMMENT_NODE
			case 9: //DOCUMENT_NODE
			case 10: //DOCUMENT_TYPE_NODE
			case 11: //DOCUMENT_FRAGMENT_NODE
			case 12: //NOTATION_NODE
				return null;
		}
	}
}
