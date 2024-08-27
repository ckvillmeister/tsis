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

$('body').on('click', '#btn_select', function(){
  voters_id = $(this).val();
  var fullname = $(this).closest("tr").find('td:eq(2)').text() + ' ' + $(this).closest("tr").find('td:eq(3)').text() + ' ' + $(this).closest("tr").find('td:eq(1)').text();
  
  Swal.fire({
    title: "Confirm",
    text: "Are you sure you want to select " + fullname + " as purok leader?",
    icon: "question",
    showCancelButton: true, 
    showConfirmButton: true,  
    confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      var barangay_id = $('#cbo_barangay').val();
      if (barangay_id != '0'){
        set_purok_leader(voters_id, barangay_id, purok_no);
        $('#modal_set_purok_leader').modal('toggle');
      }
    }
  });
});

$('body').on('click', '#btn_remove_leader', function(){
  var barangay_id = $('#cbo_barangay').val();
  var purok = $(this).closest("tr").find('td:eq(0)').text();
  var fullname = $(this).closest("tr").find('td:eq(1)').text();

  Swal.fire({
    title: "Confirm",
    text: "Are you sure you want to remove " + fullname + " as a purok leader?",
    icon: "question",
    showCancelButton: true, 
    showConfirmButton: true,  
    confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      remove_purok_leader(barangay_id, purok);
    }
  });
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
      Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
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
      Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
    }
  })
}

function remove_purok_leader(barangay_id, purok){
  $.ajax({
    url: 'remove_purok_leader',
    method: 'POST',
    data: {barangay_id: barangay_id, purok: purok},
    dataType: 'html',
    success: function(result) {
      $('#purok_leaders').html(result);
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
