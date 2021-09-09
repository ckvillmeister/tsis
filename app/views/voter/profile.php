<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>

    <?php
      $profile = $data['profile'];
      $imgurl = ($profile['imgurl']) ? ROOT.$profile['imgurl'] : ROOT."public/image/avatar.png";
    ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Voter's Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>main">Main</a></li>
                <li class="breadcrumb-item active">Voter's Profile</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card">

            <div class="overlay-wrapper">
            
            </div>

             <div class="row p-3 shadow-none m-3 bg-light rounded">
              <div class="col-sm-12">
                    <div class="card card-widget widget-user">

                      <div class="widget-user-header bg-info">
                        <h1>Profile</h1>
                      </div>

                      <div class="widget-user-image">

                        <!--<form id="frm_upload_image">-->

                          <div class="row">
                            <div class="col-sm-12">
                              <img class="rounded border border-info" src="<?php echo $imgurl; ?>" width="120" height="150" id="img_supporter"><br>
                            </div>
                          </div>
                          <?php if ($accessrole_model->check_access($role, 'uploadprofileimage')): ?>
                          <div class="row">
                            <div class="col-sm-6">
                              <span class="btn btn-file btn-info col-sm-12 mt-1">
                                <span class="fileupload-new"><i class="fas fa-upload"></i></span>
                                <input type="file" id="profile_pic" name="profile_pic" class="" accept="image/*" onchange="image_preview(this);">
                              </span>
                            </div>
                            <div class="col-sm-6">
                              <button class="btn btn-file btn-primary col-sm-12 mt-1" id="btn_save_image"><i class="fas fa-save"></i></button>
                            </div>
                          </div>
                          <?php endif; ?>

                        <!--</form>-->

                      </div>
                      <br><br>
                      <div class="card-body mt-5">

                        <form id="frm">

                          <input type="hidden" id="voters_sys_id" name="voters_sys_id" value="<?php echo isset($_GET['voterid']) ? $_GET['voterid'] : ''; ?>">

                          <div class="row mt-5">
                            <div class="col-sm-4">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="firstname" name="firstname" placeholder="Firstname" value="<?php echo $profile['firstname'] ?>">
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="middlename" name="middlename" placeholder="Middlename" value="<?php echo $profile['middlename'] ?>">
                              </div>
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="lastname" name="lastname" placeholder="Lastname" value="<?php echo $profile['lastname'] ?>">
                              </div>
                            </div>
                            <div class="col-sm-1">
                              <div class="form-group">
                                <select id="suffix" name="suffix" class="form-control form-control-sm">
                                  <option value=""></option>
                                  <option value="JR." <?php echo ($profile['suffix'] == "JR.") ? "Selected" : ""; ?>>JR.</option>
                                  <option value="SR." <?php echo ($profile['suffix'] == "SR.") ? "Selected" : ""; ?>>SR.</option>
                                  <option value="I" <?php echo ($profile['suffix'] == "I") ? "Selected" : ""; ?>>I</option>
                                  <option value="II" <?php echo ($profile['suffix'] == "II") ? "Selected" : ""; ?>>II</option>
                                  <option value="III" <?php echo ($profile['suffix'] == "III") ? "Selected" : ""; ?>>III</option>
                                  <option value="IV" <?php echo ($profile['suffix'] == "IV") ? "Selected" : ""; ?>>IV</option>
                                  <option value="V" <?php echo ($profile['suffix'] == "V") ? "Selected" : ""; ?>>V</option>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select class="form-control form-control-sm" id="barangay" name="barangay">
                                  <option value=""> [ Barangay ] </option>
                                  <?php 
                                    foreach ($data['barangay'] as $key => $barangay) {
                                  ?>
                                      <option value="<?php echo $barangay['id']; ?>" <?php echo ($profile['barangayid'] == $barangay['id']) ? "Selected" : ""; ?>><?php echo ucwords(strtolower($barangay['name'])) ?></option>
                                  <?php
                                    }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select class="form-control form-control-sm" id="purok_no" name="purok_no">
                                  <option value=""> [ Purok ] </option>
                                  <option value="1" <?php echo ($profile['purokno'] == "1") ? "Selected" : ""; ?>> 1 </option>
                                  <option value="2" <?php echo ($profile['purokno'] == "2") ? "Selected" : ""; ?>> 2 </option>
                                  <option value="3" <?php echo ($profile['purokno'] == "3") ? "Selected" : ""; ?>> 3 </option>
                                  <option value="4" <?php echo ($profile['purokno'] == "4") ? "Selected" : ""; ?>> 4 </option>
                                  <option value="5" <?php echo ($profile['purokno'] == "5") ? "Selected" : ""; ?>> 5 </option>
                                  <option value="6" <?php echo ($profile['purokno'] == "6") ? "Selected" : ""; ?>> 6 </option>
                                  <option value="7" <?php echo ($profile['purokno'] == "7") ? "Selected" : ""; ?>> 7 </option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <input type="date" class="form-control form-control-sm" id="birthdate" name="birthdate" value="<?php echo $profile['birthdate'] ?>">
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <select class="form-control form-control-sm" id="gender" name="gender">
                                  <option value=""> [ Sex ] </option>
                                  <option value="Male" <?php echo ($profile['gender'] == "Male") ? "Selected" : ""; ?>>Male</option>
                                  <option value="Female" <?php echo ($profile['gender'] == "Female") ? "Selected" : ""; ?>>Female</option>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="vin" name="vin" placeholder="Voter's Identification Number" value="<?php echo $profile['vin'] ?>">
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="vno" name="vno" placeholder="Voter's Sequence Number" value="<?php echo $profile['votersno'] ?>">
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="precinct_no" name="precinct_no" placeholder="Precinct Number" value="<?php echo $profile['precinctno'] ?>">
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <input type="text" class="form-control form-control-sm" id="cluster_no" name="cluster_no" placeholder="Cluster Number" value="<?php echo $profile['clusterno'] ?>">
                              </div>
                            </div>
                          </div>

                          <div class="float-right">
                            <?php if ($accessrole_model->check_access($role, 'saveprofile')): ?>
                            <button class="btn btn-md btn-primary" id="" value=""><i class="fas fa-save mr-2"></i>Save</button>
                            <?php endif; ?>
                          </div>

                        </form>

                      </div>
                      <!-- <div class="card-footer">
                        
                      </div> -->
                  </div>
                </div>
            </div>

          </div>    
        </div>
      </section>
    </div>

   <?php require 'app/views/components/footer_banner.php'; ?>
</div>

</body>
<?php require 'app/views/components/footer.php'; ?>
<script type="text/javascript">
  
  function image_preview(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#img_supporter')
            .attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    } 
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
        url: 'save_voter_profile',
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
              content: "Error during processing..."
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

</script>
</html>