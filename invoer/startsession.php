<?php

if ($_POST["wwtoegang"] == "hemurenge") {
	include("database.php");
	session_start();
	$_SESSION["toegang"] = 1;
	/*$q = "SELECT sessionid, lastModified FROM sessie";
	$r = mysql_query($q);
	if (mysql_num_rows($r)) {
		if (mysql_result($r, 0, "sessionid") == session_id()) {
			//niks aan de hand, tijdbijwerken
			$q = "UPDATE sessie SET sessionid='".session_id()."', lastModified = NOW()";
			mysql_query($q) or die ($q);
		}
	}else{
		$q = "INSERT INTO sessie (sessionid, lastModified) VALUES ('".session_id()."', NOW())";
		mysql_query($q) or die ($q);
	}*/
	//$_SESSION["gebruiker"] = $_POST["gebruiker"];
	//$_SESSION["wachtwoord"] = $_POST["ww"];
	if ($_POST["clubthuis"] != "" && $_POST["clubuit"] != "") {
		$q = "UPDATE scorebord SET clubthuis = '$_POST[clubthuis]', clubuit = '$_POST[clubuit]'";
		mysql_query($q) or die ($q);
	}
	if ($_POST["reset"]) {
		$q = "UPDATE scorebord SET scorethuis = 0, scoreuit = 0, status = NULL, lastModified = '".date("Y-m-d H:i:s")."'";
		mysql_query($q) or die ($q);
	}
	if ($_POST["aankondigen"]) {
		$q = "UPDATE scorebord SET lastModified = '".date("Y-m-d H:i:s", strtotime("-3 day"))."'";
		mysql_query($q) or die ($q);
		//echo $q;
	}
	$mislukt = 0;
}else{
	$mislukt = 1;
}
header("Location: invoer.php?mislukt=$mislukt");
?>