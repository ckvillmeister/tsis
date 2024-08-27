<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
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
              <h1 class="m-0 text-dark">Manage Supporters (Sangguniang Kabataan)</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>ward">Manage Supporters</a></li>
                <li class="breadcrumb-item active">SK Voters</li>
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

            <div class="row m-3 shadow-none m-3">
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
                    <button style="border-radius: 3px" class="btn btn-sm btn-info btn-flat" data-toggle="modal" data-target="#modal_voters_list" id="btn_search_member" value='member'><icon class="fas fa-search mr-2"></icon>SK Voter's List</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <div class="col-sm-12">
                <table class="table table-sm table-striped bg-white" id="table_member_list" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-center" style="display: none"></th>
                      <th class="text-center" style="width: 60px">No.</th>
                      <th class="text-center" >Last Name</th>
                      <th class="text-center" >First Name</th>
                      <th class="text-center" >Middle Name</th>
                      <th class="text-center" >Precinct</th>
                      <th class="text-center" style="width:150px">Control</th>
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
                    <button class="btn btn-sm btn-secondary pl-3 pr-3 invisible" data-toggle="modal" id="btn_delete_ward"><icon class="fas fa-trash mr-2"></icon>Delete</button>
                    <button class="btn btn-sm btn-info pl-4 pr-4" id="btn_submit"><icon class="fas fa-save mr-2"></icon>Save</button>
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
                  <th>#</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Precinct</th>
                  <th>Control</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Ward Leaders List -->
    <div class="modal fade" id="modal_leader_list" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Ward Leaders List</h5>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped" id="table_leader_list" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Ward ID</th>
                  <th>Control</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
          
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Remove Member Confirm -->
    <div class="modal fade" id="modal_remove_confirm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <span id="modal_body_message"></span>
            <div class="float-right">
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">x</button> 
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-primary" id="btn_confirm">Yes</button>
          </div>
        </div>
      </div>
    </div>

  <?php require 'app/views/components/footer_banner.php'; ?>
</div>

</body>
<?php require 'app/views/components/footer.php'; ?>
<script type="text/javascript" src="<?php echo ROOT.'public/js/sk.js'; ?>"></script>
</html>
