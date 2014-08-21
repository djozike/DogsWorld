<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_GET[id]){
mysql_query("UPDATE uzenetek SET uzenet_tipus = '". $_SESSION[id] ."' WHERE uzenet_id = '". $_GET[id] ."'");
$_SESSION[hiba]=hiba("Sikeres szabálytalanság bejelentés!<br>");
header("Location: ../uzenetek.php?id=". $_GET[id]);
}else if(isset($_SESSION[id]) and $_GET[kutya])
{
mysql_query("UPDATE uzenetek SET uzenet_tipus = '". $_SESSION[id] ."' WHERE uzenet_kuldo = '". $_GET[kutya] ."' and uzenet_kapo = '". $_SESSION[id] ."'");
mysql_query("UPDATE uzenetek SET uzenet_tipus = '". $_SESSION[id] ."' WHERE uzenet_kapo = '". $_GET[kutya] ."' and uzenet_kuldo = '". $_SESSION[id] ."'");

}else{
header("Location: ../index.php");
}
?>
