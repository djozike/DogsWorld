<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
$datumozas=mysql_query("UPDATE `kutya` SET `kutya_belepido` = '". $most ."' WHERE `kutya_nev` = '". $_SESSION[nev] ."'");
session_destroy();
header("Location: index.php");
?>
