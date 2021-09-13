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

$('body').on('click', '#btn_edit_brgy', function(e){
  barangay_id = $(this).val();
  get_barangay_info(barangay_id);
  $('#modal_barangay_form').modal('show');
});

$('body').on('click', '#btn_delete_brgy', function(e){
  barangay_id = $(this).val();
  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to delete this barangay?",
      buttons: {
          ok: function () {
            toggle_barangay(barangay_id, 0);
            get_barangays(1);
          },
          cancel: function () {
              
          }
      }
  });
});

$('body').on('click', '#btn_activate_brgy', function(e){
  barangay_id = $(this).val();
  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to re-activate this barangay?",
      buttons: {
          ok: function () {
            toggle_barangay(barangay_id, 1);
            get_barangays(0);
          },
          cancel: function () {
              
          }
      }
  });
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
          $.alert({
            title: "Saved",
            type: "green",
            content: "New barangay successfully saved!"
          })
        }
        else if (result == 2){
          $.alert({
            title: "Updated",
            type: "green",
            content: "Barangay info successfully updated!"
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
        $.alert({
            title: "Error",
            type: "red",
            content: msg + ": " + obj.status + " " + exception
          })
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
        $.alert({
            title: "Error",
            type: "red",
            content: msg + ": " + obj.status + " " + exception
          })
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
        $.alert({
            title: "Error",
            type: "red",
            content: msg + ": " + obj.status + " " + exception
          })
    }
  })
}