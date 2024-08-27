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

$('body').on('click', '#btn_edit_candidate', function(e){
  candidate_id = $(this).val();
  get_candidate_info(candidate_id);
  $('#modal_candidate_form').modal('show');
});

$('body').on('click', '#btn_delete_candidate', function(e){
  var politician_id = $(this).val();

  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to delete this candidate?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_candidate(politician_id, 0);
      get_candidates(1);
    }
  });
});

$('body').on('click', '#btn_activate_candidate', function(e){
  var politician_id = $(this).val();

  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to re-activate this candidate?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_candidate(politician_id, 1);
      get_candidates(0);
    }
  });
});

function process_candidate(id){
  $.ajax({
      url: 'politics/process_candidate',
        method: 'POST',
        data: {id: id, 
          firstname: $('#text_firstname').val(), 
          middlename: $('#text_middlename').val(),
          lastname: $('#text_lastname').val(),
          isallied: $('#cbo_isallied').val()
        },
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Success",
            text: "New candidate info successfully added!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_candidate_form').modal('toggle');
            }
          });
        }
        else if (result == 2){
          Swal.fire({
            title: "Success",
            text: "Candidate info successfully updated!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_candidate_form').modal('toggle');
            }
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error during saving!",
            icon: "error",
            confirmButtonColor: "#b34045"
          }).then((res) => {
            if (res.value) {
              $('#modal_candidate_form').modal('toggle');
            }
          });
        }

        get_candidates(1);
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

function get_candidates(status){
  $.ajax({
      url: 'politics/get_candidates',
        method: 'POST',
        data: {status: status},
        dataType: 'html',
      success: function(result) {
        $('#candidates_list').html(result);
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

function get_candidate_info(id){
  $.ajax({
      url: 'politics/get_candidate_info',
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
        Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
    }
  })
}

function toggle_candidate(id, status){
  $.ajax({
      url: 'politics/toggle_candidate',
        method: 'POST',
        data: {id: id, status: status},
        dataType: 'html',
      success: function(result) {
        
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
               year: $('#text_year').val(),
               record_id: candidate_record_id
             },
        dataType: 'html',
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Election Result",
            text: "New election result added!",
            icon: "success",
            confirmButtonColor: "#00939D"
          });
        }
        else if (result == 2){
          Swal.fire({
            title: "Election Result Update",
            text: "Election result updated!",
            icon: "success",
            confirmButtonColor: "#00939D"
          });
        }
        else if (result == 3){
          Swal.fire({
            title: "Error",
            text: "Election result already exist!",
            icon: "error",
            confirmButtonColor: "#b34045"
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error during processing!",
            icon: "error",
            confirmButtonColor: "#b34045"
          });
        }

        $('#modal_election_result_add').modal('hide');
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
        Swal.fire({
          title: "Error",
          text: err + ": " + obj.status + " " + ex,
          icon: "error",
          confirmButtonColor: "#b34045",
        });
    }
  })

});

$('body').on('click', '#btn_delete_result', function(e){
  candidate_record_id = $(this).val();

  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to delete this record?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_election_result_record(candidate_record_id, 0);
    }
  });
});

$('body').on('click', '#btn_activate_result', function(e){
  candidate_record_id = $(this).val();

  Swal.fire({
      title: "Confirm",
      text: "Are you sure you want to re-active this record?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
  }).then((res) => {
    if (res.value) {
      toggle_election_result_record(candidate_record_id, 1);
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
        setTimeout(function(){ location.reload(); }, 500);
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
