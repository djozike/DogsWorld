<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya2=mysql_fetch_object($leker)){
$leker2=mysql_query("SELECT * FROM falka WHERE falka_id = '". $kutya2->kutya_falka ."'");
while($falka=mysql_fetch_object($leker2)){
$jogok=explode('|',$falka->falka_jogok);
if(($falka->falka_vezeto==$_SESSION[id]) or ($falka->falka_vezetohelyettes==$_SESSION[id] and $jogok[2]==1)){
if($_GET[nev]!=""){
$leker=mysql_query("SELECT kutya_nev, kutya_id, kutya_falka FROM kutya WHERE kutya_nev = '". $_GET[nev] ."'");
if(mysql_num_rows($leker)>0){
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_id==$_SESSION[id]){
$_SESSION[hiba]=hiba("Magadat nem tilthatod le!<br>");
header("Location: ../falkabealit.php?page=2");
}elseif($kutya->kutya_id==$falka->falka_vezetohelyettes){
$_SESSION[hiba]=hiba("A helyettesed nem tilthatod le!<br>");
header("Location: ../falkabealit.php?page=2");
}elseif($kutya->kutya_id==$falka->falka_vezeto){
$_SESSION[hiba]=hiba("A fönököd nem tilthatod le!<br>");
header("Location: ../falkabealit.php?page=2");
}else{
$leker1=mysql_query("SELECT * FROM falkatilto WHERE falkatilto_falka = '". $falka->falka_id ."' and falkatilto_kutya = '". $kutya->kutya_id ."'");
if(mysql_num_rows($leker1)>0){
$_SESSION[hiba]=hiba("Már szerepel a tiltólistádon ez a név!<br>");
header("Location: ../falkabealit.php?page=2");
}else{
if($kutya->kutya_falka == $falka->falka_id){
mysql_query("UPDATE kutya SET kutya_falka = '0' WHERE kutya_id = '". $kutya->kutya_id ."'");
}
mysql_query("INSERT INTO falkatilto values ('". $falka->falka_id  ."','". $kutya->kutya_id ."')");
$_SESSION[hiba]=ok("Sikeres felvétel!<br>");
header("Location: ../falkabealit.php?page=2");
}
}
}
}else{
$_SESSION[hiba]=hiba("Nem létezõ nevet adtál meg!<br>");
header("Location: ../falkabealit.php?page=2");
}
}else{
$_SESSION[hiba]=hiba("Nem adtál meg nevet!<br>");
header("Location: ../falkabealit.php?page=2");
}

}else{
header("Location: ../falkabealit.php?page=2");
}
}
}
}else{
header("Location: ../index.php");
}


?>
