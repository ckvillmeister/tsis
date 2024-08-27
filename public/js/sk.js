
//$('#btn_view_leaders').fadeOut();
//$('#btn_delete_ward').fadeOut();
//Variable for Member Count
var member_counter = 0;
//Variable indicator if save or update
var submit = 'save';
//Variable for selected member to remove / delete
var member_id;
//Datatable voters list
var dt_voterslist = $('#table_voter_list').DataTable({
        "order": [[ 3, "asc" ]],
        "ordering": false,
        "pageLength": 5,
        "deferRender": true,
        "responsive": true
    });

//Select Barangay and Retrieve Voters
$('#cbo_barangay').on('change', function() {
	var barangay = $('#cbo_barangay').val();

	if (barangay != 0) {
		$('#btn_view_leaders').removeClass('invisible');
		get_voters(barangay);
		get_sk(barangay);
		clear();
		$('#btn_delete_ward').removeClass('invisible');
	}
	else{
		$('#btn_view_leaders').addClass('invisible');
	}
	
});

//Hide Select Leader Control
$('#btn_search_member').click(function(){
	dt_voterslist.search('').draw();
});

//Add Ward Member
$('body').on('click', '#btn_add_member', function(){
	var firstname = $(this).closest("tr").find('td:eq(1)').text(),
		middlename = $(this).closest("tr").find('td:eq(2)').text(),
		lastname = $(this).closest("tr").find('td:eq(3)').text(),
		precinct = $(this).closest("tr").find('td:eq(4)').text(),
		id = $(this).val(),
		leader_id = $('#text_ward_leader_id').val(),
		fullname = firstname + ' ' + middlename + ' ' + lastname;

	if (isMemberExist(id)){
		Swal.fire({
			title: "Warning",
			text: fullname + ' is already added in the SK supporters list!',
			icon: "warning",
			confirmButtonColor: "#fecf6d"
		});
	}
	else{
		if (isSupporter(id)){
			Swal.fire({
				title: "Warning",
				text: fullname + ' is already added in the SK supporters list!',
				icon: "warning",
				confirmButtonColor: "#fecf6d"
			});

			return;
		}

		$('#table_member_list tbody').append('<tr><td style="display:none">'+id+'</td>' + 
										'<td class="text-center">'+ ++member_counter +'</td>'+
										'<td>'+lastname+'</td>'+
										'<td>'+firstname+'</td>'+
										'<td>'+middlename+'</td>'+
										'<td class="text-center">'+precinct+'</td>'+
										'<td class="text-center"><button type="button" value="' + id + '" class="btn btn-sm btn-danger" id="btn_remove_member" data-toggle="tooltip" data-placement="top" title="Remove Member"><i class="fas fa-trash"></i></button></td></tr>');
	}
	
});

//Modal Remove Confirmation
$('body').on('click', '#btn_remove_member', function(){
	member_id = $(this).val();
	var firstname = $(this).closest("tr").find('td:eq(2)').text(),
		middlename = $(this).closest("tr").find('td:eq(3)').text(),
		lastname = $(this).closest("tr").find('td:eq(4)').text(),
		fullname = firstname + ' ' + middlename + ' ' + lastname;

	if (isSupporter(member_id)){
		Swal.fire({
			title: "Confirm",
			text: "This is an irreversible action. Are you sure you want to remove " + fullname + " as an SK supporter?",
			icon: "question",
			showCancelButton: true,	
			showConfirmButton: true,	
			confirmButtonColor: "#17a2b8"
		}).then((res) => {
			if (res.value) {
				removeMember();
			}
		});
	}
	else{
		Swal.fire({
			title: "Confirm",
			text: "Are you sure you want to remove " + fullname + " from the list?",
			icon: "question",
			showCancelButton: true,	
			showConfirmButton: true,	
			confirmButtonColor: "#17a2b8"
		}).then((res) => {
			if (res.value) {
				removeMember();
			}
		});
	}
});

//Remove Member
function removeMember(){
	var i = 0;
	$('#table_member_list tbody').find('tr').each(function(){
		var col = $(this).closest("tr").find('td:eq(0)').text();
		
		if (col == member_id){
			$("#table_member_list tbody tr:eq("+i+")").remove();
		}

		i++;
	});

	if (isSupporter(member_id)){
		remove_ward_member(member_id);
	}
	
	var no = 1;
    $('#table_member_list tbody').find('tr').each(function(){
        var $this = $(this);
        $('td:eq(1)', $this).text(no);
        no++;
    });
    member_counter--;
}

