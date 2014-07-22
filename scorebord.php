<?
include("database.php");
$q = "SELECT lastModified as datum FROM scorebord";
$r = mysql_query($q);
$rij = mysql_fetch_array($r);
extract($rij);

function dateDiff($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}
$dagen = dateDiff($datum, date("Y-m-d"));

if ($dagen<2) {
	//scorebord tonen
	/*$q = "REPLACE INTO sessie SET sessionid = '".session_id()."', lastModified = NOW()";
	mysql_query($q) or die (mysql_error()."<br>".$q);*/

	$q = "SELECT clubthuis, clubuit, scorethuis, scoreuit, status, lastModified FROM scorebord";
	$r = mysql_query($q);
	$rij = mysql_fetch_array($r);
	extract($rij);

	$agent = $_SERVER['HTTP_USER_AGENT'] . "\n\n";
	?>
	<head>
	<meta name="viewport" content="width=device-width"/>
	<title>Scorebord</title>
	<?
	$notauto = 0;
	if(strpos($agent, "IEMobile")){ //Internet Explorer Mobile wordt gebruikt
		$notauto = 1;
		echo "<script>";
		include("scorebord.js");
		echo "</script>";
	}else{?>
	<script src="scorebord.js" type="text/javascript"></script>
	<?}?>
	<?if(strpos($agent, "Mini")){ //Opera Mini wordt gebruikt
		$notauto = 1;
		$divpx = 20;
	}else{
		$divpx = 60;
	}?>
	<link rel="stylesheet" type="text/css" href="scorebord.css">
	</head>
	<body>
	<center>
	<p>
	<img src="http://www.hemurenge.nl/scorebord/hemurengelogo.jpg" border="0" alt="Hemur Enge">
	</p>
	<table border="0" cellpadding="0" cellspacing="0" class="scorebord">
		<tr style="padding-bottom: 4px">
			<th width="100"><?=$clubthuis;?></th><th width="20">&nbsp;</th><th width="100"><?=$clubuit;?></th>
		</tr><tr>
			<td>
				<center>
					<div id="scorethuis" class="score">
						<?=$scorethuis;?>
					</div>
				</center>
			</td>
			<td style="font-size: xx-large"> - </td>
			<td>
				<center>
					<div id="scoreuit" class="score">
						<?=$scoreuit;?>
					</div>
				</center>
			</td>
		</tr><tr>
			<td colspan="3">
				<div id="status" style="font-size: x-small"><script>document.write(getStatus(<?=$status;?>))</script></div>
				<div id="laatsterefresh" style="font-size: x-small"></div>
				<div id="laatsteupdate" style="font-size: x-small">Laatste update: <?=substr($lastModified, 10);?></div>
				<? if ($notauto) echo "<center><input type=\"button\" value=\"ververs\" onclick=\"getScore()\"? style=\"height: 30px\"></center>"; ?>
			</td>
		</tr>
	</table>
	<p style="font-size: xx-small">
	<?if(!$notauto){ //Opera Mini/IE wordt !NIET! gebruikt?>
		Stand ververst elke 10 seconden. <br>AUB niet de pagina volledig verversen!<br>
	<br>
		© JeyBe! <a href="http://www.jeybe.nl">Meer info
	</a> <br>
	<?}?>
	</p>
	<script>scorebord();</script>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-15862807-2']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
<?
}else{
	//volgende wedstrijd aankondigen
	$q = "SELECT clubthuis, clubuit, DATE_FORMAT(datum, \"%d-%m-\'%y\") AS datumNL, tijd FROM wedstrijden WHERE datum >= CURDATE() ORDER BY datum LIMIT 1";
	$r = mysql_query($q) or die ($q);
	$wedstrijd = mysql_fetch_array($r);
	extract($wedstrijd);
	?>
	<head>
	<meta name="viewport" content="width=device-width"/>
	<title>Scorebord</title>
	<link rel="stylesheet" type="text/css" href="scorebord.css">	
	</head>
	<center>
	<p>
	<img src="hemurengelogo.jpg" border="0" alt="Hemur Enge">
	</p>
	<table border="0" cellpadding="0" cellspacing="0" class="scorebord">
		<tr><th colspan="3" style="text-align: center"></th></tr>
		<tr><td colspan="3" style="text-align: center">Volgende wedstrijd</td></tr>
		<tr style="padding-bottom: 4px">
			<th width="100"><?=$clubthuis;?></th><th width="20">-</th><th width="100"><?=$clubuit;?></th>
		</tr>
		<tr><td colspan="3" style="text-align: center"><?=$datumNL;?> om <?=substr($tijd,0,5);?></td></tr>
	</table>
<?
}
?>