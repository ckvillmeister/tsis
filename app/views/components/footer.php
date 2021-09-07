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
<script type="text/javascript">
	$('.btn_submit_change_pass').click(function(){
		if ($('#text_newpassword').val() == ''){
			$('#modal_message_box #modal_title').html("Error");
			$('#modal_message_box #modal_body').html("Please enter your new password!");
			$('#modal_message_box').modal('show');
		}
		else if ($('#text_newpassword').val() != $('#text_cnewpassword').val()){
			$('#modal_message_box #modal_title').html("Error");
			$('#modal_message_box #modal_body').html("Password does not match!");
			$('#modal_message_box').modal('show');
		}
		else{
		    $.ajax({
		      	url: '<?php echo ROOT ?>accounts/reset_password',
		        method: 'POST',
		        data: {id: $(this).val(), password: $('#text_newpassword').val()},
		        dataType: 'html',
				success: function(result) {
					if (result == 1){
						$('#modal_message_box #modal_title').html("Password Changed");
						$('#modal_message_box #modal_body').html("Password has been changed!");
						$('#modal_message_box').modal('show');

						setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 2900);
						setTimeout(function(){ $('#modal_change_password').modal('hide'); }, 3000);
					}
					else{
						$('#modal_message_box #modal_title').html("Error");
						$('#modal_message_box #modal_body').html("Error changing password. . .");
						$('#modal_message_box').modal('show');
					}
				},
				error: function(obj, err, ex){
					$('#modal_message_box #modal_title').html("Error");
					$('#modal_message_box #modal_body').html(err + ": " + obj.toString() + " " + ex);
					setTimeout(function(){ $('#modal_message_box').modal('hide'); }, 3000);
				}
			})
		}
	});
</script>