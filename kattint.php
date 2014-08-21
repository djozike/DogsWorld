<?php
include("inc/session.php");
include("inc/sql.php");
include("inc/functions.php");
if(isset($_SESSION[id]) and $_GET[id]){
$lekeres=mysql_query("SELECT * FROM uzenofal WHERE uzenofal_id = '". $_GET[id] ."'");
if(mysql_num_rows($lekeres)>0){
while($uzenet=mysql_fetch_object($lekeres)){
mysql_query("UPDATE uzenofal SET uzenofal_klik = '". ($uzenet->uzenofal_klik+1) ."' WHERE uzenofal_id = '". $_GET[id] ."'");
switch($uzenet->uzenofal_tipus){
case 1:
header("Location: kutyak.php?id=". $uzenet->uzenofal_kid);
break;
case 2:
header("Location: adatlapok.php?id=". $uzenet->uzenofal_kid);
break;
case 3:
if($uzenet->uzenofal_link==null){
header("Location: blog.php?id=". $uzenet->uzenofal_kid);
}else{
header("Location: blog.php?blog=". $uzenet->uzenofal_link);
}
break;
case 4:
$lekeres=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $uzenet->uzenofal_kid ."'");
while($kutyus=mysql_fetch_object($lekeres)){
header("Location: falka.php?id=". $kutyus->kutya_falka);
}
break;
case 5:
$adat="<center><big><u>Más weboldalra mutató link</u></big><br><br>
A következõ oldal nem a ". $SITENAME ." tulajdona, ezért nem tudja és mi lehet rajta, így felelõsséget se vállal érte. Ha tovább lépsz csak óvatosan nehogy cicis nénik vagy böngészõt kifagyasztó oldalak legyenek, mindenesetre mi szóltunk.<br><br>

<u>A weblap címe:</u> http://". $uzenet->uzenofal_link ."<br><br>
<a href=http://". $uzenet->uzenofal_link ." target=_BLANK class='feherlink'>Oké, köszi azért inkább megnézem!</a></center>";
oldal($adat);
break;
}

}
}else{
header("Location: index.php");
}
}else{
header("Location: index.php");
}
?>
