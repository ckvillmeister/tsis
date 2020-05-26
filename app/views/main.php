<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>TSIS</title>

  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!--<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">-->
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>
  <?php
    $page = (object) $data;
    if ($page->content != ''){
      require 'app/views/'.$page->content;
    }
  ?>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>

  <?php require 'app/views/components/footer.php'; ?>
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

<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery/jquery.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>dist/js/adminlte.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>dist/js/demo.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/raphael/raphael.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>dist/js/pages/dashboard2.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<?php
  $url = $_GET['url'];
  $arr_url = explode('/', rtrim($url, '/'));
  $link = rtrim($arr_url[0], '/');

  if (count($arr_url) > 1){
    $link_2 = rtrim($arr_url[1], '/');
  }

  if ($link == 'accessrole'){
    echo '<script src="public/js/access_role.js"></script>';
  }
  elseif ($link == 'ward') {
    echo '<script src="public/js/ward.js"></script>';
  }
  elseif ($link == 'voter') {
    echo '<script src="public/js/voter.js"></script>';
  }
  elseif ($link == 'settings') {
    echo '<script type="text/javascript">
            var year = new Date().getFullYear();
            $("#text_year").val(year);
          </script>';
  }
  elseif ($link == 'report' & $link_2 == 'ward_list') {
    echo '<script src="'.ROOT.'public/js/report.js"></script>';
  }
  elseif ($link == 'leader' & $link_2 == 'barangay_leader') {
    echo '<script src="'.ROOT.'public/js/barangay_leader.js"></script>';
  }
  elseif ($link == 'leader' & $link_2 == 'purok_leader') {
    echo '<script src="'.ROOT.'public/js/purok_leader.js"></script>';
  }
?>
</body>
</html>
