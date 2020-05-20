<table class="table table-bordered table-striped" id="table_voter_list" style="width:100%">
  	<thead>
	    <tr>
			<th>#</th>
			<th>Lastname</th>
			<th>Firstname</th>
			<th>Middlename</th>
			<th>Control</th>
	    </tr>
  	</thead>
  	<tbody>
    <?php
        $ctr = 0;
        $voters = $data['voters'];
        foreach ($voters as $key => $voter) {
         	$voter_info = (object) $voter;
	?>
		<tr>
			<td><?php echo ++$ctr; ?></td>
			<td><?php echo $voter_info->lastname.' '.$voter_info->suffix; ?></td>
			<td><?php echo $voter_info->firstname; ?></td>
			<td><?php echo $voter_info->middlename; ?></td>
			<td><button class="btn btn-primary" id="btn_select" value="<?php echo $voter_info->id; ?>"><icon class="fas fa-check"></icon>&nbsp;Select</button></td>
		</tr>		
	<?php
		}
	?>
 	 </tbody>
</table>
<script type="text/javascript">
	var voters_id;
	var dt_voterslist = $('#table_voter_list').DataTable({
		 "pageLength": 5
	});

	$('body').on('click', '#btn_select', function(){
		voters_id = $(this).val();
		var fullname = $(this).closest("tr").find('td:eq(3)').text() + ', ' + $(this).closest("tr").find('td:eq(1)').text() + ' ' + $(this).closest("tr").find('td:eq(2)').text();
		$('#voter_name').html(fullname);
	  	$('#modal_confirm_barangay_leader').modal('show');
	});
</script>