
$('#btn_view_leaders').fadeOut();
$('#btn_delete_ward').fadeOut();
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
//Datatable ward leaders list 
var dt_leaderslist = $('#table_leader_list').DataTable({
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
		$('#btn_view_leaders').fadeIn();
	}

	if (barangay != 0) {
		get_voters(barangay);
		get_ward_leaders(barangay);
		clear();
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
		$('#modal_message_box #modal_title').html("Warning!");
		$('#modal_message_box #modal_body').html(fullname + ' is already added in the member list!');
		$('#modal_message_box').modal('show');
	}
	else{
		if (isSupporter(id, fullname, 'leader')){
			$('#modal_message_box #modal_title').html("Warning!");
			$('#modal_message_box #modal_body').html(fullname + ' is already a ward leader!');
			$('#modal_message_box').modal('show');
			return;
		}

		if (isSupporter(id, fullname, 'member')){
			var name = get_wardleader(id);
			$('#modal_message_box #modal_title').html("Warning!");
			$('#modal_message_box #modal_body').html(fullname + ' is already member of '+name+'!');
			$('#modal_message_box').modal('show');
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
		$('#modal_message_box #modal_title').html("Warning!");
		$('#modal_message_box #modal_body').html(fullname + ' is already selected as ward leader!');
		$('#modal_message_box').modal('show');
	}
	else if (isMemberExist(id)){
		$('#modal_message_box #modal_title').html("Warning!");
		$('#modal_message_box #modal_body').html(fullname + ' is already in the list!');
		$('#modal_message_box').modal('show');
	}
	else{
		if (isSupporter(id, fullname, 'leader')){
			$('#modal_message_box #modal_title').html("Warning!");
			$('#modal_message_box #modal_body').html(fullname + ' is already a ward leader!');
			$('#modal_message_box').modal('show');
			return;
		}

		if (isSupporter(id, fullname, 'member')){
			var name = get_wardleader(id);
			$('#modal_message_box #modal_title').html("Warning!");
			$('#modal_message_box #modal_body').html(fullname + ' is already member of '+name+'!');
			$('#modal_message_box').modal('show');
			return;
		}

		$('#table_member_list tbody').append('<tr><td style="display:none">'+id+'</td>' + 
										'<td>'+ ++member_counter +'</td>'+
										'<td>'+firstname+'</td>'+
										'<td>'+middlename+'</td>'+
										'<td>'+lastname+'</td>'+
										'<td><button type="button" value="' + id + '" class="btn btn-danger" id="btn_remove_member" data-toggle="tooltip" data-placement="top" title="Remove Member"><i class="fas fa-trash"> Remove</i></button></td></tr>');
	}
	
});

//Modal Remove Confirmation
$('body').on('click', '#btn_remove_member', function(){
	$('#modal_remove_confirm').modal('show');
	member_id = $(this).val();
	var firstname = $(this).closest("tr").find('td:eq(2)').text(),
		middlename = $(this).closest("tr").find('td:eq(3)').text(),
		lastname = $(this).closest("tr").find('td:eq(4)').text(),
		fullname = firstname + ' ' + middlename + ' ' + lastname;

	if (isSupporter(member_id, fullname, 'member')){
		$('#modal_body_message').html('This is an irreversible action. Are you sure you want to remove ' + fullname + ' as a member?');
	}
	else{
		$('#modal_body_message').html('Are you sure you want to remove ' + fullname + ' as a member?');
	}
});

//Remove Button
$('#btn_confirm').click(function(e){
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
    $('#modal_remove_confirm').modal('toggle');
});

//Button Submit
$('#btn_submit').click(function(){
	var rows = $('#table_member_list tbody tr').length;
	var barangay = $('#cbo_barangay').val();
    var ctr = 0;
    var members = [];
    var leader = $('#text_ward_leader_id').val();
    var wardid = $('#text_ward_id').val();

    if (leader == ''){
    	$('#modal_message_box #modal_title').html("Error!");
		$('#modal_message_box #modal_body').html('Please select a ward leader first!');
		$('#modal_message_box').modal('show');
    }
    else if (rows == 0){
    	$('#modal_message_box #modal_title').html("Error!");
		$('#modal_message_box #modal_body').html('Please select at least one member!');
		$('#modal_message_box').modal('show');
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
	$('#btn_delete_ward').fadeIn();
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
		$('#modal_message_box #modal_title').html("Warning!");
		$('#modal_message_box #modal_body').html('Nothing to remove. Please select and view a ward to remove!');
		$('#modal_message_box').modal('show');
	}
	else{
		$('#modal_remove_ward_body_message').html("This is an irreversible action. Are you sure you want to delete this ward?");
		$('#modal_remove_ward_confirm').modal('show');
	}
})

$('#btn_delete_ward_confirm').click(function(){
	var wardid = $('#text_ward_id').val();
	var barangay = $('#cbo_barangay').val();
	delete_ward(wardid);
	get_ward_leaders(barangay);
	clear();
	$('#modal_remove_ward_confirm').modal('toggle');
})

