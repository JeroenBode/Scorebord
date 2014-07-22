<?
session_start();
$twitter=1;
if($twitter) {
	include_once("functions.php");
	require_once 'constants.php';
	require_once 'abraham/twitteroauth/twitteroauth.php';
	$parameters['count']=3;
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
	$content = $connection->get('statuses/user_timeline', $parameters);


	$output = "
	<table border=0 cellspacing=0 cellpadding=0>
		<tr>
			<td style=\"text-align: left\">";
	foreach ($content as $row) {
		$tweet = (array) $row;
		$text = @make_clickable($tweet["text"]);
		$time = @strtotime($tweet["created_at"]);
		$now = time();
		$dagverschil = (int) date("j", ($now - $time));
		if ($dagverschil > 0) $dagtekst = $dagverschil." dag";
		if ($dagverschil > 1) $dagtekst .= "(en)";
		$minuutverschil = (int) date("m", ($now - $time));
		$output .= "$text<font style=\"font-size: 8pt\">&nbsp;&nbsp; ($dagtekst, $minuutverschil minuten geleden)</font><br><br>";
	}
	$output .= "
			</td>
		</tr>
	</table>";
	echo $output;
}else{
	echo "Geen twitter";
}
?>
