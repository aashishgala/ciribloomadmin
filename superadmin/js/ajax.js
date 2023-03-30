
function custom_onsubmit(form_id, response_div){

    var loc = window.location.toString();	
    if(loc.indexOf("#") > 0){
        loc = loc.substring(0, loc.indexOf("#"));
    }

    var d = $('#'+form_id).serialize();

    // console.log(d);

    $.ajax({
        type: "POST",
        url: loc+"&api=json",
        data: d,
        
        success: function(result){
            $("#"+response_div).html(result);
        }

    });

    return false;

}

function ajax_action(id, special_val){

    // Data to post
    var d = "special_val="+special_val+"&id="+id;

    // Get Current Location
    var loc = window.location.toString();
    
	if(loc.indexOf("#") > 0){
		loc = loc.substring(0, loc.indexOf("#"));
	}
    
    replce_to = loc.replace('#', '');

    if(special_val == 'delete'){

        let text = "Are You Sure You Want To Delete?";

        if(confirm(text) == true){

            $.ajax({

                type: "post",
                url: loc+"&api=json",
                data: d,
                
                success: function(result){
                    // $("#"+response_div).html(result);
                    alert(result);
                    setTimeout(function(){window.location.replace(replce_to);}, 500);
                },

                error: function(err){   
                    // $("#"+response_div).html(err.responseText);
                    alert(err);
                }

            });

        }else{

          text = "";
          return false;

        }

    }
    else if(special_val == 'edit'){
        
        $.ajax({

            type: "post",
            url: loc+"&api=json",
            data: d,
            
            success: function(result){
                $("#res").html(result);
                // alert(result);
                // setTimeout(function(){window.location.replace(self.location);}, 500);
            },

            error: function(err){   
                // $("#"+response_div).html(err.responseText);
                alert(err);
            }

        });

    }

}

function confirm_alert(msg){
    alert(msg);
}

// Extra
function ajax_onsubmit(form_id, response_div, special_val){

    var loc = window.location.toString();	
    if(loc.indexOf("#") > 0){
        loc = loc.substring(0, loc.indexOf("#"));
    }

    var d = $('#'+form_id).serialize();

    // console.log(d);

    $.ajax({
        type: "POST",
        url: loc+"&api=json&special_val="+special_val,
        data: d,
        
        success: function(result){
            $("#"+response_div).html(result);
        }

    });

    return false;

}