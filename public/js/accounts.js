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

    Swal.fire({
      title: "Error",
      text: "Please provide all required fields!",
      icon: "error",
      confirmButtonColor: "#b34045"
    });
  }
  else if ($('#text_password').val().trim() != $('#text_cpassword').val().trim()){
    Swal.fire({
      title: "Error",
      text: "Password does not match!",
      icon: "error",
      confirmButtonColor: "#b34045"
    });
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
  $("#newpassword").val('');
  $("#cnewpassword").val('');
  $('.btn_submit_reset_password').val($(this).val());
  $('#modal_reset_password').modal('show');
});

$('.btn_submit_reset_password').click(function(e){
  if ($('#newpassword').val().trim() == '' && $('#cnewpassword').val().trim() == ''){
    Swal.fire({
      title: "Error",
      text: "Please provide a new password!",
      icon: "error",
      confirmButtonColor: "#b34045"
    });
  }
  else if ($('#newpassword').val().trim() != $('#cnewpassword').val().trim()){
    Swal.fire({
      title: "Error",
      text: "Password does not match!",
      icon: "error",
      confirmButtonColor: "#b34045"
    });
  }
  else{
    reset_password($(this).val(), $('#newpassword').val().trim());
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

  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to delete this user?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_user(userid, 0);
      get_user_accounts(1);
    }
  });
});

$('body').on('click', '#btn_activate_user', function(e){
  userid = $(this).val();

  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to re-activate this user?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_user(userid, 1);
      get_user_accounts(0);
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
          Swal.fire({
            title: "Success",
            text: "New user account successfully created!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_user_account_form').modal('toggle');
            }
          });
        }
        else if (result == 2){
          Swal.fire({
            title: "Success",
            text: "User account successfully updated!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_user_account_form').modal('toggle');
            }
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error during saving!",
            icon: "error",
            confirmButtonColor: "#b34045"
          }).then((res) => {
            if (res.value) {
              $('#modal_user_account_form').modal('toggle');
            }
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
        Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
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
        Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
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
        Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
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
          Swal.fire({
            title: "Success",
            text: "Password successfully changed!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_reset_password').modal('toggle');
            }
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error while changing password!",
            icon: "error",
            confirmButtonColor: "#b34045"
          }).then((res) => {
            if (res.value) {
              $('#modal_reset_password').modal('toggle');
            }
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