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
  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to delete this barangay?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_barangay(barangay_id, 0);
      get_barangays(1);
    }
  });
});

$('body').on('click', '#btn_activate_brgy', function(e){
  barangay_id = $(this).val();
  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to re-activate this barangay?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_barangay(barangay_id, 1);
      get_barangays(0);
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
          Swal.fire({
            title: "Success",
            text: "New barangay successfully created!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_barangay_form').modal('toggle');
            }
          });
        }
        else if (result == 2){
          Swal.fire({
            title: "Success",
            text: "Barangay successfully updated!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_barangay_form').modal('toggle');
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
              $('#modal_barangay_form').modal('toggle');
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
        Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
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
        Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
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
        Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
    }
  })
}