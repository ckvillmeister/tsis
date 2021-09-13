<style>
  #tbl_barangay_list{
    font-size: 10pt
  }

  .col-header {
    font-size: 10pt
  }

</style>

<table class="table table-sm table-bordered table-striped display bg-white" style="width: 100%" id="tbl_barangay_list">
  <thead>
    <tr>
      <th class="text-center col-header">No</th>
      <th class="text-center col-header">Barangay</th>
      <th class="text-center col-header">Control</th>
    </tr>
  </thead>
  <tbody>
  	<?php
  		$ctr = 1;
  		foreach ($data['barangays'] as $key => $barangay) {
  	?>	
  	<tr>
  		<td class="text-center"><?php echo $ctr++; ?></td>
  		<td><?php echo $barangay['name']; ?></td>
  		<td class="text-center">
  			<?php 
  				if ($barangay['status']){
  			?>
  			<button class="btn btn-sm btn-warning" id="btn_edit_brgy" value="<?php echo $barangay['id']; ?>" title="Edit Barangay"><i class="fas fa-edit"></i></button>
  			<button class="btn btn-sm btn-danger" id="btn_delete_brgy" value="<?php echo $barangay['id']; ?>" title="Delete Barangay"><i class="fas fa-trash"></i></button>
  			<?php
  				}
  				else{
  			?>
  			<button class="btn btn-sm btn-success" id="btn_activate_brgy" value="<?php echo $barangay['id']; ?>" title="Re-activate Barangay"><i class="fas fa-undo"></i></button>
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
  $('#tbl_barangay_list').DataTable({
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