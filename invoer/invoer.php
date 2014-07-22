<?php
session_start();
?>
<html>
	<head>
	<meta name="viewport" content="width=device-width"/>
	<title>Invoer Scorebord Hemur Enge</title>
<?
if ($_SESSION["toegang"]) {
	//if ($_SESSION["gebruiker"] &&	$_SESSION["wachtwoord"]) $twitter = 1;
	//else $twitter = 0;
	include("database.php");
	$q = "SELECT clubthuis, clubuit, scorethuis, scoreuit, status FROM scorebord";
	$r = mysql_query($q);
	$rij = mysql_fetch_array($r);
	extract($rij);
	
	$ie=0;
	$twitter = 1;
	$agent = $_SERVER['HTTP_USER_AGENT'] . "\n\n";
	if(strpos($agent, "IEMobile") || strpos($agent, "black")){
		$ie = 1;
		echo "<script>";
		include("invoer.js");
		echo "</script>";
	}else{?>
	<script>
		var thuis = "<?=$clubthuis?>";
		var uit = "<?=$clubuit?>";
	</script>
	<script src="invoer.js" type="text/javascript"></script>
	<?}?>
	<?
	if(strpos($agent, "Mini")){ //Opera Mini wordt gebruikt
		$mobile = 1;
	}?>
	<link rel="stylesheet" type="text/css" href="invoer.css">	
	</head>
	<body onload="<? if ($twitter) echo "laatsteDrie(); setTweet();";?>">
	<center>
	<div id="scorebord">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<th width="100"><?=$clubthuis;?></th><th width="20">&nbsp;</th><th width="100"><?=$clubuit;?></th>
			</tr><tr>
				<td>
					<div id="scorethuis" class="score">
						<?
						echo $scorethuis;
						?>
					</div>
				</td>
				<td style="font-size: xx-large"> - </td>
				<td>
					<div id="scoreuit" class="score">
						<?
						echo $scoreuit;
						?>
					</div>
				</td>
			</tr>
			<tr><td colspan="5" style="text-align: center"><div id="status"><script>document.write(getStatus(<?=$status;?>))</script></div></td></tr>
			<tr>
				<td>
					<? if ($ie) { ?><input type="button" value="+" class="plus" onclick="score('plus', 'thuis');"><br><? }
					else { ?><img src="plus.png" width="100" border="0" onclick="score('plus', 'thuis');" style="margin-right: 10px"><br><br> <? }?>
					<? if ($ie) { ?><input type="button" value="-" class="min" onclick="score('min', 'thuis');"><? }
					else { ?><img src="min.png" border="0" onclick="score('min', 'thuis');"> <? }?>
				</td>
				<td>&nbsp;</td>
				<td>
					<? if ($ie) { ?><input type="button" value="+" class="plus" onclick="score('plus', 'uit');"><br><? }
					else { ?><img src="plus.png" width="100" border="0" onclick="score('plus', 'uit');" style="margin-left: 10px"><br><br> <? }?>
					<? if ($ie) { ?><input type="button" value="-" class="min" onclick="score('min', 'uit');"><? }
					else { ?><img src="min.png" border="0" onclick="score('min', 'uit');"> <? }?>
				</td>
			</tr>
		</table>
	</div>
	<br>
	<form>
		<table border="0" cellpadding="0" cellspacing="0"><tr><td>
			<textarea name="tekst" id="tekst" onkeyup="checkInvoer(event)" style="width: 100%;" rows="3">
			</textarea>
		</tr></td>
		<tr><td style="text-align: right" nowrap="nowrap">
			<input type="button" value="5 min." onclick="setStatus(4)" title="Laatste 5 min. zuivere speeltijd">
			<input type="button" value="1 min." onclick="setStatus(5)" title="Laatste minuut">
			<input type="button" value="Tweet" class="tweet" onclick="tweet();" <? if (!$twitter) echo "DISABLED"; ?> >
		</td></tr></table>
	</form>
		<p>
			<input type="button" value="begint" onclick="setStatus(1)">
			<input type="button" value="rust" onclick="setStatus(2)">
			<input type="button" value="2e helft" onclick="setStatus(3)">
			<input type="button" value="einde" onclick="setStatus(6)">
			<input type="button" value="nog niet begonnen" onclick="setStatus(0)">
		</p>
	<div id="laatstedrie">
	</div>
	<p>
	<input type="button" value="refresh twitter" onclick="laatsteDrie()" <? if (!$twitter) echo "DISABLED"; ?> >
	</p>
	<p>
	<form action="resetsession.php">
		<input type="submit" value="Uitloggen" onclick="return confirm('Weet je het zeker?')">
	</form>
	</center>
<?
}else{
	if ($_GET["mislukt"] == "1") echo "Verkeerd wachtwoord voor invoerpagina van het scorebord<br>";
	include("database.php");
?>
<form method="POST" action="startsession.php">
	<table>
		<?
		$q = "SELECT clubthuis, clubuit, scorethuis, scoreuit FROM scorebord";
		$r = mysql_query($q);
		$rij = mysql_fetch_array($r);
		extract($rij);
		?>
		<!--<tr><td colspan="2">Twitter gegevens (optioneel)<br></td></tr>
		<tr><td>Gebruiker: </td><td><input type="text" name="hemurenge"></td></tr>
		<tr><td>Ww Twitter: </td><td><input type="password" name="renerene"></td></tr>-->
		<tr><td colspan="2">Huidige scorebord</td></tr>
		<tr><td><?=$clubthuis;?> - </td><td><?=$clubuit;?></td></tr>
		<tr><td><?=$scorethuis;?></td><td><?=$scoreuit;?></td></tr>
		<?
		$q = "SELECT clubthuis, clubuit FROM wedstrijden WHERE datum >= CURDATE() ORDER BY datum LIMIT 1";
		$r = mysql_query($q);
		$rij = mysql_fetch_array($r);
		extract($rij);
		?>
		<tr><td colspan="2">Instellingen (KL-database)</td></tr>
		<tr><td>
		Thuis: </td><td><input type="text" name="clubthuis" value="<?=$clubthuis;?>" autocomplete="off"><br>
		</td></tr><tr><td>
		Uit: </td><td><input type="text" name="clubuit" value="<?=$clubuit;?>" autocomplete="off"><br>
		</td></tr>
		<tr><td colspan="2"><input type="checkbox" name="reset" value="1" id="reset"><label for="reset"> Reset score (en op Nog niet begonnen)</label></td></tr>
		<tr><td colspan="2"><input type="checkbox" name="aankondigen" value="1" id="reset"><label for="reset"> Volgende wedstrijd aankondigen</label></td></tr>
		
		<tr><td colspan="2">Toegang tot scorebord</td></tr>
		<tr><td>Ww toegang: </td><td><input type="password" name="wwtoegang"></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" name="ga verder" value="Ga verder"></td></tr>
	</table>
</form>
<?
}
?>
	</center>
