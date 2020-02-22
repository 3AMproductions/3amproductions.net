/* Following lines used to dynamically include dependent javascript files. Do not alter
php-include http://cachefile.net/scripts/jquery/1.2.1/jquery-1.2.1.pack.js
php-include copyEvents.js
php-include toXML.js
php-include toJSON.js
php-include thickbox.src.js
php-include jqmodal.js
php-include datepicker.pak.js
php-include accordion.pak.js
php-include twix.js
*/

var twilight = {
	debug : false,
	history : {
		tree : new Array(),
		parent : new Array(),
		undo : function(e){
			e.preventDefault();
			this.blur();
			if(twilight.debug) console.info("undo invoked");
			if(twilight.history.parent.length > 0){
				var tree = twilight.history.tree.pop();
				var parent = twilight.history.parent.pop();
				parent.children("a.add").before(tree);
				$("a.save").removeClass("disabled").addClass("enabled");
				if(twilight.history.parent.length == 0)
					$(this).removeClass("enabled").addClass("disabled");
			}
		},
		clear : function(){
			twilight.history.tree = new Array();
			twilight.history.parent = new Array();
			$("a.undo").removeClass("enabled").addClass("disabled");
		},
		compact : function(){// removes non project nodes from history
			for(var i=0; i<twilight.history.parent.length; i++){
				if(twilight.history.parent[i].is("fieldset")){
					twilight.history.tree.splice(i,1);
					twilight.history.parent.splice(i,1);
				}
			}
			if(twilight.history.parent.length == 0){
				$("a.undo").removeClass("enabled").addClass("disabled");
			}
		}
	},
	accordion : {
		active : null,
		container : null,
		header : null,
		init : function(container, header){
			twilight.accordion.header = header;
			twilight.accordion.container = container;
			//initialize
			$(container).Accordion({
				header: header,
				active: false,
				alwaysOpen: false,
				selectedClass: "open-project"})
				.change(twilight.accordion.change);
		},
		change : function(event, newHeader, oldHeader, newContent, oldContent){
			if(!newHeader) return;//event is fired if child form fields change. ignore them
			twilight.accordion.active = newHeader;
			if(twilight.debug) console.debug("Accordion Change:", newHeader);
		},
		activate_last : function(){
			var last = $(twilight.accordion.container +" "+ twilight.accordion.header).length - 1;
			if(twilight.debug) console.debug(last);
			$(twilight.accordion.container).activate(last);
		}
	},
	init : function(){
		if(twilight.debug) console.info("init invoked");

		//Accordion
		twilight.accordion.init("div.projects", "h2");

		//Add event listener (undo,savecommit)
		$("a.save").click(twilight.save);
		$("a.commit").click(twilight.commit);
		$("a.undo").click(twilight.history.undo);

		//Set DatePicker format
		$.datePicker.setDateFormat("ymd","-");

		//Add event listeners (add, delete, preview, datepicker)
		twilight.listen(document);
		
		if(twilight.debug) console.info("init finished");
	},
	listen : function(context){
		if(twilight.debug) console.info("listen invoked");
		if(twilight.debug) console.debug(context);
		$("a.add", context).click(twilight.clone);
		$("a.delete", context).click(twilight.remove);
		$("div.project input, div.project select, div.project textarea").change(twilight.validate);
		
		//Thickbox (Preview)
		$("a.preview", context).click(function(e){
			e.preventDefault();
			this.blur();
			var caption = "Preview of " + $(this).attr('href');
			var group = this.rel || false;
			var url = $(this).prev().val();
			if($(this).attr('href') == "subdomain")
				url = "http://" + url + ".3amproductions.net";
			thickbox.show(caption, url, group);
		});

		//Greybox (Preview)
//		greybox.twilightInit("label.url a.preview",700,925);

		//DatePicker
		$("input.date", context).datePicker({startDate:"2005-01-01"});
		
		if(twilight.debug) console.info("listen finished");
	},
	clone : function(e){
		if(twilight.debug) console.info("clone invoked");
		e.preventDefault();
		this.blur();
		var item = $(this).attr("href");
		var cloned = $("#"+item).children("div, fieldset").clone(true).insertBefore(this);
		// would like to use cloneWithEvents above and not need to reapply events but it doesn't work
		twilight.listen(this.parentNode);
		$("a.save").removeClass("disabled").addClass("enabled");
		if($(cloned).attr("class") == "project")
			twilight.accordion.activate_last();
		if(twilight.debug) console.info("clone finished");
	},
	remove : function(e){
		if(twilight.debug) console.info("remove invoked");
		if(twilight.debug) console.debug(e);
		e.preventDefault();
		this.blur();
		var fieldset = $(this).parent();
		twilight.history.parent.push(fieldset.parent());
		twilight.history.tree.push(fieldset.remove());
		$("a.undo").removeClass("disabled").addClass("enabled");
		$("a.save").removeClass("disabled").addClass("enabled");
		if(twilight.debug) console.info("remove finished");
	},
	save : function(e){
		if(twilight.debug) console.info("save invoked");
		if(twilight.debug) console.debug(e);
		e.preventDefault();
		this.blur();

		if($(this).filter(".enabled").length == 0) return;

		$("#errors").hide();
		$("#status").empty().append("Status: processing");

		function processAndTransmit(saveButton){
			var xml = null;
			twix.error.clear();
			$("#errors p").empty();
			
			xml = twix.createPortfolio($("div.projects"));
			if(twilight.debug) console.debug("XML: ", xml);
	//		alert("wait");
			if(twix.error.flag){
			//TODO handle errors
				twilight.err.notify(twix.error.msgs.join("<br />"));
				$("#status").empty().append("Status: error");
				return;
			}
			
			$(saveButton).removeClass("enabled").addClass("disabled");
			$("a.commit").removeClass("disabled").addClass("enabled");
			$("#status").empty().append("Status: transmitting");
	
			$.ajax({
				type: "POST",
				url: "twilight.php",
				processData: false,
				contentType: "application/xml",
				data:$(xml).toXML(),
				dataType: "json",
				beforeSend: function(xhr){
					xhr.setRequestHeader("X-TWIX", "update");},
				complete: twilight.ajax.complete,
				success: twilight.ajax.success,
				error: twilight.ajax.error
			});
		}
		var tempy = this;
		setTimeout(function(){processAndTransmit(tempy);}, 0);
	},
	commit :function(e){
		if(twilight.debug) console.info("commit invoked");
		if(twilight.debug) console.debug(e);
		e.preventDefault();
		this.blur();
		
		if($(this).filter(".enabled").length == 0) return;

		$("#errors").hide();
		$("#status").empty().append("Status: transmitting");
		$(this).removeClass("enabled").addClass("disabled");
		
		$.ajax({
			type: "POST",
			url: "twilight.php",
			data: {},
			dataType: "json",
			beforeSend: function(xhr){
				xhr.setRequestHeader("X-TWIX", "commit");},
			complete: twilight.ajax.complete,
			success: twilight.ajax.success,
			error: twilight.ajax.error
		});
	},
	validate : function(e){
		if(twilight.debug) console.debug("Changed: ", $(this).attr("name"), this);
		e.preventDefault();
//		twilight.err.stack = twilight.err.stack.not($(this));
//		twilight.err.stack.each(function(i){
//			if(twilight.debug) console.debug(i,this);
//			var e = document.createEvent('HTMLEvents');
//			e.initEvent('change',true,true);
//			this.dispatchEvent(e);
//		});
		
		$("a.save").removeClass("disabled").addClass("enabled");
		var value = $(this).val();
		var project = $(this).parents("div.project");
		try{
		switch($(this).attr("name")){
			case "id":
				$(this).val(twilight.util.stripWhitespace(value));
				if(value != ""){
					//check for ID uniqueness
					var sameids = $("input[@name=id]",project.parents("div.projects")).filter("input[@value='"+$(this).val()+"']");
					if(twilight.debug) console.debug("Same IDs: ",sameids);
					if(sameids.length > 1)
						throw {node : this, msg : "Duplicate project ID : '" + $(this).val() + "'"};
					//set title = id if title is empty
					if(twilight.util.stripWhitespace($("input[@name=title]", project).val()) == ""){
						$("h2", project).text(value);}} 
				else{
					throw {node : this, msg : "Empty String Disallowed as project ID"};
				}
			break;
			case "started":
			case "modified":
			case "launched":
				// get dates
				var started = $("fieldset.management input[@name=started]",project);
				var modified = $("fieldset.management input[@name=modified]",project);
				var launched = $("fieldset.management input[@name=launched]",project);
				
				// stripWhitespace
				started.val(twilight.util.stripWhitespace(started.val()));
				modified.val(twilight.util.stripWhitespace(modified.val()));
				launched.val(twilight.util.stripWhitespace(launched.val()));
				
				// parse date
				started = Date.parse(started.val().replace(/-/g, "/"));
				modified = Date.parse(modified.val().replace(/-/g, "/"));
				launched = (launched.val() == "" ? false : Date.parse(launched.val().replace(/-/g, "/")));
				
				// make sure it's valid
				if(isNaN(started))
					throw {node : this, msg : "Invalid 'started' date for project: '" + $("input[@name=id]",project).val() + "'"};
				if(isNaN(modified))
					throw {node : this, msg : "Invalid 'modified' date for project: '" + $("input[@name=id]",project).val() + "'"};
				if(isNaN(launched))
					throw {node : this, msg : "Invalid 'launched' date for project: '" + $("input[@name=id]",project).val() + "'"};
				
				// check chronology
				if(started > modified)
					throw {node : this, msg : "Invalid date for project: '" + $("input[@name=id]",project).val() + "': 'modified' must be on or after 'started'"};
				if(launched && started > launched)
					throw {node : this, msg : "Invalid date for project: '" + $("input[@name=id]",project).val() + "': 'launched' must be on or after 'started'"};
				if(launched && launched > modified)
					throw {node : this, msg : "Invalid date for project: '" + $("input[@name=id]",project).val() + "': 'modified' must be on or after 'launched'"};
			break;
			case "abbr":
			case "directory":
			case "subdomain":
			case "zip":
			case "livesite":
			case "email":
			case "src":
			case "thumbnail":
				//strip whitespace
				$(this).val(twilight.util.stripWhitespace(value));
			break;
			case "title":
				if(value != ""){
					$("h2", project).text(value);}
				else{
					var id = $("input[@name=id]", project).val();
					$("h2", project).text(id);
				}
			break;
		}
		twilight.err.clear();
		}
		catch(err)
		{
			if(twilight.debug) console.debug(err);
			$("a.save").removeClass("enabled").addClass("disabled");
//			twilight.err.stack.add($(err.node));
			twilight.err.notify(err.msg);
		}
	},
	ajax : {
		complete : function(req, status){
			if(twilight.debug) console.debug("Request: ", req);
			if(twilight.debug) console.debug("Status: ", status);
		},
		success : function(data){
			if(twilight.debug) console.debug(data);
			$("#status").empty().append("Status: "+data.msg);
		},
		error : function(req,msg,e){
			if(twilight.debug) console.debug(req,msg,e);
			twilight.err.notify($.parseJSON(req.responseText).msg);
			$("#status").empty().append("Status: Error");
		}
	},
	err : {
		stack : $(),
		notify : function(err){
			if(twilight.debug) console.debug(err);
			$("#errors p").empty().append(err);
			$("#errors").show();
//			$("#errors").ScrollTo("normal");
//			$("#errors").jqmShow();
		},
		clear : function(){
			$("#errors p").empty();
			$("#errors").hide();
		}
	},
	util : {
		stripWhitespace : function(str){
			return str.replace(/( |\t|\n)/g, "");
		}
	}
}

$(document).ready(twilight.init);