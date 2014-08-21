<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_GET[id]){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
mysql_query("UPDATE uzenetek SET uzenet_tipus = '0' WHERE uzenet_id = '". $_GET[id] ."'");
header("Location: ../uzenetek.php?page=bejelent");
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
