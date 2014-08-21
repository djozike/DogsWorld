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
<br><center><big><big><b>Falka körlevél írás</b></big></big></center><br>
<center><table><tr><td>
<table border=0><tr><td align=left>Feladó:<td align=right>". htmlentities($_SESSION[nev]) ."</tr><tr><td align=left>Címzett:</td><td align=right>". $falka->falka_nev ." falka</tr></table>
</td><td width=15></td><td width=300><b>Figyelem!</b> Az üzenetben használhatod a következõ UBB kódokat is!<br>[center]...[/center] - középre igazítás<br>[img]kép link[/img] - kép beszurás<br>[color=szín]...[/color] - szöveg színezés</td></tr></table><br>Üzeneted:<br><TEXTAREA name='uzenet' cols=50 rows=12></TEXTAREA><br><br><input type=submit name=Elkuld value=Küldés></form>". $_SESSION[hiba] ."</center><br>
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