//Button Submit
$('#btn_submit').click(function(){
	var rows = $('#table_member_list tbody tr').length;
	var barangay = $('#cbo_barangay').val();
    var ctr = 0;
    var members = [];

    if (rows == 0){
    	Swal.fire({
			title: "Empty",
			text: "Please add SK supporters!",
			icon: "error",
			confirmButtonColor: "#b34045"
		});
    }
    else{
	    $('#table_member_list tbody').find('tr').each(function(){
	      	var $this = $(this);
	    	members[ctr] = $('td:eq(0)', $this).text();
	    	ctr++;
		});

		update_sk(members, barangay);
		clear();
	}
})

//Button View Ward
$('body').on('click', '#btn_view_ward', function(){
	//$('#btn_delete_ward').fadeIn();
	$('#btn_delete_ward').removeClass('invisible');
	var fullname = $(this).closest("tr").find('td:eq(1)').text() + ' ' + $(this).closest("tr").find('td:eq(2)').text() + ' ' + $(this).closest("tr").find('td:eq(3)').text();
	var leaderid = $(this).val();
	var wardid = $(this).closest("tr").find('td:eq(4)').text();
	
	$('#text_ward_id').val(wardid);
	$('#text_ward_leader_id').val(leaderid);
	$('#text_ward_leader_name').val(fullname);
	$('#modal_leader_list').modal('toggle');
	get_wardmembers(wardid);
	submit = "update";
});

//Button Delete Ward
$('#btn_delete_ward').click(function(){
	var supporters = $('#table_member_list tbody tr').length;
	if (supporters == 0){
		Swal.fire({
			title: "Warning",
			text: "Nothing to remove. Please select a barangay with at least one supporter!",
			icon: "warning",
			confirmButtonColor: "#fecf6d"
		});
	}
	else{
		Swal.fire({
			title: "Confirm",
			text: "This is an irreversible action. Are you sure you want to delete all SK supporters from this barangay?",
			icon: "question",
			showCancelButton: true,	
			showConfirmButton: true,	
			confirmButtonColor: "#17a2b8"
		}).then((res) => {
			if (res.value) {
				var wardid = $('#text_ward_id').val();
				var barangay = $('#cbo_barangay').val();
				delete_ward(barangay);
				clear();
			}
		});
	}
})

//Function: Retrieve Voters By Barangay
function get_voters(barangay){
	$.ajax({
		url: 'get_sk_list',
		method: 'POST',
		data: {barangay: barangay},
		dataType: 'html',
		beforeSend: function() {
		    $('.overlay-wrapper').html('<div class="overlay">' +
		    					'<i class="fas fa-3x fa-sync-alt fa-spin"></i>' +
		    					'<div class="text-bold pt-2">Loading...</div>' +
            					'</div>');
		},
		complete: function(){
		    $('.overlay-wrapper').html('');
		},
		success: function(result) {
			var ctr=0;
			var data = JSON.parse(result);
			dt_voterslist.clear().draw();

	        $.each(data, function(index, arr) {
	        	dt_voterslist.row.add( [ ++ctr, arr['firstname'], arr['middlename'], arr['lastname'], arr['precinctno'],
	        		'<button type="button" value="' + arr['id'] + '" class="btn btn-sm btn-success" id="btn_add_member" data-toggle="tooltip" data-placement="top" title="Add Member"><i class="fas fa-plus mr-2"></i>Add</button>'
	        	] ).draw();
	        });

		},
		error: function(obj, err, ex){
			Swal.fire({
				title: "Error",
				text: msg + ": " + obj.status + " " + exception,
				icon: "error",
				confirmButtonColor: "#b34045"
			});
		}
	})
}

//Function: Retrieve Ward Leaders By Barangay
function get_ward_leaders(barangay){
	$.ajax({
		url: 'ward/get_ward_leaders_list',
		method: 'POST',
		data: {barangay: barangay},
		dataType: 'html',
		beforeSend: function() {
		    $('.overlay-wrapper').html('<div class="overlay">' +
		    					'<i class="fas fa-3x fa-sync-alt fa-spin"></i>' +
		    					'<div class="text-bold pt-2">Loading...</div>' +
            					'</div>');
		},
		complete: function(){
		    $('.overlay-wrapper').html('');
		},
		success: function(result) {
			var ctr=0;
			var data = JSON.parse(result);
			dt_leaderslist.clear().draw();

	        $.each(data, function(index, arr) {
	        	dt_leaderslist.row.add( [ ++ctr, arr['firstname'] + ' ' + arr['suffix'], arr['middlename'], arr['lastname'], arr['wardid'],
	        		'<button type="button" value="' + arr['id'] + '" class="btn btn-sm btn-primary" id="btn_view_ward" data-toggle="tooltip" data-placement="top" title="Select Leader"><i class="fas fa-eye mr-2"></i>View</button>'
	        	] ).draw();
	        });

	        $('body').css({ 
	            border: '', 
	            backgroundColor: '', 
	            '-webkit-border-radius': '', 
	            '-moz-border-radius': '', 
	            opacity: 1, 
	            color: '',
	            cursor: 'default'
	        });

		},
		error: function(obj, err, ex){
			Swal.fire({
				title: "Error",
				text: msg + ": " + obj.status + " " + exception,
				icon: "error",
				confirmButtonColor: "#b34045"
			});
		}
	})
}

