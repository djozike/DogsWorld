<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and ($_POST[ip]) and ($_POST[ido])){
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
$tilte=mysql_query("SELECT * FROM forumiptilt WHERE forumiptilt_ip = '". $_POST[ip] ."'");
if(mysql_num_rows($tilte)==0){
echo $_POST[ip];
mysql_query("INSERT INTO forumiptilt VALUES ('". $_POST[ip] ."', '". $ido ."')");
}
$_SESSION["hiba"]=ok("Sikeres IP tiltás!<br>");
header("Location: ../forum.php?tema=". $_POST[fid]);
}
}else{
header("Location: ../index.php");
}
?>
