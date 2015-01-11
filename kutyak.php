<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if(isset($_SESSION[nev])){
function hazas($nem){
switch($nem){
case 1:
return "Férj:";
break;
default:
return "Feleség:";
break;
}
}
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$moderator="<tr><td align=left><form method=GET action=kutyak.php>Keresés a <select name=hol style='width:100px;'><option value=regi>Regisztrációs</option><option value=belep>Belépés</option></select> ip alapján:</td><td>
<table valign=center><tr><td><input type=text name=ip style='width70px;' maxlength=16></td><td><input type=submit value=Keresés style='width:75px;'></td></tr></table></form>
</td><td></td>";}

$oldal=0;
if($_GET[oldal]>0){
$oldal=$_GET[oldal];
}else{ $oldal=0; }
$feltetel="";
if(isset($_GET[keres])){
$feltetel="WHERE `kutya_id` > 0 ";
if($_GET[nem]>0){
$feltetel.="and `kutya_nem` = '". $_GET[nem] ."' ";
}
if($_GET[fajta]!=0){
$feltetel.="and `kutya_fajta` = '". ($_GET[fajta]-1) ."' ";
}
if($_GET[falka]==1){
$feltetel.="and `kutya_falka` > '0' ";
}
if($_GET[falka]==2){
$feltetel.="and `kutya_falka` = '0' ";
}
if($_GET[fagyaszt]==1){
$feltetel.="and `kutya_fagyasztva` > '0' ";
}
if($_GET[fagyaszt]==2){
$feltetel.="and `kutya_fagyasztva` = '0' ";
}
if($_GET['tol']>-1 and $_GET['ig']>-1){
$feltetel.="and kutya_kor > '". ($_GET[tol]-1) ."' and kutya_kor < '". ($_GET[ig]+1) ."' ";
}
if($_GET['sulytol']>-1 and $_GET['sulyig']>-1){
$feltetel.="and kutya_suly > '". ($_GET[sulytol]-1) ."' and kutya_suly < '". ($_GET[sulyig]+1) ."' ";
}
if($_GET['egtol']>-1 and $_GET['egig']>-1){
$feltetel.="and kutya_egeszseg > '". ($_GET[egtol]-1) ."' and kutya_egeszseg < '". ($_GET[egig]+1) ."' ";
}

}
if($_GET[id]>0){
$feltetel="WHERE `kutya_id` ='". $_GET[id] ."'";}
if(isset($_GET[nev])){
$feltetel="WHERE `kutya_nev` LIKE '". $_GET[nev] ."%' ";}
if(isset($_GET[ip])){
if($_GET[hol]=="belep"){
$feltetel="WHERE `kutya_belepip` = '". $_GET[ip] ."' and kutya_id <> 1 ";}else{
$feltetel="WHERE `kutya_regip` = '". $_GET[ip] ."' and kutya_id <> 1 ";}}
if(isset($_GET[online])){
$user=mysql_query("SELECT distinct session.nev FROM session");
}else{
$user=mysql_query("SELECT * FROM `kutya` ". $feltetel,$kapcsolat);
}
if($feltetel!=""){
$szoveg="<b>". mysql_num_rows($user) ."</b> darab kutyát találtam.";
}
elseif(isset($_GET[online])){
$szoveg="Jelenleg <b>". (mysql_num_rows($user)-1) ."</b> kutya online az oldalon.";
}
else{
$szoveg="Már <b>". mysql_num_rows($user) ."</b> kutya van az oldalon.";
}
$fajta='<SELECT name="fajta"><option value=0>Mindegy</option>';
$fajtak=mysql_query("SELECT * FROM fajta ORDER BY fajta_nev");
while($fajtale=mysql_fetch_object($fajtak)){
if(($fajtale->fajta_id+1)==$_GET[fajta]){
$fajta.='<OPTION value="'.  ($fajtale->fajta_id+1) .'" selected>'. $fajtale->fajta_nev .'</OPTION>';
}else{
$fajta.='<OPTION value="'.  ($fajtale->fajta_id+1) .'">'. $fajtale->fajta_nev .'</OPTION>';
}}
$fajta.='</SELECT>';
$kortol=0; $sulytol=0; $sulyig=100; $egtol=0; $egig=100;
$legidosebb=mysql_query("SELECT * FROM kutya ORDER BY kutya_kor DESC LIMIT 1");
while($kellszam=mysql_fetch_object($legidosebb)){
$korig=$kellszam->kutya_kor;
}
if(isset($_GET['tol'])){
$kortol=$_GET['tol'];
}
if(isset($_GET['ig'])){
$korig=$_GET['ig'];
}
if(isset($_GET['sulytol'])){
$sulytol=$_GET['sulytol'];
}
if(isset($_GET['sulyig'])){
$sulyig=$_GET['sulyig'];
}
if(isset($_GET['egtol'])){
$egtol=$_GET['egtol'];
}
if(isset($_GET['egig'])){
$egig=$_GET['egig'];

if($_GET[nem]==1){
$lany="selected";
}elseif($_GET[nem]==2){
$fiu="selected";
}else{}
if($_GET[falka]==1){
$fvan="selected";
}elseif($_GET[falka]==2){
$fnincs="selected";
}else{}
if($_GET[fagyaszt]==1){
$favan="selected";
}elseif($_GET[fagyaszt]==2){
$fanincs="selected";
}else{}

}
$adat="<center><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr><tr><td background=pic/hatter8.gif colspan=3 align=center><table border=0 cellpadding=0><tr><td align=left>Keresés a kutya neve alapján:</td><td>
<table valign=center><tr><td><form method=GET action=kutyak.php><input type=text name=nev style='width70px;' maxlength=16></td><td><input type=submit value=Keresés style='width:75px;'></td></tr></table></form>
</td><td></td><tr><td  align=left>Keresés a kutya sorszáma alapján:</td><td>
<form method=GET action=kutyak.php><table valign=center><tr><td><input type=text name=id style='width70px;'></td><td><input type=submit value=Keresés style='width:75px;'></td></tr></table></form>
</td><td></td></tr></tr>". $moderator ."</table>". $szoveg ."</td><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></tr></table><br>

<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center><form action=kutyak.php method=GET>
<table boder=0><tr><td align=left><input type=hidden name=keres value=1>Nem:</td><td align=right><select name=nem><option value=0>Mindegy</option><option value=1 ". $lany .">Szuka</option><option value=2 ". $fiu .">Kan</option></select></td><td align=left>Fajta:</td><td align=right>". $fajta ."</td><td align=left>Falka:</td><td align=right><select name=falka><option value=0>Mindegy</option><option value=1 ". $fvan .">Van falka</option><option value=2 ". $fnincs .">Nincs falka</option></select></td><td align=left>Fagyasztva:</td><td align=right><select name=fagyaszt><option value=0>Mindegy</option><option value=1 ". $favan .">Igen</option><option value=2 ". $fanincs ." >Nem</option></select></td></tr>

<tr><td align=left>Kor:</td><td align=right><input type=text name=tol style='width:25px;' value=". $kortol ."> nap - <input type=text name=ig style='width:25px;' value=". $korig ."> nap</td><td align=left>Egészség:</td><td align=right><input type=text name=egtol style='width:30px;' value=". $egtol ."> % - <input type=text name=egig style='width:30px;' value=". $egig ."> %</td><td align=left>Súly:</td><td align=right><input type=text name=sulytol style='width:30px;' value=". $sulytol ."> % - <input type=text name=sulyig style='width:30px;' value=". $sulyig ."> %</td><td></td><td align=left><input type=submit value=Elküld></td></tr>

</table></form>
</td></tr>
<tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=800></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table>

<a href=kutyak.php?online=1 class='feherlink'><font color=#007100>Online kutyák</font></a>";


if(isset($_GET[online])){
$useres=mysql_query("SELECT distinct session.nev,kutya.*  FROM `session` JOIN `kutya` ON session.nev = kutya.kutya_nev ORDER BY kutya.kutya_id limit ". $oldal .",10",$kapcsolat);
if(mysql_num_rows($useres)==0){
$feltetel="";
$useres=mysql_query("SELECT * FROM `kutya` ORDER BY kutya_id limit ". $oldal .",10",$kapcsolat);
$adat.="<br><big>". hiba("Jelenleg senki sem online!") ."</big>";
}
}else{
$useres=mysql_query("SELECT * FROM `kutya` ". $feltetel ."ORDER BY kutya_id limit ". $oldal .",10",$kapcsolat);
if(mysql_num_rows($useres)==0){
$feltetel="";
$useres=mysql_query("SELECT * FROM `kutya` ORDER BY kutya_id limit ". $oldal .",10",$kapcsolat);
$adat.="<br><big>". hiba("Nem találtam ilyen kutyát!") ."</big>";
}

}
$i=0;
while($users=mysql_fetch_object($useres)){

if($users->kutya_suly<25.1){
$vonal[0]="szazalekkezdjo";
$vonal[1]="szazalekjo";
$vonal[2]="szazalekvegjo";
}elseif ($users->kutya_suly>79.9){
$vonal[0]="szazalekkezdrossz";
$vonal[1]="szazalekrossz";
$vonal[2]="szazalekvegrossz";
}else{
$vonal[0]="szazalekkezd";
$vonal[1]="szazalek";
$vonal[2]="szazalekveg";
}

if($users->kutya_egeszseg>79){
$vonal1[0]="szazalekkezdjo";
$vonal1[1]="szazalekjo";
$vonal1[2]="szazalekvegjo";
}elseif ($users->kutya_egeszseg<21){
$vonal1[0]="szazalekkezdrossz";
$vonal1[1]="szazalekrossz";
$vonal1[2]="szazalekvegrossz";
}else{
$vonal1[0]="szazalekkezd";
$vonal1[1]="szazalek";
$vonal1[2]="szazalekveg";
}


$szazalekok="<table border=0 cellpadding=0 cellspacing=0><tr><th width=3 height=12 background=pic/". $vonal1[0] .".JPG></th><th width=". $users->kutya_egeszseg*1.75 ." height=12 background=pic/". $vonal1[1] .".JPG></th><th width=3 height=12 background=pic/". $vonal1[2] .".JPG></th></tr></table>";
$szazalekok2="<table border=0 cellpadding=0 cellspacing=0><tr><th width=3 height=12 background=pic/". $vonal[0] .".JPG></th><th width=". $users->kutya_suly*1.75 ." height=12 background=pic/". $vonal[1] .".JPG></th><th width=3 height=12 background=pic/". $vonal[2] .".JPG></th></tr></table>";

if($users->kutya_belepido!=0){
if(($ma-$users->kutya_belepido)/(3600*24)<1){
$lekeres=mysql_query("SELECT * FROM `session` WHERE `nev` = '". str_replace("'","\'",$users->kutya_nev) ."'",$kapcsolat);
if(mysql_num_rows($lekeres)>0){
$latogat=ok("<br>Éppen itt van a gazdája!");
}else{
$latogat="<br>Ma már látogatta a gazdája!";
}
}else{
$latogat="<br>". ceil(($ma-$users->kutya_belepido)/(3600*24)) ." napja látogatta meg a gazdája!";
}
}else{
$latogat="<br>Soha sem látogatta meg a gazdája!";
}

if($users->kutya_fagyasztva!=0){
$latogat="<br>Ez a kutya még ". $users->kutya_fagyasztva ." napig le van fagyasztva!";
}
if($i>0){$adat.="<img src=pic/csik.png><br>";}
if($users->kutya_nem==2){
$kellid=hazassag_feleseg;
}else{ $kellid=hazassag_ferj; }
$hazastars=mysql_query("SELECT * FROM hazassag WHERE hazassag_ido <> '0' and  ". $kellid ." = '". $users->kutya_id ."'");
if(mysql_num_rows($hazastars)>0){
while($hazastarsid=mysql_fetch_object($hazastars)){

if($users->kutya_nem==2){
$hazas1=$hazastarsid->hazassag_ferj;
}else{ $hazas1=$hazastarsid->hazassag_feleseg; }
$nevkiderit=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $hazas1 ."'");
while($hazasnev=mysql_fetch_object($nevkiderit)){
if($hazasnev->kutya_betuszin=="774411"){
$nev1=htmlentities($hazasnev->kutya_nev);
}else{
$nev1="<font color=#". $hazasnev->kutya_betuszin .">". htmlentities($hazasnev->kutya_nev) ."</font>";
}

$hazas="<a href=kutyak.php?id=". $hazas1 ." class='barna'>". $nev1 ."</a>";
}
}
}else{
$hazas="nincs";
}
$vanadatlap=mysql_query("SELECT * FROM adatlap WHERE adatlap_aktiv = 1  and adatlap_id = '". $users->kutya_id ."'");
if(mysql_num_rows($vanadatlap)>0){
$adatlap="<a href=adatlapok.php?id=". $users->kutya_id ."><img src=pic/adatlap.jpg border=0></a>";
}else{
$adatlap="<img src=pic/adatlap2.jpg border=0>";
}
if($users->kutya_falka==0){
$falka="";
}else{
$falkakell=mysql_query("SELECT * FROM falka WHERE falka_id = '". $users->kutya_falka ."'");
while($falkaa=mysql_fetch_object($falkakell)){
$nap=floor(($ma-$falkaa->falka_alapitas)/60/60/24);
$vezetonev=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $falkaa->falka_vezeto ."'");
while($kell=mysql_fetch_object($vezetonev)){
if($kell->kutya_betuszin=="774411"){
$nev2=htmlentities($kell->kutya_nev);
}else{
$nev2="<font color=#". $kell->kutya_betuszin .">". htmlentities($kell->kutya_nev) ."</font>";
}
}
if(file_exists("pic/falka/". $users->kutya_falka .".png")){
$kep="<img src=pic/falka/". $users->kutya_falka .".png border=0 height=50 width=150>";
}else{
$kep="<img src=pic/falka/nopic.jpg border=0 width=150 height=50>";
}
$falka="<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=740></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center>
<table><tr><td align=center>". $kep ."</td><td width=600>

<table border=0><tr><td align=center width=400><u>". falkaidtonev($falkaa->falka_id) ."</u></td><td>Vezetõ: <a href=kutyak.php?id=". $falkaa->falka_vezeto ." class='feherlink'>". $nev2 ."</a></td></tr><tr><td align=left>Ez a falka ". $nap ." napja létezik és már ". $falkaa->falka_pont ." pontja van.</td><td align=left><a href=falka.php?id=". $falkaa->falka_id ." class='feherlink'>Részletek...</a></td></tr></table>

</td></tr></table>

</td></tr><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table>";
}}
$bejegyzes=mysql_query("SELECT * FROM blog WHERE blog_kutya = '". $users->kutya_id ."'");
if(mysql_num_rows($bejegyzes)>0){
$blog="<a href=blog.php?id=". $users->kutya_id ."><img src=pic/blog.jpg border=0></a>";
}else{
$blog="<img src=pic/blog2.jpg>";
}
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $users->kutya_id ."'");
if(mysql_num_rows($modie)>0){ 
while($rang=mysql_fetch_object($modie)){
$moderatocsillag="<img src=pic/mod". $rang->mod_rang .".gif>";
}}else{
$moderatocsillag="";
}
$kuty=new kutya();
$kuty->GetKutyaByID($users->kutya_id);
$adat.="<table width=750><tr align=top><td align=left><table><tr><th align=left>Név:</th><td width=250 align=right><big>". $kuty->NevMegjelenitRanggal() ."</big></td></tr><tr><td align=left>Sorszáma:</td><td align=right>". $users->kutya_id ."</td></tr><tr><td align=left>Kora:</td><td align=right>". $users->kutya_kor ." nap</td></tr><tr><td align=left>Fajta:</td><td align=right>". kutyaszamtonev($users->kutya_fajta) ."</td></tr><tr><td align=left>Nem:</td><td align=right>". nem($users->kutya_nem) ."</td></tr>
<tr><td align=left>". hazas($users->kutya_nem) ."</td><td align=right>". $hazas ."</td></tr>";
if($users->kutya_apa!=0){
$adat.="<tr><td align=left>Apa:</td><td align=right>". linker($users->kutya_apa, $users->kutya_apanev) ."</td></tr>
<tr><td align=left>Anya:</td><td align=right>". linker($users->kutya_anya, $users->kutya_anyanev) ."</td></tr>";
}
$moderator="";
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){ 
while($rang=mysql_fetch_object($modie)){
if($rang->mod_rang>1){
$moderator.="<tr><td align=left>Pénz:</td><td align=right>". penz($users->kutya_penz) ."</td></tr>";
}
}
if($users->kutya_id!=1){
$moderator.="<tr><td align=left>Regisztráció IP:</td><td align=right><a href=kutyak.php?ip=". $users->kutya_regip ."&hol=regi class='feherlink'>". $users->kutya_regip ."</td></tr>
<tr><td align=left>Belépés IP:</td><td align=right><a href=kutyak.php?ip=". $users->kutya_belepip ."&hol=belep class='feherlink'>". $users->kutya_belepip ."</a></td></tr>
<tr><td align=left>Tiltás:</td><td align=right><form method=POST action=inc/mtilto.php><input type=hidden value=". $users->kutya_id ." name=id><select name=ido><option value=1>1 napra</option><option value=2>2 napra</option><option value=3>5 napra</option><option value=4>10 napra</option></select> <input type=submit value=Mehet style='width:55px;'></form></td></tr>";
}
else{
$moderator.="<tr><td align=left>Regisztráció IP:</td><td align=right><a href=kutyak.php?ip=192.168.72.16&hol=regi class='feherlink'>192.168.72.16</td></tr>
<tr><td align=left>Belépés IP:</td><td align=right><a href=kutyak.php?ip=192.168.72.16&hol=belep class='feherlink'>192.168.72.16</a></td></tr>
<tr><td align=left>Tiltás:</td><td align=right><form method=POST action=inc/mtilto.php><input type=hidden value=". $users->kutya_id ." name=id><select name=ido><option value=1>1 napra</option><option value=2>2 napra</option><option value=3>5 napra</option><option value=4>10 napra</option></select> <input type=submit value=Mehet style='width:55px;'></form></td></tr>";

}
}
//majd anya-apa vizsgalat
$adat.=$moderator ."<tr><td align=left>Egészség:</td><td align=right><table><tr><td align=left width=180>". $szazalekok ."</td><td width=60 align=right>". $users->kutya_egeszseg ." %</td></tr></table></td></tr><tr><td align=left>Súly:</td><td align=right><table border=0><tr><td align=left  width=180>". $szazalekok2 ."</td><td width=60 align=right>". $users->kutya_suly ." %</td></tr></table></td></tr></table><center>".  $latogat ."<br>
</center><table border=0><tr><td><a href=uzenetek.php?page=uzenetir&uid=". $users->kutya_id ."><img src=pic/levelneki.jpg border=0></a></td><td><a href=uzenetek.php?page=penztkuld&uid=". $users->kutya_id ."><img src=pic/penzneki.jpg border=0></a></td><td>". $adatlap ."</td><td>". $blog ."</td><td><a href='inc/barat.php?nev=". $users->kutya_nev ."'><img src=pic/haver.jpg border=0></a></td></tr></table></td><td align=left>". $kuty->kep() ."</td></tr></table>". $falka ."<br>";
$i++;

}

