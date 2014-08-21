<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and ($_POST[kid]) and ($_POST[ido])){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
switch($_POST[ido]){
case 2:
$ido=2;
break;
case 3:
$ido=3;
break;
case 5:
$ido=5;
break;
case 10:
$ido=10;
break;
default:
$ido=1;
break;
}
$tilte=mysql_query("SELECT * FROM forumtilt WHERE forumtilt_kid = '". $_POST[kid] ."'");
if(mysql_num_rows($tilte)==0){
mysql_query("INSERT INTO forumtilt VALUES (". $_POST[kid] .", ". $ido .")");
$leiras="Szia!<br>Sajnos a ". idtonev($_SESSION[id]) ." nevû moderátor tiltotta a kutyád a fórumról és chatrõl, valószínüleg valami szabályellenes dolgót követtél el. Ha részleteket szeretnél tudni a tiltás okáról, írj a moderátornak.";
$level=mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $_POST[kid] ."', NOW(), 0, 0, 1, 0)");

}
if(isset($_POST[chat])){
header("Location: ../chato.php");
}else{
header("Location: ../forum.php?tema=". $_POST[fid]);
}
}
}else{
header("Location: ../index.php");
}
?>
