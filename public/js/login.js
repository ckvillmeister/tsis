$(document).ready(function(){

	$('#text_username').focus();

	$('#btn_login').click(function(e){
		login();
	});

	//$('#text_password').keypress(function(event){
    // 	var keycode = (event.keyCode ? event.keyCode : event.which);
	//	if(keycode == '13'){
	//		login();
	//	}
    //});

	function login(){
		$.ajax({
		    url: 'login/validate_login',
	        method: 'POST',
	        data: {username: $('#text_username').val(), password: $('#text_password').val()},
	        dataType: 'JSON',
	    	success: function(result) {
	    		if (result == 0){
	    			$('#modal_title').html("Error");
		    		$('#modal_body').html("Invalid user credentials!");
		    		setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
		    	}
		    	else{
		    		$('#modal_title').html("Success");
		    		$('#modal_body').html("Login successful");
		    		setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
		    		setTimeout(function(){ window.location = 'main';}, 4000);
		    	}
		    },
		    error: function(obj, err, ex){
		    	$('#modal_title').html("Error");
		    	$('#modal_body').html(err + ": " + obj.toString() + " " + ex);
		    	setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
			}
		})
	}
});