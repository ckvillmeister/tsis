var purok_no;

$('#btn_submit').click(function(){
	var barangay_id = $('#cbo_barangay').val();
	
	if (barangay_id != '0'){
		get_purok_leaders(barangay_id);
	}
})

$('body').on('click', '#btn_set_leader', function(){
  	var barangay_id = $('#cbo_barangay').val();
  	if (barangay_id != '0'){
  		purok_no = $(this).val();
		$('#modal_set_purok_leader').modal('show');
    get_voters_list(barangay_id);
	}
});

$('body').on('click', '#btn_edit_leader', function(){
  	var barangay_id = $('#cbo_barangay').val();
  	if (barangay_id != '0'){
  		purok_no = $(this).val();
		$('#modal_set_purok_leader').modal('show');
    get_voters_list(barangay_id);
	}
});

$('#btn_yes').click(function(){
	var barangay_id = $('#cbo_barangay').val();
  	if (barangay_id != '0'){
  		set_purok_leader(voters_id, barangay_id, purok_no);
    	$('#modal_confirm_purok_leader').modal('toggle');
      	$('#modal_set_purok_leader').modal('toggle');
  	}
});

function get_purok_leaders(barangay_id){
  	$.ajax({
		url: 'get_purok_leaders',
		method: 'POST',
		data: {barangay_id: barangay_id},
		dataType: 'html',
		success: function(result) {
			$('#purok_leaders').html('');
			$('#purok_leaders').html(result);
		},
		error: function(obj, err, ex){
		
    	}
  	})
}

function get_voters_list(barangay_id){
  $.ajax({
    url: 'get_voters_list',
    method: 'POST',
    data: {barangay: barangay_id, level: 'purok'},
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
    
    }
  })
}

function set_purok_leader(voters_id, barangay_id, purok_no){
  $.ajax({
    url: 'set_purok_leader',
    method: 'POST',
    data: {voters_id: voters_id, barangay_id: barangay_id, purok_no: purok_no},
    dataType: 'html',
    success: function(result) {
      $('#purok_leaders').html(result);
    },
    error: function(obj, err, ex){
    
    }
  })
}
