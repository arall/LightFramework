//Ajax forms
$(document).on('submit', '.ajax', function(e){
 	$(".help-block").remove();
	$(".alert").remove();
	$(".has-warning").removeClass("has-warning");
	$(".has-success").removeClass("has-success");
	$(".has-error").removeClass("has-error");
	var form = $(this);
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
							field = form.find("select[name=" + messages[x].field + "], input[name=" + messages[x].field + "]");
							if(field.length){
								field.parent().parent().addClass("has-" + messages[x].type);
								field.parent().append('<span class="help-block">' + messages[x].message + '</span>');
							}
						//Url redirection
						}else if(messages[x].url){
							$(".alert").remove();
							document.location.href = messages[x].url;
						//Message without field
						}else{
							if(messages[x].type=="error"){
								messages[x].type = "danger"
							}
							$("#mensajes-sys").append('<div class="alert alert-' + messages[x].type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + messages[x].message + '</div>');
							$('html,body').animate({ scrollTop: 0 }, 'slow');
						}
					}
				}
			}
			//Modal HTML
			if(data.modal){
				$("#genericModal .modal-content").html(data.modal);
				$("#genericModal").modal('show');
			}
			$(".btn.disabled").removeClass("disabled");
			$(".btn.disabled").disabled = false;
		}
	});
	return false;
});
<<<<<<< HEAD

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
		return field;
	}
}
=======
>>>>>>> 0cedaded4ca917e30ce16d9f89c9b8693863a283
