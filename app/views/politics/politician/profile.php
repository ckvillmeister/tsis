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
      $imgurl = ROOT."public/image/avatar.png"; //($profile['imgurl']) ? $profile['imgurl'] : 
    ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Candidates's Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>main">Main</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>candidates">Candidates</a></li>
                <li class="breadcrumb-item active">Candidates's Profile</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          
          <div class="card card-info card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?php echo $imgurl ?>">
                </div>
                <h2 class="profile-username text-center"><?php echo ucwords(mb_strtolower($profile['firstname']).' '.mb_strtolower(trim($profile['middlename'])).' '.mb_strtolower($profile['lastname'])); ?></h2>
                <br>
                <div class="row">
                  <div class="col-sm-12">
                    <button class="btn btn-sm btn-info" id="btn_new_record"><i class="fas fa-plus mr-2"></i>Add New Record</button>
                    <a class="btn btn-sm btn-primary text-white" href="<?php echo ROOT; ?>politics/profile?id=<?php echo $_GET['id']; ?>&status=1"><i class="fas fa-check mr-2"></i>Active</a>
                    <a class="btn btn-sm btn-danger text-white" href="<?php echo ROOT; ?>politics/profile?id=<?php echo $_GET['id']; ?>&status=0"><i class="fas fa-trash mr-2"></i>Trash</a>
                  </div>
                </div>
                <br>
                <div>
                  <table class="table table-sm table-bordered table-striped display nowrap bg-white" id="tbl_result_list">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Position</th>
                        <th class="text-center">Barangay</th>
                        <th class="text-center">Total Votes Received</th>
                        <th class="text-center">Year</th>
                        <th class="text-center">Control</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $ctr = 1;
                        foreach ($data['results'] as $key => $result) {

                      ?>
                      <tr>
                        <td class="text-center"><?php echo $ctr++; ?></td>
                        <td class="text-center"><?php echo $result['position']; ?></td>
                        <td><?php echo $result['barangay']; ?></td>
                        <td class="text-center"><?php echo $result['votes']; ?></td>
                        <td class="text-center"><?php echo $result['year']; ?></td>
                        <td class="text-center">
                          <?php
                            if ($result['status']){
                          ?>
                            <button class="btn btn-sm btn-warning" id="btn_edit_result" value="<?php echo $result['id']; ?>" title="Edit Election Results"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" id="btn_delete_result" value="<?php echo $result['id']; ?>" title="Delete Election Results"><i class="fas fa-trash"></i></button>
                          <?php
                            }
                            else{
                          ?>
                            <button class="btn btn-sm btn-success" id="btn_activate_result" value="<?php echo $result['id']; ?>" title="Re-activate Election Results"><i class="fas fa-undo"></i></button>
                          <?php
                            }
                          ?>
                        </td>
                      </tr>
                    <?php
                      }
                    ?>   
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

        </div>
      </section>
    </div>

   <?php require 'app/views/components/footer_banner.php'; ?>
</div>

<div class="modal fade" id="modal_election_result_add" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Add Election Result</h5>
      </div>
      <div class="modal-body">

        <div class="row mt-3">
          <div class="col-lg-4 align-self-center">
              Barangay:
          </div>
          <div class="col-lg-8">
              <select class="form-control form-control-sm" id="cbo_barangay">
                <option value="0"> [ Select Barangay ] </option>
                  <?php 
                    $barangays = $data['barangays'];
                    foreach ($barangays as $key => $barangay) {
                  ?>
                  <option value="<?php echo $barangay['id']; ?>"><?php echo $barangay['name']; ?></option>
                  <?php
                    }
                  ?>
              </select>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-4 align-self-center">
              Votes Received:
          </div>
          <div class="col-lg-8">
              <input type="number" class="form-control form-control-sm" id="text_votes_received">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-4 align-self-center">
              Year:
          </div>
          <div class="col-lg-8">
              <input type="number" class="form-control form-control-sm" id="text_year" value="<?php echo $data['year'] ?>">
          </div>
        </div>

        <div class="row mt-3 mr-0 ml-0 rounded">
          <div class="col-lg-8">
            <span id="message"></span>
          </div>
          <div class="col-lg-4">
            <div class="float-right">
              <button class="btn btn-sm btn-info" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ""; ?>" id="btn_add_vote_record"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
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

<div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
      </div>
      <div class="modal-body">
        <h5 class="modal-body" id="modal_body"></h5>
      </div>
      <div class="modal-footer">
        <div class="float-right">
          <button class="btn btn-sm btn-primary btn_yes">Yes</button>
          <button class="btn btn-sm btn-secondary" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
<?php require 'app/views/components/footer.php'; ?>
<script type="text/javascript" src="<?php echo ROOT.'public/js/politician.js'; ?>"></script>
<script type="text/javascript">
  $('#tbl_result_list').DataTable({
    "ordering": false
  });

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

</script>
</html>