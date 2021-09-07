var params = [
    'height='+screen.height,
    'width='+screen.width,
    'fullscreen=yes' // only works in IE, but here for completeness
].join(',');

$('#btn_view_ward_list').click(function() {
	var barangay = $('#cbo_barangay').val();
	if (barangay != 0) {
		get_ward_list(barangay);
	}
});

$('#btn_election_results').click(function() {
	var year = $('#cbo_election_years').val();
	if (year != 0) {
		get_election_result(year);
	}
});

$('#btn_display_comparison').click(function() {
	var position = $('#cbo_positions').val();
	if (position != 0) {
		get_comparison(position);
	}
});

$('#btn_display_supporters').click(function() {
	var supporter_type = $('#cbo_supporter_type').val();
	var barangay = $('#cbo_barangay').val();

	if (supporter_type != 0) {
		get_supporters_list(supporter_type, barangay);
	}
});

$('#btn_search_result').click(function() {
	var barangay = $('#cbo_barangay').val();
	var purok = $('#cbo_purok').val();
	var name = $('#txt_name').val();
	var precinct = $('#cbo_precinct').val();

	if (barangay != 0) {
		get_search_list(barangay, purok, precinct, name);
		$('#btn_clear').removeClass('invisible');
	}
});

$('#btn_print').click(function(){
	var mywindow = window.open("", '_blank', params);
        mywindow.document.write($('#report').html());
        mywindow.print();
});

function get_ward_list(barangay){
	$.ajax({
		url: 'get_ward_list',
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
			$('#report').html(result);
		},
		error: function(obj, err, ex){
			
		}
	})
}

function get_election_result(year){
	$.ajax({
		url: 'get_election_result',
		method: 'POST',
		data: {year: year},
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
			$('#report').html(result);
		},
		error: function(obj, err, ex){
			
		}
	})
}

function get_comparison(position){
	$.ajax({
		url: 'get_comparison',
		method: 'POST',
		data: {position: position},
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
			$('#report').html(result);
		},
		error: function(obj, err, ex){
			
		}
	})
}

function get_supporters_list(supporter_type, barangay){
	$.ajax({
		url: 'get_supporters_list',
		method: 'POST',
		data: {type: supporter_type, barangay: barangay},
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
			$('#report').html(result);
		},
		error: function(obj, err, ex){
			
		}
	})
}

function get_search_list(barangay, purok, precinct, name){
	$.ajax({
		url: 'get_search_list',
		method: 'POST',
		data: {barangay: barangay, purok: purok, precinct: precinct, name: name},
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
			$('#report').html(result);
		},
		error: function(obj, err, ex){
			
		}
	})
}