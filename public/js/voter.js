
$('#btn_show_all').click(function(){
  get_voters_list();
});

$('#btn_filter').click(function(){
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

$('body').on('click', '#add', function(){
  $('#voters_sys_id').val('');
  $('#vin').val('');
  $('#vno').val('');
  $('#firstname').val('');
  $('#middlename').val('');
  $('#lastname').val('');
  $('#suffix').val('');
  $('#precinct_no').val('');
  $('#cluster_no').val('');
  $('#purok_no').val('');
  $('#barangay').val('');
  $('#birthdate').val('');
  $('#gender').val('');

  $('#modal_voters_form').modal({
      backdrop: 'static',
      keyboard: true, 
      show: true
  });
});

$('body').on('click', '#edit', function(){
  var id = $(this).val();
  $('#voters_sys_id').val(id);
  $('#senior').bootstrapSwitch('state', false);
  $('#pensioner').bootstrapSwitch('state', false);
  $('#uct').bootstrapSwitch('state', false);
  $('#nhts').bootstrapSwitch('state', false);
  $('#pwd').bootstrapSwitch('state', false);
  $('#fourps').bootstrapSwitch('state', false);
  $("#new_voter").bootstrapSwitch('state', false);
  $('#new_affiliation').bootstrapSwitch('state', false);

  $.ajax({
    url: 'voter/get_voter_info',
    method: 'POST',
    data: { id: id },
    dataType: 'JSON',
    success: function(result) {
      $('#vin').val(result['vin']);
      $('#vno').val(result['votersno']);
      $('#firstname').val(result['firstname']);
      $('#middlename').val(result['middlename']);
      $('#lastname').val(result['lastname']);
      $('#suffix').val(result['suffix']);
      $('#precinct_no').val(result['precinctno']);
      $('#cluster_no').val(result['clusterno']);
      $('#purok_no').val(result['purokno']);
      $('#barangay').val(result['barangayid']);
      $('#birthdate').val(result['birthdate']);
      $('#gender').val(result['gender']);
      $('#contact').val(result['contact']);
      $('#work').val(result['work']);
      $('#organization').val(result['org']);
      $('#remarks').val(result['remarks']);

      if(result['senior']){
        $("#senior").bootstrapSwitch('state', true);
      }

      if(result['pensioner']){
        $("#pensioner").bootstrapSwitch('state', true);
      }

      if(result['uct']){
        $("#uct").bootstrapSwitch('state', true);
      }

      if(result['nhts']){
        $("#nhts").bootstrapSwitch('state', true);
      }

      if(result['pwd']){
        $("#pwd").bootstrapSwitch('state', true);
      }

      if(result['fourps']){
        $("#fourps").bootstrapSwitch('state', true);
      } 

      if(result['new_voter']){
        $("#new_voter").bootstrapSwitch('state', true);
        // $('#new_voter').prop('checked', true);
      } 

      if(result['new_affiliation']){
        $("#new_affiliation").bootstrapSwitch('state', true);
        // $('#new_voter').prop('checked', true);
      } 

      $('#modal_voters_form').modal({
        backdrop: 'static',
        keyboard: true, 
        show: true
      });


    },
    error: function(obj, err, ex){
      $.alert({
          title: "Error",
          type: "red",
          content: msg + ": " + obj.status + " " + exception
        })
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
          $.alert({
            title: "Saved",
            type: "green",
            content: "Image has been saved!"
          })
      	}
      	else{
          $.alert({
            title: "Error",
            type: "red",
            content: "Error during processing!"
          })
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
    data: {'brgy': $('#brgy').val()},
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

$('body').on('submit', '#frm', function(e){
    e.preventDefault();

    var fname = $('#firstname').val(),
        lname = $('#lastname').val(),
        barangay = $('#barangay').val();

    if (fname === ''){
      $.alert({
        title: "Empty",
        type: "red",
        content: "Please provide voter's firstname!"
      })
    }
    else if (lname === ''){
      $.alert({
        title: "Empty",
        type: "red",
        content: "Please provide voter's lastname!"
      })
    }
    else if (barangay === 0){
      $.alert({
        title: "Empty",
        type: "red",
        content: "Please select barangay!"
      })
    }
    else{
      $.ajax({
        url: 'voter/save_voter_profile',
        method: 'POST',
        data: $(this).serialize(),
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
          if (result == 1){
            $.alert({
              title: "Saved",
              type: "green",
              content: "Voter's information successfully saved!"
            })

            get_voters_list(1);
          }
          else if (result == 2){
            $.alert({
              title: "Updated",
              type: "green",
              content: "Voter's information successfully updated!"
            })
          }
          else{
            $.alert({
              title: "Error",
              type: "red",
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

});

