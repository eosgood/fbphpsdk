<?php

// Provides access to app specific values such as your app id and app secret.
// Defined in 'AppInfo.php'
require_once('../utils/AppInfo.php');

require_once('../facebook-php-sdk/src/facebook.php');

$facebook = new Facebook(array(
  'appId'  => AppInfo::appID(),
  'secret' => AppInfo::appSecret(),
));

$facebook->setFileUploadSupport(true);

if (isset($_POST['graph'])) {
	$user = $facebook->getUser();

	$data = array();
	$img = '../img/upload.png';

	$post_data = array(
		'source' => '@' . $img,
		'message' => 'Photo uploaded with the php sdk',
	);

	try {
        $data = $facebook->api(
        	'/me/photos', 'POST',
        	$post_data
        );
    } catch(FacebookApiException $e) {
    	$data = array('error' => $e->getMessage());
    }

    echo json_encode($data);
}