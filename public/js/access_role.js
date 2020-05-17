var role_id = 0;
var dt_accessroles = $('#dataTable').DataTable();

//Add / Update access role
$('#btn_submit').click(function(e){
  process_access_role(role_id);
  get_access_roles();
});

//Clear error message on add / update role form
$('#btn_new_access_role').click(function(e){
   $('#div_footer').html("");
});

$('#dataTable tbody td').on('click', '#btn_edit_record', function(e){
  role_id = $(this).val();
  get_access_role_info(role_id);
});

function process_access_role(id){
  $.ajax({
      url: 'accessrole/process_access_role',
        method: 'POST',
        data: {id: id, rolename: $('#text_access_role').val(), description: $('#text_description').val()},
        dataType: 'JSON',
      success: function(result) {
        if (result == 1){
          $('#div_footer').html("<div style='100%' class='alert alert-success pull-left' id='div_message'>New access role created!</div>");
        }
        else if (result == 2){
          $('#div_footer').html("<div style='100%' class='alert alert-success pull-left' id='div_message'>Access role updated!</div>");
        }
        else{
          $('#div_footer').html("<div class='alert alert-danger pull-left' id='div_message'>Error during insertion!</div>");
        }
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
        $('#text_access_role').val(result['rolename']);
        $('#text_description').val(result['description']);
        $('#modal_add_update_role').modal('show'); 
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
}

function get_access_roles(){
  $.ajax({
      url: 'accessrole/get_access_roles',
        method: 'POST',
        dataType: 'JSON',
      success: function(result) {
        var data = JSON.parse(result);
        $.each(data, function(index, arr) {
          alert(arr[1]);
          //table.row.add( [ ++ctr, arr[1], arr[2], arr[3], '' ] ).draw();
          });
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
}