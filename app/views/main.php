<!DOCTYPE html>
<html>
<head>
  <!--<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">-->

  <title id="sys_title"><?php echo ($data['system_name']) ? $data['system_name'] : "" ; ?></title>

  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/sweetalert2/sweetalert2.min.css">

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
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
<?php
  $url = $_GET['url'];
  $arr_url = explode('/', rtrim($url, '/'));
  $link = rtrim($arr_url[0], '/');
  $link_2;

  if (count($arr_url) > 1){
    $link_2 = rtrim($arr_url[1], '/');
  }

  if ($link == 'accessrole'){
    echo '<script src="'.ROOT.'public/js/access_role.js"></script>';
  }
  elseif ($link == 'ward') {
    echo '<script src="'.ROOT.'public/js/ward.js"></script>';
  }
  elseif ($link == 'voter') {
    echo '<script src="'.ROOT.'public/js/voter.js"></script>';
  }
  elseif ($link == 'settings') {
    echo '<script src="'.ROOT.'public/js/settings.js"></script>';
  }
  elseif ($link == 'report' & $link_2 == 'ward_list') {
    echo '<script src="'.ROOT.'public/js/report.js"></script>';
  }
  elseif ($link == 'report' & $link_2 == 'election_result') {
    echo '<script src="'.ROOT.'public/js/report.js"></script>';
  }
  elseif ($link == 'report' & $link_2 == 'comparison') {
    echo '<script src="'.ROOT.'public/js/report.js"></script>';
  }
  elseif ($link == 'report' & $link_2 == 'supporters') {
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
<script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.8.1/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyBbvtZeC07sZWvVsIvF78nMcy4Lvtt8PbU",
    authDomain: "tsis-4b084.firebaseapp.com",
    projectId: "tsis-4b084",
    storageBucket: "tsis-4b084.firebasestorage.app",
    messagingSenderId: "703707119922",
    appId: "1:703707119922:web:1ef29666317342b0a2972b",
    measurementId: "G-PZ44WFJQEZ"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script>
