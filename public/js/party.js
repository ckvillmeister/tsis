retrieve_political_parties(1);

$('#btn_active').on('click', function(){
  retrieve_political_parties(1);
});

$('#btn_trash').on('click', function(){
  retrieve_political_parties(0);
});

$('#frmParty').on('submit', function(e){
	e.preventDefault();

  $.ajax({
      url: 'store_party',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'html',
      success: function(result) {
        if (result == 1){
          Swal.fire({
            title: "Success",
            text: "New political party successfully created!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_party_form').modal('toggle');
            }
          });
        }
        else if (result == 2){
          Swal.fire({
            title: "Success",
            text: "Political party successfully updated!",
            icon: "success",
            confirmButtonColor: "#00939D"
          }).then((res) => {
            if (res.value) {
              $('#modal_party_form').modal('toggle');
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
              $('#modal_party_form').modal('toggle');
            }
          });
        }

        retrieve_political_parties(1);
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

function retrieve_political_parties(status){
  $.ajax({
      url: 'get_parties',
        method: 'POST',
        data: {status: status},
        dataType: 'html',
      success: function(result) {
        $('#parties').html(result);
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