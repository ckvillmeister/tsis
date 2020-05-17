<style type="text/css">
  .tbl_report{
    width: 100%;
    font-family: 'Bodoni MT';
    border-color: #807c7c;
    border-width: 2px;
  }
  .tbl_report thead tr td{
    text-align: center;
    border-color: #807c7c;
    border-width: 2px;
  }
  .tbl_report tbody tr td{
   	padding-left: 10px;
   	border-color: #807c7c;
   	border-width: 2px;
  }
  .tbl_report tbody .leader{
  	background-color: #fff83b;
   }
  .tbl_report thead tr td{
		font-size:15pt;
		font-weight: bold;
	}
	.header{
		font-family: 'Bodoni MT';
		text-align: center;
		font-size:18pt;
		font-weight: bold;
		margin: 40px;
	}
  @media print{
  	.tbl_report{
	    width: 100%;
	    font-family: 'Bodoni MT';
	    border-color: #807c7c;
	}
	.tbl_report thead tr td{
		text-align: center;
		border-color: #807c7c;
	}
	.tbl_report tbody tr td{
		padding-left: 10px;
		border-color: #807c7c;
	}
	.tbl_report tbody .leader{
	  	background-color: #fff83b;
	}
	.tbl_report thead tr td{
		font-size:15pt;
		font-weight: bold;
	}
  }
</style>
<div class="header">
	Barangay <span class="barangay_name"></span> Ward List<br>
</div>
<div class="row shadow-none m-3 rounded">
	<table border="1" class="tbl_report">
		<thead>
			<tr>
				<td rowspan="2">#</td>
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
				$wardlist = $data['wardlist'];
				foreach ($wardlist as $key => $ward) {
					$leader = $ward['leader'];
					$leader_info = (object) $leader;
			?>
				<tr>
					<td class="leader"><?php echo ++$ctr; ?></td>
					<td class="leader"><?php echo $leader_info->lastname; ?></td>
					<td class="leader"><?php echo $leader_info->firstname.' '.$leader_info->suffix; ?></td>
					<td class="leader"><?php echo $leader_info->middlename; ?></td>
					<td class="leader"><?php echo $leader_info->votersno; ?></td>
					<td class="leader"><?php echo $leader_info->precinctno; ?></td>
					<td class="leader"><?php echo $leader_info->purokno; ?></td>
					<td class="leader"><?php echo $leader_info->clusterno; ?></td>
				</tr>
			<?php
					foreach ($ward['members'][$leader_info->wardid] as $key => $member) {
						$member_info = (object) $member;
			?>
					<tr>
						<td></td>
						<td><?php echo $member_info->lastname; ?></td>
						<td><?php echo $member_info->firstname.' '.$leader_info->suffix; ?></td>
						<td><?php echo $member_info->middlename; ?></td>
						<td><?php echo $member_info->votersno; ?></td>
						<td><?php echo $member_info->precinctno; ?></td>
						<td><?php echo $member_info->purokno; ?></td>
						<td><?php echo $member_info->clusterno; ?></td>
					</tr>
			<?php
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