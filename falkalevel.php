<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[id])){
$leker=mysql_query("SELECT * FROM falka WHERE falka_vezeto = '". $_SESSION[id] ."' or falka_vezetohelyettes = '". $_SESSION[id] ."'");
if(mysql_num_rows($leker)>0){
while($falka=mysql_fetch_object($leker)){
$jogok=explode('|',$falka->falka_jogok);
if(($falka->falka_vezeto == $_SESSION[id]) or ($falka->falka_vezetohelyettes ==  $_SESSION[id] and $jogok[1]==1)){
$adat="<form method=POST action=inc/flevelez.php><center><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td align=left width=580>
<br><center><big><big><b>Falka k�rlev�l �r�s</b></big></big></center><br>
<center><table><tr><td>
<table border=0><tr><td align=left>Felad�:<td align=right>". htmlentities($_SESSION[nev]) ."</tr><tr><td align=left>C�mzett:</td><td align=right>". $falka->falka_nev ." falka</tr></table>
</td><td width=15></td><td width=300><b>Figyelem!</b> Az �zenetben haszn�lhatod a k�vetkez� UBB k�dokat is!<br>[center]...[/center] - k�z�pre igaz�t�s<br>[img]k�p link[/img] - k�p beszur�s<br>[color=sz�n]...[/color] - sz�veg sz�nez�s</td></tr></table><br>�zeneted:<br><TEXTAREA name='uzenet' cols=50 rows=12></TEXTAREA><br><br><input type=submit name=Elkuld value=K�ld�s></form>". $_SESSION[hiba] ."</center><br>
</td><th width=11 background=pic/keret.jpg></th></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th width=11 background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table></center>";
$_SESSION[hiba]="";
}

}
oldal($adat);
}else{
header("Location: index.php");
}
}else{
header("Location: index.php");
}
?>
