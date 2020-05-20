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
		get_voters_list(barangay_id);
 		$('#modal_set_purok_leader').modal('show');
	}
});

$('body').on('click', '#btn_edit_leader', function(){
  	var barangay_id = $('#cbo_barangay').val();
  	if (barangay_id != '0'){
  		purok_no = $(this).val();
		get_voters_list(barangay_id);
 		$('#modal_set_purok_leader').modal('show');
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
