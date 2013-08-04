//Inicialization
$(document).ready(function() {
	//Ajax forms
	$(".ajax").submit(function(){
	 	$(".help-block").remove();
		$(".alert").remove(); 
		$(this).ajaxSubmit({
	        dataType:  'json',
			success:   function(data) {
				if(!isArray(data)) {
					var data_array = new Array(1);
					data_array[0] = data;
					data = data_array;
				}
				for(var x=0;x<data.length;x++) {
					if(data[x].field){
						if($('#' + data[x].field).length){
							/////////////////// (THIS)
							$('#' + data[x].field).parent().addClass("has-" + data[x].type);
							$('#' + data[x].field).parent().append('<span class="help-block">' + data[x].message + '</span>');
						}
					}else if(data[x].url){
						$(".alert").remove();
						document.location.href = data[x].url;
					}else{
						$("#mensajes-sys").append('<div class="alert alert-' + data[x].type + '"><button type="button" class="close" data-dismiss="alert">&times;</button>' + data[x].message + '</div>');
					}
				}
			}
		});
		return false;
	});
});

//Funciones
function isArray(testObject) {
    return testObject && !(testObject.propertyIsEnumerable('length')) && typeof testObject === 'object' && typeof testObject.length === 'number';
}