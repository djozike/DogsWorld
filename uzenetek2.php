<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
include("inc/stilus.php");
if(isset($_SESSION[nev])){
function menu(){
include("inc/sql.php");
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$mod=" | <a href=". $_SERVER[PHP_SELF] ."?page=bejelent class='feherlink'>Bejelentett levelek</a>";
}
$adat="<center><a href=". $_SERVER[PHP_SELF] ." class='feherlink'>Üzenetek</a> | <a href=". $_SERVER[PHP_SELF] ."?page=tilto class='feherlink'>Tiltólista</a>". $mod ."<br><br><a href=". $_SERVER[PHP_SELF] ."?page=uzenetir><img src=pic/levelneki.jpg alt='Levél írás' border=0></a> <a href=". $_SERVER[PHP_SELF] ."?page=penztkuld><img src=pic/penzneki.jpg alt='Levél írás' border=0></a></center>";

return $adat;
}

if($_GET[page]=="tilto"){
$adat=menu();
$adat.="<center>Ha valaki állandóan zaklat és már nem vagy rá kíváncsi,<br> itt letilthatód és nem kapsz tõle több levelet!";
if($_SESSION[hiba]!=""){
$adat.="<br>". $_SESSION[hiba];
$_SESSION[hiba]="";}
$leker=mysql_query("SELECT * FROM `kutya` WHERE `kutya_id`='". $_SESSION[id] ."'");
while($user=mysql_fetch_object($leker)){
if(substr_count($user->kutya_tanul,"FU")==0){
$adat.=hiba("<br>Még nem tanulta meg a kutyád a fülét befogni, ezért nem tilthatsz le senkit!");
}else{
$adat.="<table><tr><td>Kutya neve:</td><td><form method=POST action=inc/tilto.php><input type=text name=nev></td><td><input type=submit value=Elküld style='width:60px'></form></td></tr></table><br>";
$lekeres=mysql_query("SELECT * FROM tilto WHERE tilto_tilto = '". $_SESSION[id] ."'");
if(mysql_num_rows($lekeres)>0){
$adat.="<table border=0>";
while($kutya=mysql_fetch_object($lekeres)){
$lekeres2=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $kutya->tilto_tiltott ."'");
while($kutyak=mysql_fetch_object($lekeres2)){
if($kutyak->kutya_betuszin=="774411"){
$adat.="<tr><td><li></td><td align=left width=80><a href=kutyak.php?id=". $kutyak->kutya_id ." class='feherlink'>". htmlentities($kutyak->kutya_nev) ."</a></td><td><a href=inc/tiltotorol.php?id=". $kutyak->kutya_id ."><img src=pic/kuka.jpg border=0></a></td></tr>";
}else{
$adat.="<tr><td><li></td><td align=left width=80><a href=kutyak.php?id=". $kutyak->kutya_id ." class='feherlink'><font color=#". $kutyak->kutya_betuszin .">". htmlentities($kutyak->kutya_nev) ."</font></a></td><td><a href=inc/tiltotorol.php?id=". $kutyak->kutya_id ."><img src=pic/kuka.jpg border=0></a></td></tr>";
}
}
}
$adat.="</table>";
}else{
$adat.=ok("Nincs senki a tiltólistádon!");
}
$adat.="</center>";
}}
}elseif($_GET[page]=="uzenetir"){
if(isset($_GET[uid])){
$leker=mysql_query("SELECT kutya_nev, kutya_betuszin FROM kutya WHERE kutya_id = '". $_GET[uid] ."'");
if(mysql_num_rows($leker)>0){
while($neve=mysql_fetch_object($leker)){
if($neve->kutya_betuszin=="774411"){
$cimzett="<input type=hidden name=nev value='". $neve->kutya_nev ."'>". htmlentities($neve->kutya_nev);
}else{
$cimzett="<input type=hidden name=nev value='". $neve->kutya_nev ."'><font color=#". $neve->kutya_betuszin .">". htmlentities($neve->kutya_nev) ."</font>";
}
}
}else{
$cimzett="<input type=text name=nev>";
}
}else{
$cimzett="<input type=text name=nev>";
}
$adat="<form method=POST action=inc/levelez.php><center><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left width=580>
<br><center><big><big><b>Üzenet írás</b></big></big></center><br>
<center><table><tr><td>
<table border=0><tr><td align=left>Feladó:<td align=right>". htmlentities($_SESSION[nev]) ."</tr><tr><td align=left>Címzett:</td><td align=right>". $cimzett ."</tr></table>
</td><td width=15></td><td width=300><b>Figyelem!</b> Az üzenetben használhatod a következõ UBB kódokat is!<br>[center]...[/center] - középre igazítás<br>[img]kép link[/img] - kép beszurás<br>[color=szín]...[/color] - szöveg színezés</td></tr></table><br>Üzeneted:<br><TEXTAREA name='uzenet' cols=50 rows=12></TEXTAREA><br><br><input type=submit name=Elkuld value=Küldés></form>". $_SESSION[hiba] ."</center><br>
</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table></center>";
$_SESSION[hiba]="";
}
elseif($_GET[page]=="penztkuld"){
if(isset($_GET[uid])){
$leker=mysql_query("SELECT kutya_nev, kutya_betuszin FROM kutya WHERE kutya_id = '". $_GET[uid] ."'");
if(mysql_num_rows($leker)>0){
while($neve=mysql_fetch_object($leker)){
if($neve->kutya_betuszin=="774411"){
$cimzett="<input type=hidden name=nev value='". $neve->kutya_nev ."'>". htmlentities($neve->kutya_nev);
}else{
$cimzett="<input type=hidden name=nev value='". $neve->kutya_nev ."'><font color=#". $neve->kutya_betuszin .">". htmlentities($neve->kutya_nev) ."</font>";
}
}
}else{
$cimzett="<input type=text name=nev>";
}
}else{
$cimzett="<input type=text name=nev>";
}$ar="";
for($i=2;$i<10;$i++){
$ar.="<option value=". $i .">". $i ." csont</option>";
}
$adat='<script src="script/levelez.js"></script>';
$adat.="<form method=POST action=inc/levelez.php><center><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left width=580>
<br><center><big><big><b>Pénz küldés</b></big></big></center><br>
<center><table><tr><td>
<table border=0><tr><td align=left>Feladó:<td align=right>". htmlentities($_SESSION[nev]) ."</tr><tr><td align=left>Címzett:</td><td align=right>". $cimzett ."</tr><tr><td align=left>Összeg:</td><td align=right><select name=penz id=penzselect onchange='KapottPenz(".$PENZKULDOSZAZALEK.")'>". $ar ."</select></td></tr><tr><td>Megérkezõ összeg:</td><td id=megerkezoosszeg>". Penz(200*$PENZKULDOSZAZALEK) ."</td></tr></table>
</td><td width=15></td><td width=300><b>Figyelem!</b> A megjegyzésben nem használhatsz UBB kódokat!<br>A küldeni kivánt összegbõl levonásra kerül ". (1-$PENZKULDOSZAZALEK)*100 ."% kézbesítési díj! Tehát ha 5 csontot küldesz csak ". penz($PENZKULDOSZAZALEK*100*5) ." érkezik meg!</td></tr></table><br>Megjegyzés:<br><TEXTAREA name='uzenet' cols=50 rows=12></TEXTAREA><br><br><input type=submit name=Elkuld value=Küldés></form>". $_SESSION[hiba] ."</center><br>
</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table></center>";
$_SESSION[hiba]="";
}
elseif($_GET[page]=="bejelent"){
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$adat=menu() ."<center>Itt a mások által szabálytalannak vélt magánleveleket láthatód,<br> mivel szabályellenesnek jelentették beleolvashatsz a levelekbe.
<br><br>";
$leker=mysql_query("
SELECT `uzenet_tipus`, `uzenet_kuldo`, `uzenet_kapo` FROM `uzenetek` WHERE `uzenet_tipus` > 0 GROUP BY `uzenet_tipus`, `uzenet_kuldo`, `uzenet_kapo`
");
if(mysql_num_rows($leker)>0){
$adat.="<table border=0 cellspacing='0' cellpadding='0'><tr background=pic/hatter8.gif><th width=5><th width=280 align=center>Levelezés<th width=160 align=center>Bejelentõ neve<th align=50></tr>";
$szin="keret3";
while($uzi=mysql_fetch_object($leker)){
$kapo=new kutya();
$kuldo=new kutya();
$bejelento=new kutya();
$kapo->getKutyaByID($uzi->uzenet_kapo);
$kuldo->getKutyaByID($uzi->uzenet_kuldo);
$bejelento->getKutyaByID($uzi->uzenet_tipus);
$adat.="<tr background=pic/". $szin .".gif><td></td><td align=left><a href=uzenetek.php?id=". $uzi->uzenet_id  ." class='feherlink'>". $kuldo->nevMegjelenit() ." - ". $kapo->nevMegjelenit() ."</a><td align=left><a href=uzenetek.php?id=". $uzi->uzenet_id  ." class='feherlink'>". $bejelento->nevMegjelenit()  ."</a></td><td align=right><a href=inc/bejtorol.php?id=". $uzi->uzenet_id ."><img src=pic/kuka.png border=0></a></tr>";

	  if($szin=="keret3")
      {
      $szin="hatter8";
      }else{
      $szin="keret3";
      }

}

$adat.="</table></center>";
}else{
$adat.=ok("Nincs bejentett levél!") ."</center>";
}
}else{
$adat=hiba("Nincs jogosultságod az oldal megtekintéséhez!");
}
}
else{
if(isset($_GET[id])){
$leker=mysql_query("SELECT * 
FROM uzenetek 
WHERE uzenet_kapo = '". $_GET[id] ."' and uzenet_kuldo = '". $_SESSION[id] ."' and uzenet_torol_kuldo = '0'
or uzenet_kapo = '". $_SESSION[id] ."' and uzenet_kuldo = '". $_GET[id]. "' and uzenet_torol_kapo = '0'
ORDER BY uzenet_ido");
if($_GET[id]==0)
{
$adat.="<center><font size=+6>". $SITENAME ." levelei</font><br>";
}
else
{
$kutya=new kutya();
$kutya->GetKutyaByID($_GET[id]);
if($kutya->online)
{
$online=ok("&bull;");
}
else{
$online=hiba("&bull;");
}
$adat.="<center><font size=+6>". $kutya->NevMegjelenitLinkelve() ." levelei". $online ."</font><br>";
}
if(mysql_num_rows($leker)>0){
if($_GET[id]!=0){
$bejelentes="<input type=submit name=\"bejelentes\" value=\"Beszélgetés bejelentése\" style='width: 160px;' onclick='javascript:confirmBejelentes(\"Biztos bejelented mint szabálysértõ levél?\")'>";
}
$adat.="<script>
uziszam=0;
function confirmTorles(szoveg, url) {
  if (confirm(szoveg)) {
	AjaxAdatKuld(\"inc/oszleveltorol.php?id=". $_GET[id] ."\", function(){ 
	document.getElementById(\"tartalom\").innerHTML=\"". $NINCSLEVEL ."\";
  });
 
  }
}
function confirmBejelentes(szoveg) {
  if (confirm(szoveg)) {
  	AjaxAdatKuld(\"inc/szabalys.php?kutya=". $_GET[id] ."\", function(){ 
		alert(\"Sikeres bejelentés! Hamarossan egy moderátor átnézi a leveled.\");
  });
  }
}

function Uzen() {
	url=\"inc/levelez.php?id=". $_GET[id] ."&uzenet=\"+document.getElementById(\"uzenet\").value.replace(/\\r\\n|\\r|\\n/g, \"[br]\");
  	AjaxAdatKuld(url, function(){ 
		document.getElementById(\"tartalom\").innerHTML=arguments[0];
		document.getElementById(\"tartalom\").scrollTop=document.getElementById(\"tartalom\").scrollHeight;
  });
  document.getElementById(\"uzenet\").value=\"\";
}

function Torol(id) {
	url=\"/inc/torol.php?id=\"+ id +\"&page=". $_GET['id'] ."\";
  	AjaxAdatKuld(url, function(){ 
		document.getElementById(\"tartalom\").innerHTML=arguments[0];
		uziszam--;
  });
}

window.onload = function(e){ 
     document.getElementById(\"tartalom\").scrollTop=document.getElementById(\"tartalom\").scrollHeight;
}

window.setInterval(function() {
    	url=\"inc/levelez.php?id=". $_GET[id] ."\";
		AjaxAdatKuld(url, function(){ 
		ujuziszam=arguments[0].substring(0,arguments[0].indexOf(\"<\"));
		if(uziszam!=ujuziszam){
		uziszam=arguments[0].substring(0,arguments[0].indexOf(\"<\"));
		document.getElementById(\"tartalom\").innerHTML=arguments[0].substring(arguments[0].indexOf(\"<\"));
		document.getElementById(\"tartalom\").scrollTop=document.getElementById(\"tartalom\").scrollHeight;
		}
  });
}, 1900);
</script>
<p align=right style=\"width:800px;\">". $bejelentes ." <input type=submit name=\"leveltorles\" value=\"Összes levél törlése\" style='width: 150px;' onclick='javascript:confirmTorles(\"Biztos törlöd az összes levelet?\", \"inc/szabalys.php?id=". $uzenet->uzenet_id ."\")'></p>
<div style=\"width: 800px; height: 470px; overflow: auto;\" id=\"tartalom\"> ";
mysql_query("UPDATE uzenetek SET uzenet_olvas = 1 WHERE uzenet_kuldo = '". $_GET['id'] ."' and uzenet_kapo= '". $_SESSION['id'] ."'");

$adat.=uzenet_listazas($_SESSION['id'], $_GET['id']);

}
else
{ 
	if($kutya->GetKutyaByID($_GET[id]))
	{
		$adat.="<br><br>". $NINCSLEVEL. "<br><br>"; 
	}
	else
	{
		header("Location: ". $_SERVER[PHP_SELF]);
	}
}
$adat.="</div>";
if($_GET[id]!=0){
$adat.=VilagosMenu(750, "<textarea cols=80 rows=8 id=uzenet></textarea><br><br><input type=submit name=elkuld value=\"Elküld\" onclick='javascript:Uzen()'>")  ."</center>";
}
}
else{
$adat=menu();
$adat.="<script>
var xmlhttp;
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
  }
function AjaxAdatKuld(url, callback)
{
xmlhttp.onreadystatechange = function() {
  if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
    callback(xmlhttp.responseText);
  }
};

xmlhttp.open(\"GET\",url, true);
xmlhttp.send();
}

function Torol(id) {
	url=\"/inc/torol.php?id=\"+ id +\"&page=\";
  	AjaxAdatKuld(url, function(){ 
		document.getElementById(\"uzenetek\").innerHTML=arguments[0];
  });
}

window.setInterval(function() {
    	url=\"inc/levelez.php?page=\";
  	AjaxAdatKuld(url, function(){ 
		document.getElementById(\"uzenetek\").innerHTML=arguments[0];
  });
}, 1800);
</script>";
$adat.="<center>A legutóbbi üzenet tartalmára kattintva tudod megnyitni a beszélgetések elõzményeit.<br>
Jelmagyarázat: <font color=#e6ba8e>Olvasott levél</font>, <font color=#6fc7ff>Elküldött, de nem olvasott</font>, <font color=#cf7082>Bejövõ, de még nem olvasott</font><br><br>". hiba("Figyelem! a ". $LEVELTORLES ." napnál régebbi olvasott levelek automatikusan törlõdnek.") ."<br><br>";

$adat.="<div id=\"uzenetek\">". osszes_uzenet_listazasa($_SESSION[id]) ."</div>";
$adat.="</center>";

}
}


oldal($adat);
}else{header("Location: index.php");}
?>
