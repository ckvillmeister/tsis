$(document).ready(function(){

	$('#text_username').focus();

	$('#btn_login').click(function(e){
		var username = $('#text_username').val(),
			password = $('#text_password').val();

		if (username == ''){
			Swal.fire({
				title: "Error",
				text: "Please enter a username!",
				icon: "error",
				confirmButtonColor: "#b34045",
			});
			error = true;
		}
		else if(password == ''){
			Swal.fire({
				title: "Error",
				text: "Please enter a password!",
				icon: "error",
				confirmButtonColor: "#b34045",
			});
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
	        		Swal.fire({
						title: "Authentication Success",
						text: "You will be now redirected to dashboard!",
						icon: "success",
						//showCancelButton: true,	
        				showConfirmButton: true,	
						confirmButtonColor: "#00939D"
					}).then((isConfirm) => {
						if (isConfirm) {
							window.location.href = 'dashboard';
						}
						else{
							setTimeout(function(){ window.location = 'dashboard';}, 4000);
						}
					});
					
	        	}
	        	else{
					Swal.fire({
						title: "Error",
						text: "Invalid credentials!",
						icon: "error",
						confirmButtonColor: "#b34045",
					});
	        	}
		    },
		    error: function(obj, err, ex){
				Swal.fire({
					title: "Error",
					text: err + ": " + obj.status + " " + ex,
					icon: "error",
					confirmButtonColor: "#b34045",
				});
		    }
		})
	}
});