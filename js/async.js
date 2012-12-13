$('#getButton').click(function(){
	var success = function(response, textStatus, jqXHR) {
		var response_obj = jQuery.parseJSON(response);
		$('#user-raw').html(response);
		$('#user-id').html(response_obj.id);
		$('#user-name').html(response_obj.name);
		$('#user-gender').html(response_obj.gender);	
	};

	$.ajax({
		url: '/async/get.php',
		type: 'post',
		data: {graph: 1},
		success: success
	});
});

$('#postButton').click(function(){
	$('#post-error').removeClass();
	$('#post-error').html('');
	$('#post-id').removeClass();
	$('#post-id').html('');

	var success = function(response, textStatus, jqXHR) {

		var response_obj = jQuery.parseJSON(response);
		if(response_obj.error) {
			console.log('error');
			$('#post-error').addClass('alert');
			$('#post-error').addClass('alert-error');
			$('#post-error').html(response_obj.error);	
		}

		if(response_obj.id) {
			$('#post-id').addClass('alert');
			$('#post-id').addClass('alert-success');
			$('#post-id').html('Post created: ' + response_obj.id);
		}
	};

	$.ajax({
		url: '/async/post.php',
		type: 'post',
		data: {graph: 1},
		success: success
	});

});

