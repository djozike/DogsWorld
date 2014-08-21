<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id])){
if(isset($_POST[nev]) and $_POST[penz]>0 and $_POST[penz]<10){
if($_POST[nev]!=""){
$leker=mysql_query("SELECT kutya_id, kutya_penz FROM kutya WHERE kutya_nev = '". $_POST[nev] ."'");
If(mysql_num_rows($leker)>0){
while($kellid=mysql_fetch_object($leker)){
if($kellid->kutya_id==$_SESSION[id]){
$_SESSION[hiba]="<br>". hiba("Magadnak nem küldhetsz pénzt!");
header("Location: ../uzenetek.php?page=penztkuld");
}else{
$lekerke=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($penz=mysql_fetch_object($lekerke)){
if($penz->kutya_penz < (100*$_POST[penz])){
$_SESSION[hiba]="<br>". hiba("Nincs elég pénzed!");
header("Location: ../uzenetek.php?page=penztkuld");
}else{
$kuldo=$penz->kutya_penz-(100*$_POST[penz]);
$kapo=$kellid->kutya_penz+(100*$PENZKULDOSZAZALEK*$_POST[penz]);
$tartalom=str_replace("<","&lt;",$_POST[uzenet]);
if($penz->kutya_betuszin=="774411"){
$nev1=htmlentities($penz->kutya_nev);
}else{
$nev1="<font color=#". $penz->kutya_betuszin .">". htmlentities($penz->kutya_nev) ."</font>";
}
$leiras="Gratulálok!<br><b>". $nev1 ."</b> nevû kutya most küldött neked ". penz(100*$PENZKULDOSZAZALEK*$_POST[penz]) ." összeget. A pénz melett a következõt is üzeni:<br>". $tartalom;
mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $kellid->kutya_id ."', NOW(), 0, 0, 1, 0)");
mysql_query("UPDATE kutya SET kutya_penz = ". $kuldo ." WHERE kutya_id = '". $_SESSION[id] ."'");
mysql_query("UPDATE kutya SET kutya_penz = ". $kapo ." WHERE kutya_id = '". $kellid->kutya_id ."'");
$_SESSION[hiba]="<br>". ok("Sikeres kézbesítés!");
header("Location: ../uzenetek.php?page=penztkuld");
}
}}
}
}else{
$_SESSION[hiba]="<br>". hiba("Nem létezik ilyen nevû kutya!");
header("Location: ../uzenetek.php?page=penztkuld");
}
}
else
{
$_SESSION[hiba]="<br>". hiba("Nem adtál meg nevet!");
header("Location: ../uzenetek.php?page=penztkuld");
}
///regi uzenet kuldes
}elseif($_POST[uzenet]!="" and isset($_POST[nev])){
$leker=mysql_query("SELECT kutya_id FROM kutya WHERE kutya_nev = '". $_POST[nev] ."'");
If(mysql_num_rows($leker)>0){
while($kellid=mysql_fetch_object($leker)){
if($kellid->kutya_id==$_SESSION[id]){
$_SESSION[hiba]="<br>". hiba("Magadnak nem küldhetsz üzenetet!");
header("Location: ../uzenetek.php?page=uzenetir");
}else{
$tilto=mysql_query("SELECT * FROM tilto WHERE tilto_tiltott = '". $_SESSION[id] ."' and tilto_tilto = '". $kellid->kutya_id ."'");
if(mysql_num_rows($tilto)>0){
$_SESSION[hiba]="<br>". hiba("Nem küldhetsz levelet mivel a tiltólistán szerepelsz!");
header("Location: ../uzenetek.php?page=uzenetir");
}else{
$tartalom=str_replace("<","&lt;",$_POST[uzenet]);
$tartalom=str_replace("[center]","<center>",$tartalom);
$tartalom=str_replace("[/center]","</center>",$tartalom);
$tartalom=str_replace("[color=","<font color=",$tartalom);
$tartalom=str_replace("[/color]","</font>",$tartalom);
$tartalom=str_replace("[img]","<img src=",$tartalom);
$tartalom=str_replace("[/img]",">",$tartalom);
$tartalom=str_replace("]",">",$tartalom);


mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $tartalom ."', '". $_SESSION[id] ."', '". $kellid->kutya_id ."', NOW(), 0, 0, 0, 0)");
$_SESSION[hiba]="<br>". ok("Sikeres kézbesítés!");
header("Location: ../uzenetek.php?page=uzenetir");
}

}
}
}else{
$_SESSION[hiba]="<br>". hiba("Nem létezik ilyen nevû kutya!");
header("Location: ../uzenetek.php?page=uzenetir");
}
//uj uzenet kuldes
}elseif($_GET[uzenet]!="" and isset($_GET[id])){
$kutyi=new kutya();
if($kutyi->getKutyaByID($_GET[id])){
if($_GET[id]==$_SESSION[id]){
echo "Magadnak nem küldhetsz üzenetet!";
}else{
$tilto=mysql_query("SELECT * FROM tilto WHERE tilto_tiltott = '". $_SESSION[id] ."' and tilto_tilto = '". $kellid->kutya_id ."'");
if(mysql_num_rows($tilto)>0){
echo "Nem küldhetsz levelet mivel a tiltólistán szerepelsz!";
}else{
$tartalom=str_replace("<","&lt;",$_GET[uzenet]);
$tartalom=str_replace("[br]","<br>",$tartalom);
$tartalom=str_replace("[center]","<center>",$tartalom);
$tartalom=str_replace("[/center]","</center>",$tartalom);
$tartalom=str_replace("[color=","<font color=",$tartalom);
$tartalom=str_replace("[/color]","</font>",$tartalom);
$tartalom=str_replace("[img]","<img src=",$tartalom);
$tartalom=str_replace("[/img]",">",$tartalom);
$tartalom=str_replace("]",">",$tartalom);


mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $tartalom ."', '". $_SESSION[id] ."', '". $_GET[id] ."', NOW(), 0, 0, 0, 0)");
mysql_query("UPDATE uzenetek SET uzenet_olvas = 1 WHERE uzenet_kuldo = '". $_GET['id'] ."' and uzenet_kapo= '". $_SESSION['id'] ."'");
//listazas
echo uzenet_listazas($_SESSION['id'], $_GET[id]);
//listazas vege
}

}
}else{
echo "Nem létezik ilyen nevû kutya!";
}

}
elseif(isset($_GET[id])){
//listazas
$leker=mysql_query("SELECT * 
FROM uzenetek 
WHERE uzenet_kapo = '". $_GET[id] ."' and uzenet_kuldo = '". $_SESSION['id'] ."' and uzenet_torol_kuldo = '0'
or uzenet_kapo = '". $_SESSION['id'] ."' and uzenet_kuldo = '". $_GET[id] . "' and uzenet_torol_kapo = '0'
ORDER BY uzenet_ido");
echo mysql_num_rows($leker);

echo uzenet_listazas($_SESSION['id'], $_GET[id]);
//listazas vege
}
elseif(isset($_GET[page])){
//osszes uzenet listazas
echo osszes_uzenet_listazasa($_SESSION['id'], $_GET[id]);
//osszes uzenet listazas vege
}
elseif(isset($_GET[level])){
//van-e uj level
$leker=mysql_query("SELECT * 
FROM uzenetek 
WHERE uzenet_kapo = '". $_SESSION['id'] ."' and uzenet_olvas = '0'");
echo mysql_num_rows($leker);
//van-e uj level vege
}
else{
$_SESSION[hiba]="<br>". hiba("Nem adtál meg minden szükséges adatot!");
header("Location: ../uzenetek.php?page=uzenetir");
}
}else{
header("Location: ../index.php");
}
?>
