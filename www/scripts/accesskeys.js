/* Following lines used to dynamically include dependent javascript files. Do not alter
php-include lib.prototype.js.php
*/

var accesskeys = {
	id : 'accesskeys',
	live : false,
	akeys : '',
	classname : '',
	init : function(){
		accesskeys.akeys = document.getElementsByClassName('akey','em');
		Event.observe(document,'keydown',accesskeys.show);
		Event.observe(document,'keyup',accesskeys.hide);
	},
	show : function(e){
		if((e.shiftKey || e.ctrlKey || e.altKey || e.modifiers > 0) && !accesskeys.live){
			if($(accesskeys.id)){
				$(accesskeys.id).removeClassName('invisible');
				$(accesskeys.id).addClassName('visible');}
			for(var i = 0; i < accesskeys.akeys.length; i++){
				accesskeys.akeys[i].addClassName('highlight_akey');}
			accesskeys.live = true;}
		return;
	},
	hide : function(e){
		if(accesskeys.live){
			if($(accesskeys.id)){
				$(accesskeys.id).addClassName('invisible');
				$(accesskeys.id).removeClassName('visible');}
			for(var i=0; i<accesskeys.akeys.length; i++){
				accesskeys.akeys[i].removeClassName('highlight_akey');}
			accesskeys.live = false;
		}
	}
};
Event.observe(window, 'load', accesskeys.init);