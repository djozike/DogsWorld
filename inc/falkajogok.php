<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya2=mysql_fetch_object($leker)){
$leker2=mysql_query("SELECT * FROM falka WHERE falka_id = '". $kutya2->kutya_falka ."'");
while($falka=mysql_fetch_object($leker2)){
if($falka->falka_vezeto==$_SESSION[id]){
if($_POST[jog]=="on"){
$jog=1;
}else{
$jog=0;
}
if($_POST[uzenetkuld]=="on"){
$uzenetkuld=1;
}else{
$uzenetkuld=0;
}
if($_POST[tagtilt]=="on"){
$tagtilt=1;
}else{
$tagtilt=0;
}
if($_POST[adminpanel]=="on"){
$adminpanel=1;
}else{
$adminpanel=0;
}
$newrights=$jog ."|". $uzenetkuld ."|". $tagtilt ."|". $adminpanel;
mysql_query("UPDATE falka SET falka_jogok = '". $newrights ."' WHERE falka_id = '". $kutya2->kutya_falka ."'");
header("Location: ../falkabealit.php");
}else{
header("Location: ../falkabealit.php");
}
}
}
}else{
header("Location: ../index.php");
}


?>
