<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[nev])){
if(isset($_GET[id])){
$leker=mysql_query("SELECT * FROM falka WHERE falka_id = '". $_GET[id] ."'");
$tagszam=mysql_query("SELECT * FROM kutya WHERE kutya_falka = '". $_GET[id] ."'");
$helyezes=mysql_query("SELECT * FROM falka ORDER BY falka_pont DESC");
$en=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
if(mysql_num_rows($leker)>0){
while($falka=mysql_fetch_object($leker)){
while($me=mysql_fetch_object($en)){
$vezerlopult="";
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$vezerlopult.='<script>
function confirmDeletem() {
  if (confirm("Biztos törölni szeretnéd ezt a falkát?")) {
    document.location = "inc/mftorol.php?id='. $falka->falka_id .'";
  }
}
</script>';
$vezerlopult.="<a href='javascript:confirmDeletem()' class='feherlink'>Falka Törlése</a><br><br>";
}
if($me->kutya_id==$falka->falka_vezeto){
$vezerlopult.='<script>
function confirmDelete() {
  if (confirm("Biztos törölni szeretnéd a falkát?")) {
    document.location = "inc/falkatorol.php";
  }
}
</script>';
$vezerlopult.="<br><a href=falkatop.php class='feherlink'>Falkatoplista</a><br><a href = \"javascript:void(0)\" onclick = \"info()\" class=\"feherlink\">Taglista</a><br><a href=falkaforum.php?id=". $falka->falka_id ." class='feherlink'>Falkafórum</a><br><a href=falkabealit.php class='feherlink'>Falka adminisztráció</a><br><a href=falkalevel.php><img src=pic/falkalevel.jpg border=0></a><br><br><a href='javascript:confirmDelete()' class='feherlink'>Falka megszüntetése</a>";
}elseif($me->kutya_id==$falka->falka_vezetohelyettes){
$jogok=explode('|',$falka->falka_jogok);
$vezerlopult.="<br><a href=falkatop.php class='feherlink'>Falkatoplista</a><br><a href = \"javascript:void(0)\" onclick = \"info()\" class=\"feherlink\">Taglista</a><br><a href=falkaforum.php?id=". $falka->falka_id ." class='feherlink'>Falkafórum</a>";
if(($jogok[2]==1 OR $jogok[3]==1) or ($jogok[2]==1 and $jogok[3]==1)){
$vezerlopult.="<br><a href=falkabealit.php class='feherlink'>Falka adminisztráció</a>";
}
if($jogok[1]==1){
$vezerlopult.="<br><a href=falkalevel.php><img src=pic/falkalevel.jpg border=0></a>";
}
$vezerlopult.="<br><br><a href=inc/lemond.php class='feherlink'>Lemondok a falkahelyettesi posztról</a>";
}elseif($me->kutya_falka==$falka->falka_id){
$vezerlopult.='<script>
function confirmDelete() {
  if (confirm("Biztos kilépsz a falkából?")) {
    document.location = "inc/falkakilep.php";
  }
}
</script>';
$vezerlopult.="<br><a href=falkatop.php class='feherlink'>Falkatoplista</a><br><a href = \"javascript:void(0)\" onclick = \"info()\" class=\"feherlink\">Taglista</a><br><a href=falkaforum.php?id=". $falka->falka_id ." class='feherlink'>Falkafórum</a><br><br><a href='javascript:confirmDelete()' class='feherlink'><img src=pic/falkakilep.jpg></a>";
}elseif($me->kutya_falka!=0){
$vezerlopult.="<a href = \"javascript:void(0)\" onclick = \"info()\" class=\"feherlink\">Taglista</a>";
}else{
$vezerlopult.="<a href = \"javascript:void(0)\" onclick = \"info()\" class=\"feherlink\">Taglista</a><br><br><a href=inc/falkabelep.php?id=". $falka->falka_id ." class='feherlink'><img src=pic/falkabelep.jpg></a>";
}

$fonok=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $falka->falka_vezeto ."'");
while($kutya=mysql_fetch_object($fonok)){
$i=0;
while($dumdum=mysql_fetch_object($helyezes)){
$i++;
if($dumdum->falka_id==$falka->falka_id){
break;
}
}
if($falka->falka_hatterszin!=""){
$hatter=" bgcolor=#". $falka->falka_hatterszin;
}
if($falka->falka_hatterkep!=""){
$hatter=" background=http://". $falka->falka_hatterkep;
}
if($kutya->kutya_betuszin=="774411"){
$nev1=htmlentities($kutya->kutya_nev);
}else{
$nev1="<font color=#". $kutya->kutya_betuszin ." >". htmlentities($kutya->kutya_nev) ."</font>";
}
if($falka->falka_vezetohelyettes==0){
$helyettes="<i>Nincs</i>";
}else{
$kellnev=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $falka->falka_vezetohelyettes ."'");
while($helyi=mysql_fetch_object($kellnev)){
if($helyi->kutya_betuszin=="774411"){
$helyettes="<a href=kutyak.php?id=". $helyi->kutya_id ." class='feherlink'>". htmlentities($helyi->kutya_nev) ."</a>";
}else{
$helyettes="<a href=kutyak.php?id=". $helyi->kutya_id ." class='feherlink'><font color=#". $helyi->kutya_betuszin ." >". htmlentities($helyi->kutya_nev) ."</font></a>";
}
}
}
if(file_exists("pic/falka/". $kutya->kutya_falka .".png")){
$kep="<img src=pic/falka/". $kutya->kutya_falka .".png?rnd=". rand(1000,9999) ." border=0 height=50 width=150>";
}else{
$kep="<img src=pic/falka/nopic.jpg border=0 width=150 height=50>";
}
$adat="<center><u><big>". falkaidtonev($falka->falka_id) ." <font color=#". $falka->falka_szin .">falka</font></big></u><br>";
$adat.="<style>
.black_overlay{
			display: none;
			position: absolute;
			top: 90px;
			left: 26%;
			width: 440px;
			height: 630px;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			top: 65px;
			left: 24%;
			width: 400px;
			height: 600px;
			padding: 6px;
			border: 11px solid #cc9866;
			background-image:url('pic/keret3.gif');
			z-index:1002;
			overflow: auto;
		}
</style>
<script>
function info()
{
if(document.getElementById(\"light\").style.display=='block'){
document.getElementById(\"light\").style.display='none';
document.getElementById(\"fade\").style.display='none';
}
else{
		document.getElementById(\"light\").style.display='block';
		document.getElementById(\"fade\").style.display='block';
}
}
</script>";
$tagok=mysql_query("SELECT * FROM kutya WHERE kutya_falka = '". $falka->falka_id ."'");
$tags="";
while($taglista=mysql_fetch_object($tagok))
{
$tags.="<tr><td><img src=pic/kutyak/". kutyaszamtofile($taglista->kutya_fajta) . $taglista->kutya_szin .".png width=30 heigth=20></td><td width=100>". idtonev($taglista->kutya_id) ."</td><td>". ($ma-$taglista->kutya_falkaido)/(24*3600) ." napja</td></tr>";
}
$adat.='<div id="fade" class="black_overlay"></div><div id="light" class="white_content"><p align=right><a href = "javascript:void(0)" onclick = "info()" class="feherlink">Bezár [x]</a></p><center><u>Taglista</u><table border=0>'. $tags .'</table></center>
</div>';
$adat.=$vezerlopult;
$adat.="<br><br><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=600></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center><table><tr><td align=center>". $kep ."</td><td><table><tr><td align=left>Pontszám:</td><td align=right width=150>". $falka->falka_pont ." pont(". mysql_num_rows($tagszam) ." fõ)</td><td align=left>Vezetõ:</td><td align=right width=120><a href=kutyak.php?id=". $kutya->kutya_id ." class='feherlink'>". $nev1 ."</a></td></tr><tr><td align=left>Helyezés:</td><td align=right>". $i ."</td><td align=left>Helyettes:</td><td align=right>". $helyettes ."</td></tr></table></td></tr></table>
</td></tr><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table>";
$dijjak=mysql_query("SELECT * FROM falkatop WHERE falkatop_1falkaid = '". $falka->falka_id ."' or falkatop_2falkaid = '". $falka->falka_id ."' or falkatop_3falkaid = '". $falka->falka_id ."'");
if(mysql_num_rows($dijjak)>0){ $big1="<big><big><big><big>"; $big2="</big></big></big></big>";
$elso=mysql_query("SELECT * FROM falkatop WHERE falkatop_1falkaid = '". $falka->falka_id ."'");
$masodik=mysql_query("SELECT * FROM falkatop WHERE falkatop_2falkaid = '". $falka->falka_id ."'");
$harmadik=mysql_query("SELECT * FROM falkatop WHERE falkatop_3falkaid = '". $falka->falka_id ."'");
$adat.="<br>Díjak:<table border=0><tr><td><img src=pic/gold_medal.png></td><td>". $big1 ."X". $big2 ."</td><td><big>". $big1 . mysql_num_rows($elso) . $big2 ."</big></td>
<td><img src=pic/silver_medal.png></td><td>". $big1 ."X". $big2 ."</td><td><big>". $big1 . mysql_num_rows($masodik) . $big2 ."</big></td>
<td><img src=pic/bronze_medal.png></td><td>". $big1 ."X". $big2 ."</td><td><big>". $big1 . mysql_num_rows($harmadik) . $big2 ."</big></td>
</tr></table>";
}
$adat.="<br><table border=0><tr><td align=center>Leirás:</td></tr><tr><td align=left width=1000 height=200 ". $hatter .">". nl2br(ubb_adatlap($falka->falka_leiras))  ."</td></tr></table></center>";

}}}

}else{
$adat=hiba("<center><br><br><br><big><big>Nincs ilyen falka!</big></big></center>");
}
}else{
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_falka==0){
$adat="<center><big><u>Falka</u></big><br>". $_SESSION[hiba] ."<br>Te még nem vagy egy falka tagja sem. Döntsd el mit szeretnél tenni:<br><br>
<table><tr><td><img src=pic/falkatop.png><a href=falkatop.php class='feherlink'></td><td><big><big><big><a href=falkatop.php class='feherlink'>Megnézem a falka toplistát</a></big></big></big></td></tr>
<tr><td><img src=pic/falkakeres.png></td><td><big><big><big><a href=falkakeres.php class='feherlink'>Keresek a falkák között</a></big></big></big></td></tr>
<tr><td><img src=pic/falkauj.png></td><td><big><big><big><a href=falkaalapit.php class='feherlink'>Alapítok egy sajátot</a></big></big></big></td></tr></table><br><br>". banner() ."</center>";
$_SESSION[hiba]="";
}else{
header("Location: falka.php?id=". $kutya->kutya_falka);
}
}
}
oldal($adat);
}else{header("Location: index.php");}
	?>
