<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[id])){
$lekeres=mysql_query("SELECT * FROM adatlap WHERE adatlap_id = '". $_SESSION[id] ."'");
$lekeres2=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
while($kutyam=mysql_fetch_object($lekeres2)){
$mailom=$kutyam->kutya_email;
if($kutyam->kutya_falkakorlevel==1){
$falkakorlevel="";
}else{
$falkakorlevel="checked";
}}
if(mysql_num_rows($lekeres)>0){
while($allapote=mysql_fetch_object($lekeres)){
$nev1=$allapote->adatlap_nev;
$lakhely=$allapote->adatlap_lakhely;
$leiras=$allapote->adatlap_leiras;
$sulys=$allapote->adatlap_suly;
$magassags=$allapote->adatlap_magassag;
$hajs=$allapote->adatlap_haj;
$szems=$allapote->adatlap_szem;
$tomb=explode("-",$allapote->adatlap_szulido);
$ev1=$tomb[0];
$honap1=$tomb[1];
$nap1=$tomb[2];
$hatterk=$allapote->adatlap_hatter;
if($allapote->adatlap_nem==1){$lany="selected";$fiu="";}else{$lany="";$fiu="selected";}
if($allapote->adatlap_aktiv==0){
$allapot=hiba("Inakt�v  <a href=inc/adatlap.php?aktiv=1 class='feherlink'>Aktiv�l</a>");
}else{
$allapot=ok("Akt�v <a href=inc/adatlap.php?aktiv=0 class='feherlink'>Inaktiv�l</a>");
}
}
}else{
$allapot=hiba("Inakt�v");
$nev1="";$magassags=1;$hajs=1;
$lakhely="";$sulys=1;$szems=1; $nap1=1;
$leiras="";$fiu="";$lany=""; $ev1=1996; $honap1=1;
}



$ev="<select name=ev style='width:50px;'>";
for($i=1914; $i<2011; $i++){
if($i==$ev1){
$ev.="<option value=". $i ." selected>". $i ."</option>";
}else{
$ev.="<option value=". $i .">". $i ."</option>";
}}
$ev.="</select>";
$nap="<select name=nap style='width:30px;'>";
for($i=1; $i<32; $i++){
if($i==$nap1){
$nap.="<option value=". $i ." selected>". $i ."</option>";
}else{
$nap.="<option value=". $i .">". $i ."</option>";
}}
$nap.="</select>";
$honap="<select name=honap style='width:33px;'>";
for($i=1; $i<13; $i++){
if($i==$honap1){
$honap.="<option value=". $i ." selected>". $i ."</option>";
}else{
$honap.="<option value=". $i .">". $i ."</option>";
}}
$honap.="</select>";
$suly="<select name=suly>";
for($i=1; $i<19; $i++){
if($i==$sulys){
$suly.="<option value=". $i ." selected>". szamtosuly($i) ."</option>";
}else{
$suly.="<option value=". $i .">". szamtosuly($i) ."</option>";
}}
$suly.="</select>";
$magassag="<select name=magassag>";
for($i=1; $i<13; $i++){
if($i==$magassags){
$magassag.="<option value=". $i ." selected>". szamtomagassag($i) ."</option>";
}else{
$magassag.="<option value=". $i .">". szamtomagassag($i) ."</option>";
}}
$magassag.="</select>";
$hajszin="<select name=hajszin>";
for($i=1; $i<8; $i++){
if($i==$hajs){
$hajszin.="<option value=". $i ." selected>". szamtohajszin($i) ."</option>";
}else{
$hajszin.="<option value=". $i .">". szamtohajszin($i) ."</option>";
}}
$hajszin.="</select>";
$szemszin="<select name=szemszin>";
for($i=1; $i<7; $i++){
if($i==$szems){
$szemszin.="<option value=". $i ." selected>". szamtoszemszin($i) ."</option>";
}else{
$szemszin.="<option value=". $i .">". szamtoszemszin($i) ."</option>";
}}
$szemszin.="</select>";
$hatterszin="<select name=hatterszin>";
function hatterszin($szin){
switch($szin){
case 2:
$betu="Vil�gosk�k";
break;
case 3:
$betu="R�zsasz�n";
break;
default:
$betu="Feh�r";
break;
}
return $betu;
}
for($i=1; $i<4; $i++){
if($i==$hatterk){
$hatterszin.="<option value=". $i ." selected>". hatterszin($i) ."</option>";
}else{
$hatterszin.="<option value=". $i .">". hatterszin($i) ."</option>";
}
}
$hatterszin.="</select>";
if(file_exists("pic/user/". $_SESSION[id] .".png")){
$kep="<td colspan=2 align=center><a href=pic/user/". $_SESSION[id] .".png target=_blank><img src=pic.php?id=". $_SESSION[id] ." border=0></a><br><a href=inc/keptorol.php class='feherlink'>K�p t�rl�se</a></td>";
}else{
$kep="<th colspan=2 align=center><img src=pic/user/avatar.jpg border=0 width=200 height=200></th>";
}


$adat="<center><big><u>Be�ll�t�sok</u></big><br>". $_SESSION[hiba] ."<br><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
<tr><td background=pic/hatter8.gif colspan=3 align=center><i>Jelsz� m�dos�t�s</i><br><br><form action=inc/bealit.php method=POST><table><tr>
<td align=left>Jelenlegi jelsz�:</td><td align=right><input type=password name=oldpass></td><td></td><tr><td  align=left>�j jelsz�:</td><td><input type=password name=newpass1></td><td><small>min 4, max 16 karakter</small></td></tr><tr><td align=left>�j jelsz� �jra:</td><td align=right><input type=password name=newpass2></td><td><small>min 4, max 16 karakter</small></td></tr>
<tr><td align=left></td><td align=right></td><td><input type=submit name=elkuld value='Megv�ltoztat'></td></tr></table></form><br><i>E-mail c�m m�dos�t�s</i><br><br>
Jelenlegi E-mail c�med: ". $mailom ."<br><form action=inc/bealit.php method=POST><table><tr>
<td align=left>�j E-mail c�m:</td><td align=right><input type=text name=mail1></td><td><small>max 40 karakter</small></td><tr><td  align=left>�j E-mail c�m �jra:</td><td><input type=text name=mail2></td><td><small>max 40 karakter</small></td></tr><tr><td align=left></td><td align=right><input type=submit name=elkuld value='Megv�ltoztat'></td><td></td></tr>
</table></form><br><table border=0><form action=inc/bealit.php method=POST><tr><td><input type=checkbox name=falkakorlevel style='width:30px;' ". $falkakorlevel ."></td><td>Falka k�rlev�l megjelen�t�se a bej�v� levelek k�z�tt</td></tr><tr><td align=center colspan=2><input type=submit name=elkuld value='Mehet'></td></tr></table></form>
</td><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></tr></table><br><u>Csont�rt v�s�rolhat� szolg�ltat�sok</u><br><br>

<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr><tr><td background=pic/hatter8.gif colspan=3 align=center>
<i>Sz�nes n�v</i><br><br>Megv�ltoztathatod a kuty�d nev�nek a sz�n�t. Az �ra ". penz($SZINESNEV) .".<br><table><tr><td>Sz�n:</td><td><form action=inc/bealit.php method=POST><select name=szin id='nevszin' onchange=". '"' ."SzinElonezet('". $_SESSION[nev] ."')". '"' . ">
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

<spam id='elonezet'></spam><br>



<i>Gondoz�s seg�t�k</i><br><br>". penz($TURBO) ."�rt n�velheted az eg�szs�g�t �s cs�kkentheted a s�ly�t.<br><table><tr><td><form action=inc/bealit.php method=POST><select name=cucc><option value=1>100% Eg�szs�g</option><option value=2>10% S�ly</option></select></td><td><input type=submit value=Elk�ld></form></td></tr></table>
</td><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></tr></table><br><u>Adatlap</u><br><br>
<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr><tr><td background=pic/hatter8.gif colspan=3 align=center>
Jelenleg adatlapod: ". $allapot ."<br> Ahhoz hogy az adatlapod akt�v legyen minden mez�t ki kell<br> t�ltened. A be�rt adatok mindenki sz�m�ra l�that�ak.<br><table border=0>
<tr><td align=left>N�v:</td><td align=right><form method=POST action=inc/adatlap.php><input type=text name=nev value='". $nev1 ."' maxlength=24></td><td align=left><small>min 3, max 24 karakter</small></td></tr>
<tr><td align=left>Nem:</td><td align=right><select name=nem><option value=1 ". $lany .">L�ny</option><option value=2 ". $fiu .">Fi�</option></select></td><td align=left></td></tr>
<tr><td align=left>Lakhely:</td><td align=right><input type=text name=lakhely value='". $lakhely ."' maxlength=32></td><td align=left><small>min 2, max 32 karakter</small></td></tr>
<tr><td align=left>Sz�let�si id�:</td><td align=right>". $ev ."&nbsp;". $honap ."&nbsp;". $nap ."</td><td align=left></td></tr>
<tr><td align=left>Tests�ly:</td><td align=right>". $suly ."</td><td align=left></td></tr>
<tr><td align=left>Testmagass�g:</td><td align=right>". $magassag ."</td><td align=left></td></tr>
<tr><td align=left>Hajsz�n:</td><td align=right>". $hajszin ."</td><td align=left></td></tr>
<tr><td align=left>Szemsz�n:</td><td align=right>". $szemszin ."</td><td align=left></td></tr>
<tr><td align=left>H�tt�rsz�n:</td><td align=right>". $hatterszin ."</td><td align=left></td></tr>
<tr><td align=center colspan=3>Le�r�s:</td></tr>
<tr><td align=center colspan=3><textarea name=leiras cols=50 rows=12>". $leiras ."</textarea></td></tr>
<tr><td align=center colspan=3><input type=submit value=Elk�ld></form></td></tr>
</table></td><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></tr></table><br><u>K�pfelt�lt�s</u><br><br>

<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr><tr><td background=pic/hatter8.gif colspan=3 align=center><p style='text-align:justify;'>
Maximum 256 kilobyte m�ret� illetve JPG, PNG vagy GIF<br> form�tum� f�jlt t�lthetsz fel! A felt�lt�tt k�pek a<br> ". $SITENAME ." tulajdon�t k�pezik, �gy azt b�rmikor a felt�lt�<br> enged�lye n�lk�l t�r�lheti vagy felhaszn�lhatja!</p>
<table border=0><tr><td align=center width=300 colspan=2>F� k�p:</td></tr>
<tr>". $kep ."</tr>
<tr><td><form enctype='multipart/form-data' action='inc/profilepic.php' method='POST'><input name='upload_img' type='file' size=10></td><td><input type='submit' value='OK' style='width:60px;'></form></td></tr>
</table>
</td><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif width=450></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></tr></table></center>";
$adat.='<script src="script/beallitas.js"></script>';
$_SESSION[hiba]="";
oldal($adat);
}else{header("Location: index.php");}
	?>