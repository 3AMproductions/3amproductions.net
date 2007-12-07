var transformix = {
	fix : function(){
		var els = document.getElementsByTagName('li');
		for (var i = 0; i < els.length; i++) {
			if(els[i].className == 'project')
				els[i].innerHTML = els[i].firstChild.textContent;
		}
	}
}
window.onload = transformix.fix;
