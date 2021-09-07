var barangay_id = 0;

get_barangays(1);

$('#btn_submit').click(function(e){
  process_barangay(barangay_id);
  get_barangays(1);
});

$('#btn_new_barangay').click(function(e){
  barangay_id = 0
  $('#text_barangay').val('');
  $('#modal_barangay_form').modal('show');
});

$('#btn_active').click(function(e){
   get_barangays(1);
});

$('#btn_trash').click(function(e){
   get_barangays(0);
});

$('.btn_yes').click(function(e){
  toggle_barangay(barangay_id, 0);
  $('#modal_confirm').modal('hide');
  get_barangays(1);
});

$('body').on('click', '#btn_edit_brgy', function(e){
  barangay_id = $(this).val();
  get_barangay_info(barangay_id);
  $('#modal_barangay_form').modal('show');
});

$('body').on('click', '#btn_delete_brgy', function(e){
  barangay_id = $(this).val();
  $('#modal_confirm #modal_title').html("Confirm");
  $('#modal_confirm #modal_body').html("Are you sure you want to delete this barangay?");
  $('#modal_confirm').modal('show');
});

$('body').on('click', '#btn_activate_brgy', function(e){
  barangay_id = $(this).val();
  toggle_barangay(barangay_id, 1);
  $('#modal_confirm').modal('hide');
  get_barangays(0);
});

function process_barangay(id){
  $.ajax({
      url: 'process_barangay',
        method: 'POST',
        data: {id: id, 
               barangay: $('#text_barangay').val()
        },
      success: function(result) {
        if (result == 1){
          $('#modal_message_box #modal_title').html("New Barangay");
          $('#modal_message_box #modal_body').html("New barangay added!");
          $('#modal_message_box').modal('show');
          
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_barangay_form').modal('hide'); }, 3000);
        }
        else if (result == 2){
          $('#modal_message_box #modal_title').html("Barangay Updated");
          $('#modal_message_box #modal_body').html("Barangay info updated!");
          $('#modal_message_box').modal('show');

          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_barangay_form').modal('hide'); }, 3000);
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

function get_barangays(status){
  $.ajax({
      url: 'get_barangays',
        method: 'POST',
        data: {status: status},
        dataType: 'html',
      success: function(result) {
        $('#barangay_list').html(result);
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
}

function get_barangay_info(id){
  $.ajax({
      url: 'get_barangay_info',
        method: 'POST',
        data: {id: id},
        dataType: 'JSON',
      success: function(result) {
        $('#text_barangay').val(result['name']);
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
}

function toggle_barangay(id, status){
  $.ajax({
      url: 'toggle_barangay',
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