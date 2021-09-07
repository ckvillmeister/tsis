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
          $('#modal_message_box').modal('show');
          $('#modal_message_box #modal_title').html("Saved");
          $('#modal_message_box #modal_body').html("Your new settings has been saved!");
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during saving!");
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
        }
      },
      error: function(obj, err, ex){
        $('#modal_message_box').modal('show');
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
}

$('#btn_backup').click(function(e){
   $.ajax({
      url: 'settings/back_up_database',
      method: 'POST',
      success: function(result) {
        if (result == 1){
          $('#modal_message_box').modal('show');
          $('#modal_message_box #modal_title').html("Backed-up");
          $('#modal_message_box #modal_body').html("Your database has been backed-up!");
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during processing!");
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
        }
      },
      error: function(obj, err, ex){
        $('#modal_message_box').modal('show');
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
          $('#modal_message_box').modal('show');
          $('#modal_message_box #modal_title').html("Image");
          $('#modal_message_box #modal_body').html("Image has been saved!");
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during saving image!");
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
        }
      },
      error: function(obj, err, ex){
        $('#modal_message_box').modal('show');
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
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
          $('#modal_message_box').modal('show');
          $('#modal_message_box #modal_title').html("Image");
          $('#modal_message_box #modal_body').html("Image has been saved!");
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
        }
        else{
          $('#modal_message_box #modal_title').html("Error");
          $('#modal_message_box #modal_body').html("Error during saving image!");
          setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
        }
      },
      error: function(obj, err, ex){
        $('#modal_message_box').modal('show');
        $('#modal_message_box #modal_title').html("Error");
        $('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
        setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
    }
  })
});