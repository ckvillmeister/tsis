
<div class="header text-center">
	<h3>List of All <span class="supporter_type"></span></h3>
</div>
<div class="row shadow-none m-3 rounded">
	<div class="col-lg-12 align-self-center">
		<table class="table table-sm table-bordered table-striped display nowrap bg-white" id="tbl_supporters_list" style="width:100%">
			<thead>
				<tr>
					<td class="text-center">No.</td>
					<td class="text-center">Supporter's Fullname</td>
					<td class="text-center">Barangay</td>
					<td class="text-center">Voter's No</td>
					<td class="text-center">Precinct No</td>
					<td class="text-center">Cluster No</td>
					<td class="text-center">Purok No</td>
					<td class="text-center">Supporter Type</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$ctr = 1;
					foreach ($data['supporters'] as $key => $row) {
				?>
				<tr>
					<td><?php echo $ctr++; ?></td>
					<td><?php echo mb_strtoupper(trim($row['firstname'])." ".trim($row['middlename'])." ".trim($row['lastname'])." ".trim($row['suffix'])); ?></td>
					<td><?php echo $row['barangay']; ?></td>
					<td class='text-center data'><?php echo $row['votersno']; ?></td>
					<td class='text-center data'><?php echo $row['precinctno']; ?></td>
					<td class='text-center data'><?php echo $row['clusterno']; ?></td>
					<td class='text-center data'><?php echo $row['purokno']; ?></td>
					<td class='text-center data'><?php echo $row['rank']; ?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	

	$(document).ready(function() {

		var supporter_type = $( "#cbo_supporter_type option:selected" ).text();
		if (supporter_type.trim() == '[ Select Supporter Type]'){
			supporter_type = 'Supporters';
		}
	$('.supporter_type').html(supporter_type);
	/*
		B - Buttons
		l - length changing input control
		f - filtering input
		r - processing display element
		t - The table
		i - Table information summary
		p - pagination control
	*/
  var table = $('#tbl_supporters_list').DataTable({
    "dom": 'Brt',
    "initComplete": function() {
      $("#tbl_supporters_list").show();
    },
    "buttons": ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
    "scrollX": true,
    "ordering": false,
    paging: false
  });
  table.buttons().container().appendTo('#reminders_wrapper .col-md-6:eq(0)');
});
</script>