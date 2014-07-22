<?php
session_start();

// require class
require_once 'constants.php';
require_once 'abraham/twitteroauth/twitteroauth.php';

// create instance
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);

if (isset($_GET["tekst"])) {
	$output = $connection->post('statuses/update', array('status'=>$_GET["tekst"]." @ http://www.hemurenge.nl/scorebord/"));
}else{
	echo "mislukt";
}
?> 