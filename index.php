<?php
require_once('utils/AppInfo.php');
require_once('./facebook-php-sdk/src/facebook.php');

$facebook = new Facebook(array(
  'appId'  => AppInfo::appID(),
  'secret' => AppInfo::appSecret(),
));

// See if there is a user from a cookie
$user = $facebook->getUser();
$user_name = 'Not Connected';
$error_message = 'No facebook errors';

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    $user_name = $user_profile['name'];
  } catch (FacebookApiException $e) {
    $error_message = $e;
    $user = null;
  }
}

$signed_request = $facebook->getSignedRequest();


?>

<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

    <meta property="og:type" content="website" />
    <meta property="og:image" content="http://www.troll.me/images/the-most-interesting-man-in-the-world/i-dont-always-test-my-code-but-when-i-do-i-prefer-to-test-in-production.jpg" />
    <meta property="og:url" content="https://fbphpsdk.herokuapp.com/" />
    <meta property="og:site_name" content="PHP SDK Sandbox" />
    <meta property="fb:app_id"  content="<?php echo AppInfo::appID() ?>" />

  <body>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo AppInfo::appID() ?>',
          cookie: true,
          xfbml: true,
          status: true
        });

        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>

    <div class="container-fluid">
      <div class="navbar">
        <div class="navbar-inner">
          <a class="brand" href="#">PHP SDK Tester</a>
          <p class="navbar-text pull-right">
             Logged in as <?php echo $user_name?>
          </p>
        </div>
      </div>
       <div class="hero-unit">
          <h1>Welcome to the PHP SDK Tester</h1>
          <p>This is a site for testing the php sdk</p>
      </div>
      <div class="row-fluid">
        <div class="span2">
          <h2>Login</h2>
          <p><fb:login-button autologoutlink="true"></fb:login-button></p>
          <p><fb:like layout="box_count"></fb:like></p>
        </div>
        <div class="span3">
            <h2>Signed Request</h2>
            <table class="table table-bordered table-striped">
              <tr>
                <td>
	                 <span
	                	rel="popover"
	                	data-title="algorithm"
	                	data-content="A JSON string containing the mechanism used to sign the request"
	                	data-trigger="hover">
	                	Encryption
	                </span>
	               </td>
	               <td><?php echo $signed_request['algorithm']; ?></td>
	            </tr>
              <tr>
                  <td>
                    <span 
                      rel="popover" 
                      data-title="issued_at"
                      data-content="A JSON number containing the Unix timestamp when the request was signed" 
                      data-trigger="hover">
                      Issue Time
                    </span>
                  </td>
                  <td><?php echo $signed_request['issued_at'];?></td>
              </tr>
              <tr>
                  <td>
                    <span 
                      rel="popover" 
                      data-title="user_id"
                      data-content="A JSON number containing the user's id"
                      data-trigger="hover">
                      User ID
                    </span>
                  </td>
                  <td><?php echo $signed_request['user_id']; ?></td>
              </tr>
            </table>
        </div>
        <div class="span3">
          <p>
            <button id="asyncButton" class="btn btn-large btn-primary" type="button">Async /me Request</button>
          </p>
          <table class="table table-bordered table-striped">
             <tr>
              <td>
                <span>User ID</span>
              </td>
              <td id="user-id">Not Loaded</td>
            </tr>
            <tr>
              <td>
                <span>User Name</span>
              </td>
              <td id="user-name">Not Loaded</td>
            </tr>
            <tr>
              <td>
                <span>User Gender</span>
              </td>
              <td id="user-gender">Not Loaded</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span5">
          <h2> Raw signed_request </h2>
          <pre>
            <?php print_r($signed_request); ?>
          </pre>
        </div>
        <div class="span5">
          <h2> Raw /me request</h2>
          <pre id="user-raw">No Data Requested</pre>
        </div>
      </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
     <script src="js/async.js"></script>
  </body>
</html>