var role_id = 0;

get_access_roles(1);

$('#btn_submit').click(function(e){
  process_access_role(role_id);
  get_access_roles(1);
});

$('#btn_new_role').click(function(e){
   $('#text_rolename').val('');
   $('#text_description').val('');
});

$('#btn_active').click(function(e){
   get_access_roles(1);
});

$('#btn_trash').click(function(e){
   get_access_roles(0);
});

$('body').on('click', '#btn_edit_role', function(e){
  role_id = $(this).val();
  get_access_role_info(role_id);
  $('#modal_role_form').modal('show');
});

$('body').on('click', '#btn_delete_role', function(e){
  role_id = $(this).val();

  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to delete this role?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_role(role_id, 0);
      get_access_roles(1);
    }
  });
});

$('body').on('click', '#btn_activate_role', function(e){
  role_id = $(this).val();

  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to re-activate this role?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_role(role_id, 1);
      get_access_roles(0);
    }
  });
});

function process_access_role(id){
  $.ajax({
      url: 'accessrole/process_access_role',
        method: 'POST',
        data: {id: id, 
          rolename: $('#text_rolename').val(), 
          description: $('#text_description').val()
        },
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Success",
            text: "New role successfully created!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_role_form').modal('toggle');
            }
          });
        }
        else if (result == 2){
          Swal.fire({
            title: "Success",
            text: "Role successfully updated!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_role_form').modal('toggle');
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
              $('#modal_role_form').modal('toggle');
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

function get_access_roles(status){
  $.ajax({
      url: 'accessrole/get_access_roles',
        method: 'POST',
        data: {status: status},
        dataType: 'html',
      success: function(result) {
        $('#role_list').html(result);
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

function get_access_role_info(id){
  $.ajax({
      url: 'accessrole/get_access_role_info',
        method: 'POST',
        data: {id: id},
        dataType: 'JSON',
      success: function(result) {
        $('#text_rolename').val(result['rolename']);
        $('#text_description').val(result['description']);
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

function toggle_role(id, status){
  $.ajax({
      url: 'accessrole/toggle_role',
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

$('#btn_save_access_rights').click(function(){
  var accs_rights = [];
  var ctr = 0;
  var id = $(this).val();

  $('#access_rights input[type=checkbox]').each(function() {
    if ($(this).is(":checked")) {
      //alert($(this).val());
      accs_rights[ctr] = $(this).val();
      ctr++;
    }
  });

  save_access_rights(id, accs_rights);
});

function save_access_rights(id, accs_rights){
  $.ajax({
      url: 'save_access_rights?id='+id,
        method: 'POST',
        data: {rights: accs_rights},
        dataType: 'html',
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Success",
            text: "Access rights has been updated!",
            icon: "success",
            confirmButtonColor: "#00939D"
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error during saving!",
            icon: "error",
            confirmButtonColor: "#b34045"
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