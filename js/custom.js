//Common Ajax Function To Be Used For All Modules...
function ajax_call(page_url, form_name, res_ele_id, qrytring) {
    $.ajax({
        type: "POST",
        url: page_url.concat("?qrystring=" + qrytring),
        data: $("#"+form_name).serialize(),
        
        success: function(response) {
            $("#"+res_ele_id).html(response);
        },
        error: function (error) {
            console.log(error);
            $("#"+res_ele_id).html(error);
        }
    });
}

function ajax_call_(page_url, form_name, res_ele_id, msg_div_id, loader_class, qrystring, Id, edit_mode_id, edit_mode_val, edit_mode_disable){
	
  $.ajax({
		type: "post",
		url: page_url.concat("?qrystring=" + qrystring + "&id=" + Id),
		data: $("#"+form_name).serialize(),
		// data:  new FormData($(form_name)[0]),
		beforeSend: function() {
			$("#"+msg_div_id).hide();
			$(loader_class).show();
		},
		success: function(response) {
			$("#"+res_ele_id).html(response);
			if(edit_mode_id!='' && edit_mode_val!=''){
				$("#"+edit_mode_id).val(edit_mode_val);
				if(edit_mode_disable=='1')
				{
					$("#"+edit_mode_id).prop("disabled", true);
				}
			}
			$(loader_class).hide();
			setTimeout(function() {
				$("#"+msg_div_id).fadeIn("slow");
			}, 3000); 
			setTimeout(function() {
				$("#"+msg_div_id).fadeOut("slow");
			}, 6000);
		}
	});
}

function user_score_ajax(page_url, qrytring) {
    $.ajax({
        type: "GET",
        url: page_url.concat("?qrystring=" + qrytring),
    });
}

$( document ).ready(function() {
	var sPageURL = window.location.search.substring(3); // console.log(sPageURL);
	
	// remove active class of nav list
	if ($(".adm-nav li").hasClass("active")) {
		setTimeout(function () {
			$(".adm-nav li").removeClass("active");
		}, 10);
	}

	// set active class of selected nav list
	setTimeout(function () {
		$("#"+sPageURL).addClass("active");
	}, 10);
});

// var getUrlParameter = function getUrlParameter(sParam) {
//     var sPageURL = window.location.search.substring(3),
//         sURLVariables = sPageURL.split('&'),
//         sParameterName,
//         i;

//     for (i = 0; i < sURLVariables.length; i++) {
//         sParameterName = sURLVariables[i].split('=');

//         if (sParameterName[0] === sParam) {
//             return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
//         }
//     }
//     return false;
// };