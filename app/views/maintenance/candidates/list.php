<table class="table table-sm table-bordered table-striped display nowrap bg-white" id="tbl_candidates_list">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th class="text-center">Candidate Fullname</th>
      <th class="text-center">Is Allied?</th>
      <th class="text-center">Control</th>
    </tr>
  </thead>
  <tbody>
  	<?php
  		$ctr = 1;

  		foreach ($data['candidates'] as $key => $candidate) {
  		
  	?>	
  	<tr>
  		<td class="text-center"><?php echo $ctr++; ?></td>
  		<td><?php echo ucwords(mb_strtolower($candidate['firstname']).' '.mb_strtolower(trim($candidate['middlename'])).' '.mb_strtolower($candidate['lastname'])); ?></td>
  		<td><?php echo ($candidate['isallied']) ? 'Yes' : ""; ?></td>
  		<td class="text-center">
  			<?php 
  				if ($candidate['status']){
  			?>
            <?php if ($data['hasaccess']): ?>
              <a class="btn btn-sm btn-primary" id="btn_candidate_profile" value="<?php echo $candidate['id']; ?>" href="<?php echo ROOT; ?>candidates/profile?id=<?php echo $candidate['id']; ?>&status=1" title="Candidate Profile"><i class="fas fa-list"></i>
              </a>
            <?php endif; ?>
  			<button class="btn btn-sm btn-warning" id="btn_edit_candidate" value="<?php echo $candidate['id']; ?>" title="Edit Candidate Information"><i class="fas fa-edit"></i></button>
  			<button class="btn btn-sm btn-danger" id="btn_delete_candidate" value="<?php echo $candidate['id']; ?>" title="Delete Candidate"><i class="fas fa-trash"></i></button>
  			<?php
  				}
  				else{
  			?>
  			<button class="btn btn-sm btn-success" id="btn_activate_candidate" value="<?php echo $candidate['id']; ?>" title="Re-activate Candidate"><i class="fas fa-undo"></i></button>
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
  $('#tbl_candidates_list').DataTable({
    "ordering": false
  });
</script>