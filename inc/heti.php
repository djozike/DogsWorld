<?php
///egyszam uj
$useres=mysql_query("SELECT * FROM `egyszampontok` ORDER BY egyszampontok_pont  desc limit 0, ". sizeof($EGYSZAMNYEREMENY),$kapcsolat);
$i=1;
while($leker=mysql_fetch_object($useres)){
$kuty=new kutya();
$kuty->GetKutyaByID($leker->egyszampontok_kid);
$kuty->PenzHozzaad($EGYSZAMNYEREMENY[$i-1]);
$kuty->SendUzenet(0,"Gratulálunk, nyertél az egyszámjátékon ". penz($EGYSZAMNYEREMENY[$i-1])." összeget.");
$id[$i]=$kuty->id;
$nev[$i]=$kuty->nev;
$i++;
}

mysql_query("DELETE FROM `egyszampontok`");
$eleje=getdate(time()-(7*24*3600));
$vege=getdate();
$hasznal=$eleje[year] .". ". $eleje[mon] .". ". $eleje[mday] ." - ". $vege[year] .". ". $vege[mon] .". ". $vege[mday];
$ir=mysql_query("INSERT INTO `egyszam` VALUES ('', '". $hasznal ."', '". $id[1] ."', '". $nev[1] ."', '". $id[2] ."','". $nev[2] ."','". $id[3] ."' , '". $nev[3] ."')",$kapcsolat);

mysql_query("UPDATE `adatlap` SET `adatlap_megnez` = '0'");
mysql_query("DELETE FROM `latogatas`");
mysql_query("DELETE FROM falkaesemeny");
$falkas=mysql_query("SELECT * FROM `falka` ORDER BY falka_pont  desc limit 0, 3",$kapcsolat);
$i=1;
while($leker=mysql_fetch_object($falkas)){
$id[$i]=$leker->falka_id;
$nev[$i]=$leker->falka_nev;
$kid[$i]=$leker->falka_vezeto;
$kutya=mysql_query("SELECT * FROM `kutya` WHERE kutya_id = '". $leker->falka_vezeto ."'",$kapcsolat);
while($lekere=mysql_fetch_object($kutya)){
$knev[$i]=$lekere->kutya_nev;
}
$i++;
}

$eleje=getdate(time()-(7*24*3600));
$vege=getdate();
$hasznal=$eleje[year] .". ". $eleje[mon] .". ". $eleje[mday] ." - ". $vege[year] .". ". $vege[mon] .". ". $vege[mday];
$ir=mysql_query("INSERT INTO `falkatop` VALUES ('', '". $hasznal ."', '". $nev[1] ."', '". $id[1] ."', '". $knev[1] ."', '". $kid[1] ."', '". $nev[2] ."','". $id[2] ."', '". $knev[2] ."', '". $kid[2] ."', '". $nev[3] ."' , '". $id[3] ."', '". $knev[3] ."', '". $kid[3] ."')",$kapcsolat);

$useres=mysql_query("SELECT * FROM `falka` ORDER BY falka_pont  desc limit 0, 10",$kapcsolat);
$i=0;
while($lekeres=mysql_fetch_object($useres)){

$kuty=new kutya();
$kuty->GetKutyaByID($lekeres->falka_vezeto);
$kuty->PenzHozzaad((10-$i)*100);
$kuty->SendUzenet(0,"Gratulálunk,<br> a falkád a ". ($i+1) .". helyezést érte el, ezért kaptál ". penz(((10-$i)*100))." összeget.");
$i++;

}
$handle = fopen("../data/lottonyeremeny.txt", "r");
$nyeremeny=fread($handle, filesize("../data/lottonyeremeny.txt"));
fclose($handle);
$nyertesek=mysql_query("SELECT * FROM lottoszelveny INNER JOIN lottonyeroszam ON lottoszelveny_szam1 = lottonyeroszam1 and lottoszelveny_szam2 = lottonyeroszam2 and lottoszelveny_szam3 = lottonyeroszam3");
if(mysql_num_rows($nyertesek)>0){
while($nyertes=mysql_fetch_object($nyertesek)){
$kutyuska=mysql_query("SELECT * FROM kutya WHERE kutya_id = '". $nyertes->lottoszelveny_kid  ."'");
while($kutya=mysql_fetch_object($kutyuska)){

$leiras="Szia!<br>Graturálok NYERTÉL A LOTTÓN!!!<br> Összesen ezen a héten ". mysql_num_rows($nyertesek) ." nyertes volt. A nyertesek között egyenlõen osztottuk el a nyereményt, így ". penz(round($nyeremeny/mysql_num_rows($nyertesek))) ." összeget irtunk neked jová.";
$level=mysql_query("INSERT INTO `uzenetek` VALUES ('', '". $leiras ."', '0', '". $kutya->kutya_id ."', NOW(), 0, 0, 1, 0)");
mysql_query("UPDATE kutya SET kutya_penz = '". ($kutya->kutya_penz+round($nyeremeny/mysql_num_rows($nyertesek))) ."' WHERE kutya_id = '". $kutya->kutya_id ."'");
}
}
$handle = fopen("../data/lottonyeremeny.txt", "w");
fwrite($handle, 0);
fclose($handle);
}


mysql_query("DELETE FROM lottoszelveny");
mysql_query("DELETE FROM lottonyeroszam");

$szam=veletlen(1,10,3);
mysql_query("INSERT INTO lottonyeroszam VALUES('". $szam[0] ."','". $szam[1] ."','". $szam[2] ."')");
?>
