<?php
include("session.php");
include("sql.php");
include("functions.php");
if(isset($_SESSION[nev])){
if(isset($_POST[oldpass]) and $_POST[newpass1] and $_POST[newpass2]){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."' and kutya_jelszo = '". $_POST[oldpass]."'");
if(mysql_num_rows($leker)>0){
if($_POST[newpass1]==$_POST[newpass2]){
if(hosszellenorzes($_POST[newpass1],4,16)==1){
$_SESSION[hiba]=hiba("Nem megfelelõ hosszúságú az új jelszó!");
header("Location: ../beallitas.php");
}else{
mysql_query("UPDATE kutya SET kutya_jelszo = '". $_POST[newpass1] ."' WHERE kutya_id = '". $_SESSION[id] ."'");
$_SESSION[hiba]=ok("Sikeres jelszó változtatás!");
header("Location: ../beallitas.php");
}
}else{
$_SESSION[hiba]=hiba("Nem egyeznek meg a beírt új jelszók!");
header("Location: ../beallitas.php");
}
}else{
$_SESSION[hiba]=hiba("Nem egyezik a beírt jelszó a jelenlegivel!");
header("Location: ../beallitas.php");
}
}elseif(isset($_POST[mail1]) and $_POST[mail2]){
if($_POST[mail1]==$_POST[mail2]){
if(hosszellenorzes($_POST[mail1],0,40)==1){
$_SESSION[hiba]=hiba("Nem megfelelõ hosszúságú az új E-mail cím!");
header("Location: ../beallitas.php");
}else{
if(email($_POST[mail1])){
$_SESSION['hiba']=hiba("Nem létezõ e-mail címet adtál meg!");
header("Location: ../beallitas.php");
}else{

mysql_query("UPDATE kutya SET kutya_email = '". $_POST[mail1] ."' WHERE kutya_id = '". $_SESSION[id] ."'");
$_SESSION[hiba]=ok("Sikeres E-mail cím változtatás!");
header("Location: ../beallitas.php");
}
}
}else{
$_SESSION[hiba]=hiba("Nem egyeznek meg a beírt új E-mail címek!");
header("Location: ../beallitas.php");
}
}elseif(isset($_POST[szin])){
$penz=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($penz)){
if($kutya->kutya_penz<$SZINESNEV){
$_SESSION[hiba]=hiba("Nincs elég pénzed!");
header("Location: ../beallitas.php");
}else{
switch($_POST[szin]){
case 1:
$szin="696969";
break;
case 2:
$szin="FFD700";
break;
case 3:
$szin="FF8C00";
break;
case 4:
$szin="DAA520";
break;
case 5:
$szin="FF6347";
break;
case 6:
$szin="FF4500";
break;
case 7:
$szin="DC143C";
break;
case 8:
$szin="DC143C";
break;
case 9:
$szin="800000";
break;
case 10:
$szin="9ACD32";
break;
case 11:
$szin="6B8E23";
break;
case 12:
$szin="008000";
break;
case 13:
$szin="6B8E23";
break;
case 14:
$szin="3CB371";
break;
case 15:
$szin="66CDAA";
break;
case 16:
$szin="1E90FF";
break;
case 17:
$szin="6495ED";
break;
case 18:
$szin="4682B4";
break;
case 19:
$szin="305DDB";
break;
case 20:
$szin="008B8B";
break;
case 21:
$szin="9370DB";
break;
case 22:
$szin="FF69B4";
break;
case 23:
$szin="F08080";
break;
case 24:
$szin="6D3AC4";
break;
case 25:
$szin="BA55D3";
break;
case 26:
$szin="8B008B";
break;
case 27:
$szin="4B0082";
break;
case 28:
$szin="774411";
break;
case 29:
$szin="000000";
break;
case 30:
$szin="483D8B";
break;
case 31:
$szin="32CD32";
break;
case 32:
$szin="00FFFF";
break;
case 33:
$szin="D2691E";
break;
case 34:
$szin="FF0000";
break;
case 35:
$szin="48D1CC";
break;
case 36:
$szin="7CFC00";
break;
case 37:
$szin="DE3163";
break;
case 38:
$szin="00FF7F";
break;
case 39:
$szin="B22222";
break;
case 40:
$szin="5F9EA0";
break;
case 41:
$szin="000080";
break;
case 42:
$szin="DB7093";
break;
case 44:
$szin="4169E1";
break;
case 45:
$szin="FF1493";
break;
default:
$szin="774411";
break;
}
$newpenz=$kutya->kutya_penz-$SZINESNEV;
//lotto nyeremeny
$handle = fopen("../data/lottonyeremeny.txt", "r");
$nyeremeny=fread($handle, filesize("../data/lottonyeremeny.txt"));
fclose($handle);
$nyeremeny+=$SZINESNEV*0.5;
$handle = fopen("../data/lottonyeremeny.txt", "w");
fwrite($handle, $nyeremeny);
fclose($handle);
//admin csontkuldes
$handle = fopen("../data/csont.txt", "r");
$nyeremeny=fread($handle, filesize("../data/csont.txt"));
fclose($handle);
$nyeremeny+=$SZINESNEV*0.5;
$handle = fopen("../data/csont.txt", "w");
fwrite($handle, $nyeremeny);
fclose($handle);
//admin csontkuldes vege
mysql_query("UPDATE kutya SET kutya_penz = '". $newpenz ."', kutya_betuszin = '". $szin ."' WHERE kutya_id = '". $_SESSION[id] ."'");
$_SESSION[hiba]=ok("Sikeres színezés!");
header("Location: ../beallitas.php");

}
}
}elseif(isset($_POST[falkaszin])){
$penz=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($penz)){
if($kutya->kutya_penz<$FALKASZINESNEV  or $kutya->kutya_falka==0){
$_SESSION[hiba]=hiba("Nincs elég pénzed!<br>");
header("Location: ../falkabealit.php");
}else{
switch($_POST[falkaszin]){
case 1:
$szin="696969";
break;
case 2:
$szin="FFD700";
break;
case 3:
$szin="FF8C00";
break;
case 4:
$szin="DAA520";
break;
case 5:
$szin="FF6347";
break;
case 6:
$szin="FF4500";
break;
case 7:
$szin="DC143C";
break;
case 8:
$szin="DC143C";
break;
case 9:
$szin="800000";
break;
case 10:
$szin="9ACD32";
break;
case 11:
$szin="6B8E23";
break;
case 12:
$szin="008000";
break;
case 13:
$szin="6B8E23";
break;
case 14:
$szin="3CB371";
break;
case 15:
$szin="66CDAA";
break;
case 16:
$szin="1E90FF";
break;
case 17:
$szin="6495ED";
break;
case 18:
$szin="4682B4";
break;
case 19:
$szin="305DDB";
break;
case 20:
$szin="008B8B";
break;
case 21:
$szin="9370DB";
break;
case 22:
$szin="FF69B4";
break;
case 23:
$szin="F08080";
break;
case 24:
$szin="6D3AC4";
break;
case 25:
$szin="BA55D3";
break;
case 26:
$szin="8B008B";
break;
case 27:
$szin="4B0082";
break;
case 28:
$szin="774411";
break;
case 29:
$szin="000000";
break;
case 30:
$szin="483D8B";
break;
case 31:
$szin="32CD32";
break;
case 32:
$szin="00FFFF";
break;
case 33:
$szin="D2691E";
break;
case 34:
$szin="FF0000";
break;
case 35:
$szin="48D1CC";
break;
case 36:
$szin="7CFC00";
break;
case 37:
$szin="DE3163";
break;
case 38:
$szin="00FF7F";
break;
case 39:
$szin="B22222";
break;
case 40:
$szin="5F9EA0";
break;
case 41:
$szin="000080";
break;
case 42:
$szin="DB7093";
break;
case 44:
$szin="4169E1";
break;
case 45:
$szin="FF1493";
break;
default:
$szin="774411";
break;
}
$newpenz=$kutya->kutya_penz-$FALKASZINESNEV;
mysql_query("UPDATE kutya SET kutya_penz = '". $newpenz ."' WHERE kutya_id = '". $_SESSION[id] ."'");
mysql_query("UPDATE falka SET falka_szin = '". $szin ."' WHERE falka_id = '". $kutya->kutya_falka ."'");
$_SESSION[hiba]=ok("Sikeres színezés!<br>");
header("Location: ../falkabealit.php");
}
}
}elseif(isset($_POST[cucc])){
$penz=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($penz)){
if($kutya->kutya_penz<$TURBO){
$_SESSION[hiba]=hiba("Nincs elég pénzed!");
header("Location: ../beallitas.php");
}else{
if($_POST[cucc] == 1 or $_POST[cucc] == 2){
$newpenz=$kutya->kutya_penz-$TURBO;
//lotto nyeremeny
$handle = fopen("../data/lottonyeremeny.txt", "r");
$nyeremeny=fread($handle, filesize("../data/lottonyeremeny.txt"));
fclose($handle);
$nyeremeny+=$TURBO;
$handle = fopen("../data/lottonyeremeny.txt", "w");
fwrite($handle, $nyeremeny);
fclose($handle);
//vege lotto nyeremeny
switch($_POST[cucc]){
case 1:
mysql_query("UPDATE kutya SET kutya_penz = '". $newpenz ."', kutya_egeszseg = '100' WHERE kutya_id = '". $_SESSION[id] ."'");
if($kutya->kutya_falka!=0){
falkapont($kutya->kutya_falka);
}
$_SESSION[hiba]=ok("Sikeres módosítás!");
header("Location: ../beallitas.php");
break;
case 2:
mysql_query("UPDATE kutya SET kutya_penz = '". $newpenz ."', kutya_suly = '10' WHERE kutya_id = '". $_SESSION[id] ."'");
$_SESSION[hiba]=ok("Sikeres módosítás!");
header("Location: ../beallitas.php");
break;
}

}else{
header("Location: ../index.php");
}
}
}
}elseif(isset($_POST[elkuld])){
if($_POST[falkakorlevel]=="on"){
$falkak=0;
}else{
$falkak=1;
}
mysql_query("UPDATE kutya SET kutya_falkakorlevel = '". $falkak ."' WHERE kutya_id = '". $_SESSION[id] ."'");
$_SESSION[hiba]=ok("Sikeres változtatás!");
header("Location: ../beallitas.php");
}else{
$_SESSION[hiba]=hiba("Nem töltöttél ki minden mezzõt!");
header("Location: ../beallitas.php");
}
}else{
header("Location: ../index.php");
}
?>