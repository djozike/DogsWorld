<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[nev]) and isset($_POST[puska])){
$kutyus=mysql_query("SELECT * FROM `kutya` WHERE `kutya_id` = '". $_SESSION[id] ."'",$kapcsolat);
while($elker=mysql_fetch_object($kutyus)){
if(substr_count($elker->kutya_tanul,$_POST[puska])==0){
if($elker->kutya_penz>49){
$ujtanul=$elker->kutya_tanul;
$ujtanul.=$_POST[puska] ."|";
if($_POST[puska]=="ER"){
$penz=$elker->kutya_penz+50;
}else{
$penz=$elker->kutya_penz-50;
}
mysql_query("UPDATE `kutya` SET `kutya_penz`='". $penz ."'  ,`kutya_tanul` = '". $ujtanul ."' WHERE `kutya_id` = '". $_SESSION[id] ."'");
mysql_query("DELETE ´tanul` WHERE `tanul_id` = '". $_SESSION[id] ."' and `tanul_mit` = '". $_POST[puska] ."'");

header("Location: ../kutyam.php");
}else{
$_SESSION[hiba]='<script>alert("Nincs elég pénzed! Még '. penz(50-$elker->kutya_penz) .'t kell gyûjtened!");</script>';
header("Location: ../kutyam.php");
}
}else{header("Location: ../index.php");}
}
}else{header("Location: ../index.php");}
	?>
