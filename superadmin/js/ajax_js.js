//Common Ajax Function To Be Used For All Modules...
function ajax_combo(ajax_php, form_name, element_id, spcl_value) {
    $.ajax({
        type: "post",
        url: ajax_php.concat("?spcl_value=" + spcl_value),
        data: $(form_name).serialize(),
        success: function(response) {
            $(element_id).html(response);
        }
    });
}

function ajax_combo3(ajax_php, form_name, element_id, msg_div_id, loader_class, spcl_value, Id, edit_mode_id, edit_mode_val, edit_mode_disable){
	
  $.ajax({
		type: "post",
		url: ajax_php.concat("?spcl_value=" + spcl_value + "&del_id=" + Id),
		data: $(form_name).serialize(),
		// data:  new FormData($(form_name)[0]),
		beforeSend: function() {
			$(msg_div_id).hide();
			$(loader_class).show();
		},
		success: function(response) {
			$(element_id).html(response);
			if(edit_mode_id!='' && edit_mode_val!=''){
				$(edit_mode_id).val(edit_mode_val);
				if(edit_mode_disable=='1')
				{
					$(edit_mode_id).prop("disabled", true);
				}
			}
			$(loader_class).hide();
			setTimeout(function() {
				$(msg_div_id).fadeIn("slow");
			}, 3000); 
			setTimeout(function() {
				$(msg_div_id).fadeOut("slow");
			}, 6000);
		}
	});
}