<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[nev]) and $_GET[id]){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_falka==0){
$leker2=mysql_query("SELECT * FROM falkatilto WHERE falkatilto_kutya = '". $_SESSION[id] ."' and falkatilto_falka = '". $_GET[id] ."'");
if(mysql_num_rows($leker2)>0){
$_SESSION[hiba]=hiba("Ki vagy tiltva ebbõl a falkából!");
header("Location: ../falka.php");
}else{
mysql_query("INSERT INTO falkaesemeny VALUES('', '". $_GET[id] ."', '". $_SESSION[id] ."', '1', '". hetnapja($datum["weekday"]) ." ". $datum["hours"] .":". $datum["minutes"] ."')");
mysql_query("UPDATE kutya SET kutya_falka = '". $_GET[id] ."', kutya_falkaido = '". $ma ."' WHERE kutya_id = '". $_SESSION[id] ."'");
$userpont=0;
falkapont($_GET[id]);
header("Location: ../falka.php");
}

}else{
header("Location: ../falka.php");

}
}
}else{header("Location: ../index.php");}
	?>
