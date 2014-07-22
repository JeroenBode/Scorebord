<?
//include_once("database.php");
global $database;
mysql_select_db("hemurengenl_scorebord") or die (mysql_error());

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
	$q = "SELECT clubthuis, clubuit, scorethuis, scoreuit FROM scorebord";
	$r = mysql_query($q) or die (mysql_error());
	$rij = mysql_fetch_array($r);
	extract($rij);
	?>
<link rel="stylesheet" type="text/css" href="../scorebord/scorebord_site.css">	
<script src="../scorebord/scorebord_site.js" type="text/javascript"></script>
<script>scorebord();</script>
<table border="0" cellpadding="0" cellspacing="0" class="scorebord" onclick="window.location='http://www.hemurenge.nl/scorebord/scorebord.php'">
	<tr style="padding-bottom: 4px">
		<th width="70"><?=$clubthuis;?></th><th width="10">&nbsp;</th><th width="70"><?=$clubuit;?></th>
	</tr><tr>
		<td class="scorebord">
			<center>
				<div id="scorethuis" class="score">
					<?=$scorethuis;?>
				</div>
			</center>
		</td>
		<td style="font-size: large"> - </td>
		<td class="scorebord">
			<center>
				<div id="scoreuit" class="score">
					<?=$scoreuit;?>
				</div>
			</center>
		</td>
	</tr><tr>
		<td colspan="3">
			<div id="status" style="font-size: xx-small;">Status</div>
			<!--<div id="laatsterefresh" style="font-size: xx-small;">Laatste refresh:</div>-->
		</td>
	</tr>
</table>
</center>
<?
}else{
	//eerstvolgende wedstrijd informatie
	$q = "SELECT clubthuis, clubuit, DATE_FORMAT(datum, \"%d-%m-\'%y\") AS datumNL, tijd FROM wedstrijden WHERE datum >= CURDATE() ORDER BY datum LIMIT 1";
	$r = mysql_query($q) or die ($q);
	$wedstrijd = mysql_fetch_array($r);
	extract($wedstrijd);
	?>
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
<?
//herstellen van de juiste db voor de rest van de site (laatste nieuws e.d.)
$database->connect();
?><!--
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-15862807-2");
pageTracker._trackPageview();
} catch(err) {}</script>-->