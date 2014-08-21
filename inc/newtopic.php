<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
if(isset($_POST[nev]) and $_POST[tema] and $_POST[leiras]){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if(substr_count($kutya->kutya_tanul,"IR")==0){
header("Location: ../forum.php");
}else{
$tilte=mysql_query("SELECT * FROM forumtilt WHERE forumtilt_kid = '". $_SESSION[id] ."'");
$iptilte=mysql_query("SELECT * FROM forumiptilt WHERE forumiptilt_ip = '". $ip ."'");
if(mysql_num_rows($tilte)>0){
while($tilto=mysql_fetch_object($tilte)){
header("Location: ../forum.php");
}
}elseif(mysql_num_rows($iptilte)>0){
while($tilto=mysql_fetch_object($iptilte)){
header("Location: ../forum.php");
}
}else{
mysql_query("INSERT INTO forumtema VALUES ('', '". $_POST[nev] ."', '". $_POST[leiras] ."', '". $_POST[tema] ."', '". $_SESSION[id] ."', NOW())");
$kellesz=mysql_query("SELECT * FROM forumtema WHERE forumtema_kutya = ". $_SESSION[id] ." ORDER BY forumtema_id DESC limit 1");
while($forum=mysql_fetch_object($kellesz)){
header("Location: ../forum.php?tema=". $forum->forumtema_id);
}
}}}
}else{
header("Location: ../forum.php");
}

}else{
header("Location: ../index.php");
}
?>
