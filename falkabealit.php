<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
include("inc/stilus.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
$leker2=mysql_query("SELECT * FROM falka WHERE falka_id = '". $kutya->kutya_falka ."'");
while($falka=mysql_fetch_object($leker2)){
$jogok=explode('|',$falka->falka_jogok);
if(($falka->falka_vezeto==$_SESSION[id]) or ($falka->falka_vezetohelyettes ==  $_SESSION[id] and (($jogok[2]==1 OR $jogok[3]==1) or ($jogok[2]==1 and $jogok[3]==1)))){
if($falka->falka_vezeto==$_SESSION[id]){
$menu="<center><a href=falkabealit.php class='feherlink'>Adat módosítás</a>  | <a href=falkabealit.php?page=1 class='feherlink'>Taglista</a> | <a href=falkabealit.php?page=3 class='feherlink'>Események</a> | <a href=falkabealit.php?page=2 class='feherlink'>Tiltólista</a><br><br>";
}else{
$menu="<center>";
if($jogok[3]==1){
$menu.="<a href=falkabealit.php?page=1 class='feherlink'>Taglista</a> | <a href=falkabealit.php?page=3 class='feherlink'>Események</a>";
}else{}
if($jogok[2]==1){
if($menu!="<center>"){
$menu.=" | ";
}
$menu.="<a href=falkabealit.php?page=2 class='feherlink'>Tiltólista</a>";
}$menu.="<br><br>";
}
$adat=$menu;
$adat.=$_SESSION[hiba];
$_SESSION[hiba]="";
if($_GET[page]==1){
if(($falka->falka_vezeto==$_SESSION[id]) or ($falka->falka_vezetohelyettes ==  $_SESSION[id] and  $jogok[3]==1)){
switch($_GET[rendez]){
case 7:
$tipus="kutya_belepip DESC";
break;
case 6:
$tipus="kutya_falkaido DESC";
break;
case 5:
$tipus="kutya_falkapont DESC";
break;
case 4:
$tipus="kutya_egeszseg DESC";
break;
case 3:
$tipus="kutya_kor DESC";
break;
case 2:
$tipus="kutya_fajta";
break;
default:
$tipus="kutya_nev";
break;
}
$leker3=mysql_query("SELECT kutya_fagyasztva, kutya_id, kutya_nev, kutya_fajta, kutya_kor, kutya_betuszin, kutya_egeszseg, kutya_belepip, kutya_falka, kutya_falkaido, (kutya_kor*kutya_egeszseg/100) as kutya_falkapont FROM kutya WHERE kutya_falka = '". $kutya->kutya_falka ."' ORDER BY ". $tipus .""); $tags=mysql_num_rows($leker3);
$helyezes=mysql_query("SELECT * FROM falka ORDER BY falka_pont DESC");
while($dumdum=mysql_fetch_object($helyezes)){
$i++;
if($dumdum->falka_id==$falka->falka_id){
break;
}
$pontpont=$dumdum->falka_pont;
}
$kellpont=$pontpont-$falka->falka_pont;
if($kellpont<0)
{
$kellpont="-";
}
$adat.="<big><u>Infó</u></big><br><br>". VilagosMenu(700,
"<table border=0 width=650><tr><td align=left>Tagok száma:</td><td align=right width=70>". $tags ." fõ</td><td align=left>Pontszám:</td><td align=right width=120>". $falka->falka_pont ."</td><td align=left>Átlag:</td><td align=right width=70>". round($falka->falka_pont/$tags,2) ."</td></tr>
<tr><td align=left>Helyezés:</td><td align=right>". $i .".</td><td align=left colspan=2>Szükséges pont a javításhoz:</td><td align=right colspan=2>". $kellpont ." pont</td></tr>
</table>") . "<br><big><u>Taglista</u></big><br><br>";
$kutyalista="<table border=0 width=650><tr><th align=center><a href=falkabealit.php?page=1&rendez=1 class='feherlink'>Név</a></th><th align=center><a href=falkabealit.php?page=1&rendez=2 class='feherlink'>Fajta</a></th><th align=center><a href=falkabealit.php?page=1&rendez=3 class='feherlink'>Kor</a></th><th align=center><a href=falkabealit.php?page=1&rendez=4 class='feherlink'>Egészség</a></th><th align=center><a href=falkabealit.php?page=1&rendez=6 class='feherlink'>Tagság</a></th><th align=center><a href=falkabealit.php?page=1&rendez=5 class='feherlink'>Falkapont</a> <a href=falkabealit.php?page=1&rendez=5 class='feherlink'>~</a></th></tr>";
while($kutyak=mysql_fetch_object($leker3)){
$falkapont="<font color=#FF0000>0</font>";
if($kutyak->kutya_fagyasztva==0){
$darabszam=mysql_query("SELECT * FROM kutya WHERE kutya_falka='". $kutyak->kutya_falka ."' and kutya_belepip = '". $kutyak->kutya_belepip ."'");
if(mysql_num_rows($darabszam)>1){
$szamol=mysql_query("SELECT (kutya_kor * kutya_egeszseg /100) AS kutya_falkapont, kutya_id FROM kutya WHERE kutya_falka='". $kutyak->kutya_falka ."' and kutya_belepip = '". $kutyak->kutya_belepip ."' and kutya_fagyasztva = '0' ORDER BY kutya_falkapont DESC limit 1");
while($eddigikutyak=mysql_fetch_object($szamol)){
if($eddigikutyak->kutya_id==$kutyak->kutya_id){
$falkapont=floor($eddigikutyak->kutya_falkapont);
}
}
}else{
$falkapont=floor($kutyak->kutya_falkapont);
}
}else{
$falkapont="<font color=#000098>0</font>";
}
$kutyalista.="<tr><td align=center>". idtonev($kutyak->kutya_id) ."</td><td align=center>". kutyaszamtonev($kutyak->kutya_fajta) ."</td><td align=center>". $kutyak->kutya_kor ." nap</td><td align=center>". $kutyak->kutya_egeszseg ."%</td><td align=center>". ceil(($ma-$kutyak->kutya_falkaido)/(24*3600)) ." napja</td><td align=center>".  $falkapont ."</td></tr>";

}
$kutyalista.="</table>";
$adat.=VilagosMenu(700,$kutyalista);
}
}elseif($_GET[page]==2){
if(($falka->falka_vezeto==$_SESSION[id]) or ($falka->falka_vezetohelyettes ==  $_SESSION[id] and  $jogok[2]==1)){
$adat.="Ha valaki zavarja a falkád, akkor tiltsd ki és nem tud belépni,<br> illetve ha tag automatikusan kilépteti a rendszer!". $_SESSION[hiba] ."<br><form action=inc/falkatilto.php method=GET><table border=0><tr><td>Neve:</td><td><input type=text name=nev></td><td><input type=submit value=Elküld></form></td></tr></table><br>";
$_SESSION[hiba]="";
$leker=mysql_query("SELECT * FROM falkatilto WHERE falkatilto_falka = '". $falka->falka_id ."'");
if(mysql_num_rows($leker)>0){
$adat.="<table border=0><tr><td align=center width=130>Név</td><td></td></tr>";
while($tiltott=mysql_fetch_object($leker)){
$leker2=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $tiltott->falkatilto_kutya ."'");
while($tiltokutya=mysql_fetch_object($leker2)){
if($tiltokutya->kutya_betuszin=="774411"){
$nev1=htmlentities($tiltokutya->kutya_nev);
}else{
$nev1="<font color=#". $tiltokutya->kutya_betuszin .">". htmlentities($tiltokutya->kutya_nev) ."</font>";
}
$adat.="<tr><td align=left><a href=kutyak.php?id=". $tiltokutya->kutya_id ." class='feherlink'>". $nev1 ."</a></td><td><a href=inc/felold.php?id=". $tiltokutya->kutya_id ."><img src=pic/kuka.jpg border=0></a></td></tr>";

}
}
$adat.="</table>";
}else{
$adat.=ok("Nincs senki a listán!");
}
}
}elseif($_GET[page]==3){
if(($falka->falka_vezeto==$_SESSION[id]) or ($falka->falka_vezetohelyettes ==  $_SESSION[id] and  $jogok[3]==1)){
$szin="hatter8.gif";
$adat=$menu ."<big><u>Események</u></big><br><br>Itt láthatod ezen a héten kik léptek be és kik léptek ki a falkádból.<br><br>
<table border=0 width=525 cellpadding=0 cellspacing=0><tr><th width=25 background=pic/". $szin ."></th><th align=center background=pic/". $szin ." width=350>Esemény</th><th align=center background=pic/". $szin .">Idõ</th></tr>";
$esemenyek=mysql_query("SELECT * FROM falkaesemeny WHERE falkaesemeny_falkaid = '".  $falka->falka_id  ."'");
while($esemeny=mysql_fetch_object($esemenyek)){
if($szin=="hatter8.gif"){
$szin="keret3.gif";
}else{
$szin="hatter8.gif";
}
switch($esemeny->falkaesemeny_tipus){
case 1:
$adat.="<tr><td background=pic/". $szin ."><img src=pic/belep.png width=25 height=25></td><td align=center background=pic/". $szin .">". idtonev($esemeny->falkaesemeny_kid) ." belépet a falkába.</td><td align=center background=pic/". $szin .">". $esemeny->falkaesemeny_ido ."</td></tr>";
break;
case 2:
$adat.="<tr><td background=pic/". $szin ."><img src=pic/kilep.png width=25 height=25></td><td align=center background=pic/". $szin .">". idtonev($esemeny->falkaesemeny_kid) ." kilépett a falkából.</td><td align=center background=pic/". $szin .">". $esemeny->falkaesemeny_ido ."</td></tr>";
break;
}


}
$adat.="</table>";
}
}else{
if($falka->falka_vezeto==$_SESSION[id]){
$tagok="<select name=nev>";
$leker3=mysql_query("SELECT * FROM kutya WHERE kutya_falka = '". $kutya->kutya_falka ."'");
while($tags=mysql_fetch_object($leker3)){
$tagok.="<option value=". $tags->kutya_id .">". $tags->kutya_nev ."</option>";
}
$tagok.="</select>";
if(file_exists("pic/falka/". $kutya->kutya_falka .".png")){
$kep="<td colspan=2 align=center><img src=pic/falka/". $kutya->kutya_falka .".png border=0 height=50 width=150></td>";
}else{
$kep="<th colspan=2 align=center><img src=pic/falka/nopic.jpg border=0 width=150 height=50></th>";
}
$jogok=explode('|',$falka->falka_jogok);
if($jogok[0]==1){
$jog="checked";
}
if($jogok[1]==1){
$uzenetkuld="checked";
}
if($jogok[2]==1){
$tagtilt="checked";
}
if($jogok[3]==1){
$adminpanel="checked";
}
if($falka->falka_kepvideo==1){
$kepvideo="checked";
}
$adat.='<script src="script/beallitas.js"></script>';
$adat.="<big><u>Adminisztráció</u></big><br><br>". VilagosMenu(500,"<table border=0><tr><td align=left>Falkavezetés átadása:</td><td align=right><form method=POST action=inc/falkaadmin.php>". $tagok ."</td><td align=left><input type=submit value=Elküld></form></td></tr>
<tr><td align=left>Falka helyettes kinevezése:</td><td align=right><form method=GET action=inc/falkaadmin.php>". $tagok ."</td><td align=right><input type=submit value=Elküld></form></td></tr></table>
<table border=0><tr><td><form action=inc/falkaadmin.php method=POST><input type=checkbox name=falkakepvideo style='width: 30px;' ". $kepvideo ."></td><td>Falka fórumon megjelenhetnek a képek és videók.</td></tr><tr><td align=center colspan=2><input type=submit name=kell value='Elküld'></form></td></tr></table>") ."

<br><big><u>Falka név színezés</u></big><br><br>". VilagosMenu(500,"Nem csak a kutyád nevét, hanem a falkádét is átszínezheted,<br> azonban ez egy kicsit drágább. Ár: ". penz($FALKASZINESNEV) ."
<table><tr><td>Szín:</td><td><form action=inc/bealit.php method=POST><select name=falkaszin id='nevszin' onchange=". '"' ."SzinElonezet('". $falka->falka_nev ."')". '"' . ">
<option value=9 style='color: #800000'>Vörös</option>
<option value=39 style='color: #B22222'>Tégla</option>
<option value=8 style='color: #C90000'>Piros</option>
<option value=7 style='color: #DC143C'>Kárminvörös</option>
<option value=34 style='color: #FF0000'>Világos Piros</option>
<option value=6 style='color: #FF4500'>Narancssárga</option>
<option value=5 style='color: #FF6347'>Paradicsomszín</option>
<option value=3 style='color: #FF8C00'>Világos Narancssárga</option>
<option value=33 style='color: #D2691E'>Csokoládé</option>
<option value=4 style='color: #DAA520'>Sötét Arany</option>
<option value=2 style='color: #FFD700'>Arany</option>
<option value=37 style='color: #DE3163'>Cseresznye</option>
<option value=45 style='color: #FF1493'>Rózsaszín</option>
<option value=22 style='color: #FF69B4'>HotPink</option>
<option value=42 style='color: #DB7093'>SápadtIbolyaPiros</option>
<option value=23 style='color: #F08080'>LightCoral</option>
<option value=10 style='color: #9ACD32'>Sárgás Zöld</option>
<option value=36 style='color: #7CFC00'>Fû Zöld</option>
<option value=31 style='color: #32CD32'>Lime Zöld</option>
<option value=38 style='color: #00FF7F'>Tavaszi Zöld</option>
<option value=11 style='color: #6B8E23'>Oliva Zöld</option>
<option value=12 style='color: #008000'>Zöld</option>
<option value=13 style='color: #006400'>Sötét Zöld</option>
<option value=14 style='color: #3CB371'>Tenger Zöld</option>
<option value=20 style='color: #008B8B'>Sötét Cián</option>
<option value=15 style='color: #66CDAA'>Akvarmin</option>
<option value=32 style='color: #00FFFF'>Aqua</option>
<option value=35 style='color: #48D1CC'>Türkiz</option>
<option value=17 style='color: #6495ED'>BúzaVirág</option>
<option value=18 style='color: #4682B4'>Acélkék</option>
<option value=44 style='color: #4169E1'>KirályKék</option>
<option value=16 style='color: #1E90FF'>DodgerKék</option>
<option value=19 style='color: #305DDB'>Kék</option>
<option value=40 style='color: #5F9EA0'>KadétKék</option>
<option value=21 style='color: #9370DB'>Világos Lila</option>
<option value=24 style='color: #6D3AC4'>Lila</option>
<option value=30 style='color: #483D8B'>Pala Szín</option> 
<option value=41 style='color: #000080'>HadiKék</option> 
<option value=27 style='color: #4B0082'>Indigó</option>
<option value=26 style='color: #8B008B'>Sötét Magenta</option>
<option value=25 style='color: #BA55D3'>Orchidea</option>
<option value=28 style='color: #774411'>Barna</option>
<option value=1 style='color: #696969'>Szürke</option>
<option value=29 style='color: #000000'>Fekete</option>
</select><td><input type=submit value=Elküld!></form></td></tr></table>

<spam id='elonezet'></spam><br>") ."

<br><big><u>Falka helyettes jogai</u></big><br><br>". VilagosMenu(500,"<form action=inc/falkajogok.php method=POST><table border=0>
<tr><td><input type=checkbox name=jog style='width:30px;' ". $jog ."></td><td align=left>Falkafórumról üzenettörlés</td></tr>
<tr><td><input type=checkbox name=uzenetkuld style='width:30px;' ". $uzenetkuld ."></td><td align=left>Tagoknak körüzenetküldés</td></tr>
<tr><td><input type=checkbox name=tagtilt style='width:30px;' ". $tagtilt ."></td><td align=left>Falkatag kitiltása</td></tr>
<tr><td><input type=checkbox name=adminpanel style='width:30px;' ". $adminpanel ."></td><td align=left>Adminisztrációs panelhez hozzáférés</td></tr>
<tr><td align=center colspan=2><input type=submit value=Elküld></td></tr></form>
</table>") ."

<br><big><u>Leírás beállítások</u></big><br><br>". VilagosMenu(500,"<form action=inc/falkabealitas.php method=POST><table border=0><tr><td align=left>Háttérszin:</td><td align=right>#<input type=text name=hatterszin value=". $falka->falka_hatterszin ."></td><td align=left><small>6 karakteres HEX kód, segítség <a href=http://www.drpeterjones.com/colorcalc/ class='feherlink' target=_blank>itt</a></small></td></tr>
<tr><td align=left>Háttérkép:</td><td align=right>http://<input type=text name=hatterkep value=". $falka->falka_hatterkep ."></td><td align=left>?<small>840px széles és tetszõleges magas kép</small></td></tr>
<tr><td align=center colspan=3>Leírás: (UBB kódokhoz segítség itt)</td></tr><tr><td align=center colspan=3><textarea name=leiras cols=50 rows=12>". $falka->falka_leiras ."</textarea></td></tr>
<tr><td align=center colspan=3><input type=submit value=Elküld></td></tr></table></form>") ."

<br><big><u>Falka logó</u></big><br><br>". VilagosMenu(500,"Maximum 56 kilobyte méretû illetve JPG, PNG vagy GIF formátumú fájlt tölthetsz<br> fel! A feltöltõtt képek a ". $SITENAME ." tulajdonát képezik, így azt bármikor a<br> feltöltõ engedélye nélkül törölheti vagy fehasználhatja!
<table border=0><form enctype='multipart/form-data' action='inc/falkapic.php' method='POST'>
<tr>". $kep ."</tr>
<tr><td><input name='upload_img' type='file' size=10></td><td><input type='submit' value='OK' style='width:60px;'></form></td></tr>
</table>");
}}
$adat.="</center>";
oldal($adat);
}else{
header("Location: falka.php");
}
}
}
}else{
header("Location: index.php");
}
?>
