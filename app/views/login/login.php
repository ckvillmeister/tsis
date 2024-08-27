<?php
  $settings_model = new SettingsModel();
  $imgurl = $settings_model->get_sys_info('System Logo');
  $imgurl = ($imgurl) ? $imgurl : '';
  $bgimg = $settings_model->get_sys_info('Login Background Image');
  $bgimg = ($bgimg) ? $bgimg : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title id="sys_title"><?php echo ($data['system_name']) ? $data['system_name'] : "" ; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="icon" href="<?php echo ROOT.$imgurl['desc']; ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo ROOT; ?>public/templates/v18/css/main.css">
  <link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>plugins/sweetalert2/sweetalert2.min.css">
  
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form validate-form">
					<span class="login100-form-title p-b-43">
          			<?php echo ($data['system_name']) ? $data['system_name'] : "" ; ?>
					</span>
					
					
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" id="text_username">
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="pass"  id="text_password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="#" class="txt1">
								Forgot Password?
							</a>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<button style="background-color: #00939D !important" class="login100-form-btn" id="btn_login">
							Login
						</button>
					</div>
					
					<div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or sign up using
						</span>
					</div>

					<div class="login100-form-social flex-c-m">
						<a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
							<i class="fa fa-facebook-f" aria-hidden="true"></i>
						</a>

						<a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</div>
        </div>

				<div class="login100-more" style="background-image: url('<?php echo $bgimg['desc']; ?>');">
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo ROOT; ?>public/templates/v18/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?php echo ROOT; ?>public/templates/v18/vendor/animsition/js/animsition.min.js"></script>
	<script src="<?php echo ROOT; ?>public/templates/v18/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo ROOT; ?>public/templates/v18/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo ROOT; ?>public/templates/v18/vendor/select2/select2.min.js"></script>
	<script src="<?php echo ROOT; ?>public/templates/v18/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo ROOT; ?>public/templates/v18/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="<?php echo ROOT; ?>public/templates/v18/vendor/countdowntime/countdowntime.js"></script>
  <script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/sweetalert2/sweetalert2.all.min.js"></script>
	<script src="<?php echo ROOT; ?>public/templates/v18/js/main.js"></script>
  <script src="<?php echo ROOT; ?>public/js/login.js"></script>

</body>
</html>