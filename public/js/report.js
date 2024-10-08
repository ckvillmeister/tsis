var params = [
    'height='+screen.height,
    'width='+screen.width,
    'fullscreen=yes' // only works in IE, but here for completeness
].join(',');

$('#btn_view_ward_list').click(function() {
	var barangay = $('#cbo_barangay').val();
	var sort = $('#cbo_sort').val();
	var filter = $('#cbo_filter').val();

	if (barangay != 0) {
		get_ward_list(barangay, sort, filter);
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
	var year = $('#cbo_election_years').val();
	if (position != 0) {
		get_comparison(position, year);
	}
});

$('#btn_display_supporters').click(function() {
	var supporter_type = $('#cbo_supporter_type').val(),
		barangay = $('#cbo_barangay').val(),
		cluster = $('#cbo_cluster').val();

	if (barangay != 0) {
		get_supporters_list(supporter_type, barangay, cluster);
	}
	
});

$('#btn_search_result').click(function() {
	var barangay = $('#cbo_barangay').val();
	var purok = $('#cbo_purok').val();
	var name = $('#txt_name').val();
	var cluster = $('#cbo_cluster').val();
	var precinct = $('#cbo_precinct').val();
	var age = $('#age_bracket').val();

	if (barangay != 0) {
		get_search_list(barangay, purok, cluster, precinct, name, age);
		$('#btn_clear').removeClass('invisible');
	}
});

$('#btn_print').click(function(){
	var mywindow = window.open("", '_blank', params);
        setTimeout(function(){ mywindow.document.write($('#report').html())}, 500);
        setTimeout(function(){ mywindow.print();}, 1500);
});

function get_ward_list(barangay, sort, filter){
	$.ajax({
		url: 'get_ward_list',
		method: 'POST',
		data: {barangay: barangay, sort: sort, filter: filter},
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
			$.alert({
	            title: "Error",
	            type: "red",
	            content: msg + ": " + obj.status + " " + exception
	          })
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
			$.alert({
	            title: "Error",
	            type: "red",
	            content: msg + ": " + obj.status + " " + exception
	          })
		}
	})
}

function get_comparison(position, year){
	$.ajax({
		url: 'get_comparison',
		method: 'POST',
		data: {position: position, year: year},
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
			$.alert({
	            title: "Error",
	            type: "red",
	            content: msg + ": " + obj.status + " " + exception
	          })
		}
	})
}

function get_supporters_list(supporter_type, barangay, cluster){
	$.ajax({
		url: 'get_supporters_list',
		method: 'POST',
		data: {type: supporter_type, barangay: barangay, cluster: cluster},
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
			$.alert({
	            title: "Error",
	            type: "red",
	            content: msg + ": " + obj.status + " " + exception
	        })
		}
	})
}

function get_search_list(barangay, purok, cluster, precinct, name, age){
	$.ajax({
		url: 'get_search_list',
		method: 'POST',
		data: {barangay: barangay, purok: purok, cluster: cluster, precinct: precinct, name: name, age: age},
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
			$.alert({
	            title: "Error",
	            type: "red",
	            content: msg + ": " + obj.status + " " + exception
	        })
		}
	})
}