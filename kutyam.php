<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if(isset($_SESSION[nev])){
$user=mysql_query("SELECT * FROM `kutya` WHERE `kutya_nev` = '". str_replace("'","\'",$_SESSION[nev]) ."'",$kapcsolat);
while($leker=mysql_fetch_object($user)){
///oop átirás
$kutyus=new kutya();
$kutyus->GetKutyaByNev($_SESSION[nev]);

$adatok='<table>
<tr><td align=left>Név:</td><th>'. $kutyus->NevMegjelenitRanggal() .'</td></tr>
<tr><td align=left>Sorszám:</td><td>'. $kutyus->id .'</td></tr>
<tr><td align=left>Fajta:</td><td>'. kutyaszamtonev($kutyus->fajta) .'</td></tr>
<tr><td align=left>Nem:</td><td>'. $kutyus->nem .'</td></tr>
<tr><td align=left>Pénz:</td><td id="penz">'. penz($kutyus->penz) .'</td></tr>
<tr><td align=left>Gének:</td><td id="genek">'. $kutyus->GenMegjelenit() .'</td></tr>
<tr><td align=left valign=top>Kölykök:</td>'. $kutyus->KolyokMegjelenit() .'</tr>
</table>';

$_SESSION[nev]=$kutyus->nev;
$_SESSION[id]=$kutyus->id;

$kep="<table>
<tr><td align=center>". $kutyus->NevMegjelenit() ." ". $kutyus->kor ." napja született!</td></tr>
<tr><td align=center><idv id='kep'>". $kutyus->Kep() ."</div></td></tr>
</table>";

$vonalak="<table><tr><th align=left>Egészség: </th><th align=right>". $kutyus->egeszseg ."%</th></tr><tr><td colspan=2>". $kutyus->EgeszsegCsik($kutyus->egeszseg*3) ."</td></tr><tr><th align=left>Súly: </th><th align=right>". $kutyus->suly ."%</th></tr><tr><td colspan=2>". $kutyus->SulyCsik($kutyus->suly*3) ."</td></tr></table>";

$talak='<div id="fade" class="black_overlay"></div><div id="light" class="white_content"><p align=right><a href = "javascript:void(0)" onclick = "megjelenit(\'light\')" class="feherlink">Bezár [x]</a></p>
<center><u><big>Étel típus csere</big></u><br>Itt lecserélheted a kutyád tápját, de figyelem a különbözõ ételek máshogy hatnak az állatod egészség és súly növekedésére. <a href=segitseg.php?page=ismerteto#egszsuly class="feherlink">Hogyan?</a><br>Ára: <b>'. penz($KAJA) .'</b><br><input type=radio name=kaja id=kaja1 value=1 style="width: 20px;"><img src=pic/salata2.gif>Saláta<br>
<input type=radio id=kaja2 name=kaja value=2 style="width: 20px;"> <img src=pic/tal2.gif> Táp&nbsp;&nbsp;<br><input type=radio name=kaja id=kaja3 value=3 style="width: 20px;"><img src=pic/fagyi2.gif>Fagylalt<br><input type=submit value=Elküld onclick="kajavalt()"><br><span id="kiiras"></span></center></div>';
$talak.="<table border=0 cellpadding=0 cellspacing=0><tr><th align=left colspan=7>Étel: (még <span id=\"kajakiir\">". $kutyus->kaja ."</span> napra elég van)</th></tr><tr id=\"talak\">". $kutyus->Talak()."</tr>";
$talak.='<tr id="etet">'. $kutyus->EtetMegjelenit() .'</tr></table><script src="script/kutyam.js"></script>';
if($kutyus->belepido<$ma && $kutyus->belepido>=($ma-24*60*60))
{
if($kutyus->Latogat())
{
$kutyus->PenzHozzaad($LEGJOBBGAZDANYEREMENY);
$kutyus->SendUzenet(0, "Gratulálunk!<br>Szorgos munkád meghozta a gyümölcsét, kaptál ". penz($LEGJOBBGAZDANYEREMENY) ." összeget, mivel elnyerted a legjobb gazda címet.");         
}
}
elseif($kutyus->belepido<($ma-24*60*60))
{
$kutyus->NemLatogat();
}else{}

$legjobbgazd="<table><tr><th><img src=pic/gazda.png></th><td width=700 style='text-align:justify;'>Szerezd meg a legjobb gazdi címet és a(z) ". penz($LEGJOBBGAZDANYEREMENY) ." nyereményt! Ehhez nem kell mást tenned, csupán minden nap ". $LEGJOBBGAZDANAP ." napon keresztül folyamatosan látogasd a kutyádat, és máris tied az ". penz($LEGJOBBGAZDANYEREMENY) .". Még <b>". ($LEGJOBBGAZDANAP-$kutyus->legjobbgondozo) ."</b> napot kell látogatnod. <a href=segitseg.php?page=ismerteto#legjobbgazda class='feherlink'>Részletek...</a></td></tr></table>"; 
if($kutyus->kor>$FAGYASZTMINAP){
$lehet="aktiv";
$fagyasztas=$kutyus->FagyasztasMegjelenit();
}else{
$lehet="inaktiv";
$fagyasztas="A kutyád még túl fiatal ahhoz hogy le fagyaszd, megfázna és elpusztulna ezért csak ". $FAGYASZTMINAP ." napos kor felett fagyaszthatod le.";
}
///
$egyszam='<div id="egyszamablak" class="white_content"><p align=right><a href = "javascript:void(0)" onclick = "megjelenit(\'egyszamablak\')" class="feherlink">Bezár [x]</a></p>
<center><u><big>Egyszámjáték</big></u><div style="display: table;"><img style="vertical-align:middle;display: table-cell;" src=pic/egyszam.png>
   <span style="vertical-align: middle;display: table-cell;text-align:justify;"  id=\'egyszamjatek\'>'. $kutyus->EgyszamMegjelenit($_SESSION[hiba]) .'</span></div></div>';

$targylista="<table border=0>";
$db=0;
$targyakLekeres = mysql_query("SELECT * FROM targyak");
	while($targyak=mysql_fetch_object($targyakLekeres))
	{
		$fajtak = explode("|", $targyak->targyak_fajta);
		if(in_array($kutyus->fajta, $fajtak))
		{
			$targylista.="<tr><td  width= 400 align=center>". $targyak->targyak_nev ."<br>Ár:". penz($targyak->targyak_ar) ."<br>";
			if(!$kutyus->VanTargy($targyak->targyak_id))
			{
				$targylista.="<input type=button id=\"megvesz". $targyak->targyak_id ."\" name=vetel value=Megveszem onclick=\"targyvesz('". $targyak->targyak_id ."')\">";
				$targylista.="<input type=button id=\"levesz". $targyak->targyak_id ."\" name=levetel value=\"Leveszem\" style= \"display: none;\">";
			}
			else
			{
				$targylista.="<input type=button id=\"levesz". $targyak->targyak_id ."\" name=levetel value=\"Leveszem\">";
			}
			$targylista.="</td><td width = 200>
				<div style=\"position: relative; left: 0; top: 0;\">
				<img src=pic/kutyak/". kutyaszamtofile($kutyus->fajta) . $kutyus->szin .".png width=60% style=\"position: relative; left: 0; top: 0;\">
				<img src=pic/targyak/". kutyaszamtofile($kutyus->fajta) . $targyak->targyak_file .".png width=60% style=\"position: absolute; top: 0; left: 0;\">
				</div>
			</td></tr>";
			$db++;
		}
	}
$targylista.="</table>";
if($db == 0)
{
	$targylista = "<big><font color=#ff0000>Sajnos ehhez a fajtához nem tartozik tárgy!</font></big>";
}  
$bolt='<div id="targyablak" class="white_content"><p align=right><a href = "javascript:void(0)" onclick = "megjelenit(\'targyablak\')" class="feherlink">Bezár [x]</a></p>
<center><u><big>Tárgyak</big></u><br><span id="targyhiba"></span><br>'. $targylista .'</center></div>';
$bolt.='<div id="gyogyszerablak" class="white_content"><p align=right><a href = "javascript:void(0)" onclick = "megjelenit(\'gyogyszerablak\')" class="feherlink">Bezár [x]</a></p>
<center><u><big>Gyógyszerek</big></u><br>HAMAROSAN...</center></div>';
$bolt.='<div id="szinezesablak" class="white_content"><p align=right><a href = "javascript:void(0)" onclick = "megjelenit(\'szinezesablak\')" class="feherlink">Bezár [x]</a></p>
<center><u><big>Név színezés</big></u><br>HAMAROSAN...</center></div>';
$bolt.="A boltban szép és hasznos dolgokat vehetsz.<center><a href = \"javascript:void(0)\" onclick = \"megjelenit('targyablak')\" class=\"feherlink\">Tárgyak</a><br><a href = \"javascript:void(0)\" onclick = \"megjelenit('gyogyszerablak')\" class=\"feherlink\">Gyógyszerek</a><br><a href = \"javascript:void(0)\" onclick = \"megjelenit('szinezesablak')\" class=\"feherlink\">Név színezés</a><br><a href = \"javascript:void(0)\" onclick = \"megjelenit('light')\" class=\"feherlink\">Étel csere</a></center>";

$_SESSION[hiba]="";
///
belepido($_SESSION[nev]);
$nemr=$leker->kutya_nem;
if($kutyus->kor>17){
$kell=mysql_query("SELECT * FROM `hazassag` WHERE `hazassag_aktiv` = '". $_SESSION[id] ."' or `hazassag_ferj` = '". $_SESSION[id] ."' or `hazassag_feleseg` = '". $_SESSION[id] ."'");

if(mysql_num_rows($kell)==0){
$sziv="a"; $hazas="A házasság komoly dolog, de már elég érett vagy hozzá. Ha felkészültnek érzed magad írd be a nevét annak, akivel házasodni szeretnél.<center><form method=POST action=inc/hazassag.php><input type=text name=nev style='width:90px;'><input type=submit value=Küld style='width:50px;'></form></center>". $_SESSION[hibas];
$_SESSION[hibas]="";
}else{ 
while($hazasodunk=mysql_fetch_object($kell)){
if($hazasodunk->hazassag_ido=="0"){
if($hazasodunk->hazassag_aktiv==$_SESSION[id]){
$sziv="a"; $hazas="A lány/fiú kérés megtörtént. Most várnod kell, amíg nem válaszol. Ha megunnád, kattints a visszavonás gombra.<br><center><a href=inc/keresvissza.php class='feherlink'>Visszavonom</a></center>";
}else{

$kellez=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $hazasodunk->hazassag_aktiv ."'");
if(mysql_num_rows($kellez)>0){
while($kii=mysql_fetch_object($kellez)){
$sziv="a"; $hazas="<a href=kutyak.php?id=". $kii->kutya_id ." class='barna'>". htmlentities($kii->kutya_nev) ."</a> nevû  kutya megkérte a kezed. Gyorsan dönts, hogy mit szeretnél.<br><center><a href=inc/elfogad.php class='feherlink'>Igen,hozzámegyek</a><br><a href=inc/visszautasit.php class='feherlink'>Nem, másra várok</a></center>";
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

$hazas="Megkérted a ". $nev1 ." nevû kutyát hogy legyen kölyökkutyátok, a kérésre még nem válaszolt, tehát most várnunk kell.<br><center><a href=inc/nemkolyok.php class='feherlink'>Nem várok tovább</a></center>";

}else{

$hazas=$nev1 . " nevû kutya megkért hogy legyen közös kutyátok. Döntsd el, hogy legyen-e kölykötök.<br><center><a href=inc/igenkolyok.php class='feherlink'>Szeretnék kölyköt</a><br><a href=inc/nemkolyok.php class='feherlink'>Nem szeretnék</a></center>";

}
}else{
if($most>$kolyok->kolyok_ido){
if($_SESSION[id]==$kolyok->kolyok_tulaj){
$hazas="Gratulálok! Megszületett az ifjú trónörökös. Tied a dicsõség hogy elnevezd a ". nem($kolyok->kolyok_nem) ."t.<br><form action=inc/newborn.php method=POST>Név:<input type=text name=nev style='width: 110px;' maxlength=16><br>Jelszó:<input type=password name=jelszo style='width: 90px;' maxlength=16><br><center><input type=submit value='Elküld'></center></form><br>". $_SESSION[hibas];
$_SESSION[hibas]="";
}else{
$hazas="Gratulálok! Megszületett a kis csöppség. A házastársad adhat neki nevet, neked csak várnod kell.<br><center><a href=inc/nemkolyok.php class='feherlink'>Nem várok tovább</a></center>";
}
}else{
$hazas="Most pedig várni kell ". ($kolyok->kolyok_ido-$ma)/3600/24 ." napot amíg megszületik a kölyök...";
}
}
}
}else{
$hazas='<script>
function confirmDelete() {
  if (confirm("Biztos el akarsz vállni?")) {
    document.location = "inc/visszautasit.php";
  }
}
</script>';
$sziv="a"; $hazas.="Gratulálunk! Már <b>". $feltolt ."</b> napja házastársak vagytok a(z) ". $nev1 ." nevû kutyával! Valóban szép teljesítmény.<br><center><a href=inc/kolyok.php class='feherlink'>Kölyökkutya</a><br><a href='javascript:confirmDelete()' class='feherlink'>El akarok válni</a></center>"; 
}
}
}else{
$sziv="a";
mysql_query("DELETE FROM `hazassag` WHERE `hazassag_aktiv` = '". $_SESSION[id] ."' or `hazassag_ferj` = '". $_SESSION[id] ."' or `hazassag_feleseg` = '". $_SESSION[id] ."'");

}
}
}
}


}else{$sziv="p";$hazas="A házasság komoly dolog, ezért érett fejre van hozzá szükség. Sajnos a te kutyád még nem töltötte be a 18. napját és ezért nem házasodhat.";}
if(substr_count($leker->kutya_tanul,"IR")!=0 and substr_count($leker->kutya_tanul,"SZ")!=0 and substr_count($leker->kutya_tanul,"BR")!=0 and substr_count($leker->kutya_tanul,"ER")!=0 and substr_count($leker->kutya_tanul,"FU")!=0 and substr_count($leker->kutya_tanul,"KE")!=0 and substr_count($leker->kutya_tanul,"VE")!=0){
$tanul="A te kutyád már nagyon okos. Mindent tud, ezért már nem lehet neki mit tanítani. Talán késõbb lesznek új leckék.";
}else{
if($leker->kutya_tanult==$ma){
$tanul="Mára már megtanult az okos kutyád. Legközelebb holnap tudod tanítani.";
}else{$tanul="Tanítsd meg a különbözõ leckéket kutyádnak!<br><center><form method=POST action=inc/tanul.php><select name=tanul>";
if(substr_count($leker->kutya_tanul,"IR")==0){ $tanul.="<option value=IR>Írni tanulni (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'IR'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=3-$row->tanul_lecke; } $tanul.=$lecke. "/3)</option>"; }
if(substr_count($leker->kutya_tanul,"SZ")==0){ $tanul.="<option value=SZ>Számolni tanulni (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'SZ'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=5-$row->tanul_lecke; } $tanul.=$lecke. "/5)</option>"; }
if(substr_count($leker->kutya_tanul,"BR")==0){ $tanul.="<option value=BR>Lottózni (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'BR'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=10-$row->tanul_lecke; } $tanul.=$lecke. "/10)</option>"; }
if(substr_count($leker->kutya_tanul,"ER")==0){ $tanul.="<option value=ER>Érettségizni (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'ER'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=12-$row->tanul_lecke; } $tanul.=$lecke. "/12)</option>"; }
if(substr_count($leker->kutya_tanul,"FU")==0){ $tanul.="<option value=FU>Fül befogása (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'FU'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=7-$row->tanul_lecke; } $tanul.=$lecke. "/7)</option>"; }
if(substr_count($leker->kutya_tanul,"KE")==0){ $tanul.="<option value=KE>Kereskedés (";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'KE'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=10-$row->tanul_lecke; } $tanul.=$lecke. "/10)</option>"; }
if(substr_count($leker->kutya_tanul,"VE")==0){ $tanul.="<option value=VE>Kvíz(";$tudas=mysql_query("SELECT * FROM `tanul` WHERE `tanul_id` = '". $leker->kutya_id ."' and `tanul_mit` = 'VE'",$kapcsolat);$lecke=0;while ($row = mysql_fetch_object($tudas)) { $lecke=12-$row->tanul_lecke; } $tanul.=$lecke. "/12)</option>"; }
$tanul.="</select><br><input type=submit name=elkuld value=Tanítás></form></center>";
}
$tanul.="<br>Picit fel szeretnéd gyorsítani a dolgot? 50 ossáért puskázd ki és rögtön megtanulja a kutyád.<center><form method=POST action=inc/puska.php><select name=puska>";
if(substr_count($leker->kutya_tanul,"IR")==0){ $tanul.="<option value=IR>Írni tanulni</option>"; }
if(substr_count($leker->kutya_tanul,"SZ")==0){ $tanul.="<option value=SZ>Számolni tanulni</option>"; }
if(substr_count($leker->kutya_tanul,"BR")==0){ $tanul.="<option value=BR>Lottózni</option>"; }
if(substr_count($leker->kutya_tanul,"ER")==0){ $tanul.="<option value=ER>Érettségizni</option>"; }
if(substr_count($leker->kutya_tanul,"FU")==0){ $tanul.="<option value=FU>Fül befogása</option>"; }
if(substr_count($leker->kutya_tanul,"KE")==0){ $tanul.="<option value=KE>Kereskedés</option>"; }
if(substr_count($leker->kutya_tanul,"VE")==0){ $tanul.="<option value=VE>Kvíz</option>"; }
$tanul.="</select><input type=submit name=elkuld value=Puskázz></form></center>";
}

