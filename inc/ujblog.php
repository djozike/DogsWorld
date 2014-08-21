<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_GET[id])){
if(isset($_SESSION[id]) and $_POST[cim] and $_POST[leiras]!=""){
if(hosszellenorzes($_POST[cim],0,60)==1){
$_SESSION[hiba]=hiba("Nem megfelelõ hosszú cím!");
header("Location: ../ujbejegyzes.php?id=". $_GET[id]);
}else{
mysql_query("UPDATE blog SET blog_ido = NOW(), blog_cim = '". $_POST[cim] ."', blog_bejegyzes = '". $_POST[leiras] ."' WHERE blog_id = '". $_GET[id] ."'");

header("Location: ../blog.php?blog=". $_GET[id]);
}
}else{
$_SESSION[hiba]=hiba("Nem töltöttél ki minden mezõt!");
header("Location: ../ujbejegyzes.php?id=". $_GET[id]);
}

}else{
if(isset($_SESSION[id]) and $_POST[cim] and $_POST[leiras]!=""){
if(hosszellenorzes($_POST[cim],0,60)==1){
$_SESSION[hiba]=hiba("Nem megfelelõ hosszú cím!");
header("Location: ../ujbejegyzes.php");
}else{
mysql_query("INSERT INTO blog VALUES ('', '". $_SESSION[id] ."', NOW(), '". $_POST[cim] ."', '". $_POST[leiras] ."')");

$lekerid8=mysql_query("SELECT * FROM blog WHERE blog_kutya = '". $_SESSION[id] ."' ORDER BY blog_id DESC limit 1");

while($kell=mysql_fetch_object($lekerid8)){
header("Location: ../blog.php?blog=". $kell->blog_id);
}
}
}else{
$_SESSION[hiba]=hiba("Nem töltöttél ki minden mezõt!");
header("Location: ../ujbejegyzes.php");
}}
?>
