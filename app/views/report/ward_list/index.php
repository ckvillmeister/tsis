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
              <h1 class="m-0 text-dark">Ward List</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Ward List</li>
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
              <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
                Barangay
              </div>
              <div class="col-lg-3">
                <select class="form-control form-control-sm" id="cbo_barangay">
                  <option value="0"> [ Select Barangay ] </option>
                    <?php 
                      $barangays = $data['barangay'];
                      foreach ($barangays as $key => $barangay) {
                    ?>
                    <option value="<?php echo $barangay['id']; ?>"><?php echo $barangay['name']; ?></option>
                    <?php
                      }
                    ?>
                </select>
              </div>
              <div class="col-lg-5">
                <button class="btn btn-sm btn-primary" id="btn_view_ward_list"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
              </div>
              <div class="col-lg-2">
                <div class="float-right">
                  <button class="btn btn-sm btn-primary" id="btn_print"><icon class="fas fa-print mr-2"></icon>Print</button>
                </div>
              </div>
            </div>

            <div id="report">
            </div>

          </div>    
        </div>
      </section>
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
<script type="text/javascript" src="<?php echo ROOT.'public/js/report.js'; ?>"></script>
</html>
