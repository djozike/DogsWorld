<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
$leker2=mysql_query("SELECT * FROM falka WHERE falka_id = '". $kutya->kutya_falka ."'");
if(mysql_num_rows($leker2)>0){
while($falka=mysql_fetch_object($leker2)){
if($falka->falka_vezeto==$_SESSION[id]){

falkatorol($falka->falka_id);

header("Location: ../falka.php");
}else{
header("Location: ../falka.php");
}}
}else{
header("Location: ../falka.php");
}
}
}else{
header("Location: ../index.php");
}
?>
