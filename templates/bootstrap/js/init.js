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

$(document).ready(function(){
	//Bootsrap Switches
	$("input[type='checkbox'].switch").bootstrapSwitch();
	//Lada spinners
	Ladda.bind('.ladda-button');
	//Sortable table links
	$(".sortable").sortable();
	//Pagination
	$(".pagination a").pagination();
	//Change submit
	$(".change-submit").changeSubmit();
	//Form Buttons
	$(".formButton").formButton();
});