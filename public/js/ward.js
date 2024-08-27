
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
        "responsive": true,
		columnDefs: [
			{ className: 'text-center', targets: [0] },
			{ className: 'text-center', targets: [4] },
			{ className: 'text-center', targets: [5] }
		]
    });
//Datatable ward leaders list 
var dt_leaderslist = $('#table_leader_list').DataTable({
        "order": [[ 3, "asc" ]],
        "ordering": false,
        "pageLength": 5,
        "deferRender": true,
        "responsive": true,
		columnDefs: [
			{ className: 'text-center', targets: [0] },
			{ className: 'text-center', targets: [4] },
			{ className: 'text-center', targets: [5] }
		]
    });

//Select Barangay and Retrieve Voters
$('#cbo_barangay').on('change', function() {
	var barangay = $('#cbo_barangay').val();

	if (barangay != 0) {
		$('#btn_view_leaders').removeClass('invisible');
		get_voters(barangay);
		get_ward_leaders(barangay);
		clear();
	}
	else{
		$('#btn_view_leaders').addClass('invisible');
	}
	
});

//Hide Add Member Control
$('#btn_search_leader').click(function(){
	dt_voterslist.search('').draw();
	dt_voterslist.column(4).visible(true);
	dt_voterslist.column(5).visible(false);
});

//Hide Select Leader Control
$('#btn_search_member').click(function(){
	dt_voterslist.search('').draw();
	dt_voterslist.column(4).visible(false);
	dt_voterslist.column(5).visible(true);
});

//Select Ward Leader
$('body').on('click', '#btn_select_leader', function(){
	var fullname = $(this).closest("tr").find('td:eq(1)').text() + ' ' + $(this).closest("tr").find('td:eq(2)').text() + ' ' + $(this).closest("tr").find('td:eq(3)').text();
	var id = $(this).val();

	if (isMemberExist(id)){
		Swal.fire({
			title: "Warning",
			text: fullname + ' is already added in the member list!',
			icon: "warning",
			confirmButtonColor: "#fecf6d",
		});
	}
	else{
		if (isSupporter(id, fullname, 'leader')){
			Swal.fire({
				title: "Warning",
				text: fullname + ' is already a ward leader!',
				icon: "warning",
				confirmButtonColor: "#fecf6d",
			});
			return;
		}

		if (isSupporter(id, fullname, 'member')){
			var name = get_wardleader(id);
			Swal.fire({
				title: "Warning",
				text: fullname + ' is already a member of '+name+'!',
				icon: "warning",
				confirmButtonColor: "#fecf6d",
			});

			return;
		}
		
		clear();
		$('#text_ward_leader_id').val(id);
		$('#text_ward_leader_name').val(fullname);
		$('#modal_voters_list').modal('toggle');
		
	}
});

