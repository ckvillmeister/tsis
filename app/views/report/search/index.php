<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--<link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/css/bootstrap.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/buttons/css/dataTables.bootstrap4.min.css">-->
  <style>
    .font{
      font-size: 10pt;
    }
  </style>
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
                  <option value="0"> Select Barangay </option>
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
                  <option value="0"> Select Purok </option>
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
                <input type="text" class="form-control form-control-sm" id="txt_name" style="padding-left:20px" placeholder="Supporter's Name">
              </div>
            </div>

            <div class="row shadow-none mt-3 mr-3 ml-3 rounded">
              <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
                Cluster:
              </div>
              <div class="col-lg-3">
                <select id="cbo_cluster" class="form-control form-control-sm" style="width: 100%;">
                  <option value=""> Select Cluster Number </option>
                </select>
              </div>
            </div>

            <div class="row shadow-none mt-3 mr-3 ml-3 rounded">
              <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
                Precinct:
              </div>
              <div class="col-lg-3">
                <select id="cbo_precinct" class="form-control form-control-sm" style="width: 100%;">
                  <option value=""> Select Precinct Number </option>
                </select>
              </div>
            </div>

            <div class="row shadow-none m-3 rounded">
              <div class="col-lg-2 align-self-center" style="vertical-align: middle;">
                Age Bracket:
              </div>
              <div class="col-lg-3">
                <select id="age_bracket" class="form-control form-control-sm" style="width: 100%;">
                  <option value=""> Age Bracket </option>
                  <option value="1"> 15 - 24 </option>
                  <option value="2"> 25 - 40 </option>
                  <option value="3"> 41 Above </option>
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
  $('#age_bracket').select2();
  $('#cbo_barangay').select2({dropdownCssClass: "font"});
  $('#cbo_purok').select2({dropdownCssClass: "font"});
  $('#cbo_cluster').select2({dropdownCssClass: "font"});
  $('#cbo_precinct').select2({dropdownCssClass: "font"});
  $('#age_bracket').select2({dropdownCssClass: "font"});

  $('#btn_clear').click(function(){
    $('#cbo_barangay').val('').trigger('change'); 
    $('#cbo_purok').val('').trigger('change'); 
    $('#cbo_precinct').val('').trigger('change'); 
    $('#txt_name').val('');
  });

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

  $('#cbo_cluster').on('change', function(){
    
    $.ajax({
      url: 'get_cluster_precincts',
      method: 'POST',
      data: {barangay: $('#cbo_barangay').val(), cluster: $('#cbo_cluster').val()},
      dataType: 'JSON',
      success: function(result) {
        var ctr=0;
        $('#cbo_precinct').empty();
        $('#cbo_precinct').append('<option value="">Select Precinct Number</option>');
        $.each(result, function(index, arr) {
          var newOption = new Option(arr, arr, false, false);
          $('#cbo_precinct').append(newOption).trigger('change');
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
