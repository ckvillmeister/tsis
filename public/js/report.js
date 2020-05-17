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