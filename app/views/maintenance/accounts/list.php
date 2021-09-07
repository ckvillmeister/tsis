<table class="table table-sm table-bordered table-striped display nowrap bg-white" id="table_access_role_list">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th class="text-center">User Fullname</th>
      <th class="text-center">Account Username</th>
      <th class="text-center">Role</th>
      <th class="text-center">Created By</th>
      <th class="text-center">Controls</th>
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