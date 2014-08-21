<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM hazassag WHERE hazassag_ferj = '". $_SESSION[id] ."' or hazassag_feleseg = '". $_SESSION[id] ."'");
while($eredmeny=mysql_fetch_object($leker)){

if($eredmeny->hazassag_ferj==$_SESSION[id]){
mysql_query("UPDATE hazassag SET hazassag_aktiv = '0', hazassag_ido = '". $ma ."', hazassag_feleseg = '". $eredmeny->hazassag_aktiv ."' WHERE hazassag_ferj = '". $_SESSION[id] ."'");
}else{
mysql_query("UPDATE hazassag SET hazassag_aktiv = '0', hazassag_ido = '". $ma ."', hazassag_ferj = '". $eredmeny->hazassag_aktiv ."' WHERE hazassag_feleseg = '". $_SESSION[id] ."'");
}

}
header("Location: ../kutyam.php");
}else{
header("Location: ../index.php");
}
?>