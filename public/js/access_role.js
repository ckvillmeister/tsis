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

$('.btn_yes').click(function(e){
  toggle_role(role_id, 0);
  $('#modal_confirm').modal('hide');
  get_access_roles(1);
});

$('body').on('click', '#btn_edit_role', function(e){
  role_id = $(this).val();
  get_access_role_info(role_id);
  $('#modal_role_form').modal('show');
});

$('body').on('click', '#btn_delete_role', function(e){
  role_id = $(this).val();
  $('#modal_confirm #modal_title').html("Confirm");
  $('#modal_confirm #modal_body').html("Are you sure you want to delete this role?");
  $('#modal_confirm').modal('show');
});

$('body').on('click', '#btn_activate_role', function(e){
  role_id = $(this).val();
  toggle_role(role_id, 1);
  $('#modal_confirm').modal('hide');
  get_access_roles(0);
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
          $('#modal_message_box #modal_title').html("New Role");
          $('#modal_message_box #modal_body').html("New role created!");
          $('#modal_message_box').modal('show');
          
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_role_form').modal('hide'); }, 3000);
        }
        else if (result == 2){
          $('#modal_message_box #modal_title').html("Role Updated");
          $('#modal_message_box #modal_body').html("Access role updated!");
          $('#modal_message_box').modal('show');

          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_role_form').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
          $('#modal_message_box #modal_title').html("Access Rights");
          $('#modal_message_box #modal_body').html("Access rights has been updated!");
          $('#modal_message_box').modal('show');
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during processing!");
          $('#modal_message_box').modal('show');
        }
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
}