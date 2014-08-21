<?php
include("sql.php");
include("functions.php");
include("session.php");
if(isset($_SESSION[id]) and $_GET[id]){
$ellenoriz=mysql_query("SELECT * FROM piac WHERE piac_id = '". $_GET[id] ."' and piac_elado = '". $_SESSION[id] ."'");
if(mysql_num_rows($ellenoriz)>0){
mysql_query("DELETE FROM piac WHERE piac_id = '". $_GET[id] ."' and piac_elado = '". $_SESSION[id] ."'");
$_SESSION[hiba]=ok("Sikeresen levetted az egyik kutyád a piacról!");
header("Location: ../piac.php");
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
