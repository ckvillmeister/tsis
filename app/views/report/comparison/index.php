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
              <h1 class="m-0 text-dark">Comparison</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Comparison</li>
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
                Position:
              </div>
              <div class="col-lg-2">
                <select class="form-control form-control-sm" id="cbo_positions">
                  <option value="0"> [ Select Position ] </option>
                    <?php 
                      $positions = $data['positions'];
                      foreach ($positions as $key => $position) {
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $position; ?></option>
                    <?php
                      }
                    ?>
                </select>
              </div>
              <div class="col-lg-2">
                <select class="form-control form-control-sm" id="cbo_election_years">
                  <option value="0"> [ Select Year ] </option>
                    <?php                   
                      $year_start = 2007;
                      $year_end =  date('Y');

                      for($year_start; $year_start <= $year_end; $year_start += 3){
                    ?>
                    <option value="<?php echo $year_start; ?>"><?php echo $year_start; ?></option>
                    <?php
                      }
                    ?>
                </select>
              </div>
              <div class="col-lg-6">
                <button class="btn btn-sm btn-primary" id="btn_display_comparison"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
              </div>
              <!--<div class="col-lg-2">
                <div class="float-right">
                  <button class="btn btn-sm btn-primary" id="btn_print"><icon class="fas fa-print mr-2"></icon>Print</button>
                </div>
              </div>
            -->
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
<script type="text/javascript" src="<?php echo ROOT.'public/js/report.js'; ?>"></script>
</html>


