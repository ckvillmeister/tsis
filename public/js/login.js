$(document).ready(function(){

	$('#text_username').focus();

	$('#btn_login').click(function(e){
		var username = $('#text_username').val(),
			password = $('#text_password').val();

		if (username == ''){
			$.alert({
	            title: "Error",
	            type: "red",
	            content: "Please enter username!"
	        })
			error = true;
		}
		else if(password == ''){
			$.alert({
	            title: "Error",
	            type: "red",
	            content: "Please enter password!"
	        })
		}
		else{
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
	        		$.alert({
			            title: "Success",
			            type: "green",
			            content: "Login successful!"
			        })
					setTimeout(function(){ window.location = 'dashboard';}, 4000);
	        	}
	        	else{
	        		$.alert({
			            title: "Error",
			            type: "red",
			            content: "Login error!"
			        })
					$('#text_username').focus();
	        	}
		    },
		    error: function(obj, err, ex){
		        $.alert({
		            title: "Error",
		            type: "red",
		            content: msg + ": " + obj.status + " " + exception
		          })
		    }
		})
	}
});