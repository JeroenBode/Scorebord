<?
include("database.php");
$q = "SELECT scorethuis, scoreuit, status, lastModified FROM scorebord";
$r = mysql_query($q);
$rij = mysql_fetch_array($r);
extract($rij);
echo "$scorethuis $scoreuit $status $lastModified";
?>