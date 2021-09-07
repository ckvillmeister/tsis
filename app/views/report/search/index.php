<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--<link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/css/dataTables.bootstrap4.min.css">-->
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
              <h1 class="m-0 text-dark">Search</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Search</li>
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

            <div class="row shadow-none mt-3 mr-3 ml-3 rounded">
              <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
                Barangay:
              </div>
              <div class="col-lg-3">
                <select class="form-control form-control-sm" id="cbo_barangay">
                  <option value="0"></option>
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
            </div>

            <div class="row shadow-none mt-3 mr-3 ml-3 rounded">
              <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
                Purok:
              </div>
              <div class="col-lg-3">
                <select class="form-control form-control-sm" id="cbo_purok">
                  <option value="0"></option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                </select>
              </div>
            </div>

            <div class="row shadow-none mt-3 mr-3 ml-3 rounded">
              <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
                Name:
              </div>
              <div class="col-lg-3">
                <input type="text" class="form-control form-control-sm" id="txt_name">
              </div>
            </div>

            <div class="row shadow-none m-3 rounded">
              <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
                Precinct:
              </div>
              <div class="col-lg-3">
                <select id="cbo_precinct" class="form-control form-control-sm" style="width: 100%;">
                  <option value=""></option>
                    <?php 
                      $precincts = $data['precincts'];
                      foreach ($precincts as $key => $precinct) {
                    ?>
                    <option value="<?php echo $precinct; ?>"><?php echo $precinct; ?></option>
                    <?php
                      }
                    ?>
                  </select>
              </div>
            </div>

            <div class="row shadow-none m-3 rounded">
              <div class="col-lg-4 align-self-center" style="vertical-align: middle;">
                <button class="btn btn-sm btn-primary" id="btn_search_result"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
                <button class="btn btn-sm btn-danger invisible" id="btn_clear"><icon class="fas fa-times mr-2"></icon>Clear</button>
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
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/jquery.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/jszip.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/pdfmake.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/vfs_fonts.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/buttons.print.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT.'public/js/report.js'; ?>"></script>
<script type="text/javascript">
  $('#cbo_barangay').select2();
  $('#cbo_purok').select2();
  $('#cbo_precinct').select2();

  $('#btn_clear').click(function(){
    $('#cbo_barangay').val('').trigger('change'); 
    $('#cbo_purok').val('').trigger('change'); 
    $('#cbo_precinct').val('').trigger('change'); 
    $('#txt_name').val('');
  });
</script>
</html>
