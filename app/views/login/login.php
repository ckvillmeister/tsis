<?php
  $settings_model = new SettingsModel();
  $imgurl = $settings_model->get_sys_info('System Image');
  $imgurl = ($imgurl) ? $imgurl : '';
  $bgimg = $settings_model->get_sys_info('Login Background Image');
  $bgimg = ($bgimg) ? $bgimg : '';
?>

<!DOCTYPE html>
<html>
<head>
  <?php require 'app/views/components/header.php'; ?>
  <style>
        * {
            margin: 0;
            padding: 0;
        }
        .imgbox {
            display: grid;
            height: 100%;
        }
        .center-fit {
            max-width: 100%;
            max-height: 100vh;
            margin: auto;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-light" style="background-color: #196751">
    <div class="container">
      
      <a href="<?php echo ROOT; ?>" class="navbar-brand">
        <img src="<?php echo $imgurl['desc']; ?>" alt="TSIS Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light" style="color:white"><?php echo ($data['system_name']) ? $data['system_name'] : "" ; ?></span>
      </a>
      
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="mr-3">
          <input class="form-control form-control-navbar" type="text" id="text_username" placeholder="Username" aria-label="Search">
        </li>
        <li class="mr-3">
          <input class="form-control form-control-navbar" type="password" id="text_password" placeholder="Password" aria-label="Search">
        </li>
        <li>
           <button class="btn btn-navbar" type="submit" id="btn_login"><i class="fas fa-sign-in-alt"></i></button>
        </li>
      </ul>
    </div>
  </nav>
  <div class="imgbox">
    <img class="center-fit" src="<?php echo $bgimg['desc']; ?>">
  </div>
</div>  

<!-- Modal Message -->
<div class="modal fade" id="modal_message" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="message_modal_header modal-header bg-success">
        <h5><i class="message_icon icon fas fa-check"></i><span class="ml-2" id="modal_body_header"></span></h5>
      </div>
      <div class="modal-body">
        <span id="modal_body_message"></span>
      </div>
    </div>
  </div>
</div>

<?php require 'app/views/components/footer.php'; ?>
<script src="<?php echo ROOT; ?>public/js/login.js"></script>
</body>

</html>