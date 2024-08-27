<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/select2/css/select2.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <?php require 'app/views/components/navbar.php'; ?>
    <?php require 'app/views/components/sidebar.php'; ?>

      <style>
        /* #btn_view_leaders, #btn_search_leader, #btn_search_member, #btn_submit, #btn_delete_ward {
          width:160px;
          border-radius: 5px;
        } */

        #table_member_list{
          font-size: 10pt
        }

        .col-header {
          font-size: 10pt
        }
      </style>

      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Manage Supporters (Special Ops)</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>ward">Manage Supporters</a></li>
                  <li class="breadcrumb-item active">Special Ops</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">

            <div class="card card-info card-tabs">
              <div class="card-header p-0 pt-1">
              <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Add Suppoters</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Remove Supporters</a>
                </li>
              </ul>
              </div>
              <div class="card-body">
                <div class="overlay-wrapper"></div>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

                    <div class="row mb-3">
                      <div class="col-sm-2 align-self-center" style="vertical-align: middle;">
                        <b>Barangay</b>
                      </div>
                      <div class="col-sm-3">
                        <select class="form-control form-control-sm rounded-0" id="cbo_barangay" style="border: 0; outline: 0; border-bottom: 2px solid #17a2b8">
                          <option value="0"></option>
                            <?php 
                              $barangays = $data['barangay'];
                              foreach ($barangays as $key => $value) {
                            ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                            <?php
                              }
                            ?>
                        </select>
                      </div>
                      <div class="col-sm-7">
                        <div class="float-right">
                          <div class="btn-group">
                            <button class="btn btn-sm btn-secondary invisible" data-toggle="modal" data-target="#modal_voters_list" id="btn_search_voters" value='member'><icon class="fas fa-search mr-2"></icon>Search Voters</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-2 align-self-center" style="vertical-align: middle;">
                        <b>Party</b>
                      </div>
                      <div class="col-sm-3">
                        <select class="form-control form-control-sm rounded-0" id="cbo_party" style="border: 0; outline: 0; border-bottom: 2px solid #17a2b8">
                          <option value="0"></option>
                            <?php 
                              $parties = $data['parties'];
                              foreach ($parties as $key => $party) {
                            ?>
                            <option value="<?php echo $party['id']; ?>"><?php echo $party['name']; ?></option>
                            <?php
                              }
                            ?>
                        </select>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-2 align-self-center" style="vertical-align: middle;">
                        <b>Candidates</b>
                      </div>
                      <div class="col-sm-10">
                        <div class="select2-info">
                          <select class="form-control form-control-sm rounded-0" id="cbo_candidates" multiple="multiple" data-placeholder="Select a candidate/s" data-dropdown-css-class="select2-info" style="width: 100%; border: 0 !important; outline: 0 !important; border-bottom: 2px solid #17a2b8 !important">
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-sm-12">
                        <table class="table table-sm table-striped bg-white" id="table_specialops_list" style="width:100%">
                          <thead>
                            <tr>
                              <th class="text-center"style="width: 60px">No.</th>
                              <th class="text-center">Last Name</th>
                              <th class="text-center">First Name</th>
                              <th class="text-center">Middle Name</th>
                              <th class="text-center">Control</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="row m-3">
                      <div class="col-sm-12">
                        <div class="float-right">
                          <div class="btn-group">
                            <!-- <button class="btn btn-sm btn-secondary pl-3 pr-3 invisible" data-toggle="modal" id="btn_delete_ward"><icon class="fas fa-trash mr-2"></icon>Delete</button> -->
                            <button class="btn btn-sm btn-info pl-4 pr-4" id="btn_submit"><icon class="fas fa-save mr-2"></icon>Save</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    
                    <div class="row mb-3">
                      <div class="col-sm-2 align-self-center" style="vertical-align: middle;">
                        <b>Barangay</b>
                      </div>
                      <div class="col-sm-3">
                        <select class="form-control form-control-sm rounded-0" id="barangay" style="border: 0; outline: 0; border-bottom: 2px solid #17a2b8">
                          <option value="0"></option>
                            <?php 
                              $barangays = $data['barangay'];
                              foreach ($barangays as $key => $value) {
                            ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                            <?php
                              }
                            ?>
                        </select>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <div class="col-sm-2 align-self-center" style="vertical-align: middle;">
                        <b>Party</b>
                      </div>
                      <div class="col-sm-3">
                        <select class="form-control form-control-sm rounded-0" id="party" style="border: 0; outline: 0; border-bottom: 2px solid #17a2b8">
                          <option value="0"></option>
                            <?php 
                              $parties = $data['parties'];
                              foreach ($parties as $key => $party) {
                            ?>
                            <option value="<?php echo $party['id']; ?>"><?php echo $party['name']; ?></option>
                            <?php
                              }
                            ?>
                        </select>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-sm-12">
                        <table class="table table-sm table-striped bg-white" id="special_ops_list" style="width:100%">
                          <thead>
                            <tr>
                              <th class="text-center"style="width: 60px">No.</th>
                              <th class="text-center">Fullname</th>
                              <th class="text-center">Candidate c/o</th>
                              <th class="text-center">Control</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>

          </div>
        </section>
      </div>

      <!-- Modal Voters List -->
      <div class="modal fade" id="modal_voters_list" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_title">Voters List</h5>
            </div>
            <div class="modal-body">
              <table class="table table-sm table-bordered table-striped" id="table_voter_list" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-center" >#</th>
                    <th class="text-center" >First Name</th>
                    <th class="text-center" >Middle Name</th>
                    <th class="text-center" >Last Name</th>
                    <th class="text-center" >Control</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    <?php require 'app/views/components/footer_banner.php'; ?>
  </div>

