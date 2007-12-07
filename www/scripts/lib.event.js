/* http://www.scottandrew.com/weblog/articles/cbs-events */

if(document.addEventListener){
	var event = {
    add : function(obj, evType, fn, useCapture){
		  obj.addEventListener(evType, fn, useCapture);
      return true;},
		remove : function(obj, evType, fn, useCapture){
		  obj.removeEventListener(evType, fn, useCapture);
      return true;}
	};
}
else if(document.attachEvent){
	var event = {
    add : function(obj, evType, fn, useCapture){
		  var r = obj.attachEvent("on"+evType, fn);
      return r;},
		remove : function(obj, evType, fn, useCapture){
		  var r = obj.detachEvent("on"+evType, fn);
      return r;}
	};
}
else{
	var event = {
    add : function(obj, evType, fn, useCapture){},
		remove : function(obj, evType, fn, useCapture){}
	};
}

/*

var event = {
  add : function(obj, evType, fn, useCapture){
    if (obj.addEventListener){
      obj.addEventListener(evType, fn, useCapture);
      return true;}
  	else if (obj.attachEvent){
      var r = obj.attachEvent("on"+evType, fn);
      return r;}
  	else {
      alert("Handler could not be attached");
  		return false;}},
  
  remove : function(obj, evType, fn, useCapture){
    if (obj.removeEventListener){
      obj.removeEventListener(evType, fn, useCapture);
      return true;}
  	else if (obj.detachEvent){
      var r = obj.detachEvent("on"+evType, fn);
      return r;}
  	else {
      alert("Handler could not be removed");
  		return false;}}
};

*/