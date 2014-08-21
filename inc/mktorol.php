<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
unlink("../pic/user/". $_GET[id] .".png");
$nev1=idtonev($_SESSION[id]);
$leiras="Szia!<br>Sajnos a ". $nev1 ." nevû moderátor törölte az adatlapodról a képed, valószínüleg szabályellenes volt. Ha részleteket szeretnél tudni a törlés okáról, írj a moderátornak.";
$level=mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $_GET[id] ."', NOW(), 0, 0, 1, 0)");
header("Location: ../adatlapok.php?id=". $_GET[id]);
}else{header("Location: ../index.php");}
}else{header("Location: ../index.php");}
?>
