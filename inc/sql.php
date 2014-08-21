<?php
$host="sql4.ultraweb.hu";
$adatbazisnev="NEV";
$adatbazisjelszo="JELSZO";
$kapcsolat = mysql_connect($host, $adatbazisnev, $adatbazisjelszo);
if (!$kapcsolat) die("Nem sikerült csatlakozni adatbázishoz ,ha 24órája fennál a hiba lépjen kapcsolatba egy fejlesztõvel!");
mysql_select_db($adatbazisnev, $kapcsolat) or die("Nem sikerült csatlakozni adatbázishoz ,ha 24órája fennál a hiba lépjen kapcsolatba egy fejlesztõvel!");
?>