<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_GET[id]){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya2=mysql_fetch_object($leker)){
$leker2=mysql_query("SELECT * FROM falka WHERE falka_id = '". $kutya2->kutya_falka ."'");
while($falka=mysql_fetch_object($leker2)){
$jogok=explode('|',$falka->falka_jogok);
if(($falka->falka_vezeto==$_SESSION[id]) or ($falka->falka_vezetohelyettes ==  $_SESSION[id] and $jogok[2]==1)){
mysql_query("DELETE FROM `falkatilto` WHERE `falkatilto_falka` = '". $falka->falka_id ."' and falkatilto_kutya = '". $_GET[id] ."'");
$_SESSION[hiba]=ok("<br>Sikeres feloldás!<br>");
header("Location: ../falkabealit.php?page=2");
}else{
header("Location: ../index.php");
}}}
}else{
header("Location: ../index.php");
}
?>
