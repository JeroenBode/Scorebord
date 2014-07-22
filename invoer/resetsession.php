<?php
session_start();
$_SESSION["toegang"] = 0;
session_unset();
header("Location: invoer.php");
?>