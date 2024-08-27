<style>
  #tbl_candidates_list{
    font-size: 10pt
  }

  .col-header {
    font-size: 10pt
  }

</style>

<div class="col-sm-12">
	<div class="row mb-2">
		<div class="col-sm-12">
			<div class="float-right">
			    <div class="btn-group">
			    	<?php if ($data['partyinfo']['status'] == 1){ ?>
			    	<button class="btn btn-sm btn-danger pl-4 pr-4" onclick="toggleParty(<?php echo $data['partyid']; ?>, 0)"><icon class="fas fa-trash mr-2"></icon>Retire Party</button>
			    	<?php }else{ ?>
			    	<button class="btn btn-sm btn-secondary pl-4 pr-4" onclick="toggleParty(<?php echo $data['partyid']; ?>, 1)"><icon class="fas fa-undo mr-2"></icon>Re-activate Party</button>
			    	<?php } ?>
			     	<button class="btn btn-sm btn-info pl-4 pr-4" id="btn-add-member" data-toggle="modal" data-target="#modal_add_member_form"><icon class="fas fa-user mr-2"></icon>Add Member</button>
			    </div>
			</div>
		</div>
	</div>

	<table class="table table-sm table-bordered table-striped display bg-white" style="width: 100%" id="tbl_candidates_list">
	  <thead>
	    <tr>
	      <th class="text-center col-header">No</th>
	      <th class="text-center col-header">Candidate Fullname</th>
	      <th class="text-center col-header">Position</th>
	      <th class="text-center col-header">Control</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  	$ctr = 1;
	  	foreach ($data['members'] as $key => $member) {
	  		$fullname = $member['candidate']['lastname'].', '.$member['candidate']['firstname'];
	  		$fullname = ($member['candidate']['middlename']) ? $fullname.' '.$member['candidate']['middlename'] : $fullname;
	  	?>
	  	<tr>
	  		<td class="text-center"><?php echo $ctr++ ?></td>
	  		<td class="text-center"><?php echo strtoupper($fullname) ?></td>
	  		<td class="text-center"><?php echo $member['position'] ?></td>
	  		<td class="text-center">
	  			<a class="btn btn-sm btn-primary" target=”_blank” id="btn_candidate_profile" value="<?php echo $member['candidate']['id']; ?>" href="<?php echo ROOT; ?>politics/profile?id=<?php echo $member['candidate']['id']; ?>&status=1" title="Politician Profile"><i class="fas fa-list"></i>
              </a>
	  			<button class="btn btn-sm btn-danger" title="Remove Member" onclick="removeMember(<?php echo $member['id']; ?>)"><i class="fas fa-trash"></i></button>
	  		</td>
	  	</tr>
		<?php
		}
		?>
	  </tbody>
	</table>
</div>

<script>
	function removeMember(memberid){
		Swal.fire({
			title: "Confirm",
			text: "Are you sure you want to remove him / her as a member of this party?",
			icon: "question",
			showCancelButton: true,	
			showConfirmButton: true,	
			confirmButtonColor: "#17a2b8"
		}).then((res) => {
			if (res.value) {
				$.ajax({
					url: 'party_remove_member',
					method: 'POST',
					data: {memberid: memberid},
					dataType: 'html',
					success: function(result) {
						get_slate(id, 1);
					},
					error: function(obj, err, ex){
						Swal.fire({
						  title: "Error",
						  text: err + ": " + obj.status + " " + ex,
						  icon: "error",
						  confirmButtonColor: "#b34045",
						});
					}
				  })
			}
		});
	}

	function toggleParty(partyid, status){
		var rows = $('#tbl_candidates_list tbody tr').length;
		var msg = (status) ? "Are you sure you want to re-activate this party?" : "Are you sure you want to retire this party?";

		if (parseInt(rows) >= 1 && status == 0){
			Swal.fire({
				  title: "Error",
				  text: "Cannot retire party. There are still active members",
				  icon: "error",
				  confirmButtonColor: "#b34045",
				});
		}
		else{
			Swal.fire({
				title: "Confirm",
				text: msg,
				icon: "question",
				showCancelButton: true,	
				showConfirmButton: true,	
				confirmButtonColor: "#17a2b8"
			}).then((res) => {
				if (res.value) {
					$.ajax({
						url: 'toggle_party',
						method: 'POST',
						data: {partyid: partyid, status: status},
						dataType: 'html',
						success: function(result) {
							location.href = result;
						},
						error: function(obj, err, ex){
							Swal.fire({
							  title: "Error",
							  text: err + ": " + obj.status + " " + ex,
							  icon: "error",
							  confirmButtonColor: "#b34045",
							});
						}
					  })
				}
			});
		}
		
	}
</script>