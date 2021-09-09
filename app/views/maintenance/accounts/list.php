<style>
  #tbl_accounts_list{
    font-size: 10pt
  }

  .col-header {
    font-size: 10pt
  }

</style>

<table class="table table-sm table-bordered table-striped display bg-white" style="width: 100%" id="tbl_accounts_list">
  <thead>
    <tr>
      <th class="text-center col-header">No</th>
      <th class="text-center col-header">User Fullname</th>
      <th class="text-center col-header">Account Username</th>
      <th class="text-center col-header">Role</th>
      <th class="text-center col-header">Created By</th>
      <th class="text-center col-header">Controls</th>
    </tr>
  </thead>
  <tbody>
  	<?php
  		$ctr = 1;

  		foreach ($data['users'] as $key => $user) {
  		
  	?>	
  	<tr>
  		<td class="text-center"><?php echo $ctr++; ?></td>
  		<td><?php echo ucwords(strtolower($user['firstname']).' '.strtolower(trim($user['middlename'])).' '.strtolower($user['lastname']).' '.strtolower(trim($user['suffix']))); ?></td>
  		<td><?php echo $user['username']; ?></td>
      <td><?php echo (array_key_exists("rolename",$user['role'][0])) ? $user['role'][0]['rolename'] : ""; ?></td>
      <td><?php echo ucwords(strtolower($user['creator']['firstname']).' '.strtolower(trim($user['creator']['middlename'])).' '.strtolower($user['creator']['lastname']).' '.strtolower(trim($user['creator']['suffix']))); ?></td>
  		<td class="text-center">
  			<?php 
  				if ($user['status']){
  			?>
        <button class="btn btn-sm btn-success" id="btn_reset_password" value="<?php echo $user['id']; ?>" title="Reset Password"><i class="fas fa-exchange-alt"></i></button>
  			<button class="btn btn-sm btn-warning" id="btn_edit_user" value="<?php echo $user['id']; ?>" title="Edit User Account"><i class="fas fa-edit"></i></button>
  			<button class="btn btn-sm btn-danger" id="btn_delete_user" value="<?php echo $user['id']; ?>" title="Delete User Account"><i class="fas fa-trash"></i></button>
  			<?php
  				}
  				else{
  			?>
  			<button class="btn btn-sm btn-success" id="btn_activate_user" value="<?php echo $user['id']; ?>" title="Re-activate User Account"><i class="fas fa-undo"></i></button>
  			<?php
  				}
  			?>
  		</td>
  	</tr>
	<?php
		}
	?>    
  </tbody>
</table>

<script type="text/javascript">
  $('#tbl_accounts_list').DataTable({
    "scrollX": true,
    "ordering": false,
    lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
    styles: {
      tableHeader: {
        fontSize: 8
      }
    }
  });
</script>