<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[id])){
header("Location: kutyak.php");
}else{
if(isset($_GET[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_nev = '". $_GET[id] ."'");
if(mysql_num_rows($leker)==0){
$_SESSION['hiba']=hiba("Nincs ilyen nevû kutya!");
header("Location: mail.php");
}else{
while($kutya=mysql_fetch_object($leker)){
$message = "Üdv!\nValaki kikérte az ehhez a mail címhez tartozó belépéshez szükséges adatókat, ha nem te voltál kérlek hagyd figyelmen kívül a levelünk. A belépéshez szükséges adataid:\n
Kutyád neve: ". $kutya->kutya_nev ."\nJelszó: ". $kutya->kutya_jelszo ."\n\nÜdvözlettel:\nKutyuskanevelde csapata\n\nU.i.: Ez egy automatán generált levél kérlek ne válaszolj rá.";
$message = wordwrap($message, 70);
if (mail($kutya->kutya_email, 'Elfelejetett jelszó igénylés', $message)){
header("Location: mail.php?ok=1");
}else{
header("Location: mail.php?ok=2");
}}}
}else{
$adat="<center><u><big>Elfelejetett jelszó</big></u><br><br>";
if(isset($_GET['ok'])){
$adat.="<br><br>";
if($_GET['ok']==1){
$adat.=ok("Sikeressen elküldtük a megadott e-mail címre a jelszót!</center>");
}else{
$adat.=hiba("Sajnos a mai nap már elértük a napi E-mail küldési limitünk, próbálkozz holnap!</center>");
}
}else{
$adat.="Ha elfejetted a kutyád jelszavát írd be a kutyád nevét és mail címedre elküldjük a szükséges adatokat!<br>
Kutyád neve:<form method=GET action=mail.php><input type=text name=id> <input type=submit value='Elküld'></form>". $_SESSION['hiba'] ."</center>";
$_SESSION[hiba]='';
}
oldal($adat);
}}
	?>
