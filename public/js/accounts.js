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
    $('#modal_message_box #modal_title').html("Error");
    $('#modal_message_box #modal_body').html("Please provided all required fields!");
    $('#modal_message_box').modal('show');
    
    setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
  }
  else if ($('#text_password').val().trim() != $('#text_cpassword').val().trim()){
    $('#modal_message_box #modal_title').html("Error");
    $('#modal_message_box #modal_body').html("Password does not match!");
    $('#modal_message_box').modal('show');
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

$('.btn_yes').click(function(e){
  toggle_user(userid, 0);
  $('#modal_confirm').modal('hide');
  get_user_accounts(1);
});

$('body').on('click', '#btn_reset_password', function(e){
  $("#text_newpassword").val('');
  $("#text_cnewpassword").val('');
  $('.btn_submit_reset_password').val($(this).val());
  $('#modal_reset_password').modal('show');
});

$('.btn_submit_reset_password').click(function(e){
  if ($('#text_newpassword').val().trim() == '' | $('#text_cnewpassword').val().trim() == ''){
    $('#modal_message_box #modal_title').html("Error");
    $('#modal_message_box #modal_body').html("Please provide new password!");
    $('#modal_message_box').modal('show');
    
    setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
  }
  else if ($('#text_newpassword').val().trim() != $('#text_cnewpassword').val().trim()){
    $('#modal_message_box #modal_title').html("Error");
    $('#modal_message_box #modal_body').html("Password does not match!");
    $('#modal_message_box').modal('show');
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
  $('#modal_confirm #modal_title').html("Confirm");
  $('#modal_confirm #modal_body').html("Are you sure you want to delete this user?");
  $('#modal_confirm').modal('show');
});

$('body').on('click', '#btn_activate_user', function(e){
  userid = $(this).val();
  toggle_user(userid, 1);
  $('#modal_confirm').modal('hide');
  get_user_accounts(0);
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
          $('#modal_message_box #modal_title').html("New User");
          $('#modal_message_box #modal_body').html("New user account created!");
          $('#modal_message_box').modal('show');
          
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_user_account_form').modal('hide'); }, 3000);
        }
        else if (result == 2){
          $('#modal_message_box #modal_title').html("User Updated");
          $('#modal_message_box #modal_body').html("User account updated!");
          $('#modal_message_box').modal('show');

          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_user_account_form').modal('hide'); }, 3000);
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during submission. . .");
          $('#modal_message_box').modal('show');
        }
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
          $('#modal_message_box #modal_title').html("Password Reset");
          $('#modal_message_box #modal_body').html("Password reset!");
          $('#modal_message_box').modal('show');

          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_reset_password').modal('hide'); }, 3000);
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during reset. . .");
          $('#modal_message_box').modal('show');
        }
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
}