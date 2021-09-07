$(document).ready(function(){

	$('#text_username').focus();

	$('#btn_login').click(function(e){
		var username = $('#text_username').val(),
			password = $('#text_password').val(),
			error = false;

		if (username == ''){
			$('#username_error_msg').html("<span id='message'>Please enter username!</span>");
			error = true;
		}
		else{
			$('#username_error_msg').html("");
		}

		if(password == ''){
			$('#password_error_msg').html("<span id='message'>Please enter password!</span>");
			error = true;
		}
		else{
			$('#password_error_msg').html("");
		}
		
		if (error == false){
			login();
		}
	});

	$('#text_username').keypress(function(event){
     	var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == 13){
			login();
		}
    });

	$('#text_password').keypress(function(event){
     	var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == 13){
			login();
		}
    });

	function login(){
		$.ajax({
		    url: 'authentication/validate_login',
	        method: 'POST',
	        data: {username: $('#text_username').val(), password: $('#text_password').val()},
	        success: function(result) {
	        	if (result == 1){
	        		header = 'Login Success';
					msg = 'Login Successful!';
					$('.message_modal_header').removeClass('bg-danger');
					$('.message_modal_header').addClass('bg-success');
					$('.message_icon').removeClass('fas fa-times');
					$('.message_icon').addClass('fas fa-check');
					$('#modal_body_header').html(header);
					$('#modal_body_message').html(msg);
					$('#modal_message').modal({
						backdrop: 'static',
				    	keyboard: false
					});
					setTimeout(function(){ window.location = 'dashboard';}, 4000);
	        	}
	        	else{
	        		header = 'Login Error';
					msg = 'Invalid user credentials!';
					$('.message_modal_header').removeClass('bg-success');
					$('.message_modal_header').addClass('bg-danger');
					$('.message_icon').removeClass('fas fa-check');
					$('.message_icon').addClass('fas fa-times');
					$('#modal_body_header').html(header);
					$('#modal_body_message').html(msg);
					$('#modal_message').modal({
						backdrop: 'static',
				    	keyboard: false
					});
					setTimeout(function(){ $('#modal_message').modal('toggle'); }, 4000);
					$('#text_username').focus();
	        	}
		    }
		})
	}
});