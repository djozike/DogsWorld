<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$vanekolyok=mysql_query("UPDATE kolyok SET kolyok_aktiv = '0', kolyok_ido = '". ($ma+3*24*3600) ."' WHERE kolyok_apa = '". $_SESSION[id] ."' or kolyok_anya = '". $_SESSION[id] ."'");
header("Location: ../kutyam.php");
}else{
header("Location: ../index.php");
}
?>
