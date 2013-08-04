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
				if(data.length){
					for(var x=0;x<data.length;x++) {
						//Field message
						if(data[x].field){
							console.log(form.find("input[name=" + data[x].field + "]").length);
							if(form.find("input[name=" + data[x].field + "]").length){
								form.find("input[name=" + data[x].field + "]").parent().addClass("has-" + data[x].type);
								form.find("input[name=" + data[x].field + "]").parent().append('<span class="help-block">' + data[x].message + '</span>');
							}
						//Url redirection
						}else if(data[x].url){
							$(".alert").remove();
							document.location.href = data[x].url;
						//Message without field
						}else{
							$("#mensajes-sys").append('<div class="alert alert-' + data[x].type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + data[x].message + '</div>');
						}
					}
				}
			}
		});
		return false;
	});
});