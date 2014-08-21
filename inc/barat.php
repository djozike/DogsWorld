<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id]) and $_GET[nev]){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_nev = '". $_GET[nev] ."'");
if(mysql_num_rows($leker)>0){
while($masik=mysql_fetch_object($leker)){
if($masik->kutya_id == $_SESSION[id]){
$_SESSION[hiba]=hiba("Magadnak nem lehetsz a barátja! :)");
header("Location: ../baratok.php");
}else{
$leker2=mysql_query("SELECT * FROM baratlista WHERE baratlista_owner = '". $_SESSION[id] ."' and baratlista_barat = '". $masik->kutya_id ."'");
if(mysql_num_rows($leker2)>0){
$_SESSION[hiba]=hiba("Már szerepel ez a kutya a barátlistádon!");
header("Location: ../baratok.php");
}else{
mysql_query("INSERT INTO baratlista VALUES('". $_SESSION[id] ."','". $masik->kutya_id ."')");
$_SESSION[hiba]=ok("Sikeres felvéltel!!");
header("Location: ../baratok.php");
}
}
}
}else{
$_SESSION[hiba]=hiba("Nincs ilyen nevû kutya!");
header("Location: ../baratok.php");
}
}else{
header("Location: ../index.php");
}
?>
