<style type="text/css">
	/*.tbl_report{ 
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
	
	*/

	.header{
		font-family: 'Calibri' !important;
		text-align: center !important;
		font-size:18pt !important;
		font-weight: bold !important;
		margin: 40px !important;
	}

	.tbl_report tbody .leader{
		background-color: #fff83b !important;
	}

	
  	@media print{
	  	/*.tbl_report {
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
		}*/

		.tbl_report tbody .leader{
		  	background-color: #fff83b !important;
		  	-webkit-print-color-adjust: exact;
		}
  	}
</style>
<div class="header">
	<h1><b>Supporters List</b></h1>
	<?php
		//echo ($data['purok']) ? '<span>Purok '.$data['purok'].'</span>': '';
	?>	
</div>
<?php
	$leader_count = 0;
	$member_count = 0;
	foreach ($data['wardlist'] as $key => $ward) {
		$leader_count++;
		foreach ($ward['members'][$ward['leader']['wardid']] as $key => $member) {
			$member_count++;
		}
	}
?>
<div class="row shadow-none m-3 rounded">
	<table class="tbl_report table table-sm table-bordered table-striped bg-white">
		<thead>
			<tr>
				<td colspan="2">Barangay</td>
				<td colspan="8"><b><span class="barangay_name"></span></b></td>
			</tr>
			<tr>
				<td colspan="2">Purok</td>
				<td colspan="8"><b>
					<?php
						echo ($data['purok']) ? '<span>'.$data['purok'].'</span>': 'ALL PUROK';
					?></b>
				</td>
			</tr>
			<tr>
				<td colspan="2">Leaders</td>
				<td colspan="8"><b><?php echo $leader_count; ?></b></td>
			</tr>
			<tr>
				<td colspan="2">Members</td>
				<td colspan="8"><b><?php echo $member_count; ?></b></td>
			</tr>
			<tr>
				<td colspan="2">Total Supporters</td>
				<td colspan="8"><b><?php echo $leader_count + $member_count; ?></b></td>
			</tr>
			<tr>
				<td rowspan="2" class="text-center">No.</td>
				<td rowspan="2" class="text-center">Photo</td>
				<td colspan="3">FULLNAME</td>
				<td rowspan="2">Voter's No</td>
				<td rowspan="2">Cluster No</td>
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
				$leader_count = 0;
				$member_count = 0;
				foreach ($wardlist as $key => $ward) {
					$leader_count++;
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
					<td class="leader"><?php echo $leader_info->clusterno; ?></td>
					<td class="leader"><?php echo $leader_info->precinctno; ?></td>
					<td class="leader"><?php echo $leader_info->purokno; ?></td>
					<td class="leader" style="text-align: center" data-voterid = "<?php echo $leader_info->voterid; ?>" ondblclick="addRemarks(<?php echo $leader_info->voterid; ?>)">
						<?php echo ($leader_info->new_voter) ? '<small class="badge badge-primary">New Voter</small>' : ''; ?>
						<?php echo ($leader_info->new_affiliation) ? '<small class="badge badge-secondary">New Affiliation</small>' : ''; ?>
						<?php echo ($leader_info->remarks) ? '<small class="badge badge-warning">Remarks: '.$leader_info->remarks.'</small>' : '';  ?>
					</td>
				</tr>
			<?php
					if(array_key_exists($leader['wardid'], $ward['members'])){
						foreach ($ward['members'][$leader['wardid']] as $key => $member) {
							$member_count++;
							$member_info = (object) $member;
			?>
							<tr>
								<td></td>
								<td></td>
								<td><?php echo $member_info->lastname; ?></td>
								<td><?php echo $member_info->firstname.' '.$member_info->suffix; ?></td>
								<td><?php echo $member_info->middlename; ?></td>
								<td><?php echo $member_info->votersno; ?></td>
								<td><?php echo $member_info->clusterno; ?></td>
								<td><?php echo $member_info->precinctno; ?></td>
								<td><?php echo $member_info->purokno; ?></td>
								<td style="text-align: center" data-voterid = "<?php echo $member_info->voterid; ?>" ondblclick="addRemarks(<?php echo $member_info->voterid; ?>)">
									<?php echo ($member_info->new_voter) ? '<small class="badge badge-primary">New Voter</small>' : ''; ?>
									<?php echo ($member_info->new_affiliation) ? '<small class="badge badge-secondary">New Affiliation</small>' : ''; ?>
									<?php echo ($member_info->remarks) ? '<small class="badge badge-warning">Remarks: '.$member_info->remarks.'</small>' : '';  ?>
								</td>
							</tr>
			<?php
						}
					}
				}
			?>
		</tbody>
	</table>
</div><br>
<!-- <div class="row shadow-none m-3 rounded">
	<div class="col-md-12">
		Leaders: <strong><?php echo $leader_count; ?></strong>
	</div>
</div>

<div class="row shadow-none m-3 rounded">
	<div class="col-md-12">
		Members: <strong><?php echo $member_count; ?></strong>
	</div>
</div>

<div class="row shadow-none m-3 rounded">
	<div class="col-md-12">
		Total: <strong><?php echo $leader_count + $member_count; ?></strong>
	</div>
</div> -->
<script type="text/javascript">
	var barangay = $( "#cbo_barangay option:selected" ).text();
	$('.barangay_name').html(barangay);

	function addRemarks(voterid){
		$(event.target).html("<input type='text' class='form form-control form-control-sm' id='remarks' onkeypress='setRemarks(" + voterid + ")'>");
		$(event.target).focus();
	}

	function setRemarks(voterid){
		var keycode = (event.keyCode ? event.keyCode : event.which);

		if(keycode == 13){
			var sourcetag = $(event.target);
			var remarks = $(event.target).val();

			$.ajax({
				url: '<?php echo ROOT; ?>voter/setVoterRemarks',
				method: 'POST',
				data: {voterid: voterid, remarks: remarks},
				dataType: 'html',
				success: function(result) {
					sourcetag.parent().html(remarks);
				},
				error: function(obj, err, ex){
					$.alert({
			            title: "Error",
			            type: "red",
			            content: msg + ": " + obj.status + " " + exception
			        })
				}
			})
		}
		
	}
</script>
<link rel="stylesheet" href="<?php echo ROOT.BOOTSTRAP; ?>dist/css/adminlte.min.css">