<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_GET[id]){
mysql_query("DELETE FROM `baratlista` WHERE `baratlista_owner` = '". $_SESSION[id] ."' and baratlista_barat = '". $_GET[id] ."'");
$_SESSION[hiba]=ok("Sikeres törlés!");
header("Location: ../baratok.php");
}else{
header("Location: ../index.php");
}
?>
