/* Following lines used to dynamically include dependent javascript files. Do not alter
php-include http://code.jquery.com/jquery-latest.pack.js
*/
/* Greybox Redux
 * Required: http://jquery.com/
 * Written by: John Resig
 * Based on code by: 4mir Salihefendic (http://amix.dk)
 * License: LGPL (read more in LGPL.txt)
 */

var greybox = {
	done : false,
	height : 400,
	width : 400,
	animate : true,
	init : function(selector,height,width){
		$(selector).click(function(e){
			e.preventDefault();
			this.blur();
			var t = this.title || this.innerHTML || this.href;
			greybox.show(t,this.href,height,width);
		});
	},
	twilightInit : function(selector,height,width){
		$(selector).click(function(e){
			e.preventDefault();
			this.blur();
			var t = this.title || this.innerHTML || this.href;
			var url = $(this).prev().val();
			if($(this).prev().attr("name") == "subdomain")
				url = "http://"+url+".3amproductions.net";
			greybox.show(t,url,height,width);
		});
	},
	show : function(caption, url, height, width) {
		greybox.height = height || 400;
		greybox.width = width || 400;
		if(!greybox.done) {
			$(document.body).append("<div id='GB_overlay'></div><div id='GB_window'><div id='GB_caption'></div>"
				+ "<img src='/images/close.gif' alt='Close Window'/></div>");
			$("#GB_window img").click(greybox.hide);
			$("#GB_overlay").click(greybox.hide);
			$(window).resize(greybox.position);
			$(window).scroll(greybox.position);
			greybox.done = true;
		}
		$("#GB_frame").remove();
		$("#GB_window").append("<iframe id='GB_frame' src='"+url+"'></iframe>");
		$("#GB_caption").html(caption+" : "+url);
		$("#GB_overlay").show();
		greybox.position();
		if(greybox.animate) $("#GB_window").slideDown("slow");
		else $("#GB_window").show();
	},
	hide : function() {
		$("#GB_window,#GB_overlay").hide();
	},
	position : function() {
		var de = document.documentElement;
		var h = self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight;
		var w = self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
		var iebody=(document.compatMode && document.compatMode != "BackCompat")? document.documentElement : document.body;
		var dsocleft=document.all? iebody.scrollLeft : pageXOffset;
		var dsoctop=document.all? iebody.scrollTop : pageYOffset;
		
		var height = h < greybox.height ? h - 32 : greybox.height;
		var top = (h - height)/2 + dsoctop;
		
		$("#GB_window").css({width:greybox.width+"px",height:height+"px",
		  left: ((w - greybox.width)/2)+"px", top: top+"px" });
		$("#GB_frame").css("height",height - 32 +"px");
		$("#GB_overlay").css({height:h, top:dsoctop + "px", width:w});
	}
}

//$(document).ready(greybox.init);