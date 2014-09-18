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
				processMessages(data.messages, form)
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