if($feltetel=="" and $_GET[online]!=1){
if($oldal!=0){$adat.="<a href=kutyak.php?oldal=". ($oldal-10) ." class='feherlink'>Elõzõ 10 kutya</a>";}
if($oldal< mysql_num_rows($user)-10){$adat.=" <a href=kutyak.php?oldal=". ($oldal+10) ." class='feherlink'>Következõ 10 kutya</a>";}
}else{
if($_GET[id]>0){
$kieg="&id=". $_GET[id];}
if(isset($_GET[keres])){
$kieg="&keres=1&nem=". $_GET[nem] ."&fajta=". $_GET[fajta] ."&fagyaszt=". $_GET[fagyaszt] ."&falka=". $_GET[falka] ."&tol=". $_GET[tol] ."&ig=". $_GET[ig] ."&sulytol=". $_GET[sulytol] ."&sulyig=". $_GET[sulyig] ."&egtol=". $_GET[egtol] ."&egig=". $_GET[egig];}
if(isset($_GET[nev])){
$kieg="&nev=". $_GET[nev];}                                               
if(isset($_GET[ip])){
$kieg="&ip=". $_GET[ip] ."&hol=". $_GET[hol];}
if(isset($_GET[online])){
$kieg="&online=1";}
if($oldal!=0){$adat.="<a href=kutyak.php?oldal=". ($oldal-10) . $kieg ." class='feherlink'>Elõzõ 10 kutya</a>";}
if($oldal< mysql_num_rows($user)-10){$adat.=" <a href=kutyak.php?oldal=". ($oldal+10) . $kieg ." class='feherlink'>Következõ 10 kutya</a>";}

}

$adat.="</center>";
oldal($adat);
}else{header("Location: index.php");}
	?>
