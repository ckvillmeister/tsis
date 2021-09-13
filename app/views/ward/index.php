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
      #btn_view_leaders, #btn_search_leader, #btn_search_member, #btn_submit, #btn_delete_ward {
        width:160px;
        border-radius: 5px;
      }

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
              <h1 class="m-0 text-dark">Warding</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Warding</li>
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
              <div class="col-sm-2 align-self-center" style="vertical-align: middle;">
                Barangay
              </div>
              <div class="col-sm-3">
                <select class="form-control form-control-sm" id="cbo_barangay">
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
                  <button class="btn btn-sm btn-primary invisible" data-toggle="modal" data-target="#modal_leader_list" id="btn_view_leaders"><icon class="fas fa-eye mr-2"></icon>View Leaders</icon></button>
                </div>
              </div>
            </div>

            <div class="row p-3 shadow-none ml-3 mr-3 mb-3 bg-light rounded">
              <div class="col-sm-2 align-self-center" style="vertical-align: middle;">
                Ward Leader
                <input type="hidden" id="text_ward_id">
                <input type="hidden" id="text_ward_leader_id">
              </div>
              <div class="col-sm-6">
                <input type="text" class="form-control form-control-sm bg-white" id="text_ward_leader_name" readonly="readonly">
              </div>
              <div class="col-sm-4">
                <div class="float-right">
                  <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_voters_list" id="btn_search_leader" value='leader'><icon class="fas fa-search mr-2"></icon>Search Leader</button>
                </div>
              </div>
            </div>

            <div class="row-fluid p-3 shadow-none ml-3 mr-3 mb-3 bg-light rounded">
              <div class="col-sm-12">
                <div class="float-right">
                  <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_voters_list" id="btn_search_member" value='member'><icon class="fas fa-search mr-2"></icon>Search Member</button>
                </div>
              </div>
              <br><br>
              <div class="row mt-3">
                <div class="col-sm-12">
                  <table class="table table-sm table-bordered table-striped display bg-white" id="table_member_list" style="width:100%">
                    <thead>
                      <tr>
                        <th class="text-center" style="display: none"></th>
                        <th class="text-center" style="width: 20px">No.</th>
                        <th class="text-center" >First Name</th>
                        <th class="text-center" >Middle Name</th>
                        <th class="text-center" >Last Name</th>
                        <th class="text-center" style="width:150px">Control</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="row p-3 shadow-none ml-3 mr-3 mb-3 bg-light rounded">
              <div class="col-sm-12 align-self-center" style="vertical-align: middle;">
                <div class="float-right">
                  <button class="btn btn-sm btn-danger invisible" data-toggle="modal" id="btn_delete_ward"><icon class="fas fa-trash mr-2"></icon>Delete</button>
                  <button class="btn btn-sm btn-success" id="btn_submit"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
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
            <table class="table table-bordered table-striped" id="table_voter_list" style="width:100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Control</th>
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

    <!-- Modal Remove Ward Confirm -->
    <div class="modal fade" id="modal_remove_ward_confirm" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <span id="modal_remove_ward_body_message"></span>
            <div class="float-right">
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">x</button> 
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-primary" id="btn_delete_ward_confirm">Yes</button>
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
<script type="text/javascript" src="<?php echo ROOT.'public/js/ward.js'; ?>"></script>
</html>