//Add Ward Member
$('body').on('click', '#btn_add_member', function(){
	var firstname = $(this).closest("tr").find('td:eq(1)').text(),
		middlename = $(this).closest("tr").find('td:eq(2)').text(),
		lastname = $(this).closest("tr").find('td:eq(3)').text(),
		id = $(this).val(),
		leader_id = $('#text_ward_leader_id').val(),
		fullname = firstname + ' ' + middlename + ' ' + lastname;

	if (leader_id == id){
		Swal.fire({
			title: "Warning",
			text: fullname + ' is already selected as ward leader!',
			icon: "warning",
			confirmButtonColor: "#fecf6d",
		});
	}
	else if (isMemberExist(id)){
		Swal.fire({
			title: "Warning",
			text: fullname + ' is already in the list!',
			icon: "warning",
			confirmButtonColor: "#fecf6d",
		});
	}
	else{
		if (isSupporter(id, fullname, 'leader')){
			Swal.fire({
				title: "Warning",
				text: fullname + ' is already a ward leader!',
				icon: "warning",
				confirmButtonColor: "#fecf6d",
			});
			return;
		}

		if (isSupporter(id, fullname, 'member')){
			var name = get_wardleader(id);
			Swal.fire({
				title: "Warning",
				text: fullname + ' is already a member of '+name+'!',
				icon: "warning",
				confirmButtonColor: "#fecf6d",
			});
			return;
		}

		$('#table_member_list tbody').append('<tr><td style="display:none">'+id+'</td>' + 
										'<td class="text-center">'+ ++member_counter +'</td>'+
										'<td>'+firstname+'</td>'+
										'<td>'+middlename+'</td>'+
										'<td>'+lastname+'</td>'+
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

	if (isSupporter(member_id, fullname, 'member')){
		Swal.fire({
			title: "Confirm",
			text: "This is an irreversible action. Are you sure you want to remove " + fullname + " as a member?",
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
			text: "Are you sure you want to remove " + fullname + " as a member?",
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

	if (isSupporter(member_id, '', 'member')){
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
    var leader = $('#text_ward_leader_id').val();
    var wardid = $('#text_ward_id').val();

    if (leader == ''){
		Swal.fire({
			title: "Error",
			text: "Please select a ward leader first!",
			icon: "error",
			confirmButtonColor: "#b34045",
		});
    }
    else if (rows == 0){
		Swal.fire({
			title: "Error",
			text: "Please select at least one member!",
			icon: "error",
			confirmButtonColor: "#b34045",
		});
    }
    else{
	    $('#table_member_list tbody').find('tr').each(function(){
	      	var $this = $(this);
	    	members[ctr] = $('td:eq(0)', $this).text();
	    	ctr++;
		});

		if (submit == 'save'){
			save_ward(leader, members, barangay);
		}
		else if (submit == 'update'){
			update_ward(wardid, leader, members, barangay);
		}

		get_ward_leaders(barangay);
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
	var wardid = $('#text_ward_id').val();
	if (wardid == ''){
		Swal.fire({
			title: "Warning",
			text: "Nothing to remove. Please select and view a ward to remove!",
			icon: "warning",
			confirmButtonColor: "#fecf6d",
		});
	}
	else{
		Swal.fire({
			title: "Confirm",
			text: "This is an irreversible action. Are you sure you want to delete this ward?",
			icon: "question",
			showCancelButton: true,	
			showConfirmButton: true,	
			confirmButtonColor: "#17a2b8"
		}).then((res) => {
			if (res.value) {
				var wardid = $('#text_ward_id').val();
				var barangay = $('#cbo_barangay').val();
				delete_ward(wardid);
				get_ward_leaders(barangay);
				clear();
			}
		});
	}
})

//Function: Retrieve Voters By Barangay
function get_voters(barangay){
	$.ajax({
		url: 'get_voters_list',
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
	        	dt_voterslist.row.add( [ ++ctr, arr['firstname'] + ' ' + arr['suffix'], arr['middlename'], arr['lastname'], 
	        		'<button type="button" value="' + arr['id'] + '" class="btn btn-sm btn-primary" id="btn_select_leader" data-toggle="tooltip" data-placement="top" title="Select Leader"><i class="fas fa-check mr-2"></i>Select</button>',
	        		'<button type="button" value="' + arr['id'] + '" class="btn btn-sm btn-success" id="btn_add_member" data-toggle="tooltip" data-placement="top" title="Add Member"><i class="fas fa-plus mr-2"></i>Add</button>'
	        	] ).draw();
	        });

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

//Function: Retrieve Ward Leaders By Barangay
function get_ward_leaders(barangay){
	$.ajax({
		url: 'get_ward_leaders_list',
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
				text: err + ": " + obj.status + " " + ex,
				icon: "error",
				confirmButtonColor: "#b34045",
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
function isSupporter(id, name, position){
	var flag = false;

	$.ajax({
		url: 'check_if_supporter',
		method: 'POST',
		data: {id: id, position: position},
		async: false,
		dataType: 'JSON',
		success: function(result) {
			flag = result;
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

	return flag;
}

//Function: Save Ward
function save_ward(leader, members, barangay){
	$.ajax({
		url: 'save_ward',
		method: 'POST',
		data: {leader: leader, members: members, barangay: barangay},
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				Swal.fire({
					title: "Success",
					text: "Supporters list sucessfully saved!",
					icon: "success",
					confirmButtonColor: "#00939D",
				});
			}
			else {
				Swal.fire({
					title: "Error",
					text: "Error during saving!",
					icon: "error",
					confirmButtonColor: "#b34045",
				});
			}
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

//Function: Update Ward
function update_ward(wardid, leader, members, barangay){
	$.ajax({
		url: 'update_ward',
		method: 'POST',
		data: {wardid: wardid, leader: leader, members: members, barangay: barangay},
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				Swal.fire({
					title: "Success",
					text: "Supporters list sucessfully updated!",
					icon: "success",
					confirmButtonColor: "#00939D",
				});
			}
			else {
				Swal.fire({
					title: "Error",
					text: "Error during updating!",
					icon: "error",
					confirmButtonColor: "#b34045",
				});
			}
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

//Function: Get Ward Leader Name
function get_wardleader(id){
	var name;
	$.ajax({
		url: 'get_wardleader',
		method: 'POST',
		data: {id: id},
		async: false,
		dataType: 'JSON',																																	
		success: function(result) {
			name = result['firstname']+' '+result['middlename']+' '+result['lastname']+' '+result['suffix'];
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
	return name;
}

//Function: Get Members
function get_wardmembers(wardid){
	$.ajax({
		url: 'get_wardmembers',
		method: 'POST',
		data: {wardid: wardid},
		dataType: 'html',																																	
		success: function(result) {
			member_counter = 0;
			var data = JSON.parse(result);
			$('#table_member_list tbody').html('');
	        $.each(data, function(index, arr) {
	        	$('#table_member_list tbody').append('<tr><td style="display:none">'+arr['id']+'</td>' + 
										'<td class="text-center">'+ ++member_counter +'</td>'+
										'<td>'+arr['firstname']+' '+arr['suffix']+'</td>'+
										'<td>'+arr['middlename']+'</td>'+
										'<td>'+arr['lastname']+'</td>'+
										'<td class="text-center"><button type="button" value="' + arr['id'] + '" class="btn btn-sm btn-danger" id="btn_remove_member" data-toggle="tooltip" data-placement="top" title="Remove Member"><i class="fas fa-trash"></i></button></td></tr>');
	        });
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

//Function: Remove Member
function remove_ward_member(id){
	$.ajax({
		url: 'remove_ward_member',
		method: 'POST',
		data: {id: id},
		dataType: 'html',																																	
		success: function(result) {
			
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
function delete_ward(wardid){
	$.ajax({
		url: 'delete_ward',
		method: 'POST',
		data: {wardid: wardid},
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				Swal.fire({
					title: "Success",
					text: "Supporters list sucessfully deleted!",
					icon: "success",
					confirmButtonColor: "#00939D",
				});
			}
			else {
				Swal.fire({
					title: "Error",
					text: "Error during deleting!",
					icon: "error",
					confirmButtonColor: "#b34045",
				});
			}
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