<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[nev])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_falka!=0){
$leker2=mysql_query("SELECT * FROM falka WHERE falka_id = '". $kutya->kutya_falka ."'");
while($falka=mysql_fetch_object($leker2)){
mysql_query("INSERT INTO falkaesemeny VALUES('', '". $falka->falka_id ."', '". $_SESSION[id] ."', '2', '". hetnapja($datum["weekday"]) ." ". $datum["hours"] .":". $datum["minutes"] ."')");

mysql_query("UPDATE kutya SET kutya_falka = '0' WHERE kutya_id = '". $_SESSION[id] ."'");
falkapont($falka->falka_id);
}
header("Location: ../falka.php");
}else{
header("Location: ../falka.php");

}
}
}else{header("Location: ../index.php");}
	?>
