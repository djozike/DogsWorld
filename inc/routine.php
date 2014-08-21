<?
include("sql.php");
include("oop.php");
$handle = fopen("idor.txt", "r");
$legutobbifutas=fread($handle, filesize("idor.txt"));
fclose($handle);
if($legutobbifutas<$ma){
$user=mysql_query("SELECT * FROM `kutya`",$kapcsolat);
while($leker=mysql_fetch_object($user)){
$feltolt=(($ma-$leker->kutya_regido)/(3600*24))+1;
if($leker->kutya_fagyasztva==0){
$fagyaszt=0;
if($leker->kutya_etel==0){
$newkaja=0;
$egeszseg=$leker->kutya_egeszseg-5;
$suly=$leker->kutya_suly-2.5;
}else{
$newkaja=$leker->kutya_etel-1;
switch($leker->kutya_kajatipus){
case 1: 
$egeszseg=$leker->kutya_egeszseg;
$suly=$leker->kutya_suly;
break;
case 2:
$egeszseg=$leker->kutya_egeszseg+1;
$suly=$leker->kutya_suly+0.5;
break;
case 3:
$egeszseg=$leker->kutya_egeszseg+2;
$suly=$leker->kutya_suly+1;
break;
}
}
if(($suly>79.9) and ($suly<90)){
$egeszseg--;
} else if($suly>89.9){
$egeszseg=$egeszseg-2;
}else{}

}else{ $fagyaszt=$leker->kutya_fagyasztva-1; $egeszseg=$leker->kutya_egeszseg; $newkaja=$leker->kutya_etel; $suly=$leker->kutya_suly;}

mysql_query("UPDATE `kutya` SET `kutya_fagyasztva` = '". $fagyaszt ."', `kutya_egeszseg` = '". kerekit($egeszseg) ."',`kutya_etel` = '". $newkaja ."',`kutya_kor` = '". $feltolt ."',`kutya_suly` = '". kerekit($suly) ."' WHERE `kutya_id` = '". $leker->kutya_id ."'");

}
$egszampontok=mysql_query("SELECT * FROM egyszampontok");
while($egyszam=mysql_fetch_object($egszampontok)){
mysql_query("UPDATE `egyszampontok` SET `egyszampontok_tipp` = '0', egyszampontok_szam = '". rand(1,75) ."', egyszampontok_min = '1', egyszampontok_max = '76' WHERE egyszampontok_kid = '". $egyszam->egyszampontok_kid ."'");
}

mysql_query("DELETE FROM `uzenetek` WHERE uzenet_torol_kuldo = 1 and uzenet_torol_kapo = 1");
mysql_query("DELETE FROM uzenetek WHERE REPLACE(REPLACE(REPLACE(uzenet_ido,'-',''),' ',''),':','') < '". date("YmdHis",$ma-(3600*24*$LEVELTORLES)) ."' and uzenet_olvas = '1' and uzenet_tipus = '0'");

$tiltottak=mysql_query("SELECT * FROM forumtilt");
while($szamol=mysql_fetch_object($tiltottak)){
$ujtilt=$szamol->forumtilt_ido-1;
mysql_query("UPDATE forumtilt SET forumtilt_ido = '". $ujtilt ."' WHERE forumtilt_kid = '". $szamol->forumtilt_kid ."'");
}
mysql_query("DELETE FROM forumtilt WHERE forumtilt_ido = 0");
$tiltottak2=mysql_query("SELECT * FROM oldaltilt");
while($szamol2=mysql_fetch_object($tiltottak2)){
$ujtilt2=$szamol2->oldaltilt_ido-1;
mysql_query("UPDATE oldaltilt SET oldaltilt_ido = '". $ujtilt2 ."' WHERE oldaltilt_kid = '". $szamol2->oldaltilt_kid ."'");
}
mysql_query("DELETE FROM oldaltilt WHERE oldaltilt_ido = 0");
$tiltottak3=mysql_query("SELECT * FROM forumiptilt");
while($szamol3=mysql_fetch_object($tiltottak3)){
$ujtilt3=$szamol3->forumiptilt_ido-1;
mysql_query("UPDATE forumiptilt SET forumiptilt_ido = '". $ujtilt3 ."' WHERE forumiptilt_ip = '". $szamol3->forumiptilt_ip ."'");
}
mysql_query("DELETE FROM forumiptilt WHERE forumiptilt_ido = 0");
mysql_query("DELETE FROM piac WHERE piac_ido < ". $ma-(3*24*3600) ."");
$kellene=getdate();
if($kellene[weekday]=="Monday"){
include("heti.php");
}
include("falkapont.php");
$handle = fopen("idor.txt", "w");
fwrite($handle, $ma);
fclose($handle);

$useres=mysql_query("SELECT * FROM `kvizeredmeny` ORDER BY kvizeredmeny_pont  desc limit 0, 1",$kapcsolat);
$i=0;
while($lekeres=mysql_fetch_object($useres)){

$kuty=new kutya();
$kuty->GetKutyaByID($lekeres->kvizeredmeny_kutyaid);
$kuty->PenzHozzaad(200);
$kuty->SendUzenet(0,"Gratulálunk,<br> a kvíz játékban az 1. helyezést érted el, ezért kaptál ". penz(200)." összeget.");
$i++;

}

mysql_query("DELETE FROM kvizeredmeny");
			
}
?>
