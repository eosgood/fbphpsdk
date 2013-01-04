$('#getButton').click(function(){
	$('#user-error').removeClass('alert alert-error');
	$('#user-error').html('');
	$('.user-data').html('loading...');

	var success = function(response, textStatus, jqXHR) {
		var response_obj = jQuery.parseJSON(response);

		if(response_obj.error) {
			$('#user-error').addClass('alert');
			$('#user-error').addClass('alert-error');
			$('#user-error').html(response_obj.error);	
			return;
		}

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
	$('.post-data').removeClass('alert');
	$('.post-data').html('');

	$('#post-id').html('loading...');

	var success = function(response, textStatus, jqXHR) {

		var response_obj = jQuery.parseJSON(response);
		if(response_obj.error) {
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

$('#photoButton').click(function(){
	$('.photo-data').removeClass('alert');
	$('.photo-data').html('');

	$('#photo-id').html('loading...');

	var success = function(response, textStatus, jqXHR) {

		var response_obj = jQuery.parseJSON(response);
		if(response_obj.error) {
			$('#photo-error').addClass('alert');
			$('#photo-error').addClass('alert-error');
			$('#photo-error').html(response_obj.error);	
		}

		if(response_obj.id) {
			$('#photo-id').addClass('alert');
			$('#photo-id').addClass('alert-success');
			$('#photo-id').html('Post created: ' + response_obj.id);
		}
	};

	$.ajax({
		url: '/async/photo.php',
		type: 'post',
		data: {graph: 1},
		success: success
	});

});

