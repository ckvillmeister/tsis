var voter;
var barangay_id;

get_barangay_leaders();

$('body').on('click', '#btn_set_leader', function(){
  barangay_id = $(this).val();
  get_voters_list(barangay_id);
  $('#modal_set_barangay_leader').modal('show');
});

$('body').on('click', '#btn_edit_leader', function(){
  barangay_id = $(this).val();
  get_voters_list(barangay_id);
  $('#modal_set_barangay_leader').modal('show');
});

$('body').on('click', '#btn_select', function(){
  voters_id = $(this).val();
  var fullname = $(this).closest("tr").find('td:eq(3)').text() + ', ' + $(this).closest("tr").find('td:eq(1)').text() + ' ' + $(this).closest("tr").find('td:eq(2)').text();
  
  Swal.fire({
    title: "Confirm",
    text: "Are you sure you want to select " + fullname + " as barangay leader?",
    icon: "question",
    showCancelButton: true, 
    showConfirmButton: true,  
    confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      set_barangay_leader(voters_id, barangay_id);
      $('#modal_set_barangay_leader').modal('toggle');
    }
  });
});

$('body').on('click', '#btn_remove_leader', function(){
  var barangay_id = $(this).val();
  var barangay = $(this).closest("tr").find('td:eq(1)').text();
  var fullname = $(this).closest("tr").find('td:eq(2)').text();

  Swal.fire({
    title: "Confirm",
    text: "Are you sure you want to remove " + fullname + " as barangay leader for " + barangay + "?",
    icon: "question",
    showCancelButton: true, 
    showConfirmButton: true,  
    confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      remove_barangay_leader(barangay_id);
    }
  });
});


function get_barangay_leaders(){
  $.ajax({
      url: 'get_barangay_leaders',
        method: 'POST',
        dataType: 'html',
      success: function(result) {
        $('#barangay_leaders').html(result);
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

function get_voters_list(barangay_id){
  $.ajax({
    url: 'get_voters_list',
    method: 'POST',
    data: {barangay: barangay_id, level: 'barangay'},
    dataType: 'html',
    beforeSend: function() {
        $('.overlay-wrapper').html('<div class="overlay">' +
                  '<i class="fas fa-3x fa-sync-alt fa-spin"></i>' +
                  '<div class="text-bold pt-2">Loading...</div>' +
                      '</div>');
    },
    complete: function(){
        $('.overlay-wrapper').html('');
    }, 
    success: function(result) {
      $('#voters_list').html(result);
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

function set_barangay_leader(voters_id, barangay_id){
  $.ajax({
    url: 'set_barangay_leader',
    method: 'POST',
    data: {voters_id: voters_id, barangay_id: barangay_id},
    dataType: 'html',
    success: function(result) {
      $('#barangay_leaders').html(result);
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

function remove_barangay_leader(barangay_id){
  $.ajax({
    url: 'remove_barangay_leader',
    method: 'POST',
    data: {barangay_id: barangay_id},
    dataType: 'html',
    success: function(result) {
      $('#barangay_leaders').html(result);
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
