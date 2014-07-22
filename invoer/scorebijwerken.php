<?php
include_once("database.php");
$s = "score".$_GET["s"];
$_SESSION[$s] = $_GET["score"];
$q = "UPDATE scorebord SET $s = $_GET[score], lastModified = NOW()";
//echo $q;
mysql_query($q);
?>