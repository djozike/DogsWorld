<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/oop.php");
include("inc/stilus.php");
if(isset($_SESSION[id])){
$adat="<center><big><u>Bar�tlista</u></big>
<br><br>Ha valakivel j�ban vagy vedd fel a bar�tlist�dra �s k�nnyed�n �szre veheted ha �ppen online,<br> vagy l�thatod mikor volt itt utolj�ra.<br><br><u>�j bar�t felv�tele</u>
". VilagosMenu(300,"<table border=0><tr><td>N�v:</td><td><form action=inc/barat.php method=GET><input type=text name=nev></td><td><input type=submit value=Elk�ld></form></td></tr></table>")."<br>";
$adat.=$_SESSION[hiba];
$_SESSION[hiba]="";
$kutya=new kutya();
if($kutya->GetKutyaByID($_SESSION[id])){
if(sizeof($kutya->baratok)>0){
$adat.="<table border=0 cellspacing='0' cellpadding='0'><tr background=pic/hatter8.gif><th width=5></th><th align=center width=330>N�v</th><th></th><th></th><th></th><th align=center width=170>Utols� bel�p�s</th><th></th></tr>";
$szin="keret3";
 $baratkutya=new kutya();
for($i=0; $i<sizeof($kutya->baratok); $i++)
{
 
 if($baratkutya->GetKutyaByID($kutya->baratok[$i]))
 {
      if($baratkutya->online)
      {
      $ido=ok("Most �pp itt van");
      }else{
      $ido=elteltido($baratkutya->belepido);
      }
 
      if($baratkutya->adatlap)
      {
      $adatlap="<a href=adatlapok.php?id=". $baratkutya->id ."><img src=pic/adatlap.gif border=0></a>";
      }else{
      $adatlap="<img src=pic/list2.gif border=0>";
      }
 
      if($baratkutya->blog)
      {
      $blog="<a href=blog.php?id=". $baratkutya->id ."><img src=pic/blog.gif border=0></a>";
      }else{
      $blog="<img src=pic/blog2.gif border=0>";
      }
 
      $adat.="<tr background=pic/". $szin .".gif><td></td><td>". $baratkutya->NevMegjelenitRanggalLinkelve() ."</td><td>". $blog ."</td><td>". $adatlap ."</td><td><a href=uzenetek.php?page=uzenetir&uid=". $baratkutya->id ."><img src=pic/letter.gif border=0></a></td><td>". $ido ."</td><td><a href=inc/barattorol.php?id=". $baratkutya->id ."><img src=pic/kuka.png border=0></a></td></tr>";

      if($szin=="keret3")
      {
      $szin="hatter8";
      }else{
      $szin="keret3";
      }
 }
}

$adat.="</table>";
}else{
$adat.=hiba("<br><br>Nincs senki a bar�t list�don!");
}
$adat.='</center>';
}else{
header("Location: index.php");
}

oldal($adat);
}else{
header("Location: index.php");
}
	?>
