<?php

// Provides access to app specific values such as your app id and app secret.
// Defined in 'AppInfo.php'
require_once('../utils/AppInfo.php');

require_once('../facebook-php-sdk/src/facebook.php');

$facebook = new Facebook(array(
  'appId'  => AppInfo::appID(),
  'secret' => AppInfo::appSecret(),
));

if (isset($_POST['graph'])) {
  // See if there is a user from a cookie
  $user = $facebook->getUser();

  $data = array();
  if ($user) {
    try {
      // Proceed knowing you have a logged in user who's authenticated.
      $data = $facebook->api('/me');
    } catch (FacebookApiException $e) {
      $data = array('error' => $e);
    }
  }

  echo json_encode($data);
}