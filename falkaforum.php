<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutya=mysql_fetch_object($leker)){
if($kutya->kutya_falka!=0){
$leker2=mysql_query("SELECT * FROM falka WHERE falka_id = '". $kutya->kutya_falka ."'");
while($falka=mysql_fetch_object($leker2)){
$fonok=$falka->falka_vezeto;
$kisfonok=$falka->falka_vezetohelyettes;
$jogok=explode('|',$falka->falka_jogok);
$adat="<center><big><u>Falkafórum</u></big><br><br>";
if($falka->falka_kepvideo==1){
$adat.="Erre a fórumra szúrhatsz be képet és videót.";
}else{
$adat.="Erre a fórumra nem tudsz képet és videót beszúrni.";
}
$adat.="<br><br><form method=POST action=inc/fforum.php><input type=hidden name=topic value=". $falka->falka_id .">Üzeneted:<br><textarea name=uzenet cols=50 rows=6></textarea><br><input type=submit value=Elküld></form><br><br>";
if($_GET[oldal]>0){
$oldal=$_GET[oldal];
}else{ $oldal=0; }
$leker=mysql_query("SELECT * FROM forum INNER JOIN kutya ON forum.forum_kid = kutya.kutya_id WHERE forum_topic = '". $falka->falka_id ."' ORDER BY forum_id DESC limit ". $oldal .",25");
while($forum=mysql_fetch_object($leker)){
$forumozoKutya = new kutya();
$forumozoKutya->getKutyaByID($forum->forum_kid);
if(($fonok==$_SESSION[id]) or ($kisfonok==$_SESSION[id])){
if($fonok==$_SESSION[id]){
$admin="<a href=inc/uzenettorol.php?uid=". $forum->forum_id ." class='feherlink'>üzenet törlése</a> | <a href='inc/falkatilto.php?nev=". $forum->kutya_nev  ."' class='feherlink'>kutya kitiltása</a> | ";
}elseif($kisfonok==$_SESSION[id]){
$admin="";
if($jogok[0]==1){
$admin.="<a href=inc/uzenettorol.php?uid=". $forum->forum_id ." class='feherlink'>üzenet törlése</a> | ";
}
if($jogok[2]==1){
$admin.="<a href='inc/falkatilto.php?nev=". $forum->kutya_nev ."' class='feherlink'>kutya kitiltása</a> | ";
}
}else{}
}else{
$admin="";
}
$adat.="<table border=0 width=750 CELLSPACING=0 CELLPADDING=0><tr bgcolor=#e6ba8e><td align=left class='forum' colspan=2>
<table border=0 width=750 CELLSPACING=0 CELLPADDING=0><tr><td align=left><a href=kutyak.php?id=". $forum->forum_kid ." class='feherlink'>". $forum->forum_nev ."</a></td><td align=right>". $admin ."". str_replace("-",".",$forum->forum_ido) ."</td></tr></table></td></tr>
<tr><td bgcolor=#e6ba8e align=center height=105 valign=top width=110><center>". $forumozoKutya->Avatar(100) ." </center></td><td align=left valign=top width=640 class='forum'>". nl2br($forum->forum_uzenet) ."</td></tr></table><br>";
}
$hozzaszolasszam=mysql_query("SELECT * FROM forum WHERE forum_topic = '". $falka->falka_id ."'");
if($oldal!=0){$adat.="<a href=falkaforum.php?id=". $falka->falka_id ."&oldal=". ($oldal-25) ." class='feherlink'>Elõzõ 25 hozzászolás</a>";}
if($oldal< mysql_num_rows($hozzaszolasszam)-25){$adat.=" <a href=falkaforum.php?id,=". $falka->falka_id ."&oldal=". ($oldal+25) ." class='feherlink'>Következõ 25 hozzászolás</a>";}

$adat.="</center>";
oldal($adat);
}
}else{
header("Location: ../kutyam.php");
}
}
}else{
header("Location: ../index.php");
}
?>
