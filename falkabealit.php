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
$menu="<center><a href=falkabealit.php class='feherlink'>Adat m�dos�t�s</a>  | <a href=falkabealit.php?page=1 class='feherlink'>Taglista</a> | <a href=falkabealit.php?page=3 class='feherlink'>Esem�nyek</a> | <a href=falkabealit.php?page=2 class='feherlink'>Tilt�lista</a><br><br>";
}else{
$menu="<center>";
if($jogok[3]==1){
$menu.="<a href=falkabealit.php?page=1 class='feherlink'>Taglista</a> | <a href=falkabealit.php?page=3 class='feherlink'>Esem�nyek</a>";
}else{}
if($jogok[2]==1){
if($menu!="<center>"){
$menu.=" | ";
}
$menu.="<a href=falkabealit.php?page=2 class='feherlink'>Tilt�lista</a>";
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
$adat.="<big><u>Inf�</u></big><br><br>". VilagosMenu(700,
"<table border=0 width=650><tr><td align=left>Tagok sz�ma:</td><td align=right width=70>". $tags ." f�</td><td align=left>Pontsz�m:</td><td align=right width=120>". $falka->falka_pont ."</td><td align=left>�tlag:</td><td align=right width=70>". round($falka->falka_pont/$tags,2) ."</td></tr>
<tr><td align=left>Helyez�s:</td><td align=right>". $i .".</td><td align=left colspan=2>Sz�ks�ges pont a jav�t�shoz:</td><td align=right colspan=2>". $kellpont ." pont</td></tr>
</table>") . "<br><big><u>Taglista</u></big><br><br>";
$kutyalista="<table border=0 width=650><tr><th align=center><a href=falkabealit.php?page=1&rendez=1 class='feherlink'>N�v</a></th><th align=center><a href=falkabealit.php?page=1&rendez=2 class='feherlink'>Fajta</a></th><th align=center><a href=falkabealit.php?page=1&rendez=3 class='feherlink'>Kor</a></th><th align=center><a href=falkabealit.php?page=1&rendez=4 class='feherlink'>Eg�szs�g</a></th><th align=center><a href=falkabealit.php?page=1&rendez=6 class='feherlink'>Tags�g</a></th><th align=center><a href=falkabealit.php?page=1&rendez=5 class='feherlink'>Falkapont</a> <a href=falkabealit.php?page=1&rendez=5 class='feherlink'>~</a></th></tr>";
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
$adat.="Ha valaki zavarja a falk�d, akkor tiltsd ki �s nem tud bel�pni,<br> illetve ha tag automatikusan kil�pteti a rendszer!". $_SESSION[hiba] ."<br><form action=inc/falkatilto.php method=GET><table border=0><tr><td>Neve:</td><td><input type=text name=nev></td><td><input type=submit value=Elk�ld></form></td></tr></table><br>";
$_SESSION[hiba]="";
$leker=mysql_query("SELECT * FROM falkatilto WHERE falkatilto_falka = '". $falka->falka_id ."'");
if(mysql_num_rows($leker)>0){
$adat.="<table border=0><tr><td align=center width=130>N�v</td><td></td></tr>";
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
$adat.=ok("Nincs senki a list�n!");
}
}
}elseif($_GET[page]==3){
if(($falka->falka_vezeto==$_SESSION[id]) or ($falka->falka_vezetohelyettes ==  $_SESSION[id] and  $jogok[3]==1)){
$szin="hatter8.gif";
$adat=$menu ."<big><u>Esem�nyek</u></big><br><br>Itt l�thatod ezen a h�ten kik l�ptek be �s kik l�ptek ki a falk�db�l.<br><br>
<table border=0 width=525 cellpadding=0 cellspacing=0><tr><th width=25 background=pic/". $szin ."></th><th align=center background=pic/". $szin ." width=350>Esem�ny</th><th align=center background=pic/". $szin .">Id�</th></tr>";
$esemenyek=mysql_query("SELECT * FROM falkaesemeny WHERE falkaesemeny_falkaid = '".  $falka->falka_id  ."'");
while($esemeny=mysql_fetch_object($esemenyek)){
if($szin=="hatter8.gif"){
$szin="keret3.gif";
}else{
$szin="hatter8.gif";
}
switch($esemeny->falkaesemeny_tipus){
case 1:
$adat.="<tr><td background=pic/". $szin ."><img src=pic/belep.png width=25 height=25></td><td align=center background=pic/". $szin .">". idtonev($esemeny->falkaesemeny_kid) ." bel�pet a falk�ba.</td><td align=center background=pic/". $szin .">". $esemeny->falkaesemeny_ido ."</td></tr>";
break;
case 2:
$adat.="<tr><td background=pic/". $szin ."><img src=pic/kilep.png width=25 height=25></td><td align=center background=pic/". $szin .">". idtonev($esemeny->falkaesemeny_kid) ." kil�pett a falk�b�l.</td><td align=center background=pic/". $szin .">". $esemeny->falkaesemeny_ido ."</td></tr>";
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
$adat.="<big><u>Adminisztr�ci�</u></big><br><br>". VilagosMenu(500,"<table border=0><tr><td align=left>Falkavezet�s �tad�sa:</td><td align=right><form method=POST action=inc/falkaadmin.php>". $tagok ."</td><td align=left><input type=submit value=Elk�ld></form></td></tr>
<tr><td align=left>Falka helyettes kinevez�se:</td><td align=right><form method=GET action=inc/falkaadmin.php>". $tagok ."</td><td align=right><input type=submit value=Elk�ld></form></td></tr></table>
<table border=0><tr><td><form action=inc/falkaadmin.php method=POST><input type=checkbox name=falkakepvideo style='width: 30px;' ". $kepvideo ."></td><td>Falka f�rumon megjelenhetnek a k�pek �s vide�k.</td></tr><tr><td align=center colspan=2><input type=submit name=kell value='Elk�ld'></form></td></tr></table>") ."

<br><big><u>Falka n�v sz�nez�s</u></big><br><br>". VilagosMenu(500,"Nem csak a kuty�d nev�t, hanem a falk�d�t is �tsz�nezheted,<br> azonban ez egy kicsit dr�g�bb. �r: ". penz($FALKASZINESNEV) ."
<table><tr><td>Sz�n:</td><td><form action=inc/bealit.php method=POST><select name=falkaszin id='nevszin' onchange=". '"' ."SzinElonezet('". $falka->falka_nev ."')". '"' . ">
<option value=9 style='color: #800000'>V�r�s</option>
<option value=39 style='color: #B22222'>T�gla</option>
<option value=8 style='color: #C90000'>Piros</option>
<option value=7 style='color: #DC143C'>K�rminv�r�s</option>
<option value=34 style='color: #FF0000'>Vil�gos Piros</option>
<option value=6 style='color: #FF4500'>Narancss�rga</option>
<option value=5 style='color: #FF6347'>Paradicsomsz�n</option>
<option value=3 style='color: #FF8C00'>Vil�gos Narancss�rga</option>
<option value=33 style='color: #D2691E'>Csokol�d�</option>
<option value=4 style='color: #DAA520'>S�t�t Arany</option>
<option value=2 style='color: #FFD700'>Arany</option>
<option value=37 style='color: #DE3163'>Cseresznye</option>
<option value=45 style='color: #FF1493'>R�zsasz�n</option>
<option value=22 style='color: #FF69B4'>HotPink</option>
<option value=42 style='color: #DB7093'>S�padtIbolyaPiros</option>
<option value=23 style='color: #F08080'>LightCoral</option>
<option value=10 style='color: #9ACD32'>S�rg�s Z�ld</option>
<option value=36 style='color: #7CFC00'>F� Z�ld</option>
<option value=31 style='color: #32CD32'>Lime Z�ld</option>
<option value=38 style='color: #00FF7F'>Tavaszi Z�ld</option>
<option value=11 style='color: #6B8E23'>Oliva Z�ld</option>
<option value=12 style='color: #008000'>Z�ld</option>
<option value=13 style='color: #006400'>S�t�t Z�ld</option>
<option value=14 style='color: #3CB371'>Tenger Z�ld</option>
<option value=20 style='color: #008B8B'>S�t�t Ci�n</option>
<option value=15 style='color: #66CDAA'>Akvarmin</option>
<option value=32 style='color: #00FFFF'>Aqua</option>
<option value=35 style='color: #48D1CC'>T�rkiz</option>
<option value=17 style='color: #6495ED'>B�zaVir�g</option>
<option value=18 style='color: #4682B4'>Ac�lk�k</option>
<option value=44 style='color: #4169E1'>Kir�lyK�k</option>
<option value=16 style='color: #1E90FF'>DodgerK�k</option>
<option value=19 style='color: #305DDB'>K�k</option>
<option value=40 style='color: #5F9EA0'>Kad�tK�k</option>
<option value=21 style='color: #9370DB'>Vil�gos Lila</option>
<option value=24 style='color: #6D3AC4'>Lila</option>
<option value=30 style='color: #483D8B'>Pala Sz�n</option> 
<option value=41 style='color: #000080'>HadiK�k</option> 
<option value=27 style='color: #4B0082'>Indig�</option>
<option value=26 style='color: #8B008B'>S�t�t Magenta</option>
<option value=25 style='color: #BA55D3'>Orchidea</option>
<option value=28 style='color: #774411'>Barna</option>
<option value=1 style='color: #696969'>Sz�rke</option>
<option value=29 style='color: #000000'>Fekete</option>
</select><td><input type=submit value=Elk�ld!></form></td></tr></table>

<spam id='elonezet'></spam><br>") ."

<br><big><u>Falka helyettes jogai</u></big><br><br>". VilagosMenu(500,"<form action=inc/falkajogok.php method=POST><table border=0>
<tr><td><input type=checkbox name=jog style='width:30px;' ". $jog ."></td><td align=left>Falkaf�rumr�l �zenett�rl�s</td></tr>
<tr><td><input type=checkbox name=uzenetkuld style='width:30px;' ". $uzenetkuld ."></td><td align=left>Tagoknak k�r�zenetk�ld�s</td></tr>
<tr><td><input type=checkbox name=tagtilt style='width:30px;' ". $tagtilt ."></td><td align=left>Falkatag kitilt�sa</td></tr>
<tr><td><input type=checkbox name=adminpanel style='width:30px;' ". $adminpanel ."></td><td align=left>Adminisztr�ci�s panelhez hozz�f�r�s</td></tr>
<tr><td align=center colspan=2><input type=submit value=Elk�ld></td></tr></form>
</table>") ."

<br><big><u>Le�r�s be�ll�t�sok</u></big><br><br>". VilagosMenu(500,"<form action=inc/falkabealitas.php method=POST><table border=0><tr><td align=left>H�tt�rszin:</td><td align=right>#<input type=text name=hatterszin value=". $falka->falka_hatterszin ."></td><td align=left><small>6 karakteres HEX k�d, seg�ts�g <a href=http://www.drpeterjones.com/colorcalc/ class='feherlink' target=_blank>itt</a></small></td></tr>
<tr><td align=left>H�tt�rk�p:</td><td align=right>http://<input type=text name=hatterkep value=". $falka->falka_hatterkep ."></td><td align=left>?<small>840px sz�les �s tetsz�leges magas k�p</small></td></tr>
<tr><td align=center colspan=3>Le�r�s: (UBB k�dokhoz seg�ts�g itt)</td></tr><tr><td align=center colspan=3><textarea name=leiras cols=50 rows=12>". $falka->falka_leiras ."</textarea></td></tr>
<tr><td align=center colspan=3><input type=submit value=Elk�ld></td></tr></table></form>") ."

<br><big><u>Falka log�</u></big><br><br>". VilagosMenu(500,"Maximum 56 kilobyte m�ret� illetve JPG, PNG vagy GIF form�tum� f�jlt t�lthetsz<br> fel! A felt�lt�tt k�pek a ". $SITENAME ." tulajdon�t k�pezik, �gy azt b�rmikor a<br> felt�lt� enged�lye n�lk�l t�r�lheti vagy fehaszn�lhatja!
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
