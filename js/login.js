$('#login-js').click(function(){
	FB.getLoginStatus(function(response){
		if (response.status === 'connected') {
			FB.logout();
		} else {
			FB.login();
		}
	});
});

$('#stream-js').click(function(){
	FB.login(function(response) {
		
	}, {scope: 'publish_stream'});
});

$('#photo-js').click(function(){
	FB.login(function(response) {
		
	}, {scope: 'photo_upload'});
});