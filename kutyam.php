<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if(isset($_SESSION[nev])){
$user=mysql_query("SELECT * FROM `kutya` WHERE `kutya_nev` = '". str_replace("'","\'",$_SESSION[nev]) ."'",$kapcsolat);
while($leker=mysql_fetch_object($user)){
///oop �tir�s
$kutyus=new kutya();
$kutyus->GetKutyaByNev($_SESSION[nev]);

$adatok='<table>
<tr><td align=left>N�v:</td><th>'. $kutyus->NevMegjelenitRanggal() .'</td></tr>
<tr><td align=left>Sorsz�m:</td><td>'. $kutyus->id .'</td></tr>
<tr><td align=left>Fajta:</td><td>'. kutyaszamtonev($kutyus->fajta) .'</td></tr>
<tr><td align=left>Nem:</td><td>'. $kutyus->nem .'</td></tr>
<tr><td align=left>P�nz:</td><td id="penz">'. penz($kutyus->penz) .'</td></tr>
<tr><td align=left>G�nek:</td><td id="genek">'. $kutyus->GenMegjelenit() .'</td></tr>
<tr><td align=left valign=top>K�lyk�k:</td>'. $kutyus->KolyokMegjelenit() .'</tr>
</table>';

$_SESSION[nev]=$kutyus->nev;
$_SESSION[id]=$kutyus->id;

$kep="<table>
<tr><td align=center>". $kutyus->NevMegjelenit() ." ". $kutyus->kor ." napja sz�letett!</td></tr>
<tr><td align=center>". $kutyus->Kep() ."</td></tr>
</table>";

$vonalak="<table><tr><th align=left>Eg�szs�g: </th><th align=right>". $kutyus->egeszseg ."%</th></tr><tr><td colspan=2>". $kutyus->EgeszsegCsik($kutyus->egeszseg*3) ."</td></tr><tr><th align=left>S�ly: </th><th align=right>". $kutyus->suly ."%</th></tr><tr><td colspan=2>". $kutyus->SulyCsik($kutyus->suly*3) ."</td></tr></table>";

$talak='<div id="fade" class="black_overlay"></div><div id="light" class="white_content"><p align=right><a href = "javascript:void(0)" onclick = "kajavaltablak()" class="feherlink">Bez�r [x]</a></p>
<center><u><big>�tel t�pus csere</big></u><br>Itt lecser�lheted a kuty�d t�pj�t, de figyelem a k�l�nb�z� �telek m�shogy hatnak az �llatod eg�szs�g �s s�ly n�veked�s�re. <a href=segitseg.php?page=ismerteto#egszsuly class="feherlink">Hogyan?</a><br>�ra: <b>'. penz($KAJA) .'</b><br><input type=radio name=kaja id=kaja1 value=1 style="width: 20px;"><img src=pic/salata2.gif>Sal�ta<br>
<input type=radio id=kaja2 name=kaja value=2 style="width: 20px;"> <img src=pic/tal2.gif> T�p&nbsp;&nbsp;<br><input type=radio name=kaja id=kaja3 value=3 style="width: 20px;"><img src=pic/fagyi2.gif>Fagylalt<br><input type=submit value=Elk�ld onclick="kajavalt()"><br><span id="kiiras"></span></center></div>';
$talak.="<table border=0 cellpadding=0 cellspacing=0><tr><th align=left colspan=7>�tel: (m�g <span id=\"kajakiir\">". $kutyus->kaja ."</span> napra el�g van) "; 
$talak.='<a href = "javascript:void(0)" onclick = "kajavaltablak()" class="feherlink">[V�ltoztat]</a></th></tr><tr id="talak">'. $kutyus->Talak().'</tr>';
$talak.='<tr id="etet">'. $kutyus->EtetMegjelenit() .'</tr></table><script src="script/kutyam.js"></script>';
if($kutyus->belepido<$ma && $kutyus->belepido>=($ma-24*60*60))
{
if($kutyus->Latogat())
{
$kutyus->PenzHozzaad($LEGJOBBGAZDANYEREMENY);
$kutyus->SendUzenet(0, "Gratul�lunk!<br>Szorgos munk�d meghozta a gy�m�lcs�t, kapt�l". penz($LEGJOBBGAZDANYEREMENY) ." �sszeget, mivel elnyerted a legjobb gazda c�met.");         
}
}
elseif($kutyus->belepido<($ma-24*60*60))
{
$kutyus->NemLatogat();
}else{}

$legjobbgazd="<table><tr><th><img src=pic/gazda.png></th><td width=700 style='text-align:justify;'>Szerezd meg a legjobb gazdi c�met �s az ". penz($LEGJOBBGAZDANYEREMENY) ." nyerem�nyt! Ehhez nem kell m�st tenned, csup�n minden nap ". $LEGJOBBGAZDANAP ." napon kereszt�l folyamatosan l�togasd a kuty�dat, �s m�ris tied az ". penz($LEGJOBBGAZDANYEREMENY) .". M�g <b>". ($LEGJOBBGAZDANAP-$kutyus->legjobbgondozo) ."</b> napot kell l�togatnod. <a href=segitseg.php?page=ismerteto#legjobbgazda class='feherlink'>R�szletek...</a></td></tr></table>"; 
if($kutyus->kor>$FAGYASZTMINAP){
$lehet="aktiv";
$fagyasztas=$kutyus->FagyasztasMegjelenit();
}else{
$lehet="inaktiv";
$fagyasztas="A kuty�d m�g t�l fiatal ahhoz hogy le fagyaszd, megf�zna �s elpusztulna ez�rt csak ". $FAGYASZTMINAP ." napos kor felett fagyaszthatod le.";
}
///
$egyszam=$kutyus->EgyszamMegjelenit($_SESSION[hiba]);
$_SESSION[hiba]="";
///
belepido($_SESSION[nev]);
$nemr=$leker->kutya_nem;
if($kutyus->kor>17){
$kell=mysql_query("SELECT * FROM `hazassag` WHERE `hazassag_aktiv` = '". $_SESSION[id] ."' or `hazassag_ferj` = '". $_SESSION[id] ."' or `hazassag_feleseg` = '". $_SESSION[id] ."'");

if(mysql_num_rows($kell)==0){
$sziv="a"; $hazas="A h�zass�g komoly dolog, de m�r el�g �rett vagy hozz�. Ha felk�sz�ltnek �rzed magad �rd be a nev�t annak, akivel h�zasodni szeretn�l.<center><form method=POST action=inc/hazassag.php><input type=text name=nev style='width:90px;'><input type=submit value=K�ld style='width:50px;'></form></center>". $_SESSION[hibas];
$_SESSION[hibas]="";
}else{ 
while($hazasodunk=mysql_fetch_object($kell)){
if($hazasodunk->hazassag_ido=="0"){
if($hazasodunk->hazassag_aktiv==$_SESSION[id]){
$sziv="a"; $hazas="A l�ny/fi� k�r�s megt�rt�nt. Most v�rnod kell, am�g nem v�laszol. Ha megunn�d, kattints a visszavon�s gombra.<br><center><a href=inc/keresvissza.php class='feherlink'>Visszavonom</a></center>";
}else{

$kellez=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $hazasodunk->hazassag_aktiv ."'");
if(mysql_num_rows($kellez)>0){
while($kii=mysql_fetch_object($kellez)){
$sziv="a"; $hazas="<a href=kutyak.php?id=". $kii->kutya_id ." class='barna'>". htmlentities($kii->kutya_nev) ."</a> nev�  kutya megk�rte a kezed. Gyorsan d�nts, hogy mit szeretn�l.<br><center><a href=inc/elfogad.php class='feherlink'>Igen,hozz�megyek</a><br><a href=inc/visszautasit.php class='feherlink'>Nem, m�sra v�rok</a></center>";
}
}else{
$sziv="a";
}
}
}else{
if($nemr==1){
$kellid=$hazasodunk->hazassag_feleseg;
}else{ $kellid=$hazasodunk->hazassag_ferj; }
$kellez=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $kellid ."'");
if(mysql_num_rows($kellez)>0){
while($kii=mysql_fetch_object($kellez)){
$feltolt=ceil((($ma-$hazasodunk->hazassag_ido)/(3600*24))+1);
if($kii->kutya_betuszin=="774411"){
$nev1="<a href=kutyak.php?id=". $kii->kutya_id ." class='barna'>". htmlentities($kii->kutya_nev) ."</a>";
}else{
$nev1="<a href=kutyak.php?id=". $kii->kutya_id ." class='barna'><font color=#". $kii->kutya_betuszin .">". htmlentities($kii->kutya_nev) ."</font></a>";
}
$vanekolyok=mysql_query("SELECT * FROM kolyok WHERE kolyok_apa = '". $_SESSION[id] ."' or kolyok_anya = '". $_SESSION[id] ."'");
if(mysql_num_rows($vanekolyok)>0){
$sziv="a";
while($kolyok=mysql_fetch_object($vanekolyok)){
if($kolyok->kolyok_aktiv!=0){
if($kolyok->kolyok_aktiv==$_SESSION[id]){

$hazas="Megk�rted a ". $nev1 ." nev� kuty�t hogy legyen k�ly�kkuty�tok, a k�r�sre m�g nem v�laszolt, teh�t most v�rnunk kell.<br><center><a href=inc/nemkolyok.php class='feherlink'>Nem v�rok tov�bb</a></center>";

}else{

$hazas=$nev1 . " nev� kutya megk�rt hogy legyen k�z�s kuty�tok. D�ntsd el, hogy legyen-e k�lyk�t�k.<br><center><a href=inc/igenkolyok.php class='feherlink'>Szeretn�k k�lyk�t</a><br><a href=inc/nemkolyok.php class='feherlink'>Nem szeretn�k</a></center>";

}
}else{
if($most>$kolyok->kolyok_ido){
if($_SESSION[id]==$kolyok->kolyok_tulaj){
$hazas="Gratul�lok! Megsz�letett az ifj� tr�n�r�k�s. Tied a dics�s�g hogy elnevezd a ". nem($kolyok->kolyok_nem) ."t.<br><form action=inc/newborn.php method=POST>N�v:<input type=text name=nev style='width: 110px;' maxlength=16><br>Jelsz�:<input type=password name=jelszo style='width: 90px;' maxlength=16><br><center><input type=submit value='Elk�ld'></center></form><br>". $_SESSION[hibas];
$_SESSION[hibas]="";
}else{
$hazas="Gratul�lok! Megsz�letett a kis cs�pps�g. A h�zast�rsad adhat neki nevet, neked csak v�rnod kell.<br><center><a href=inc/nemkolyok.php class='feherlink'>Nem v�rok tov�bb</a></center>";
}
}else{
$hazas="Most pedig v�rni kell ". ($kolyok->kolyok_ido-$ma)/3600/24 ." napot am�g megsz�letik a k�ly�k...";
}
}
}
}else{
$hazas='<script>
function confirmDelete() {
  if (confirm("Biztos el akarsz v�llni?")) {
    document.location = "inc/visszautasit.php";
  }
}
</script>';
$sziv="a"; $hazas.="Gratul�lunk! M�r <b>". $feltolt ."</b> napja h�zast�rsak vagytok a ". $nev1 ." nev� kuty�val! Val�ban sz�p teljes�tm�ny.<br><center><a href=inc/kolyok.php class='feherlink'>K�ly�kkutya</a><br><a href='javascript:confirmDelete()' class='feherlink'>El akarok v�lni</a></center>"; 
}
}
}else{
$sziv="a";
mysql_query("DELETE FROM `hazassag` WHERE `hazassag_aktiv` = '". $_SESSION[id] ."' or `hazassag_ferj` = '". $_SESSION[id] ."' or `hazassag_feleseg` = '". $_SESSION[id] ."'");

}
}
}
}


}else{$sziv="p";$hazas="A h�zass�g komoly dolog, ez�rt �rett fejre van hozz� sz�ks�g. Sajnos a te kuty�d m�g nem t�lt�tte be a 18. napj�t �s ez�rt nem h�zasodhat.";}
if(substr_count($leker->kutya_tanul,"IR")!=0 and substr_count($leker->kutya_tanul,"SZ")!=0 and substr_count($leker->kutya_tanul,"BR")!=0 and substr_count($leker->kutya_tanul,"ER")!=0 and substr_count($leker->kutya_tanul,"FU")!=0 and substr_count($leker->kutya_tanul,"KE")!=0 and substr_count($leker->kutya_tanul,"VE")!=0){
$tanul="A te kuty�d m�r nagyon okos. Mindent tud, ez�rt m�r nem lehet neki mit tan�tani. Tal�n k�s�bb lesznek �j leck�k.";
}else{
if($leker->kutya_tanult==$ma){
$tanul="M�ra m�r megtanult az okos kuty�d. Legk�zelebb holnap tudod tan�tani.";
}else{$tanul="Tan�tsd meg a k�l�nb�z� leck�ket kuty�dnak!<br><center><form method=POST action=inc/tanul.php><select name=tanul>";
if(substr_count($leker->kutya_tanul,"IR")==0){ $tanul.="<option value=IR>�rni tanulni (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'IR'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=3-$row->tanul_lecke; } $tanul.=$lecke. "/3)</option>"; }
if(substr_count($leker->kutya_tanul,"SZ")==0){ $tanul.="<option value=SZ>Sz�molni tanulni (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'SZ'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=5-$row->tanul_lecke; } $tanul.=$lecke. "/5)</option>"; }
if(substr_count($leker->kutya_tanul,"BR")==0){ $tanul.="<option value=BR>Lott�zni (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'BR'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=10-$row->tanul_lecke; } $tanul.=$lecke. "/10)</option>"; }
if(substr_count($leker->kutya_tanul,"ER")==0){ $tanul.="<option value=ER>�retts�gizni (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'ER'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=12-$row->tanul_lecke; } $tanul.=$lecke. "/12)</option>"; }
if(substr_count($leker->kutya_tanul,"FU")==0){ $tanul.="<option value=FU>F�l befog�sa (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'FU'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=7-$row->tanul_lecke; } $tanul.=$lecke. "/7)</option>"; }
if(substr_count($leker->kutya_tanul,"KE")==0){ $tanul.="<option value=KE>Keresked�s (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'KE'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=10-$row->tanul_lecke; } $tanul.=$lecke. "/10)</option>"; }
if(substr_count($leker->kutya_tanul,"VE")==0){ $tanul.="<option value=VE>Kv�z(";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'VE'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=12-$row->tanul_lecke; } $tanul.=$lecke. "/12)</option>"; }
$tanul.="</select><br><input type=submit name=elkuld value=Tan�t�s></form></center>";
}
$tanul.="<br>Picit fel szeretn�d gyors�tani dolgot? 50 oss��rt pusk�zd ki �s r�gt�n megtanulja a kuty�d.<center><form method=POST action=inc/puska.php><select name=puska>";
if(substr_count($leker->kutya_tanul,"IR")==0){ $tanul.="<option value=IR>�rni tanulni</option>"; }
if(substr_count($leker->kutya_tanul,"SZ")==0){ $tanul.="<option value=SZ>Sz�molni tanulni</option>"; }
if(substr_count($leker->kutya_tanul,"BR")==0){ $tanul.="<option value=BR>Lott�zni</option>"; }
if(substr_count($leker->kutya_tanul,"ER")==0){ $tanul.="<option value=ER>�retts�gizni</option>"; }
if(substr_count($leker->kutya_tanul,"FU")==0){ $tanul.="<option value=FU>F�l befog�sa</option>"; }
if(substr_count($leker->kutya_tanul,"KE")==0){ $tanul.="<option value=KE>Keresked�s</option>"; }
if(substr_count($leker->kutya_tanul,"VE")==0){ $tanul.="<option value=VE>Kv�z</option>"; }
$tanul.="</select><input type=submit name=elkuld value=Pusk�zz></form></center>";
}

