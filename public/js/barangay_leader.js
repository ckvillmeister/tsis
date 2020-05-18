get_barangay_leaders();

$('body').on('click', '#btn_set_leader', function(){
  $('#modal_set_barangay_leader').modal('show');
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