//Function: Check if Voter is Already in the List
function isMemberExist(id){
	var flag = false;

	$('#table_member_list').find('tr').each(function(){
	    var $this = $(this);
	    if(id == $('td:eq(0)', $this).text()){
	        flag = true;
	    }
	});

	if(flag){
	  return true;
	}
	else{
	  return false;
	}
}

//Function: Check if Voter is Already a Supporter
function isSupporter(id){
	var flag = false;

	$.ajax({
		url: 'check_if_sk_supporter',
		method: 'POST',
		data: {id: id},
		async: false,
		dataType: 'JSON',
		success: function(result) {
			flag = result;
		},
		error: function(obj, err, ex){
			Swal.fire({
				title: "Error",
				text: msg + ": " + obj.status + " " + exception,
				icon: "error",
				confirmButtonColor: "#b34045"
			});
		}
	})

	return flag;
}

//Function: Save Ward
function update_sk(members, barangay){
	$.ajax({
		url: 'save_sk',
		method: 'POST',
		data: {members: members, barangay: barangay},
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				Swal.fire({
					title: "Saved",
					text: "SK supporters successfully saved!",
					icon: "success",
					confirmButtonColor: "#00939D"
				});
				$('#cbo_barangay').val('');
			}
			else {
				Swal.fire({
					title: "Error",
					text: "Error during saving",
					icon: "error",
					confirmButtonColor: "#b34045"
				});
			}
		},
		error: function(obj, err, ex){
			Swal.fire({
				title: "Error",
				text: msg + ": " + obj.status + " " + exception,
				icon: "error",
				confirmButtonColor: "#b34045"
			});
		}
	})
}

//Function: Remove Member
function remove_ward_member(id){
	$.ajax({
		url: 'remove_sk_supporter',
		method: 'POST',
		data: {id: id},
		dataType: 'html',																																	
		success: function(result) {
			
		},
		error: function(obj, err, ex){
			Swal.fire({
				title: "Error",
				text: msg + ": " + obj.status + " " + exception,
				icon: "error",
				confirmButtonColor: "#b34045"
			});
		}
	})
}

function clear(){
	$('#text_ward_id').val('');
	$('#text_ward_leader_id').val('');
	$('#text_ward_leader_name').val('');
	$('#table_member_list tbody').html('');
	//$('#btn_delete_ward').fadeOut();
	$('#btn_delete_ward').addClass('invisible');
	submit = "save";
	member_counter = 0;
}

//Function: Delete Ward
function delete_ward(brgy){
	$.ajax({
		url: 'remove_sk_supporter',
		method: 'POST',
		data: {brgy: brgy},
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				Swal.fire({
					title: "Success",
					text: "Successfully removed all SK supporters!",
					icon: "success",
					confirmButtonColor: "#00939D",
				});
				$('#cbo_barangay').val('');
			}
			else {
				Swal.fire({
					title: "Error",
					text: "Error during updating!",
					icon: "error",
					confirmButtonColor: "#b34045"
				});
			}
		},
		error: function(obj, err, ex){
			Swal.fire({
				title: "Error",
				text: msg + ": " + obj.status + " " + exception,
				icon: "error",
				confirmButtonColor: "#b34045"
			});
		}
	})
}

function get_sk(barangayid){
	$.ajax({
		url: 'get_sk_members',
		method: 'POST',
		data: {barangayid: barangayid},
		dataType: 'html',																																	
		success: function(result) {
			member_counter = 0;
			var data = JSON.parse(result);
			$('#table_member_list tbody').html('');
	        $.each(data, function(index, arr) {
	        	$('#table_member_list tbody').append('<tr><td style="display:none">'+arr['id']+'</td>' + 
										'<td class="text-center" style="width: 60px">'+ ++member_counter +'</td>'+
										'<td>'+arr['lastname']+'</td>'+
										'<td>'+arr['firstname']+'</td>'+
										'<td>'+arr['middlename']+'</td>'+
										'<td class="text-center">'+arr['precinct_no']+'</td>'+
										'<td class="text-center"><button type="button" value="' + arr['id'] + '" class="btn btn-sm btn-danger" id="btn_remove_member" data-toggle="tooltip" data-placement="top" title="Remove Member"><i class="fas fa-trash"></i></button></td></tr>');
	        });
		},
		error: function(obj, err, ex){
			Swal.fire({
				title: "Error",
				text: msg + ": " + obj.status + " " + exception,
				icon: "error",
				confirmButtonColor: "#b34045"
			});
		}
	})
}