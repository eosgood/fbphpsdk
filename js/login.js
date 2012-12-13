$('#login-js').click(function(){
	FB.login(function(response) {

	});
});

$('#perms-js').click(function(){
	FB.login(function(response) {
		
	}, {scope: 'publish_stream'});
});