$lotto="";
if(substr_count($leker->kutya_tanul,"BR")==0){
}else{
$lotto.="<a href=lotto.php class='feherlink'>Lott�</a><br>";
}
if(substr_count($leker->kutya_tanul,"VE")==0){
}else{
$lotto.="<a href=autoverseny.php class='feherlink'>Kv�z</a><br>";
}
if($lotto==""){
$lotto="Sajnos te m�g semmi j�t�kkkal nem tudsz j�tszani. De ne buslakodj, ink�bb tanulj meg egy-kett�t �s j�tsz!";
}
$menu="<table border=0 cellpadding=5 cellspacing=0>
<tr>
	<td><img src=pic/tanul.png></td>
	<td background=pic/hatter8.gif><img src=pic/". $sziv ."hazassag.png></td>
	<td><img src=pic/". $lehet ."fagyaszt.png></td>
	<td background=pic/hatter8.gif><img src=pic/egyszam.png></td>
	<td><img src=pic/lotto.png></td></tr>
<tr>
	<td align=center><i>Tanul�s</i></td>
	<td align=center background=pic/hatter8.gif><i>H�zass�g</i></td>
	<td align=center><i>Fagyaszt�s</i></td>
	<td align=center background=pic/hatter8.gif><i>Egysz�m j�t�k</i></td>
	<td align=center><i>J�t�kok</i></td></tr>
