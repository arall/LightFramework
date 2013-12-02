//Inicialization
$(document).ready(function() {
	//Ajax forms
	$(".ajax").submit(function(){
	 	$(".help-block").remove();
		$(".alert").remove(); 
		var form = $(this);
		$(this).ajaxSubmit({
	        dataType:  'json',
			success:   function(data) {
				if(data.messages.length){
					messages = data.messages;
					for(var x=0;x<messages.length;x++) {
						//Field message
						if(messages[x].field){
							console.log(form.find("input[name=" + messages[x].field + "]").length);
							if(form.find("input[name=" + messages[x].field + "]").length){
								form.find("input[name=" + messages[x].field + "]").parent().addClass("has-" + messages[x].type);
								form.find("input[name=" + messages[x].field + "]").parent().append('<span class="help-block">' + data[x].message + '</span>');
							}
						//Url redirection
						}else if(messages[x].url){
							$(".alert").remove();
							document.location.href = messages[x].url;
						//Message without field
						}else{
							$("#mensajes-sys").append('<div class="alert alert-' + messages[x].type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + data[x].message + '</div>');
						}
					}
				}
			}
		});
		return false;
	});
});