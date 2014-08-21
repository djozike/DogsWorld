<head><style>
body {
font-family: Comic Sans MS;
}
img, div { behavior: url(iepngfix.htc) }
body,td,th {
	color: #774411;
}
a.feherlink:link     {text-decoration: none; color: #AA3311}
a.feherlink:visited  {text-decoration: none; color: #AA3311}
a.feherlink:active   {text-decoration: underline; color: #AA3311}
a.feherlink:hover    {text-decoration: underline; color: #AA3311}

form { margin: 0; padding: 0; }
</style></head>
<body background=pic/keret3.gif><center><b>Jelenleg a chatet figyelik:</b><?
include("inc/sql.php");
include("inc/session.php");
include("inc/functions.php");
$kell=mysql_query("SELECT * FROM session INNER JOIN kutya ON session.nev=kutya.kutya_nev WHERE hely = '/chatkiir.php' or hely = '/chato.php' or hely = '/inc/chat.php'");
while($kutyak=mysql_fetch_object($kell)){

echo idtonev($kutyak->kutya_id).", ";

}
?></center><table>
<?php
$szin=="hatter8.gif";
$moderator=0;
$modie=mysql_query("SELECT * FROM moderator WHERE mod_kutya = '". $_SESSION[id] ."'");
if(mysql_num_rows($modie)>0){
$moderator=1;
}
$leker=mysql_query("SELECT * FROM chat ORDER BY chat_id DESC");
while($uzenet=mysql_fetch_object($leker)){
if($szin=="hatter8.gif"){
$szin="keret3.gif";
}else{
$szin="hatter8.gif";
}
if($moderator==1){
$modipanel="<form action=inc/mftilt.php method=POST><input type=hidden name=ido value=1><input type=hidden name=fid value=1><input type=hidden name=kid value=". $uzenet->chat_kid ."><input type=hidden value=55 name=chat><input type=submit value='Tilt' style='width:20px; background:#980000;'></form>";
}
echo ("<tr><td width=800 align=left background=pic/". $szin .">[". $uzenet->chat_ido ."] ". idtonev($uzenet->chat_kid)  ." : ". $uzenet->chat_uzenet ."</td><td align=right>". $modipanel ."</td></tr>");
}
?>
</table><meta http-equiv=refresh content=4 />
