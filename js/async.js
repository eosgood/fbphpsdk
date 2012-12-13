$('#asyncButton').click(function(){
	var success = function(response, textStatus, jqXHR) {
		var response_obj = jQuery.parseJSON(response);
		$('#user-raw').html(response);
		$('#user-id').html(response_obj.id);
		$('#user-name').html(response_obj.name);
		$('#user-gender').html(response_obj.gender);	
	};

	$.ajax({
		url: '/async/graph.php',
		type: 'post',
		data: {graph: 1},
		success: success
	});
});