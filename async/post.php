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
	$user = $facebook->getUser();

	$data = array();
	$post_data = array(
		'link' => 'https://fbphpsdk.herokuapp.com/',
		'caption' => 'Trying out the php sdk',
		'name' => 'PHP SDK Sandbox',
		'description' => 'Testing site for the php sdk'
	);

	error_log('post endpoint');

	try {
        $data = $facebook->api(
        	'/me/feed', 'POST',
        	$post_data
        );
    } catch(FacebookApiException $e) {
    	$data = array('error' => $e->getMessage());
    }

    echo json_encode($data);
}