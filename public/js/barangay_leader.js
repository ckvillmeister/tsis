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

$('#btn_yes').click(function(){
      set_barangay_leader(voters_id, barangay_id);
      $('#modal_confirm_barangay_leader').modal('toggle');
      $('#modal_set_barangay_leader').modal('toggle');
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
      }
  })
}

function get_voters_list(barangay_id){
  $.ajax({
    url: 'get_voters_list',
    method: 'POST',
    data: {barangay: barangay_id, level: 'barangay'},
    dataType: 'html',
    success: function(result) {
      $('#voters_list').html(result);
    },
    error: function(obj, err, ex){
    
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
    
    }
  })
}
