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
              <h1 class="m-0 text-dark">Supporters List</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Supporters List</li>
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
              <div class="col-lg-3">
                <select class="form-control form-control-sm" id="cbo_cluster">
                  <option value="0"> [ Select Cluster ] </option>
                    <!-- <?php 
                      //$barangays = $data['barangay'];
                      //foreach ($barangays as $key => $barangay) {
                    ?>
                    <option value="<?php //echo $barangay['id']; ?>"><?php echo $barangay['name']; ?></option>
                    <?php
                      //}
                    ?> -->
                </select>
              </div>
              <div class="col-lg-3">
                <select class="form-control form-control-sm" id="cbo_supporter_type">
                  <option value="0"> [ Select Supporter Type] </option>
                  <option value="1">Barangay Leaders</option>
                  <option value="2">Purok Leaders</option>
                  <option value="3">Ward Leaders</option>
                  <option value="4">Ward Members</option>
                </select>
              </div>
              <div class="col-lg-3">
                <button class="btn btn-sm btn-primary" id="btn_display_supporters"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
              </div>
              <!--<div class="col-lg-2">
                <div class="float-right">
                  <button class="btn btn-sm btn-primary" id="btn_print"><icon class="fas fa-print mr-2"></icon>Print</button>
                </div>
              </div>-->
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
<script>
  $('#cbo_barangay').on('change', function(){
    
    $.ajax({
      url: 'get_barangay_clusters',
      method: 'POST',
      data: {barangay: $('#cbo_barangay').val()},
      dataType: 'JSON',
      success: function(result) {
        var ctr=0;

        $('#cbo_cluster').empty();
        $('#cbo_cluster').append('<option value="">Select Cluster Number</option>');
        $.each(result, function(index, arr) {
          var newOption = new Option(arr, arr, false, false);
          $('#cbo_cluster').append(newOption);
        });
      },
      error: function(obj, err, ex){
        $.alert({
              title: "Error",
              type: "red",
              content: err + ": " + obj.status + " " + ex
        })
      }
    })
  })
</script>
</html>