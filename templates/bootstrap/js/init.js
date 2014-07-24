//Ajax forms
$(document).on('submit', '.ajax', function(e){
 	$(".help-block").remove();
	$(".alert").remove();
	$(".has-warning").removeClass("has-warning");
	$(".has-success").removeClass("has-success");
	$(".has-error").removeClass("has-error");
	var form = $(this);
	var redirect = false;
	$(this).ajaxSubmit({
        dataType:  'json',
		success:   function(data) {
			//Messages
			if(data.messages){
				messages = data.messages;
				if(messages.length){
					for(var x=0;x<messages.length;x++) {
						//Field message
						if(messages[x].field){
							field = form.find("select[name=" + messages[x].field + "], input[name=" + messages[x].field + "], textarea[name=" + messages[x].field + "], checkbox[name=" + messages[x].field + "]");
							if(field.length){
								field.parent().parent().addClass("has-" + messages[x].type);
								field.parent().append('<span class="help-block">' + messages[x].message + '</span>');
							}else{
								$("#mensajes-sys").append('<div class="alert alert-' + messages[x].type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + messages[x].message + '</div>');
								$('html,body').animate({ scrollTop: 0 }, 'slow');
							}
						//Url redirection
						}else if(messages[x].url){
							$(".alert").remove();
							redirect = true;
							document.location.href = messages[x].url;
						//Message without field
						}else{
							if(messages[x].type=="error"){
								messages[x].type = "danger";
							}
							$("#mensajes-sys").append('<div class="alert alert-' + messages[x].type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + messages[x].message + '</div>');
							$('html,body').animate({ scrollTop: 0 }, 'slow');
						}
					}
				}
			}
			//Debug Message
			if(data.debug){
				if(data.debug.length){
					messages = data.debug;
					for(var x=0;x<messages.length;x++) {
						//Increment counter
						var total = parseInt($("#debugCounterMessagesAjax").html());
						total++;
						$("#debugCounterMessagesAjax").html(total);
						//UL exists?
						if(!$("#debugModalMessagesAjax ul.list-group").length){
							//Create UL
							$("#debugModalMessagesAjax .modal-body").append("<ul class='list-group'></ul>");
							//Delete Blockquote
							$("#debugModalMessagesAjax blockquote").remove();
						}
						//Add message
						$("#debugModalMessagesAjax ul.list-group").append("<li class='list-group-item'><blockquote>" + messages[x].message + "</blockquote>" + messages[x].trace + "</li>");
					}
				}
			}
			//Extras
			if(data.data){
				//Modal HTML
				if(data.data.modal){
					$("#genericModal .modal-content").html(data.data.modal);
					$("#genericModal").modal('show');
				}
			}
			if(!redirect){
				$(".btn.disabled").disabled = false;
				$(".btn.disabled").removeClass("disabled");
				//Lada spinners
				Ladda.stopAll();
			}
		}
	});
	return false;
});

//Pagination
$(document).on('click', '.pagination a', function(e){
	var app = $(this).attr("data-app");
	var action = $(this).attr("data-action");
	var limit = $(this).attr("data-limit");
	var limitStart = $(this).attr("data-limitStart");
	var form = $(this).closest("form");
	if(app){
		checkFormField(form, "app", app);
	}
	if(action){
		checkFormField(form, "action", action);
	}
	checkFormField(form, "limit", limit);
	checkFormField(form, "limitStart", limitStart);
	form.submit();
});

//Sortable Columns
$(document).on('click', '.sortable', function(e){
	var form = $(this).closest("form");
	checkFormField(form, "order", $(this).attr("data-order"));
	checkFormField(form, "orderDir", $(this).attr("data-orderDir"));
	form.submit();
});

//Auto appends (if needed) hidden field
function checkFormField(formElement, fieldName, fieldValue){
	var field = formElement.find("input[name='" + fieldName + "']");
	if(!field.length){
		$('<input>').attr({
		    type: 'hidden',
		    name: fieldName,
		    value: fieldValue
		}).appendTo(formElement);
	}else{
		field.val(fieldValue);
	}
}

//change-submit
$(document).on('change', '.change-submit', function(e){
	$('#mainForm').submit();
});

//Toolbar
$(document).on('click', '.formButton', function(e){
	//Data
	element = $(this);
	if(!element.attr("data-selector")){
		$form = $(this).closest("form");
		if(!$form.length){
			$form = $("#mainForm");
		}
	}else{
		$form = $(element.attr("data-selector"));
	}
	app = element.attr("data-app"); 
	action = element.attr("data-action"); 
	requireIds = element.attr("data-requiereids"); 
	confirmation = element.attr("data-confirmation");
	ajax = element.attr("data-ajax");
	modalId = element.attr("data-modal"); 
	noAjax = element.attr("data-noajax");
	link = element.attr("data-link");
	//Start
	element.removeAttr("prevent-ladda");
	//Requiere IDs
	if(requireIds && $form.find("input:checkbox:checked").length<=0){
		alert("Debes seleccionar un elemento");
		element.attr("prevent-ladda", "true");
		return false;
	}
	//Confirmation
	if(confirmation){
		if(!confirm(confirmation)){
			element.removeClass("disabled");
			element.disabled = false;
			element.attr("prevent-ladda", "true");
			return false;
		}
	}
	//Modal
	if(modalId){
		$("#" + modalId).on('shown.bs.modal', function (e) {
			Ladda.stopAll();
		});
		$("#" + modalId).modal('show');
		return false;
	}
	//Link
	if(link){
		window.location.href = link;
		return false;
	}
	//No action / non-ajax
	if(!action && noAjax){
		//Check router
		var router = $form.find('input[name=router]').val();
		if(router){
			app = router + "/" + app;
		}
		window.location.href = URL + app + "/" +  action;
		return false;
	}
	//Disable element
	if(element){
		if(element.length){
			if(element.hasClass("disabled")){
				return false;
			}else{
				element.addClass("disabled");
				element.disabled = true;
			}
		}
	}
	//App
	if(app){
		checkFormField($form, "app", app);
	}
	//Action
	if(action){
		checkFormField($form, "action", action);
	}
	//Non-ajax
	if(noAjax){
		$form.removeClass("ajax");
	}else{
		$form.addClass("ajax");
	}
	//Submit
	$form.submit();
	//Restore
	if(ajax){
		element.removeClass("disabled");
		element.disabled = false;
		$form.find('input[name=app]').val("");
		$form.find('input[name=action]').val("");
	}
	return false;
});

$(document).ready(function(){
	//Bootsrap Switches
	$("input[type='checkbox'].switch").bootstrapSwitch();
	//Lada spinners
	Ladda.bind('.ladda-button');
});

//Check Alls
$(document).on('click', '.checkall', function(e){
	$(document).find(':checkbox').prop('checked', this.checked);
});