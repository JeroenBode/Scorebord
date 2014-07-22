<?php
$db_server_sb = "mysql.hemurenge.nl";
$db_login_sb = "hemurengenl"; //username van de database
$db_pass_sb = "amerongen"; //password van de database
$db_naam_sb = "hemurengenl"; //naam van de database

mysql_connect($db_server_sb, $db_login_sb, $db_pass_sb) or die("Er kan geen verbinding gemaakt worden met de database, MySQL retouneerde: ".mysql_error());
mysql_select_db($db_naam_sb) or die("Er kan geen database geselecteerd worden. MySQL retouneerde devolgende error: ".mysql_error());
?>