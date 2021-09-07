
<div class="header">
	<span class="supporter_type"> 
</div>
<div class="row shadow-none m-3 rounded">
	<div id="example_wrapper"></div>
	<div class="col-lg-12 align-self-center">
		<table class="table table-sm table-bordered table-striped display nowrap bg-white" id="tbl_comparison">
			<thead>
				<tr>
					<td class="text-center">No.</td>
					<td class="text-center">Candidate Fullname</td>
					<?php
						foreach ($data['barangay'] as $key => $row) {
							echo '<td class="text-center">'.ucwords(strtolower($row['name'])).'</td>';
						}
					?>
					<td class="text-center">Total</td>
				</tr>
			</thead>
			<tbody>
				<?php
					$ctr = 1;

					foreach ($data['comparison'] as $key => $row) {
				?>
				<tr>
					<td class="text-center"><?php echo $ctr++; ?></td>
					<td><?php echo mb_strtoupper(trim($row['firstname'])." ".trim($row['middlename'])." ".trim($row['lastname'])); ?></td>
					<?php
						$total=0;
						foreach ($data['barangay'] as $key => $barangay) {

							$vote = 0;
							if (array_key_exists($barangay['name'], $row['votes'])){
								$vote = $row['votes'][strtoupper($barangay['name'])];
								$total += $vote;
							}
							echo '<td class="text-center">'.$vote.'</td>';
						}
					?>
					<td class="text-center"><?php echo $total; ?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	<div class="col-lg-12 align-self-center">
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
  var table = $('#tbl_comparison').DataTable({
    "dom": 'Brt',
    "initComplete": function() {
      $("#tbl_comparison").show();
    },
    "buttons": ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis'],
    "scrollX": true,
  });
  table.buttons().container().appendTo('#reminders_wrapper .col-md-6:eq(0)');
});
</script>
