<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[nev])){
if(isset($_GET[page])){
$szin="hatter8.gif";
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$modmenu="<td align=center background=pic/". $szin ." width=80>Hírdetõ</td><td background=pic/". $szin ."></td>";
}
$adat="<center><big><big><u>Üzenõfal</u></big></big><br><br><table border=0 cellpadding=0 cellspacing=0><tr><td align=center background=pic/". $szin .">Idõ</td><td align=center width=480 background=pic/". $szin .">Üzenet</td><td align=center background=pic/". $szin .">Kattintás</td>". $modmenu ."</tr>";
$lekeres=mysql_query("SELECT * FROM uzenofal INNER JOIN kutya ON uzenofal.uzenofal_kid = kutya.kutya_id ORDER BY uzenofal_id DESC LIMIT 20");
while($uzenetek=mysql_fetch_object($lekeres)){
if($szin=="hatter8.gif"){
$szin="keret3.gif";
}else{
$szin="hatter8.gif";
}
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
if($uzenetek->kutya_betuszin=="774411"){
$neve=htmlentities($uzenetek->kutya_nev);
}else{
$neve="<font color=#". $uzenetek->kutya_betuszin .">". htmlentities($uzenetek->kutya_nev) ."</font>";
}
$mod="<td align=center background=pic/". $szin ."><a href=kutyak.php?id=". $uzenetek->uzenofal_kid ." class='feherlink'>". $neve ."</a></td><td align=center background=pic/". $szin ." ><a href=inc/uzenotorol.php?id=". $uzenetek->uzenofal_id ." class='feherlink'><img src=pic/kuka.png border=0></a></td>";
}

$szoveg=htmlentities($uzenetek->uzenofal_uzenet);
$szoveg=str_replace(":s:","<img src=pic/barat.gif style='vertical-align: text-bottom;'>",$szoveg);
$szoveg=str_replace(":l:","<img src=pic/letter.gif style='vertical-align: text-bottom;'>",$szoveg);
$szoveg=str_replace(":p:","<img src=pic/money.gif style='vertical-align: text-bottom;'>",$szoveg);
$szoveg=str_replace(":f:","<img src=pic/falka.gif style='vertical-align: text-bottom;'>",$szoveg);
$szoveg=str_replace(":c:","<img src=pic/mod3.gif style='vertical-align: text-bottom;'>",$szoveg);
if($uzenetek->uzenofal_szin!=774411){
$uzenet="<font color=#". $uzenetek->uzenofal_szin .">". $szoveg ."</font>";
}else{
$uzenet=$szoveg;
}
if($uzenetek->uzenofal_tipus!=6){
$uzenet="<a href=kattint.php?id=". $uzenetek->uzenofal_id ." class='feherlink'>". $uzenet ."</a>";
}

$adat.="<tr><td align=left background=pic/". $szin .">". str_replace("-",".",$uzenetek->uzenofal_ido) ."</td><td background=pic/". $szin .">". $uzenet ."</td><td align=center background=pic/". $szin .">". $uzenetek->uzenofal_klik ."</td>". $mod ."</tr>";
}
$adat.="</table>";
}else{
$blogok="";
$blogle=mysql_query("SELECT * FROM blog WHERE blog_kutya= '". $_SESSION[id] ."' order by blog_id desc");
while($blogs=mysql_fetch_object($blogle))
{
 $blogok.="<option value=".$blogs->blog_id.">".$blogs->blog_cim."</option>";

}

$adat='<script src="script/uzenofal.js"></script>';
$adat.="<center><big><big><u>Üzenõfal</u></big></big><br><br>Szeretnél valamit megosztani mindenkivel? Írj az üzenõfalra, az egész ". $SITENAME ." olvashatja, amit szeretnél,
 az üzeneted mutathat a kutyádra, az adatlapodra, a falkádra vagy akár a blogodra. És csupán <u>". penz($UZENOFAL) ."</u> az ára.<br>A legutóbbi 20 üzenet jelenik meg. <a href=uzenofal.php?page=utolso20 class='feherlink'>Itt nézheted meg õket!</a><br><br>
 <table><tr><td align=left colspan=2><form action=inc/uzi.php method=POST>Üzeneted adatai:</td></tr><tr><td align=left valign=top>Az üzenetem mutasson:</td><td>
 <table border=0><tr><td><input type=radio name=hova value=1 style='width:20px;'></td><td align=left>A kutyámra</td></tr>
 <tr><td><input type=radio name=hova value=2 style='width:20px;'></td><td align=left>Az adatlapomra</td></tr>
 <tr><td><input type=radio name=hova value=3 style='width:20px;'></td><td align=left>A blogomra: <select name=blog style='width:180px;'><option value=0>Blogom fõoldala</option>". $blogok ."</select></td></tr>
 <tr><td><input type=radio name=hova value=4 style='width:20px;'></td><td align=left>A falkámra</td></tr>
<tr><td><input type=radio name=hova value=5 style='width:20px;'></td><td align=left>Egy weboldalra, aminek a címe: http:\\\ <input type=text name=honlap></td></tr>
 <tr><td><input type=radio name=hova value=6 style='width:20px;'></td><td align=left>A végtelen semmibe</td></tr>
 </table> </td></tr><tr><td align=left>Üzeneted színe(+". penz($UZENOFAL_SZINES) ."):</td><td align=left>
 <select name=szin>
<option value=0>Nem szinezek</option>
<option value=9 style='color: #800000'>Vörös</option>
<option value=8 style='color: #C90000'>Piros</option>
<option value=34 style='color: #FF0000'>Világos Piros</option>
<option value=7 style='color: #DC143C'>Kárminvörös</option>
<option value=6 style='color: #FF4500'>Narancssárga</option>
<option value=3 style='color: #FF8C00'>Világos Narancssárga</option>
<option value=33 style='color: #D2691E'>Csokoládé</option>
<option value=5 style='color: #FF6347'>Paradicsomszín</option>
<option value=22 style='color: #FF69B4'>HotPink</option>
<option value=23 style='color: #F08080'>LightCoral</option>
<option value=2 style='color: #FFD700'>Arany</option>
<option value=4 style='color: #DAA520'>Sötét Arany</option>
<option value=10 style='color: #9ACD32'>SárgaZöld</option>
<option value=31 style='color: #32CD32'>Lime Zöld</option>
<option value=11 style='color: #6B8E23'>Oliva Zöld</option>
<option value=12 style='color: #008000'>Zöld</option>
<option value=13 style='color: #006400'>Sötét Zöld</option>
<option value=14 style='color: #3CB371'>Tenger Zöld</option>
<option value=20 style='color: #008B8B'>Sötét Cián</option>
<option value=15 style='color: #66CDAA'>Akvarmin</option>
<option value=32 style='color: #00FFFF'>Aqua</option>
<option value=17 style='color: #6495ED'>BúzaVirág</option>
<option value=18 style='color: #4682B4'>Acélkék</option>
<option value=16 style='color: #1E90FF'>DodgerKék</option>
<option value=19 style='color: #305DDB'>Kék</option>
<option value=21 style='color: #9370DB'>Közepes Lila</option>
<option value=24 style='color: #6D3AC4'>Lila</option>
<option value=30 style='color: #483D8B'>Pala Szín</option> 
<option value=27 style='color: #4B0082'>Indigó</option>
<option value=26 style='color: #8B008B'>Sötét Magenta</option>
<option value=25 style='color: #BA55D3'>Orchidea</option>
<option value=28 style='color: #774411'>Barna</option>
<option value=1 style='color: #696969'>Szürke</option>
<option value=29 style='color: #000000'>Fekete</option>
</select></td></tr>
<tr><td align=left>Jelek az üzenetedbe:</td><td><img src=pic/barat.gif onclick=UzenetHozzafuz('s')> <img src=pic/letter.gif onclick=UzenetHozzafuz('l')> <img src=pic/money.gif onclick=UzenetHozzafuz('p')> <img src=pic/falka.gif onclick=UzenetHozzafuz('f')> <img src=pic/mod3.gif onclick=UzenetHozzafuz('c')></td></tr>
<tr><td align=left>Üzeneted (max. 70 karakter):</td><td><input type=text name=uzenet style='width:500px;' maxlength=70 id='uzenet'></td></tr>
<tr><td align=left></td><td align=left><input type=submit value='Elküld'></form></td></tr>
<tr><td colspan=2 align=center>". $_SESSION[hiba] ."</td></tr></table>";
$_SESSION[hiba]="";
}
$adat.="</center>";
oldal($adat);
}else{
header("Location: index.php");
}
?>
