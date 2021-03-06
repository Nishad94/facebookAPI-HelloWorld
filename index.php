<?php

session_start();
 
require_once( 'Facebook/HttpClients/FacebookHttpable.php' );
require_once( 'Facebook/HttpClients/FacebookCurl.php' );
require_once( 'Facebook/HttpClients/FacebookCurlHttpClient.php' );
require_once( 'Facebook/HttpClients/FacebookGuzzleHttpClient.php' );
require_once( 'Facebook/HttpClients/FacebookStream.php' );
require_once( 'Facebook/HttpClients/FacebookStreamHttpClient.php' );

require_once( 'Facebook/FacebookSession.php' );
require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'Facebook/FacebookRequest.php' );
require_once( 'Facebook/FacebookResponse.php' );
require_once( 'Facebook/FacebookSDKException.php' );
require_once( 'Facebook/FacebookRequestException.php' );
require_once( 'Facebook/FacebookAuthorizationException.php' );
require_once( 'Facebook/GraphObject.php' );
require_once( 'Facebook/Entities/AccessToken.php');
require_once( 'Facebook/Entities/SignedRequest.php');
 
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\Entities\SignedRequest;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookGuzzleHttpClient;
use Facebook\HttpClients\FacebookStream;
use Facebook\HttpClients\FacebookStreamHttpClient;
 
// init app with app id (APPID) and secret (SECRET)
FacebookSession::setDefaultApplication('296586090536642','850aca68f14e4f39069f13beb0018760');
 
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper( 'http://immense-depths-9230.herokuapp.com/' );

// Requested permissions for the app - optional
$permissions = array(
  'email',
  'user_location',
  'user_birthday',
  'user_friends',
  'user_likes',
  'user_actions.music'
);
 
try {
  $session = $helper->getSessionFromRedirect();
  echo "<h1>Hello World</h1>";
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
 
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
   
  // print data
  echo  print_r( $graphObject, 1 );

  $request = new FacebookRequest( $session, 'GET', '/me/friends');
  $response = $request->execute();
  $graphObject = $response->getGraphObject();

  echo "<h3> Friends using this app : </h3>";
  echo  print_r( $graphObject, 1 );
} else {
  // show login url
  echo '<a href="' . $helper->getLoginUrl($permissions) . '">Login</a>';
}