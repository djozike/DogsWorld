<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]))
{
mysql_query("DELETE FROM `hazassag` WHERE `hazassag_aktiv` = '". $_SESSION[id] ."'");
header("Location: ../kutyam.php");
}
else
{
header("Location: ../index.php");
}
?>