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
  $('#modal_confirm #modal_title').html("Confirm");
  $('#modal_confirm #modal_body').html("Are you sure you want to delete this candidate?");
  $('#modal_confirm').modal('show');
});

$('body').on('click', '#btn_activate_candidate', function(e){
  candidate_id = $(this).val();
  toggle_candidate(candidate_id, 1);
  $('#modal_confirm').modal('hide');
  get_candidates(0);
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
          $('#modal_message_box #modal_title').html("New candidate");
          $('#modal_message_box #modal_body').html("New candidate added!");
          $('#modal_message_box').modal('show');
          
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_candidate_form').modal('hide'); }, 3000);
        }
        else if (result == 2){
          $('#modal_message_box #modal_title').html("Candidate Updated");
          $('#modal_message_box #modal_body').html("Candidate information updated!");
          $('#modal_message_box').modal('show');

          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_candidate_form').modal('hide'); }, 3000);
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during submission. . .");
          $('#modal_message_box').modal('show');
        }
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
          $('#modal_message_box #modal_title').html("New Election Result");
          $('#modal_message_box #modal_body').html("New election result added!");
          $('#modal_message_box').modal('show');
          
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_candidate_form').modal('hide'); }, 3000);
          setTimeout(function(){ location.reload(); }, 4000);
        }
        else if (result == 2){
          $('#modal_message_box #modal_title').html("Election Result Updated");
          $('#modal_message_box #modal_body').html("Election result updated!");
          $('#modal_message_box').modal('show');

          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_candidate_form').modal('hide'); }, 3000);
          setTimeout(function(){ location.reload(); }, 4000);
        }
        else if (result == 3){
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Election result already exist!");
          $('#modal_message_box').modal('show');

          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
          setTimeout(function(){ $('#modal_candidate_form').modal('hide'); }, 3000);
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during submission. . .");
          $('#modal_message_box').modal('show');
        }
      },
      error: function(obj, err, ex){
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })

});

$('body').on('click', '#btn_delete_result', function(e){
  candidate_record_id = $(this).val();
  $('#modal_confirm #modal_title').html("Confirm");
  $('#modal_confirm #modal_body').html("Are you sure you want to delete this record?");
  $('#modal_confirm').modal('show');
});

$('body').on('click', '#btn_activate_result', function(e){
  toggle_election_result_record($(this).val(), 1);
});

$('.btn_yes').click(function(e){
  toggle_election_result_record(candidate_record_id, 0);
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
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
}
