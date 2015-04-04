<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
include("inc/stilus.php");
if(isset($_SESSION[id])){

$leker=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $_SESSION[id] ."'");
if(substr_count($leker->kutya_tanul,"VE")==0){

$adat="<center><big><u>Kvízelés</u></big><br><br>
A játék célja, hogy minél több kérdésre helyesen válaszolj. 90 másodperced van az indítástól számítva, hogy helyes választ adj, hibás válasz esetén 5 másodperc idõbüntetést kapsz. Minden nap a legtöbb helyes választ megadó 2 csont jutalomba részesül.
<br><br>
<script src=\"script/kviz.js\"></script>

<table><tr><td width=250><div id='ido'></div></td><td width=250><div id='pont' align=right></div></td></tr></table>
". VilagosMenu(500, "<div id='kerdes'><input type=submit value=\"Kezdés\" onclick=\"elkezd()\"></div>") ."
<div id='jatek' style='display:none;'>
<table>
<tr><td width=250 align=center>". VilagosMenu(200, "<div id='valasz1' onclick='valaszol(1)'></div>") ."</td><td width=250 align=center>". VilagosMenu(200, "<div id='valasz2' onclick='valaszol(2)'></div>") ."</td></tr>
<tr><td width=250 align=center>". VilagosMenu(200, "<div id='valasz3' onclick='valaszol(3)'></div>") ."</div></td><td width=250 align=center>". VilagosMenu(200, "<div id='valasz4' onclick='valaszol(4)'></div>") ."</div></td></tr>
</table>


</div>

<br><u><big>Mai Top10</big></u><br><table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td>
<table><tr><th>#</th><th align=center width=150>Név</th><th align=right width=150>Legtöbb pont</th></tr><div id='eredmenyek'>";
$pontlista=mysql_query("SELECT * FROM `kvizeredmeny` ORDER BY kvizeredmeny_pont  desc limit 0, 10",$kapcsolat);
$i=1;
while($pontok=mysql_fetch_object($pontlista))
{
$kuty=new kutya();
$kuty->GetKutyaByID($pontok->kvizeredmeny_kutyaid);
$adat.="<tr><th>". $i."</th><th align=center width=150>". $kuty->NevMegjelenitRanggalLinkelve() ."</th><th align=right width=150>". $pontok->kvizeredmeny_pont ." pont</th></tr>";
$i++;
}

$adat.="</div></table>
</td><td width=11 background=pic/keret.jpg></td></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table></center>


</center>";

oldal($adat);
}else{
header("Location: index.php");
}
}else{
header("Location: index.php");
}
?>
