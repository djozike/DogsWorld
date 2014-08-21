<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_GET[id]){
mysql_query("DELETE FROM `tilto` WHERE `tilto_tilto` = '". $_SESSION[id] ."' and tilto_tiltott = '". $_GET[id] ."'");
$_SESSION[hiba]=ok("Sikeres feloldás!");
header("Location: ../uzenetek.php?page=tilto");
}else{
header("Location: ../index.php");
}
?>