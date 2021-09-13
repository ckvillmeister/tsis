var userid = 0, update = 0, username = '';

get_user_accounts(1);

$('#text_firstname').change(function(){
  if (update == 0){
    username = $(this).val().trim().split(" ").join("").toLowerCase();
  }
  else{
    if($('#text_username').val() == ''){
      username = $(this).val().trim().split(" ").join("").toLowerCase();
    }
  }
});

$('#text_lastname').change(function(){
  if (update == 0){
    $('#text_username').val(username+'.'+$(this).val().split(" ").join("").toLowerCase());
  }
  else{
    if($('#text_username').val() == ''){
      $('#text_username').val(username+'.'+$(this).val().split(" ").join("").toLowerCase());
    }
  }
});

$('#btn_submit').click(function(e){

  if ($('#text_username').val().trim() == '' | $('#text_password').val().trim() == '' 
    | $('#text_firstname').val().trim() == '' | $('#text_lastname').val().trim() == ''
    | $('#cbo_role').val().trim() == ''){

    $.alert({
        title: "Error",
        type: "red",
        content: "Please provided all required fields!"
      })
  }
  else if ($('#text_password').val().trim() != $('#text_cpassword').val().trim()){
    $.alert({
        title: "Error",
        type: "red",
        content: "Password does not match!"
      })
  }
  else{
    process_user_account(userid);
    get_user_accounts(1);
  }

});

$('#btn_new_user').click(function(e){
  userid = 0;
  update = 0;
  username = '';
  $('.password_row').removeClass('invisible');
  $('#text_username').val('');
  $('#text_password').val('');
  $('#text_cpassword').val('');
  $('#text_firstname').val('');
  $('#text_middlename').val('');
  $('#text_lastname').val('');
  $('#cbo_extension').val('');
  $('#cbo_role').val('');
});

$('#btn_active').click(function(e){
   get_user_accounts(1);
});

$('#btn_trash').click(function(e){
   get_user_accounts(0);
});

$('body').on('click', '#btn_reset_password', function(e){
  $("#text_newpassword").val('');
  $("#text_cnewpassword").val('');
  $('.btn_submit_reset_password').val($(this).val());
  $('#modal_reset_password').modal('show');
});

$('.btn_submit_reset_password').click(function(e){
  if ($('#text_newpassword').val().trim() == '' | $('#text_cnewpassword').val().trim() == ''){
    $.alert({
        title: "Error",
        type: "red",
        content: "Please provided new password!"
      })
  }
  else if ($('#text_newpassword').val().trim() != $('#text_cnewpassword').val().trim()){
    $.alert({
        title: "Error",
        type: "red",
        content: "Password does not match!"
      })
  }
  else{
    reset_password($(this).val(), $('#text_newpassword').val().trim());
  }
});

$('body').on('click', '#btn_edit_user', function(e){
  userid = $(this).val();
  update = 1;

  $('.password_row').addClass('invisible');
  get_user_account_info(userid);
  $('#modal_user_account_form').modal('show');
});

$('body').on('click', '#btn_delete_user', function(e){
  userid = $(this).val();

  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to delete this user?",
      buttons: {
          ok: function () {
            toggle_user(userid, 0);
            get_user_accounts(1);
          },
          cancel: function () {
              
          }
      }
  });
});

$('body').on('click', '#btn_activate_user', function(e){
  userid = $(this).val();

  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to re-activate this user?",
      buttons: {
          ok: function () {
            toggle_user(userid, 1);
            get_user_accounts(0);
          },
          cancel: function () {
              
          }
      }
  });
});

function process_user_account(id){
  $.ajax({
      url: 'accounts/process_user_account',
        method: 'POST',
        data: {id: id, 
          username: $('#text_username').val(), 
          password: $('#text_password').val(),
          firstname: $('#text_firstname').val(),
          middlename: $('#text_middlename').val(),
          lastname: $('#text_lastname').val(),
          extension: $('#cbo_extension').val(),
          role: $('#cbo_role').val(),
        },
      success: function(result) {
        if (result == 1){
          $.alert({
            title: "Saved",
            type: "green",
            content: "New user account created!"
          })
        }
        else if (result == 2){
          $.alert({
            title: "Updated",
            type: "green",
            content: "User account updated!"
          })
        }
        else{
          $.alert({
            title: "Error",
            type: "red",
            content: "Error during processing!"
          })
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

function get_user_accounts(status){
  $.ajax({
      url: 'accounts/get_user_accounts',
        method: 'POST',
        data: {status: status},
        dataType: 'html',
      success: function(result) {
        $('#user_list').html(result);
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

function get_user_account_info(id){
  $.ajax({
      url: 'accounts/get_user_account_info',
        method: 'POST',
        data: {id: id},
        dataType: 'JSON',
      success: function(result) {
        $('#text_username').val(result['username']);
        $('#text_password').val(result['password'])
        $('#text_cpassword').val(result['password'])
        $('#text_firstname').val(result['firstname']);
        $('#text_middlename').val(result['middlename']);
        $('#text_lastname').val(result['lastname']);
        $('#cbo_extension').val(result['suffix']);
        $('#cbo_role').val(result['role']);
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

function toggle_user(id, status){
  $.ajax({
      url: 'accounts/toggle_user',
        method: 'POST',
        data: {id: id, status: status},
        dataType: 'html',
      success: function(result) {
        
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

function reset_password(id, password){
  $.ajax({
      url: 'accounts/reset_password',
        method: 'POST',
        data: {id: id, password: password},
        dataType: 'html',
      success: function(result) {
        if (result == 1){
          $.alert({
            title: "Reset Password",
            type: "green",
            content: "Password reset!"
          })
        }
        else{
          $.alert({
            title: "Error",
            type: "red",
            content: "Error while resetting password!"
          })
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