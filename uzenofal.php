<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[nev])){
if(isset($_GET[page])){
$szin="hatter8.gif";
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$modmenu="<td align=center background=pic/". $szin ." width=80>H�rdet�</td><td background=pic/". $szin ."></td>";
}
$adat="<center><big><big><u>�zen�fal</u></big></big><br><br><table border=0 cellpadding=0 cellspacing=0><tr><td align=center background=pic/". $szin .">Id�</td><td align=center width=480 background=pic/". $szin .">�zenet</td><td align=center background=pic/". $szin .">Kattint�s</td>". $modmenu ."</tr>";
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
$adat.="<center><big><big><u>�zen�fal</u></big></big><br><br>Szeretn�l valamit megosztani mindenkivel? �rj az �zen�falra, az eg�sz ". $SITENAME ." olvashatja, amit szeretn�l,
 az �zeneted mutathat a kuty�dra, az adatlapodra, a falk�dra vagy ak�r a blogodra. �s csup�n <u>". penz($UZENOFAL) ."</u> az �ra.<br>A legut�bbi 20 �zenet jelenik meg. <a href=uzenofal.php?page=utolso20 class='feherlink'>Itt n�zheted meg �ket!</a><br><br>
 <table><tr><td align=left colspan=2><form action=inc/uzi.php method=POST>�zeneted adatai:</td></tr><tr><td align=left valign=top>Az �zenetem mutasson:</td><td>
 <table border=0><tr><td><input type=radio name=hova value=1 style='width:20px;'></td><td align=left>A kuty�mra</td></tr>
 <tr><td><input type=radio name=hova value=2 style='width:20px;'></td><td align=left>Az adatlapomra</td></tr>
 <tr><td><input type=radio name=hova value=3 style='width:20px;'></td><td align=left>A blogomra: <select name=blog style='width:180px;'><option value=0>Blogom f�oldala</option>". $blogok ."</select></td></tr>
 <tr><td><input type=radio name=hova value=4 style='width:20px;'></td><td align=left>A falk�mra</td></tr>
<tr><td><input type=radio name=hova value=5 style='width:20px;'></td><td align=left>Egy weboldalra, aminek a c�me: http:\\\ <input type=text name=honlap></td></tr>
 <tr><td><input type=radio name=hova value=6 style='width:20px;'></td><td align=left>A v�gtelen semmibe</td></tr>
 </table> </td></tr><tr><td align=left>�zeneted sz�ne(+". penz($UZENOFAL_SZINES) ."):</td><td align=left>
 <select name=szin>
<option value=0>Nem szinezek</option>
<option value=9 style='color: #800000'>V�r�s</option>
<option value=8 style='color: #C90000'>Piros</option>
<option value=34 style='color: #FF0000'>Vil�gos Piros</option>
<option value=7 style='color: #DC143C'>K�rminv�r�s</option>
<option value=6 style='color: #FF4500'>Narancss�rga</option>
<option value=3 style='color: #FF8C00'>Vil�gos Narancss�rga</option>
<option value=33 style='color: #D2691E'>Csokol�d�</option>
<option value=5 style='color: #FF6347'>Paradicsomsz�n</option>
<option value=22 style='color: #FF69B4'>HotPink</option>
<option value=23 style='color: #F08080'>LightCoral</option>
<option value=2 style='color: #FFD700'>Arany</option>
<option value=4 style='color: #DAA520'>S�t�t Arany</option>
<option value=10 style='color: #9ACD32'>S�rgaZ�ld</option>
<option value=31 style='color: #32CD32'>Lime Z�ld</option>
<option value=11 style='color: #6B8E23'>Oliva Z�ld</option>
<option value=12 style='color: #008000'>Z�ld</option>
<option value=13 style='color: #006400'>S�t�t Z�ld</option>
<option value=14 style='color: #3CB371'>Tenger Z�ld</option>
<option value=20 style='color: #008B8B'>S�t�t Ci�n</option>
<option value=15 style='color: #66CDAA'>Akvarmin</option>
<option value=32 style='color: #00FFFF'>Aqua</option>
<option value=17 style='color: #6495ED'>B�zaVir�g</option>
<option value=18 style='color: #4682B4'>Ac�lk�k</option>
<option value=16 style='color: #1E90FF'>DodgerK�k</option>
<option value=19 style='color: #305DDB'>K�k</option>
<option value=21 style='color: #9370DB'>K�zepes Lila</option>
<option value=24 style='color: #6D3AC4'>Lila</option>
<option value=30 style='color: #483D8B'>Pala Sz�n</option> 
<option value=27 style='color: #4B0082'>Indig�</option>
<option value=26 style='color: #8B008B'>S�t�t Magenta</option>
<option value=25 style='color: #BA55D3'>Orchidea</option>
<option value=28 style='color: #774411'>Barna</option>
<option value=1 style='color: #696969'>Sz�rke</option>
<option value=29 style='color: #000000'>Fekete</option>
</select></td></tr>
<tr><td align=left>Jelek az �zenetedbe:</td><td><img src=pic/barat.gif onclick=UzenetHozzafuz('s')> <img src=pic/letter.gif onclick=UzenetHozzafuz('l')> <img src=pic/money.gif onclick=UzenetHozzafuz('p')> <img src=pic/falka.gif onclick=UzenetHozzafuz('f')> <img src=pic/mod3.gif onclick=UzenetHozzafuz('c')></td></tr>
<tr><td align=left>�zeneted (max. 70 karakter):</td><td><input type=text name=uzenet style='width:500px;' maxlength=70 id='uzenet'></td></tr>
<tr><td align=left></td><td align=left><input type=submit value='Elk�ld'></form></td></tr>
<tr><td colspan=2 align=center>". $_SESSION[hiba] ."</td></tr></table>";
$_SESSION[hiba]="";
}
$adat.="</center>";
oldal($adat);
}else{
header("Location: index.php");
}
?>
