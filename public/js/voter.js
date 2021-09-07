
$('#btn_show_all').click(function(){
  get_voters_list();
});

$('#btn_save').click(function(){
    $.ajax({
      url: 'save_voter_profile',
      method: 'POST',
      data: { id: $(this).val(),
              fname: $('#text_firstname').val(),
              mname: $('#text_middlename').val(),
              lname: $('#text_lastname').val(),
              ext: $('#cbo_extension').val(),
              barangay: $('#cbo_barangay').val(),
              purok: $('#cbo_purok').val(),
              sex: $('#cbo_sex').val(),
              vin: $('#ctext_vin').val(),
              vno: $('#text_vno').val(),
              precinctno: $('#text_precinctno').val(),
              clusterno: $('#text_clusterno').val()
            },
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
        //$('#report').html(result);
      },
      error: function(obj, err, ex){
        
      }
    })
});

$('#btn_save_image').click(function(e) {
	e.preventDefault();

	var file_data = $("#profile_pic")[0].files[0];   
    var form_data = new FormData();
    var voter_id = $('#btn_save').val();             
    form_data.append('file', file_data);
	
	$.ajax({
      url: 'save_image?id='+voter_id,
      method: 'POST',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function(result) {
      	if (result == 1){
      		$('#modal_message_box #modal_title').html("Info");
			$('#modal_message_box #modal_body').html("Image has been saved!");
			$('#modal_message_box').modal('show');
      	}
      	else{
      		$('#modal_message_box #modal_title').html("Error");
			$('#modal_message_box #modal_body').html("Error during saving. . .");
			$('#modal_message_box').modal('show');
      	}
        
      },
      error: function(obj, err, ex){
        
      }
    })
});

//Function: Get voters list 
function get_voters_list(){
	$.ajax({
		url: 'voter/get_voters_list',
		method: 'POST',
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

