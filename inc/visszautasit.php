<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
mysql_query("DELETE FROM hazassag WHERE hazassag_ferj = '". $_SESSION[id] ."' or hazassag_feleseg = '". $_SESSION[id] ."'");

header("Location: ../kutyam.php");
}else{
header("Location: ../index.php");
}
?>