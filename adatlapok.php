<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if(isset($_SESSION[id])){
if(isset($_GET[id])){
$idkell=mysql_query("SELECT * FROM adatlap WHERE adatlap_id = '". $_GET[id] ."' and adatlap_aktiv = 1");
if(mysql_num_rows($idkell)>0){
$kutyus=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_GET[id] ."'");
while($kutya=mysql_fetch_object($idkell)){
while($kutya2=mysql_fetch_object($kutyus)){
if($kutya2->kutya_betuszin=="774411"){
$nev1=htmlentities($kutya2->kutya_nev);
}else{
$nev1="<font color=#". $kutya2->kutya_betuszin .">". htmlentities($kutya2->kutya_nev) ."</font>";
}
$adatlapKutya = new kutya();
$adatlapKutya->getKutyaByID($_GET[id]);

if($kutya->adatlap_nem==1){
$nem="Lány";
}else{$nem="Fiú";}
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$moderator='<script>
function confirmDeletem() {
  if (confirm("Biztos törölni szeretnéd ezt az adatlapot?")) {
    document.location = "inc/matorol.php?id='. $kutya->adatlap_id .'";
  }
}
</script><script>
function confirmDeletek() {
  if (confirm("Biztos törölni szeretnéd ezt a képet?")) {
    document.location = "inc/mktorol.php?id='. $kutya->adatlap_id .'";
  }
}
</script>';
$moderator.=" <a href='javascript:confirmDeletem()' class='feherlink'>Adatlap Törlés</a> <a href='javascript:confirmDeletek()' class='feherlink'>Kép Törlés</a>";
}
switch($kutya->adatlap_hatter){
case 2: 
$szin=4;
break;
CASE 3:
$szin=5;
break;
default:
$szin=3;
break;
}
$adat="<center><big><big><u>". ubb_forum($kutya->adatlap_nev) ." adatlapja</u></big></big><br><br>";
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center><table border=0 width=790><tr><td align=left>". ubb_forum($kutya->adatlap_nev) .  $moderator ."</td><td align=right>Utolsó módosítás: ". str_replace("-",".",$kutya->adatlap_frissit) ."</td></tr><tr><td align=left>Kutyája neve: <a href=kutyak.php?id=". $kutya2->kutya_id ." class='feherlink'>". $nev1 ."</a></td><td align=right>Látogatások: ". $kutya->adatlap_megnez ." db</td></tr></table>
</td></tr><tr background=pic/hatter". $szin .".gif><td align=center colspan=3><table border=0><tr><td width=420 align=center>
<table border=0><tr><td align=left width=80>Nem:</td><td align=right width=180>". $nem ."</td></tr>
<tr><td align=left width=80>Lakhely:</td><td align=right width=180>". ubb_forum($kutya->adatlap_lakhely) ."</td></tr>
<tr><td align=left width=80>Kor:</td><td align=right width=180>". kor($kutya->adatlap_szulido) ." év(". str_replace("-",".",$kutya->adatlap_szulido) .")</td></tr>
<tr><td align=left width=80>Horoszkóp:</td><td align=right width=180>". horoszkop($kutya->adatlap_szulido) ."</td></tr>
<tr><td align=left width=80>Testsúly:</td><td align=right width=180>". szamtosuly($kutya->adatlap_suly) ."</td></tr>
<tr><td align=left width=80>Testmagasság:</td><td align=right width=180>". szamtomagassag($kutya->adatlap_magassag) ."</td></tr>
<tr><td align=left width=80>Hajszín:</td><td align=right width=180>". szamtohajszin($kutya->adatlap_haj) ."</td></tr>
<tr><td align=left width=80>Szemszín:</td><td align=right width=180>". szamtoszemszin($kutya->adatlap_szem) ."</td></tr></table>
</td><td align=center width=402>". $adatlapKutya->Avatar(200) ."</td></tr>
<tr background=pic/hatter". $szin .".gif><td align=center colspan=3>Leírás:</td></tr>
<tr background=pic/hatter". $szin .".gif><td align=left colspan=3 class='forum'><div style='width: 810px; overflow-x: auto;'>". nl2br(ubb_adatlap($kutya->adatlap_leiras)) ."</div></td></tr></table>
<tr><td width=11 height=11 background=pic/balalso". $szin .".jpg></td><td background=pic/hatter". $szin .".gif width=800></td><td width=11 height=11 background=pic/jobbalso". $szin .".jpg></td></tr>
</td></tr></table></center>";
$megnez=mysql_query("SELECT * FROM latogatas WHERE latogatas_adatlap = '". $kutya->adatlap_id ."' and latogatas_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($megnez)==0){
mysql_query("INSERT INTO latogatas VALUES ('". $kutya->adatlap_id ."','". $_SESSION[id] ."')");
$megnezni=mysql_query("SELECT * FROM latogatas WHERE latogatas_adatlap = '". $kutya->adatlap_id ."'");
mysql_query("UPDATE adatlap SET adatlap_megnez = '". mysql_num_rows($megnezni) ."' WHERE adatlap_id = '". $_GET[id] ."'");
}


}
}
oldal($adat);
}else{
header("Location: adatlapok.php");
}
}else{
$adat="<center>";
$idkell=mysql_query("SELECT * FROM adatlap WHERE adatlap_id = '". $_SESSION[id] ."' and adatlap_aktiv = 1");
if(mysql_num_rows($idkell)>0){
$adat.="<a href=adatlapok.php?id=". $_SESSION[id] ." class='feherlink'>Saját adatlapom</a><br><br>";
}
$sulys=$_GET[suly]; $magassags=$_GET[magassag]; $hajs=$_GET[hajszin]; $szems=$_GET[szemszin];
$suly="<select name=suly><option value=0>Mindegy</option>";
for($i=1; $i<19; $i++){
if($i==$sulys){
$suly.="<option value=". $i ." selected>". szamtosuly($i) ."</option>";
}else{
$suly.="<option value=". $i .">". szamtosuly($i) ."</option>";
}}
$suly.="</select>";
$magassag="<select name=magassag><option value=0>Mindegy</option>";
for($i=1; $i<13; $i++){
if($i==$magassags){
$magassag.="<option value=". $i ." selected>". szamtomagassag($i) ."</option>";
}else{
$magassag.="<option value=". $i .">". szamtomagassag($i) ."</option>";
}}
$magassag.="</select>";
$hajszin="<select name=hajszin><option value=0>Mindegy</option>";
for($i=1; $i<8; $i++){
if($i==$hajs){
$hajszin.="<option value=". $i ." selected>". szamtohajszin($i) ."</option>";
}else{
$hajszin.="<option value=". $i .">". szamtohajszin($i) ."</option>";
}}
$hajszin.="</select>";
$szemszin="<select name=szemszin><option value=0>Mindegy</option>";
for($i=1; $i<7; $i++){
if($i==$szems){
$szemszin.="<option value=". $i ." selected>". szamtoszemszin($i) ."</option>";
}else{
$szemszin.="<option value=". $i .">". szamtoszemszin($i) ."</option>";
}}
$szemszin.="</select>";
if($_GET[tol]!=""){
$kormin=$_GET[tol];
}else{
$kormin=0;
}
if($_GET[ig]!=""){
$kormax=$_GET[ig];
}else{
$kormax=100;
}
$nemek="<select name=nem>";
if($_GET[nem]==1){
$nemek.="<option value=0>Mindegy</option><option value=1 selected>Lány</option><option value=2>Fiú</option>";
}elseif($_GET[nem]==2){
$nemek.="<option value=0>Mindegy</option><option value=1>Lány</option><option value=2 selected>Fiú</option>";
}else{
$nemek.="<option value=0>Mindegy</option><option value=1>Lány</option><option value=2>Fiú</option>";
}
$nemek.="</select>";
$adat.="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center><form action=adatlapok.php method=GET>
<table boder=0><tr><td align=left><input type=hidden name=keres value=1>Nem:</td><td align=right>". $nemek ."</td><td align=left>Lakhely:</td><td align=right><input type=text name=lakhely value=". $_GET[lakhely] ."></td><td align=left>Testsúly:</td><td align=right>". $suly ."</td><td align=left>Testmagasság:</td><td align=right>". $magassag ."</td></tr>
<tr><td align=left>Kor:</td><td align=right><input type=text name=tol style='width:30px;' value=". $kormin ."> év - <input type=text name=ig style='width:30px;' value=". $kormax ."> év</td><td align=left>Hajszín:</td><td align=right>". $hajszin ."</td><td align=left>Szemszín:</td><td align=right>". $szemszin ."</td><td></td><td align=left><input type=submit value=Elküld></td></tr>
</table></form>
</td></tr>
<tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table><br><br>";
if(isset($_GET[keres])){
$oldal=0;
if(isset($_GET[page])){
$oldal=$_GET[page];}
$adat.="<u>Keresés</u><br>"; $i=0; $feltetel="";
if($_GET[nem]==1 or $_GET[nem]==2){
$feltetel.="and adatlap_nem ='". $_GET[nem] ."' ";
}
if($_GET[lakhely]!=""){
$feltetel.="and adatlap_lakhely ='". $_GET[lakhely] ."' ";
}
if($_GET[suly]>0 and $_GET[suly]<19){
$feltetel.="and adatlap_suly ='". $_GET[suly] ."' ";
}
if($_GET[magassag]>0 and $_GET[magassag]<13){
$feltetel.="and adatlap_magassag ='". $_GET[magassag] ."' ";
}
if($_GET[hajszin]>0 and $_GET[hajszin]<8){
$feltetel.="and adatlap_haj ='". $_GET[hajszin] ."' ";
}
if($_GET[szemszin]>0 and $_GET[szemszin]<7){
$feltetel.="and adatlap_szem ='". $_GET[szemszin] ."' ";
}
if($_GET['tol']>-1 and $_GET['ig']>-1){
$feltetel.="and REPLACE(adatlap_szulido,'-','') < '". kortodatum(($_GET[tol]-1),"min") ."' and REPLACE(adatlap_szulido,'-','') > '". kortodatum($_GET[ig],"max") ."'";
}
$toplista=mysql_query("SELECT * FROM adatlap WHERE adatlap_aktiv = 1 ". $feltetel ."ORDER BY adatlap_megnez DESC limit ". $oldal .", 50");
}else{
$toplista=mysql_query("SELECT * FROM adatlap WHERE adatlap_aktiv = 1 and adatlap_megnez <> 0 ORDER BY adatlap_megnez DESC limit 0, 50");
$i=1;$adat.="<u>Toplista</u><br>";
}
while($adatlap=mysql_fetch_object($toplista)){
$adatlapKutya = new kutya();
$adatlapKutya->getKutyaByID($adatlap->adatlap_id);

$kutyus=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $adatlap->adatlap_id ."'");
while($kutya=mysql_fetch_object($kutyus)){
if($kutya->kutya_betuszin=="774411"){
$nev1=htmlentities($kutya->kutya_nev);
}else{
$nev1="<font color=#". $kutya->kutya_betuszin .">". htmlentities($kutya->kutya_nev) ."</font>";
}
if($adatlap->adatlap_nem==1){
$nem="Lány";
}else{$nem="Fiú";}
$adat.="<table border=0 bgcolor=#ffffff><tr>";
if($i!=0){
$adat.="<td align=center width=65><big><big><big><big>". $i .".</big></big></big></big></td>";
}
$adat.="<td align=center>". $adatlapKutya->Avatar(100) ."</td><td width=250><table border=0 cellpadding=0 cellspacing=0 width=520>
<tr><td align=left class='forum' background=pic/hatter8.gif>". ubb_forum($adatlap->adatlap_nev) ."</td><td align=right background=pic/hatter8.gif>Utolsó módosítás: ". str_replace("-",".",$adatlap->adatlap_frissit) ."</td></tr>
<tr><td align=left class='forum' background=pic/hatter8.gif>Kutyája neve: <a href=kutyak.php?id=". $kutya->kutya_id ." class='feherlink'>". $nev1 ."</a></td><td align=right background=pic/hatter8.gif>Látogatások: ". $adatlap->adatlap_megnez ." db</td></tr>
<tr><td align=left class='forum'>Nem: ". $nem ."</td><td align=right></td></tr>
<tr><td align=left class='forum'>Kor: ". kor($adatlap->adatlap_szulido) ." év(". str_replace("-",".",$adatlap->adatlap_szulido) .")</td><td align=right><a href=adatlapok.php?id=". $adatlap->adatlap_id ." class='feherlink'>Részletek...</a></td></tr></table></td></tr></table><br>";

}
if($i!=0){
$i++;
}}
if(isset($_GET[keres])){
$feltetels="keres=1&nem=". $_GET[nem] ."&lakhely=". $_GET[lakhely] ."&suly=". $_GET[suly] ."&magassag=". $_GET[magassag] ."&tol=". $_GET[tol] ."&ig=". $_GET[ig] ."&hajszin=". $_GET[hajszin] ."&szemszin=". $_GET[szemszin];
$toplistaa=mysql_query("SELECT * FROM adatlap WHERE adatlap_aktiv = 1 ". $feltetel ."ORDER BY adatlap_megnez DESC");
if($oldal!=0){$adat.="<a href=adatlapok.php?page=". ($oldal-50) ."&". $feltetels ." class='feherlink'>Elõzõ 50 adatlap</a>";}
if($oldal< mysql_num_rows($toplistaa)-50){$adat.=" <a href=adatlapok.php?page=". ($oldal+50) ."&". $feltetels ." class='feherlink'>Következõ 50 adatlap</a>";}
}
$adat.="</center>";
oldal($adat);
}
}else{
header("Location: index.php");
}
	?>
