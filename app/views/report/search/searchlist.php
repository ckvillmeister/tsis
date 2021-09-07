<div class="header text-center">
	<h3>Search Results</h3>
</div>
<div class="row shadow-none m-3 rounded">
	<div class="col-lg-12 align-self-center">
		<table class="table table-sm table-bordered table-striped display nowrap bg-white" id="tbl_search_result" style="width:100%">
			<thead>
				<tr>
					<td rowspan="2" class="text-center">No.</td>
					<td colspan="3">FULLNAME</td>
					<td rowspan="2">Voter's No</td>
					<td rowspan="2">Precinct No</td>
					<td rowspan="2">Purok No</td>
					<td rowspan="2">Cluster No</td>
				</tr>
				<tr>
					<td>Last Name</td>
					<td>First Name</td>
					<td>Middle Name</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$ctr = 0;
					$searchlist = $data['searchlist'];
					foreach ($searchlist as $key => $record) {
						$record_info = (object) $record;
				?>
					<tr>
						<td class="text-center" ><?php echo ++$ctr; ?></td>
						<td class=""><?php echo $record_info->lastname; ?></td>
						<td class=""><?php echo $record_info->firstname.' '.$record_info->suffix; ?></td>
						<td class=""><?php echo $record_info->middlename; ?></td>
						<td class=""><?php echo $record_info->votersno; ?></td>
						<td class=""><?php echo $record_info->precinctno; ?></td>
						<td class=""><?php echo $record_info->purokno; ?></td>
						<td class=""><?php echo $record_info->clusterno; ?></td>
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
	/*
		B - Buttons
		l - length changing input control
		f - filtering input
		r - processing display element
		t - The table
		i - Table information summary
		p - pagination control
	*/
  	var table = $('#tbl_search_result').DataTable({
	    "dom": 'Brt',
	    "initComplete": function() {
	      $("#tbl_search_result").show();
	    },
	    "buttons": ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
	    "scrollX": true,
	    "ordering": false,
	    paging: false
 	});
 	table.buttons().container().appendTo('#reminders_wrapper .col-md-6:eq(0)');
	});
</script>