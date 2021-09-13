var candidate_id = 0, candidate_record_id = 0;

get_candidates(1);

$('#btn_submit').click(function(e){
  process_candidate(candidate_id);
  get_candidates(1);
});

$('#btn_new_candidate').click(function(e){
  candidate_id = 0;
   $('#text_candidatename').val('');
   $('#text_description').val('');
});

$('#btn_active').click(function(e){
   get_candidates(1);
});

$('#btn_trash').click(function(e){
   get_candidates(0);
});

$('.btn_yes').click(function(e){
  toggle_candidate(candidate_id, 0);
  $('#modal_confirm').modal('hide');
  get_candidates(1);
});

$('body').on('click', '#btn_edit_candidate', function(e){
  candidate_id = $(this).val();
  get_candidate_info(candidate_id);
  $('#modal_candidate_form').modal('show');
});

$('body').on('click', '#btn_delete_candidate', function(e){
  candidate_id = $(this).val();

  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to delete this candidate?",
      buttons: {
          ok: function () {
            toggle_candidate(candidate_id, 0);
            get_candidates(1);
          },
          cancel: function () {
              
          }
      }
  });
});

$('body').on('click', '#btn_activate_candidate', function(e){
  candidate_id = $(this).val();

  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to re-activate this candidate?",
      buttons: {
          ok: function () {
            toggle_candidate(candidate_id, 1);
            get_candidates(0);
          },
          cancel: function () {
              
          }
      }
  });
});

function process_candidate(id){
  $.ajax({
      url: 'candidates/process_candidate',
        method: 'POST',
        data: {id: id, 
          firstname: $('#text_firstname').val(), 
          middlename: $('#text_middlename').val(),
          lastname: $('#text_lastname').val(),
          isallied: $('#cbo_isallied').val()
        },
      success: function(result) {
        if (result == 1){
          $.alert({
            title: "Saved",
            type: "green",
            content: "New candidate added successfully!"
          })
        }
        else if (result == 2){
          $.alert({
            title: "Updated",
            type: "green",
            content: "Candidate information updated successfully!"
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

function get_candidates(status){
  $.ajax({
      url: 'candidates/get_candidates',
        method: 'POST',
        data: {status: status},
        dataType: 'html',
      success: function(result) {
        $('#candidates_list').html(result);
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

function get_candidate_info(id){
  $.ajax({
      url: 'candidates/get_candidate_info',
        method: 'POST',
        data: {id: id},
        dataType: 'JSON',
      success: function(result) {
        $('#text_firstname').val(result['firstname']);
        $('#text_middlename').val(result['middlename']);
        $('#text_lastname').val(result['lastname']);
        $('#cbo_isallied').val(result['isallied']);
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

function toggle_candidate(id, status){
  $.ajax({
      url: 'candidates/toggle_candidate',
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

$('#btn_new_record').click(function(e){
  candidate_record_id = 0;
  $('#modal_election_result_add').modal('show');
});

$('#btn_add_vote_record').click(function(e){
  $.ajax({
      url: 'process_vote_record',
        method: 'POST',
        data: {id: $(this).val(),
               barangay: $('#cbo_barangay').val(),
               votes: $('#text_votes_received').val(),
               position: $('#text_position').val(),
               level: $('#text_level').val(),
               party: $('#text_party').val(),
               year: $('#text_year').val(),
               record_id: candidate_record_id
             },
        dataType: 'html',
      success: function(result) {
        if (result == 1){
          $.alert({
            title: "Election Result",
            type: "green",
            content: "New election result added!"
          })
        }
        else if (result == 2){
          $.alert({
            title: "Election Result Update",
            type: "green",
            content: "Election result updated!"
          })
        }
        else if (result == 3){
          $.alert({
            title: "Error",
            type: "green",
            content: "Election result already exist!"
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
});

$('body #tbl_result_list').on('click', '#btn_edit_result', function(e){
  candidate_record_id = $(this).val();

  $.ajax({
      url: 'get_voter_record_info',
        method: 'POST',
        data: {id: $(this).val()},
        dataType: 'JSON',
      success: function(result) {
        $('#cbo_barangay').val(result['barangay']);
        $('#text_votes_received').val(result['votes']);
        $('#text_year').val(result['year']);
        $('#modal_election_result_add').modal('show');
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

$('body').on('click', '#btn_delete_result', function(e){
  candidate_record_id = $(this).val();

  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to delete this record?",
      buttons: {
          ok: function () {
            toggle_election_result_record(candidate_record_id, 0);
          },
          cancel: function () {
              
          }
      }
  });
});

$('body').on('click', '#btn_activate_result', function(e){
  candidate_record_id = $(this).val();

  $.confirm({
      title: 'Confirm',
      type: 'blue',
      content: "Are you sure you want to re-activate this record?",
      buttons: {
          ok: function () {
            toggle_election_result_record(candidate_record_id, 1);
          },
          cancel: function () {
              
          }
      }
  });
});

function toggle_election_result_record(id, status){
  $.ajax({
      url: 'toggle_election_result',
        method: 'POST',
        data: {id: id, status: status},
        dataType: 'html',
      success: function(result) {
        setTimeout(function(){ location.reload(); }, 2000);
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