$lotto="";
if(substr_count($leker->kutya_tanul,"SZ")==0){
}else{
$lotto.=$egyszam . "<a href = \"javascript:void(0)\" onclick = \"megjelenit('egyszamablak')\" class='feherlink'>Egyszámjáték</a><br>";
}
if(substr_count($leker->kutya_tanul,"BR")==0){
}else{
$lotto.="<a href=lotto.php class='feherlink'>Lottó</a><br>";
}
if(substr_count($leker->kutya_tanul,"VE")==0){
}else{
$lotto.="<a href=autoverseny.php class='feherlink'>Kvíz</a><br>";
}
if($lotto==""){
$lotto="Sajnos te még semmi játékkal nem tudsz játszani. De ne búslakodj, inkább tanulj meg egy-kettõt és játssz!";
}
$menu="<table border=0 cellpadding=5 cellspacing=0>
<tr>
	<td><img src=pic/tanul.png></td>
	<td background=pic/hatter8.gif><img src=pic/". $sziv ."hazassag.png></td>
	<td><img src=pic/". $lehet ."fagyaszt.png></td>
	<td background=pic/hatter8.gif><img src=pic/bolt.png></td>
	<td><img src=pic/lotto.png></td></tr>
<tr>
	<td align=center><i>Tanulás</i></td>
	<td align=center background=pic/hatter8.gif><i>Házasság</i></td>
	<td align=center><i>Fagyasztás</i></td>
	<td align=center background=pic/hatter8.gif><i>Bolt</i></td>
	<td align=center><i>Játékok</i></td></tr>
<tr VALIGN=TOP>
	<td width=150 style='text-align:justify;'>". $tanul ."</td>
	<td width=150 style='text-align:justify;' background=pic/hatter8.gif>". $hazas ."</td>
	<td width=150 style='text-align:justify;' id='fagyaszt'>". $fagyasztas ."</td>
	<td width=150 style='text-align:justify;' background=pic/hatter8.gif>". $bolt ."</td>
	<td width=150 style='text-align:justify;'><center>". $lotto ."</center></td></tr></Table>";
}
$adat="<style>
.black_overlay{
			display: none;
			position: fixed;
			top: 0px;
			left: 0px;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: fixed;
			top: 25%;
			left: 30%;
			width: 500px;
			height: 350px;
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