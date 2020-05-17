
setTimeout(function(){ get_voters_list(); }, 2000);

//Function: Get voters list 
function get_voters_list(){
	$.ajax({
		url: 'voter/get_voters_list',
		method: 'POST',
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
			$('#voters_list').html(result);
		},
		error: function(obj, err, ex){
		
		}
	})
}