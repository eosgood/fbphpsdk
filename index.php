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

$login_url = $facebook->getLoginUrl();
$login_perms_url = $facebook->getLoginUrl(array('scope' => 'publish_stream'));

?>

<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>PHP SDK Sandbox</title>

    <!-- Le styles -->
     <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">

    <meta property="fb:admins" content="6420900" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="PHP SDK Sandbox" />
    <meta property="og:description" content="Test the Facebook PHP SDK" /> 
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
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">PHP SDK Sandbox</a>
          <p class="navbar-text pull-right">
             Logged in as <?php echo $user_name?>
          </p>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="page-header">
        <h1>Welcome to the PHP SDK Sandbox</h1>
      </div>

      <div class="bs-docs-social">
        <ul class="bs-docs-social-buttons">
          <li>
            <iframe class="github-btn" src="https://fbphpsdk.herokuapp.com/github-btn.html?user=eosgood&repo=fbphpsdk&type=watch&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="100px" height="20px"></iframe>
          </li>
          <li>
            <iframe class="github-btn" src="https://fbphpsdk.herokuapp.com/github-btn.html?user=eosgood&repo=fbphpsdk&type=fork&count=true" allowtransparency="true" frameborder="0" scrolling="0" width="150px" height="20px"></iframe>
          </li>
          <li>
            <fb:like layout="button_count" href="https://fbphpsdk.herokuapp.com/"></fb:like>
          </li>
        </ul>
      </div>

      <hr />

      <div class="row">
        <div class="span6">
          <h4>Login using the <a href="https://developers.facebook.com/docs/reference/php/">PHP SDK</a></h4>
          <p>Uses the PHP SDK to login with <a href="https://developers.facebook.com/docs/reference/php/facebook-getLoginUrl/"><code>$facebook->getLoginUrl()</code></a></p>
          <p><a class="btn btn-success" href="<?php echo $login_url; ?>">Login with PHP &raquo;</a></p>
        </div>
        <div class="span6">
          <h4>Login using the <a href="https://developers.facebook.com/docs/reference/javascript/">JS SDK</a></h4>
          <p>Uses the Javascript SDK to login with <a href="https://developers.facebook.com/docs/reference/javascript/FB.login/"><code>FB.login()</code></a></p>
          <p><a class="btn btn-success" id="login-js">Login with JS &raquo;</a></p>
       </div>
      </div>

      <hr />

      <div class="row">
        <div class="span3">
          <h4>Signed Request</h4>
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
        <div class="span8">
          <h4> Raw signed_request </h4>
          <pre>
            <?php print_r($signed_request); ?>
          </pre>
        </div>
      </div>

      <hr />

      <div class="row">
        <div class="span6">
          <h4>GET Request to '/me'</h4>
          <p>Send a GET request to https://graph.facebook.com/me using the php sdk via ajax request</p>
          <p><button id="getButton" class="btn btn-primary" type="button">GET /me</button></p>
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
         <div class="span6">
          <h4>POST Request to '/me'/feed'</h4>
          <p>Send a post request to 'https://graph.facebook.com/me' with the php sdk via ajax call. Requires <code>'publish_stream'</code> permissions.</p>
          <p>
            <a class="btn btn-warning" href="<?php echo $login_perms_url; ?>">Request perms with PHP &raquo;</a>           
            <a class="btn btn-warning" id="perms-js">Request perms with JS &raquo;</a>
          </p>
          <p><button id="postButton" class="btn btn-primary" type="button">POST /me</button></p>
          <div id="post-id"></div>
          <div id="post-error"></div>
        </div>
      </div>

      <footer class="footer">
        <p class="muted pull-right">Copyright &copy; 2012 Eric Osgood</p>
      </footer>

    </div>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/async.js"></script>
    <script src="js/login.js"></script>
  </body>
</html>