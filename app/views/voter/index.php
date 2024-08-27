<!DOCTYPE html>

<html>
<head>
  <?php require 'app/views/components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Voters List</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Voter</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card">

            <div class="row shadow-none m-3 rounded">
              <div class="col-lg-2">
                  <select class="form-control form-control-sm" id="brgy" name="brgy">
                    <option value="0">[ Select Barangay ]</option>
                    <?php
                      foreach ($data['barangays'] as $key => $barangay) {
                    ?>
                    <option value="<?php echo $barangay['id']; ?>"><?php echo ucwords(strtolower($barangay['name'])); ?></option>
                    <?php
                      }
                    ?>
                  </select>
              </div>
              <div class="col-lg-10 align-self-center">
                <div class="btn-group">
                  <button class="btn btn-sm btn-primary" id="btn_filter"><icon class="fas fa-filter mr-4"></icon>Filter</button>
                  <button class="btn btn-sm btn-secondary" id="btn_show_all"><icon class="fas fa-list mr-2"></icon>Show All</button>
                  <button class="btn btn-sm btn-success" id="add"><icon class="fas fa-plus mr-2"></icon>New Voter</button>
                </div>
              </div>
            </div>
          
            <div class="overlay-wrapper">
            
            </div>
            
            <div id="voters_list">
            </div>
            
          </div>    
        </div>
      </section>
    </div>

    <div class="modal fade" id="modal_voters_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Voter's Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form id="frm">
              <div class="row">

                <input type="hidden" id="voters_sys_id" name="voters_sys_id">

                <div class="col-lg-2 align-self-center">
                      VIN:
                  </div>
                  <div class="col-lg-4">
                      <input type="text" class="form-control form-control-sm" id="vin" name="vin">
                  </div>
                  <div class="col-lg-2 align-self-center">
                      Voter's No:
                  </div>
                  <div class="col-lg-4">
                      <input type="text" class="form-control form-control-sm" id="vno" name="vno">
                  </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    First Name:
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="firstname" name="firstname">
                </div>
                <div class="col-lg-2 align-self-center">
                    Middle Name:
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="middlename" name="middlename">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Last Name:
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="lastname" name="lastname">
                </div>
                <div class="col-lg-2 align-self-center">
                    Suffix:
                </div>
                <div class="col-lg-4">
                    <select class="form-control form-control-sm" id="suffix" name="suffix">
                      <option value=""></option>
                      <option value="Jr.">Jr.</option>
                      <option value="Sr.">Sr.</option>
                      <option value="I">I</option>
                      <option value="II">II</option>
                      <option value="III">III</option>
                      <option value="IV">IV</option>
                    </select>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Precint Number:
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="precinct_no" name="precinct_no">
                </div>
                <div class="col-lg-2 align-self-center">
                    Cluster Number:
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="cluster_no" name="cluster_no">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Purok Number:
                </div>
                <div class="col-lg-4">
                    <select class="form-control form-control-sm" id="purok_no" name="purok_no">
                      <option value=""> [ Purok ] </option>
                      <option value="1"> 1 </option>
                      <option value="2"> 2 </option>
                      <option value="3"> 3 </option>
                      <option value="4"> 4 </option>
                      <option value="5"> 5 </option>
                      <option value="6"> 6 </option>
                      <option value="7"> 7 </option>
                    </select>
                </div>
                <div class="col-lg-2 align-self-center">
                    Barangay:
                </div>
                <div class="col-lg-4">
                    <select class="form-control form-control-sm" id="barangay" name="barangay">
                      <option value="0"></option>
                      <?php
                        foreach ($data['barangays'] as $key => $barangay) {
                      ?>
                      <option value="<?php echo $barangay['id']; ?>"><?php echo ucwords(strtolower($barangay['name'])); ?></option>
                      <?php
                        }
                      ?>
                    </select>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Birthdate:
                </div>
                <div class="col-lg-4">
                    <input type="date" class="form-control form-control-sm" id="birthdate" name="birthdate">
                </div>
                <div class="col-lg-2 align-self-center">
                    Gender:
                </div>
                <div class="col-lg-4">
                    <select class="form-control form-control-sm" id="gender" name="gender">
                      <option value="0"></option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                </div>
              </div>

              <hr>

              Other Information

              <hr>

              <div class="row">
                <div class="col-lg-2 align-self-center">
                    Contact Number:
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="contact" name="contact">
                </div>
                <div class="col-lg-2 align-self-center">
                    Current Work:
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control form-control-sm" id="work" name="work">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Organization:
                </div>
                <div class="col-lg-10">
                    <input type="text" class="form-control form-control-sm" id="organization" name="organization">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-sm-2 align-self-center">
                    Remarks:
                </div>
                <div class="col-sm-10">
                  <div class="form-group">
                    <textarea class="form-control form-control-sm" id="remarks" name="remarks"></textarea>
                  </div>
                </div>
              </div>

              <br>

              <!-- <div class="row mt-3">
                <div class="col-lg-2">

                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="senior" name="senior" class="mr-2">Is Senior Citizen? 
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="pensioner" name="pensioner" class="mr-2">Is Social Pensioner? 
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="uct" name="uct" class="mr-2">Is UCT Member? 
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2">

                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="nhts" name="nhts" class="mr-2">Is NHTS? 
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="pwd" name="pwd" class="mr-2">Is PWD? 
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="fourps" name="fourps" class="mr-2">Is 4Ps? 
                </div>
              </div> -->

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Is Senior Citizen?:
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="senior" name="senior" data-bootstrap-switch data-on-text="YES" data-off-text="NO">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Is Social Pensioner? :
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="pensioner" name="pensioner" data-bootstrap-switch data-on-text="YES" data-off-text="NO">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Is UCT Member?:
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="uct" name="uct" data-bootstrap-switch data-on-text="YES" data-off-text="NO">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Is NHTS?:
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="nhts" name="nhts" data-bootstrap-switch data-on-text="YES" data-off-text="NO">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                  Is PWD?:
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="pwd" name="pwd" data-bootstrap-switch data-on-text="YES" data-off-text="NO">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                  Is 4Ps?:
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="fourps" name="fourps" data-bootstrap-switch data-on-text="YES" data-off-text="NO">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Is New Voter?:
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="new_voter" name="new_voter" data-bootstrap-switch data-on-text="YES" data-off-text="NO">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-2 align-self-center">
                    Is New Affiliation?:
                </div>
                <div class="col-lg-3">
                  <input type="checkbox" id="new_affiliation" name="new_affiliation" data-bootstrap-switch data-on-text="YES" data-off-text="NO">
                </div>
              </div>

              <div class="row mt-3 mr-0 ml-0 p-2 bg-light rounded">
                <div class="col-lg-8">
                  <span id="message"></span>
                </div>
                <div class="col-lg-4">
                  <div class="float-right">
                    <button class="btn btn-sm btn-success" id="voterid" name="id"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
                  </div>
                </div>
              </div>
              
            </form>

          </div>
        </div>
      </div>
    </div>

  <?php require 'app/views/components/footer_banner.php'; ?>
</div>

<div class="modal fade" id="modal_message_box" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
      </div>
      <div class="modal-body">
        <h6 class="modal-body" id="modal_body"></h5>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
</body>
<?php require 'app/views/components/footer.php'; ?>
<script type="text/javascript" src="<?php echo ROOT.BOOTSTRAP.'plugins/bootstrap-switch/js/bootstrap-switch.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo ROOT.'public/js/voter.js'; ?>"></script>
<script type="text/javascript">
  $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
</script>
</html>