<tr VALIGN=TOP>
	<td width=150 style='text-align:justify;'>". $tanul ."</td>
	<td width=150 style='text-align:justify;' background=pic/hatter8.gif>". $hazas ."</td>
	<td width=150 style='text-align:justify;' id='fagyaszt'>". $fagyasztas ."</td>
	<td background=pic/hatter8.gif width=150 style='text-align:justify;' id='egyszamjatek'>". $egyszam ."</td>
	<td width=150 style='text-align:justify;'><center>". $lotto ."</center></td></tr></Table>";
}
$adat="<style>
.black_overlay{
			display: none;
			position: absolute;
			top: 27%;
			left: 27%;
			width: 55%;
			height: 33%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			top: 25%;
			left: 25%;
			width: 50%;
			height: 30%;
			padding: 6px;
			border: 11px solid #cc9866;
			background-image:url('pic/keret3.gif');
			z-index:1002;
			overflow: auto;
		}
	</style>";
$adat.="<center><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg colspan=2></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left>". $adatok ."<br>". $vonalak ."<br>". $talak ."</td><td align=center valign=top>". $kep ."</td><td width=11 background=pic/keret.jpg></td></tr><tr><td height=11 background=pic/keret.jpg colspan=4></tr><tr><td width=11 background=pic/keret.jpg></td><td colspan=2><center>". $legjobbgazd ."</center></td><td width=11 background=pic/keret.jpg></td></tr><tr><th height=11 colspan=4 background=pic/keret.jpg></th></tr><tr><th width=11 background=pic/keret.jpg></th><td colspan=2 align=center>". $menu ."</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 colspan=2 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table></center>";

oldal($adat);
}else{header("Location: index.php");}
?>