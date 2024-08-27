$('#btn_submit').click(function(e){
   save_settings($('#text_system_name').val(), $('#text_election_year').val());
});

function save_settings(systemname, electionyear){
  $.ajax({
      url: 'settings/save_settings',
      data: { name: systemname,
              year: electionyear
      },
      method: 'POST',
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Success",
            text: "New settings applied!",
            icon: "success",
            confirmButtonColor: "#00939D"
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error during saving!",
            icon: "error",
            confirmButtonColor: "#b34045"
          });
        }
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

$('#btn_backup').click(function(e){
   $.ajax({
      url: 'settings/back_up_database',
      method: 'POST',
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Success",
            text: "Database backup successfully created!",
            icon: "success",
            confirmButtonColor: "#00939D"
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error during creating a backup!",
            icon: "error",
            confirmButtonColor: "#b34045"
          });
        }
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

$('#btn_save_logo').click(function(e){
  e.preventDefault();

  var sys_logo = "System Logo";
  var file_data = $("#system_image")[0].files[0];   
  var form_data = new FormData();            
  form_data.append('file', file_data);

   $.ajax({
      url: 'settings/save_system_image?set_name='+sys_logo,
      method: 'POST',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Success",
            text: "System logo has been set!",
            icon: "success",
            confirmButtonColor: "#00939D"
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error during saving!",
            icon: "error",
            confirmButtonColor: "#b34045"
          });
        }
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

$('#btn_save_bg_image').click(function(e){
  e.preventDefault();

  var sys_logo = "Login Background Image";
  var file_data = $("#system_bg_image")[0].files[0];   
  var form_data = new FormData();            
  form_data.append('file', file_data);

   $.ajax({
      url: 'settings/save_system_image?set_name='+sys_logo,
      method: 'POST',
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Success",
            text: "Login background image has been set!",
            icon: "success",
            confirmButtonColor: "#00939D"
          });
        }
        else{
          Swal.fire({
            title: "Error",
            text: "Error during saving!",
            icon: "error",
            confirmButtonColor: "#b34045"
          });
        }
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