//Function: Retrieve Voters By Barangay
function get_voters(barangay){
	$.ajax({
		url: 'ward/get_voters_list',
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
	        		'<button type="button" value="' + arr['id'] + '" class="btn btn-primary" id="btn_select_leader" data-toggle="tooltip" data-placement="top" title="Select Leader"><i class="fas fa-check"> Select</i></button>',
	        		'<button type="button" value="' + arr['id'] + '" class="btn btn-success" id="btn_add_member" data-toggle="tooltip" data-placement="top" title="Add Member"><i class="fas fa-plus"> Add</i></button>'
	        	] ).draw();
	        });

		},
		error: function(obj, err, ex){
		
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
	        		'<button type="button" value="' + arr['id'] + '" class="btn btn-primary" id="btn_view_ward" data-toggle="tooltip" data-placement="top" title="Select Leader"><i class="fas fa-eye"> View</i></button>'
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
		url: 'ward/check_if_supporter',
		method: 'POST',
		data: {id: id, position: position},
		async: false,
		dataType: 'JSON',
		success: function(result) {
			flag = result;
		},
		error: function(obj, err, ex){
		
		}
	})

	return flag;
}

//Function: Save Ward
function save_ward(leader, members, barangay){
	$.ajax({
		url: 'ward/save_ward',
		method: 'POST',
		data: {leader: leader, members: members, barangay: barangay},
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				$('#modal_message_box #modal_title').html("Success!");
				$('#modal_message_box #modal_body').html('Ward successfully saved!');
				$('#modal_message_box').modal('show');
			}
			else {
				$('#modal_message_box #modal_title').html("Error!");
				$('#modal_message_box #modal_body').html('Error during saving!');
				$('#modal_message_box').modal('show');
			}
		},
		error: function(obj, err, ex){
		
		}
	})
}

//Function: Update Ward
function update_ward(wardid, leader, members, barangay){
	$.ajax({
		url: 'ward/update_ward',
		method: 'POST',
		data: {wardid: wardid, leader: leader, members: members, barangay: barangay},
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				$('#modal_message_box #modal_title').html("Success!");
				$('#modal_message_box #modal_body').html('Ward successfully updated!');
				$('#modal_message_box').modal('show');
			}
			else {
				$('#modal_message_box #modal_title').html("Error!");
				$('#modal_message_box #modal_body').html('Error during updating!');
				$('#modal_message_box').modal('show');
			}
		},
		error: function(obj, err, ex){
		
		}
	})
}

//Function: Get Ward Leader Name
function get_wardleader(id){
	var name;
	$.ajax({
		url: 'ward/get_wardleader',
		method: 'POST',
		data: {id: id},
		async: false,
		dataType: 'JSON',																																	
		success: function(result) {
			name = result['firstname']+' '+result['middlename']+' '+result['lastname']+' '+result['suffix'];
		},
		error: function(obj, err, ex){
		
		}
	})
	return name;
}

//Function: Get Members
function get_wardmembers(wardid){
	$.ajax({
		url: 'ward/get_wardmembers',
		method: 'POST',
		data: {wardid: wardid},
		dataType: 'html',																																	
		success: function(result) {
			var ctr = 0;
			var data = JSON.parse(result);
			$('#table_member_list tbody').html('');
	        $.each(data, function(index, arr) {
	        	$('#table_member_list tbody').append('<tr><td style="display:none">'+arr['id']+'</td>' + 
										'<td>'+ ++ctr +'</td>'+
										'<td>'+arr['firstname']+' '+arr['suffix']+'</td>'+
										'<td>'+arr['middlename']+'</td>'+
										'<td>'+arr['lastname']+'</td>'+
										'<td><button type="button" value="' + arr['id'] + '" class="btn btn-danger" id="btn_remove_member" data-toggle="tooltip" data-placement="top" title="Remove Member"><i class="fas fa-trash"> Remove</i></button></td></tr>');
	        });
		},
		error: function(obj, err, ex){
		
		}
	})
}

//Function: Remove Member
function remove_ward_member(id){
	$.ajax({
		url: 'ward/remove_ward_member',
		method: 'POST',
		data: {id: id},
		dataType: 'html',																																	
		success: function(result) {
			
		},
		error: function(obj, err, ex){
		
		}
	})
}

function clear(){
	$('#text_ward_id').val('');
	$('#text_ward_leader_id').val('');
	$('#text_ward_leader_name').val('');
	$('#table_member_list tbody').html('');
	$('#btn_delete_ward').fadeOut();
	submit = "save";
	member_counter = 0;
}

//Function: Delete Ward
function delete_ward(wardid){
	$.ajax({
		url: 'ward/delete_ward',
		method: 'POST',
		data: {wardid: wardid},
		dataType: 'html',
		success: function(result) {
			if (result == 1){
				$('#modal_message_box #modal_title').html("Success!");
				$('#modal_message_box #modal_body').html('Ward successfully removed!');
				$('#modal_message_box').modal('show');
			}
			else {
				$('#modal_message_box #modal_title').html("Error!");
				$('#modal_message_box #modal_body').html('Error during deleting!');
				$('#modal_message_box').modal('show');
			}
		},
		error: function(obj, err, ex){
		
		}
	})
}