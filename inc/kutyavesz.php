<?php
include("sql.php");
include("oop.php");
include("session.php");
if(isset($_SESSION[id]) and $_GET[id]){
$ellenoriz=mysql_query("SELECT * FROM piac WHERE piac_id = '". $_GET[id] ."' and piac_elado <> '". $_SESSION[id] ."'");
if(mysql_num_rows($ellenoriz)>0){
while($elado=mysql_fetch_object($ellenoriz)){
$kutyus=new kutya();
$kutyus->GetKutyaByID($_SESSION[id]);
$penzem=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutyam=mysql_fetch_object($penzem)){
if($elado->piac_ar*100>$kutyus->penz){
	$_SESSION[hiba]=hiba("Nincs elég pénzed, hogy megvedd ezt a kutyát!");
	header("Location: ../piac.php");
}else{
$vasaroltKutyus=new kutya();
$vasaroltKutyus->GetKutyaByID($elado->piac_aru);

mysql_query("DELETE FROM session WHERE nev = '". $vasaroltKutyus->nev ."'");
mysql_query("DELETE FROM baratlista WHERE baratlista_owner = '". $vasaroltKutyus->id ."'");
mysql_query("UPDATE uzenetek SET uzenet_torol_kuldo = '1' WHERE uzenet_kuldo = '". $vasaroltKutyus->id ."'");
mysql_query("UPDATE uzenetek SET uzenet_torol_kapo = '1' WHERE uzenet_kapo = '". $vasaroltKutyus->id ."'");

$ujjelszo=rand(100000000,999999999);
$levonandopenz=$elado->piac_ar*100;
$jovairandopenz=$elado->piac_ar*$PIACELADSZAZALEK*100;

$SalesmanKutyus=new kutya();
$SalesmanKutyus->GetKutyaByID($elado->piac_elado);
$SalesmanKutyus->PenzHozzaad($jovairandopenz);
$SalesmanKutyus->SendUzenet(0,"Szia!<br>Jó hírem van. Sikerült eladnod a <b>". $vasaroltKutyus->nev ."</b> nevû kutyát az érte járó ". penz($jovairandopenz) ." összeget jováírtuk ennél a kutyádnál.");

$kutyus->PenzElvesz($levonandopenz);
$kutyus->SendUzenet(0,"Szia!<br>Megvásároltad a <b>". $vasaroltKutyus->nev ."</b> nevû kutyát az érte járó ". penz($levonandopenz) ." összeget levonttuk tõled. A belépéshez szükséges adatok a következõk:<br>
Név: ". $vasaroltKutyus->nev ."<br>Jelszó:". $ujjelszo ."<br><br>Jó kutyázást!");

mysql_query("UPDATE kutya SET kutya_jelszo = '". $ujjelszo ."', kutya_email = '". $kutyam->kutya_email ."' WHERE kutya_id = '". $vasaroltKutyus->id ."'");

mysql_query("DELETE FROM piac WHERE piac_id = '". $elado->piac_id ."'");
$_SESSION[hiba]=ok("Sikeressen megvásároltad a kutyát, levélben megkaptad a jelszavát!");
header("Location: ../piac.php");

}
}
}
}else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
