<style type="text/css">
	.tbl_report{ 
		border-collapse: collapse !important;
		width: 100% !important;
		font-family: 'Calibri' !important;
		border: 1px solid black !important;
	}
	.tbl_report thead tr td{
		font-size:15pt !important;
		font-weight: bold !important;
		text-align: center !important;
		border: 1px solid black !important;
	}
	.tbl_report tbody tr td{
		padding-left: 10px;
		border: 1px solid black !important;
		font-size:10pt !important;
	}
	.tbl_report tbody .leader{
		background-color: #fff83b !important;
	}
	.header{
		font-family: 'Calibri' !important;
		text-align: center !important;
		font-size:18pt !important;
		font-weight: bold !important;
		margin: 40px !important;
	}
  	@media print{
	  	.tbl_report {
	  		border-collapse: collapse !important;
		    width: 100% !important;
			font-family: 'Calibri' !important;
			border: 1px solid black !important;
		    -webkit-print-color-adjust: exact;
		}
		.tbl_report thead tr td{
			font-size:15pt !important;
			font-weight: bold !important;
			text-align: center !important;
			border: 1px solid black !important;
			-webkit-print-color-adjust: exact;
		}
		.tbl_report tbody tr td{
			padding-left: 10px !important;
			border: 1px solid black !important;
			font-size:10pt !important;
			-webkit-print-color-adjust: exact;
		}
		.tbl_report tbody .leader{
		  	background-color: #fff83b !important;
		  	-webkit-print-color-adjust: exact;
		}
		.tbl_report thead tr td{
			font-size:15pt !important;
			font-weight: bold !important;
			-webkit-print-color-adjust: exact;
		}
  	}
</style>
<div class="header">
	Barangay <span class="barangay_name"></span> Ward List<br>
</div>
<div class="row shadow-none m-3 rounded">
	<table class="tbl_report tbl-sm">
		<thead>
			<tr>
				<td rowspan="2" class="text-center">No.</td>
				<td rowspan="2" class="text-center">Photo</td>
				<td colspan="3">FULLNAME</td>
				<td rowspan="2">Voter's No</td>
				<td rowspan="2">Precinct No</td>
				<td rowspan="2">Purok No</td>
				<td rowspan="2">Remarks</td>
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
				$wardlist = $data['wardlist'];
				foreach ($wardlist as $key => $ward) {
					$leader = $ward['leader'];
					$leader_info = (object) $leader;
					$imgurl = (file_exists($leader_info->imgurl)) ? ROOT.$leader_info->imgurl : ROOT."public/image/avatar130x160.png";
			?>
				<tr>
					<td class="leader text-center" ><?php echo ++$ctr; ?></td>
					<td class="leader text-center" style="padding: 0px !important; background: #ffffff !important; padding: 6pt !important"><img src="<?php echo $imgurl; ?>" width="100" height="130"></td>
					<td class="leader"><?php echo $leader_info->lastname; ?></td>
					<td class="leader"><?php echo $leader_info->firstname.' '.$leader_info->suffix; ?></td>
					<td class="leader"><?php echo $leader_info->middlename; ?></td>
					<td class="leader"><?php echo $leader_info->votersno; ?></td>
					<td class="leader"><?php echo $leader_info->precinctno; ?></td>
					<td class="leader"><?php echo $leader_info->purokno; ?></td>
					<td class="leader" style="text-align: center"><?php echo ($leader_info->new_voter) ? '<small class="badge badge-primary">New Voter</small>' : ''; ?></td>
				</tr>
			<?php
					if(array_key_exists($leader['wardid'], $ward['members'])){
						foreach ($ward['members'][$leader['wardid']] as $key => $member) {
							$member_info = (object) $member;
			?>
							<tr>
								<td></td>
								<td></td>
								<td><?php echo $member_info->lastname; ?></td>
								<td><?php echo $member_info->firstname.' '.$leader_info->suffix; ?></td>
								<td><?php echo $member_info->middlename; ?></td>
								<td><?php echo $member_info->votersno; ?></td>
								<td><?php echo $member_info->precinctno; ?></td>
								<td><?php echo $member_info->purokno; ?></td>
								<td style="text-align: center"><?php echo ($member_info->new_voter) ? '<small class="badge badge-primary">New Voter</small>' : ''; ?></td>
							</tr>
			<?php
						}
					}
				}
			?>
		</tbody>
	</table>
</div>
<script type="text/javascript">
	var barangay = $( "#cbo_barangay option:selected" ).text();
	$('.barangay_name').html(barangay);
</script>