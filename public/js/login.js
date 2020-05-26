$(document).ready(function(){

	$('#text_username').focus();

	$('#btn_login').click(function(e){
		var username = $('#text_username').val(),
			password = $('#text_password').val(),
			error = false;

		if (username == ''){
			$('#username_error_msg').html("<span id='message'>Please Enter a Username!</span>");
			error = true;
		}

		if(password == ''){
			$('#password_error_msg').html("<span id='message'>Please Enter a Password!</span>");
			error = true;
		}
		
		if (error == false){
			login();
		}

		$('#message').fadeOut();
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
		    	setTimeout(function(){ window.location = 'main';}, 4000);
		    }
		})
	}
});