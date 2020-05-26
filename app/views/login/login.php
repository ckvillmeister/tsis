<!DOCTYPE html>
<html>

<head>
  <title>Patient Information System</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
        <div class="login-logo">
          <a href="#">Patient Information System</a>
        </div>
          <div class="input-group">
            <input type="email" class="form-control" id="text_username" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <span id="username_error_msg" class="pl-2"></span>
          <br><br>
          <div class="input-group">
            <input type="password" class="form-control" id="text_password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <span id="password_error_msg" class="pl-2"></span>
          <br><br>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block" id="btn_login">Sign In</button>
            </div>
          </div>
      </div>
    </div>
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
<script src="<?php echo ROOT.BOOTSTRAP; ?>dist/js/adminlte.min.js"></script>
<script src="<?php echo ROOT; ?>public/js/login.js"></script>
</body>

</html>