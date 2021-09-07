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
              <h1 class="m-0 text-dark">Candidates</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>main">Main</a></li>
                <li class="breadcrumb-item active">Candidates</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card">

            <div class="row p-3 shadow-none m-3 bg-light rounded">
              <div class="col-lg-12 align-self-center">
                <button class="btn btn-sm btn-primary" id="btn_new_candidate" data-toggle="modal" data-target="#modal_candidate_form"><icon class="fas fa-plus mr-2"></icon>New Candidate</button>
                <button class="btn btn-sm btn-secondary" id="btn_active"><icon class="fas fa-check mr-2"></icon>Active</button>
                <button class="btn btn-sm btn-danger" id="btn_trash"><icon class="fas fa-trash mr-2"></icon>Trash</button>
              </div>
            </div>

            <div class="row p-3 shadow-none ml-3 mr-3 mb-3 bg-light rounded">
              <div class="col-lg-12 align-self-center">
                
                <div id="candidates_list">
                </div>

              </div>
            </div>

          </div>    
        </div>
      </section>
    </div>

    <div class="modal fade" id="modal_candidate_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Candidate Information</h5>
          </div>
          <div class="modal-body">

            <div class="row mt-3">
              <div class="col-lg-3 align-self-center">
                  First Name:
              </div>
              <div class="col-lg-9">
                  <input type="text" class="form-control form-control-sm" id="text_firstname">
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-lg-3 align-self-center">
                  Middle Name:
              </div>
              <div class="col-lg-9">
                  <input type="text" class="form-control form-control-sm" id="text_middlename">
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-lg-3 align-self-center">
                  Last Name:
              </div>
              <div class="col-lg-9">
                  <input type="text" class="form-control form-control-sm" id="text_lastname">
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-lg-3 align-self-center">
                  Is Allied?:
              </div>
              <div class="col-lg-3">
                  <select id="cbo_isallied" class="form-control form-control-sm">
                    <option value=""></option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                  </select>
              </div>
            </div>

            <div class="row mt-3 mr-0 ml-0 p-2 bg-light rounded">
              <div class="col-lg-8">
                <span id="message"></span>
              </div>
              <div class="col-lg-4">
                <div class="float-right">
                  <button class="btn btn-sm btn-success" id="btn_submit"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
                </div>
              </div>
            </div>

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
        <h5 class="modal-body" id="modal_body"></h5>
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
<script type="text/javascript" src="<?php echo ROOT.'public/js/candidate.js'; ?>"></script>
</html>