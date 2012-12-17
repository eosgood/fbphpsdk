$(document).ready(function(){
  function init(){
    
    var fb_app_id = $("meta[property='fb:app_id']").attr("content");

    FB.init({
      appId  : fb_app_id,
      cookie : true,
      xfbml  : true
    });

    FB.getLoginStatus(fb_status.update);
    $('#fb-status').click(function(){
      FB.getLoginStatus(fb_status.update, true);
    })

    FB.Event.subscribe('auth.login', function(response) {
      window.location.reload();
    });
    FB.Event.subscribe('auth.logout', function(response) {
      window.location.reload();
    });
  }

  if(window.FB) {
    init();
  } else {
    window.fbAsyncInit = init;
  }
});