<?php

function VilagosMenu($w, $tartalom)
{
   return "<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso2.jpg></td><td background=pic/hatter8.gif width=". $w ."></td><td width=11 height=11 background=pic/jobbfelso2.jpg></td></tr>
		<tr><td background=pic/hatter8.gif colspan=3 align=center>". $tartalom ."
		</td></tr><tr><td width=11 height=11 background=pic/balalso2.jpg></td><td background=pic/hatter8.gif></td><td width=11 height=11 background=pic/jobbalso2.jpg></td></tr></table>";
}

function KeretesMenu($w, $tartalom)
{
  return "<table border=0 cellpadding=0 cellspacing=0><tr><td width=11 height=11 background=pic/balfelso.jpg></td><td height=11 background=pic/keret.jpg></td><td width=11 height=11 background=pic/jobbfelso.jpg></td></tr><tr><td width=11 background=pic/keret.jpg></td><td width=". $w .">".
          $tartalom ."</td><td width=11 background=pic/keret.jpg></td></tr><tr><th width=11 height=11 background=pic/balalso.jpg></th><th background=pic/keret.jpg></th><th width=11 height=11 background=pic/jobbalso.jpg></th></tr></table>";
}
function Uzenet($uID, $uzenet_id, $tartalom, $ido, $keretszin, $hatterszin)
{
$kutyi = new kutya();
if($kutyi->GetKutyaByID($uID))
{
		$kapo=$kutyi->NevMegjelenitRanggalLinkelve();
}
elseif($uID==0)
{
	$kapo="Dogs World";
}
else
{
	$kapo="<i>Törölt kutya</i>";
}
if(file_exists("pic/user/". $uID .".png") or file_exists("../pic/user/". $uID .".png")){
$kep="<a href=http://". $_SERVER['SERVER_NAME'] ."/pic/user/". $uID .".png target=_blank><img src=http://". $_SERVER['SERVER_NAME'] ."/pic.php?id=". $uID ."&size=100 border=0></a>";
}else{
$kep="<img src=http://". $_SERVER['SERVER_NAME'] ."/pic/user/avatar.jpg border=0 width=100 height=100>";
}

return "<table border=0 width=750 CELLSPACING=0 CELLPADDING=0><tr bgcolor=#". $keretszin ."><td align=left class='forum' colspan=2>
<table border=0 width=750 CELLSPACING=0 CELLPADDING=0><tr><td align=left>". $kapo ."</td><td align=right>". str_replace("-",".",$ido) ."</td></tr></table>
</td></tr>
<tr><td bgcolor=#". $keretszin ." align=center height=105 valign=top width=110><center>". $kep ." </center></td><td align=left valign=top width=640 class='forum' bgcolor=#". $hatterszin ."><table><tr><td height=70 valign=top><div style='width: 640px; height: 70 px; overflow-x: auto;'>". $tartalom ."</div></td></tr>
<tr><td align=right width=650><img src=http://". $_SERVER['SERVER_NAME'] ."/pic/kuka.png onclick='javascript:Torol(". $uzenet_id .")'></td></tr></table>
</td></tr></table><br>";



}
?>