</body>
<?php require 'app/views/components/footer.php'; ?>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/select2/js/select2.full.min.js"></script>
<script>

  var supporter_counter = 0;
  var dt_voterslist = $('#table_voter_list').DataTable({
        "order": [[ 3, "asc" ]],
        "ordering": false,
        "pageLength": 5,
        "deferRender": true,
        "responsive": true,
    columnDefs: [
      { className: 'text-center', targets: [0] },
      { className: 'text-center', targets: [3] },
      { className: 'text-center', targets: [4] }
    ]
    });

  $('#cbo_candidates').select2();

  $('#cbo_barangay').on('change', function() {
    var barangay = $('#cbo_barangay').val();

    if (barangay != 0) {
      get_voters(barangay);
      $('#btn_search_voters').removeClass('invisible');
    }
    else{
      $('#btn_search_voters').addClass('invisible');
    }
  });

  $('#barangay').on('change', function() {
    var party = $('#party').val();
    var barangay = $('#barangay').val();

    get_supporters(party, barangay);
  });

  $('#party').on('change', function() {
    var party = $('#party').val();
    var barangay = $('#barangay').val();

    get_supporters(party, barangay);
  });

  $('#cbo_party').on('change', function(){
    var party_id = $(this).val();

    $.ajax({
        url: 'slate',
          method: 'POST',
          data: {id: party_id, status: 1},
          dataType: 'JSON',
        success: function(result) {
          $('#cbo_candidates').empty();
          $.each(result, function(index, arr) {
            var fullname = arr['candidate']['lastname']+', '+arr['candidate']['firstname'];
            fullname = (arr['candidate']['middlename']) ? fullname+' '+arr['candidate']['middlename'] : fullname;
            
            $('#cbo_candidates').append("<option value='"+arr['candidate']['id']+"'>"+fullname.toUpperCase()+" ("+arr['position']+")"+"</option>");
          });
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

  $('#btn_submit').click(function(){
    var rows = $('#table_specialops_list tbody tr').length;
    var ctr = 0;
    var specials = [];
    var candidates = $('#cbo_candidates').val();
    var party = $('#cbo_party').val();
    var barangay = $('#cbo_barangay').val();
    
    if (rows == 0){
      Swal.fire({
        title: "Error",
        text: "Please select add at least one supporter!",
        icon: "error",
        confirmButtonColor: "#b34045",
      });
    }
    else if (candidates == '' || candidates == null){
      Swal.fire({
        title: "Error",
        text: "Please select at least one candidate for this special ops!",
        icon: "error",
        confirmButtonColor: "#b34045",
      });
    }
    else{
      $('#table_specialops_list tbody').find('tr').each(function(){
        var voterid = $(this).find('button').val();
          specials[ctr] = voterid;
          ctr++;
      });

      $.ajax({
        url: 'save_special_ops',
        method: 'POST',
        data: {candidates: candidates, specials: specials, barangay: barangay, party: party},
        dataType: 'html',
        success: function(result) {
          if (result == 1){
            Swal.fire({
              title: "Success",
              text: "Additional supporters succesfully saved!",
              icon: "success",
              confirmButtonColor: "#00939D",
            }).then((res) => {
              if (res.value) {
                location.reload();
              }
            });
          }
          else {
            Swal.fire({
              title: "Error",
              text: "Error during saving!",
              icon: "error",
              confirmButtonColor: "#b34045",
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
    
    //alert($('#cbo_candidates').val());
  });

  function get_voters(barangay){
    $.ajax({
      url: 'get_voters_list',
      method: 'POST',
      data: {barangay: barangay},
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
        var ctr=0;
        var data = JSON.parse(result);
        dt_voterslist.clear().draw();

            $.each(data, function(index, arr) {
              dt_voterslist.row.add( [ ++ctr, arr['firstname'] + ' ' + arr['suffix'], arr['middlename'], arr['lastname'], 
                '<button type="button" value="' + arr['id'] + '" class="btn btn-sm btn-info" onclick="addSpecialOps(this)" data-toggle="tooltip" data-placement="top" title="Add Member"><i class="fas fa-plus mr-2"></i>Add</button>'
              ] ).draw();
            });

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

  function addSpecialOps(e){
    var id = $(e).val();
    var firstname = $(e).closest("tr").find('td:eq(1)').text();
    var middlename = $(e).closest("tr").find('td:eq(2)').text();
    var lastname = $(e).closest("tr").find('td:eq(3)').text();
    var fullname = firstname + ' ' + middlename + ' ' + lastname;

    if (isSupporter(id, 'leader')){
      Swal.fire({
        title: "Warning",
        text: fullname + ' is already a ward leader!',
        icon: "warning",
        confirmButtonColor: "#fecf6d",
      });
      return;
    }
    else if (isSupporter(id, 'member')){
      var name = get_wardleader(id);
      Swal.fire({
        title: "Warning",
        text: fullname + ' is already a member of '+name+'!',
        icon: "warning",
        confirmButtonColor: "#fecf6d",
      });
    }
    else if (isSupporterExist(id)){
      Swal.fire({
        title: "Warning",
        text: fullname + ' is already added in the member list!',
        icon: "warning",
        confirmButtonColor: "#fecf6d",
      });
    }
    else{
      $('#table_specialops_list tbody').append('<tr><td class="text-center">'+ ++supporter_counter +'</td>'+
                    '<td>'+lastname+'</td>'+
                    '<td>'+firstname+'</td>'+
                    '<td>'+middlename+'</td>'+
                    '<td class="text-center"><button type="button" value="' + id + '" class="btn btn-sm btn-danger" id="btn_remove_member" data-toggle="tooltip" data-placement="top" title="Remove Supporter"><i class="fas fa-trash"></i></button></td></tr>');
    }
  }

  function isSupporter(id, position){
    var flag = false;

    $.ajax({
      url: 'check_if_supporter',
      method: 'POST',
      data: {id: id, position: position},
      async: false,
      dataType: 'JSON',
      success: function(result) {
        flag = result;
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

    return flag;
  }

  function get_wardleader(id){
    var name;
    $.ajax({
      url: 'get_wardleader',
      method: 'POST',
      data: {id: id},
      async: false,
      dataType: 'JSON',                                                                 
      success: function(result) {
        name = result['firstname']+' '+result['middlename']+' '+result['lastname']+' '+result['suffix'];
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
    return name;
  }

  function get_supporters(party, barangay){
    $.ajax({
      url: 'get_special_supporters',
      method: 'POST',
      data: {party: party, barangay: barangay},
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
        var ctr=0;
        var data = JSON.parse(result);
        $('#special_ops_list tbody').empty();

        $.each(data, function(index, arr) {
          var sfullname = arr['lastname']+', '+arr['firstname'];
          sfullname = (arr['middlename']) ? sfullname+' '+arr['middlename'] : $sfullname;
          var cfullname = arr['clastname']+', '+arr['cfirstname'];
          cfullname = (arr['cmiddlename']) ? cfullname+' '+arr['cmiddlename'] : $cfullname;

          $('#special_ops_list tbody').append('<tr>' +
                        '<td class="text-center">'+ ++ctr +'</td>' +
                        '<td>'+sfullname.toUpperCase()+'</td>' +
                        '<td>'+cfullname.toUpperCase()+'</td>' +
                        '<td class="text-center">'+
                          '<button type="button" class="btn btn-sm btn-danger" onclick="removeSupporter('+arr['id']+','+arr['cid']+')"><i class="fas fa-trash"></i></button>' +
                        '</td></tr>');
        });

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

  function isSupporterExist(id){
    var flag = false;

    $('#table_specialops_list tbody').find('tr').each(function(){
        var voterid = $(this).find('button').val();
        if(id == voterid){
            flag = true;
        }
    });

    if(flag){
      return true;
    }
    else{
      return false;
    }
  }

  function removeSupporter(supporter_id, candidate_id){
    var party = $('#party').val();
    var barangay = $('#barangay').val();

    Swal.fire({
      title: "Confirm",
      text: "This is an irreversible action. Are you sure you want to remove this supporter?",
      icon: "question",
      showCancelButton: true, 
      showConfirmButton: true,  
      confirmButtonColor: "#17a2b8"
    }).then((res) => {
      if (res.value) {
        $.ajax({
          url: 'remove_special_supporter',
          method: 'POST',
          data: {party_id: party, supporter_id: supporter_id, candidate_id: candidate_id},
          async: false,
          dataType: 'JSON',
          success: function(result) {
            get_supporters(party, barangay);
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
    });
  }
</script>
</html>
