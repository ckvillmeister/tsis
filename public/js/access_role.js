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

  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to delete this role?",
      buttons: {
          ok: function () {
              toggle_role(role_id, 0);
              get_access_roles(1);
          },
          cancel: function () {
              
          }
      }
  });
});

$('body').on('click', '#btn_activate_role', function(e){
  role_id = $(this).val();

  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to re-activate this role?",
      buttons: {
          ok: function () {
              toggle_role(role_id, 1);
              get_access_roles(0);
          },
          cancel: function () {
              
          }
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
          $.alert({
            title: "Saved",
            type: "green",
            content: "New role created!"
          })
        }
        else if (result == 2){
          $.alert({
            title: "Updated",
            type: "green",
            content: "Access role updated!"
          })
        }
        else{
          $.alert({
            title: "Error",
            type: "blue",
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
        $.alert({
            title: "Error",
            type: "red",
            content: msg + ": " + obj.status + " " + exception
          })
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
        $.alert({
            title: "Error",
            type: "red",
            content: msg + ": " + obj.status + " " + exception
          })
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
        $.alert({
            title: "Error",
            type: "red",
            content: msg + ": " + obj.status + " " + exception
          })
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
          $.alert({
            title: "Success",
            type: "green",
            content: "Access rights has been updated!"
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