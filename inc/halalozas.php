<?php
include("session.php");
include("sql.php");
include("functions.php");
$hullakle=mysql_query("SELECT * FROM kutya WHERE kutya_egeszseg = 0 and kutya_id <> 1");
while($hullak=mysql_fetch_object($hullakle)){

///falka
$falkavezetoh=mysql_query("SELECT * FROM falka WHERE falka_vezetohelyettes = '". $hullak->kutya_id ."'");
while($falkah=mysql_fetch_object($falkavezetoh)){
mysql_query("UPDATE falka SET falka_vezetohelyettes = '0' WHERE falka_id = '". $falkah->falka_id ."'");
}
$falkavezeto=mysql_query("SELECT * FROM falka WHERE falka_vezeto = '". $hullak->kutya_id ."'");
while($falka=mysql_fetch_object($falkavezeto)){
if($falka->falka_vezetohelyettes==0){
falkatorol($falka->falka_id);
}else{
mysql_query("UPDATE falka SET falka_vezeto = '". $falka->falka_vezetohelyettes ."', falka_vezetohelyettes = '0' WHERE falka_id = '". $falka->falka_id ."'");
}
}
///adatlap
if(file_exists("../pic/user/". $hullak->kutya_id .".png")){
unlink("../pic/user/". $hullak->kutya_id .".png");
}
mysql_query("DELETE FROM adatlap WHERE adatlap_id = '". $hullak->kutya_id ."'");
////baratlista
mysql_query("DELETE FROM baratlista WHERE baratlista_owner = '". $hullak->kutya_id ."'");
mysql_query("DELETE FROM baratlista WHERE baratlista_barat = '". $hullak->kutya_id ."'");
///blog
$blogok=mysql_query("SELECT * FROM blog WHERE blog_kutya = '". $hullak->kutya_id ."'");
while($blog=mysql_fetch_object($blogok)){
mysql_query("DELETE FROM komment WHERE komment_blog = '". $blog->blog_id ."'");
}
mysql_query("DELETE FROM blog WHERE blog_kutya = '". $hullak->kutya_id ."'");
///uzenetek
mysql_query("DELETE FROM tilto WHERE tilto_tilto = '". $hullak->kutya_id ."'");
mysql_query("DELETE FROM tilto WHERE tilto_tiltott = '". $hullak->kutya_id ."'");
mysql_query("DELETE FROM uzenetek WHERE uzenet_kuldo = '". $hullak->kutya_id ."'");
mysql_query("DELETE FROM uzenetek WHERE uzenet_kapo = '". $hullak->kutya_id ."'");
///tanulas
mysql_query("DELETE FROM tanul WHERE tanul_id = '". $hullak->kutya_id ."'");
///hazassag
mysql_query("DELETE FROM hazassag WHERE hazassag_aktiv = '". $hullak->kutya_id ."' or hazassag_ferj = '". $hullak->kutya_id ."' or hazassag_feleseg = '". $hullak->kutya_id ."'");
mysql_query("DELETE FROM kolyok WHERE kolyok_apa = '". $hullak->kutya_id ."' or kolyok_anya = '". $hullak->kutya_id ."'");
//moderator
mysql_query("DELETE FROM moderator WHERE mod_kutya = '". $hullak->kutya_id ."'");
///piac
mysql_query("DELETE FROM piac WHERE piac_elado = '". $hullak->kutya_id ."'");
mysql_query("DELETE FROM piac WHERE piac_aru = '". $hullak->kutya_id ."'");
///lotto
mysql_query("DELETE FROM lottoszelveny WHERE lottoszelveny_kid = '". $hullak->kutya_id ."'");
}
mysql_query("DELETE FROM kutya WHERE kutya_egeszseg = 0 and kutya_id <> 1");

?>
