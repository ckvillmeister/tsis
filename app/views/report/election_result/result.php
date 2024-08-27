<div class="header text-center">
	<h3>Election Results <span class="year"></span></h3>
</div>
<div class="row shadow-none m-3 rounded">
	<div class="col-lg-12 align-self-center">
		<table class="table table-sm table-bordered table-striped display nowrap bg-white" id="tbl_result" style="width:100%">
			<thead>
				<tr>
					<td class="text-center">No.</td>
					<td>Candidate Fullname</td>
					<td>Position</td>
					<td>Total Voters</td>
					<td>Total Supporters</td>
					<td>Actual Votes Received</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$ctr = 1;
					$prev_post = "";
					foreach ($data['results'] as $key => $row) {
						if ($row['position'] != $prev_post){
							$ctr = 1;
							$prev_post = $row['position'];
							//echo '<tr><td colspan="6" style="background-color: #000000 !important; height: 10px"></td></tr>';
						}
				?>
				<tr>
					<td><?php echo $ctr++; ?></td>
					<td><?php echo mb_strtoupper(trim($row['firstname'])." ".trim($row['middlename'])." ".trim($row['lastname'])); ?></td>
					<td><?php echo $row['position']; ?></td>
					<td class='text-center data'><?php echo number_format($row['total_voters']); ?></td>
					<td class='text-center data'><?php echo ($row['allied']['id'] == $row['partyid']) ? number_format($row['total_supporters']) : ''; ?></td>
					<td class='text-center data'><?php echo number_format($row['votes']); ?></td>
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

		var year = $( "#cbo_election_years option:selected" ).text();
	$('.year').html(year);
	/*
		B - Buttons
		l - length changing input control
		f - filtering input
		r - processing display element
		t - The table
		i - Table information summary
		p - pagination control
	*/
  var table = $('#tbl_result').DataTable({
    "dom": 'Blrtp',
    "initComplete": function() {
      $("#tbl_result").show();
    },
    "buttons": ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
    "scrollX": true,
    "ordering": false,
    paging: true
  });
  table.buttons().container().appendTo('#reminders_wrapper .col-md-6:eq(0)');
});
</script>
