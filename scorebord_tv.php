<?
include("database.php");
$q = "SELECT clubthuis, clubuit, scorethuis, scoreuit FROM scorebord";
$r = mysql_query($q);
$rij = mysql_fetch_array($r);
extract($rij);

$agent = $_SERVER['HTTP_USER_AGENT'] . "\n\n";
?>
<head>
<meta name="viewport" content="width=device-width; initial-scale=1.0; minimum-scale=1.0; user-scalable=1;" />
<title>Scorebord</title>
<?
if(strpos($agent, "IEMobile")){ //Internet Explorer Mobile wordt gebruikt
	$mobile = 1;
	echo "<script>";
	include("scorebord.js");
	echo "</script>";
}else{?>
<script src="scorebord.js" type="text/javascript"></script>
<?}?>
<?if(strpos($agent, "Mini")){ //Opera Mini wordt gebruikt
	$mobile = 1;
	$divpx = 20;
}else{
	$divpx = 60;
}?>
<link rel="stylesheet" type="text/css" href="scorebord.css">	
</head>
<body onload="scorebord()">
<!--<center>
<p>
<img src="hemurengelogo.jpg" border="0" alt="Hemur Enge">
</p>-->
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
			<div id="laatsterefresh" style="font-size: 8pt;"></div><br>
			<div id="lastModified" style="font-size: 10pt; display: none"></div>
			<? if ($mobile) echo "<center><input type=\"button\" value=\"ververs\" onclick=\"getScore()\"?></center>"; ?>
		</td>
	</tr>
</table>
<?if(!strpos($agent, "Mini")){ //Opera Mini wordt !NIET! gebruikt?>
<!--<p style="font-size: 10pt">
	Stand ververst elke 10 seconden. <br>AUB niet de pagina volledig verversen!<br><br>&copy; Gerben!
</p>-->
<?}?>
</center>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-15862807-2");
pageTracker._trackPageview();
} catch(err) {}</script>