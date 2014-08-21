<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_POST[topic]){
if($_POST[uzenet]==""){
$_SESSION[hiba]=hiba("Nem irtál be semmit!");
header("Location: ../falkaforum.php");
}else{
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_falka==$_POST[topic]){
if($kutya->kutya_betuszin=="774411"){
$nev1=htmlentities($kutya->kutya_nev);
}else{
$nev1="<font color=#". $kutya->kutya_betuszin .">". htmlentities($kutya->kutya_nev) ."</font>";
}
$kelladat=mysql_query("SELECT * FROM falka WHERE falka_id = '". $_POST[topic] ."'");
while($falka=mysql_fetch_object($kelladat)){
if($falka->falka_kepvideo==1){
$uzenet=ubb_adatlap($_POST[uzenet]);
}else{
$uzenet=ubb_forum($_POST[uzenet]);
}
}
mysql_query("INSERT INTO forum VALUES ('','". $_POST[topic] ."','". $_SESSION[id] ."','". $nev1 ."', NOW(), '". $uzenet ."')");
header("Location: ../falkaforum.php");
}else{
header("Location: ../falkaforum.php");
}
}
}
}else{
header("Location: ../index.php");
}
?>
