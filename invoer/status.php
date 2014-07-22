<?php
	include("database.php");
	$q = "UPDATE scorebord SET status = $_GET[status], lastModified = NOW()";
	mysql_query($q);
?>