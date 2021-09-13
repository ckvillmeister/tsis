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
          $.alert({
            title: "Saved",
            type: "green",
            content: "Your new settings has been saved!"
          })
        }
        else{
          $.alert({
            title: "Error",
            type: "red",
            content: "Error during saving!"
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

$('#btn_backup').click(function(e){
   $.ajax({
      url: 'settings/back_up_database',
      method: 'POST',
      success: function(result) {
        if (result == 1){
          $.alert({
            title: "Successful",
            type: "green",
            content: "Your database has been backed-up!"
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
          $.alert({
            title: "Saved",
            type: "green",
            content: "System logo has been set!"
          })
        }
        else{
          $.alert({
            title: "Error",
            type: "red",
            content: "Error during saving!"
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
          $.alert({
            title: "Saved",
            type: "green",
            content: "Login background image has been set!"
          })
        }
        else{
          $.alert({
            title: "Error",
            type: "red",
            content: "Error during saving!"
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