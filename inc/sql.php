<?php
$host="sql4.ultraweb.hu";
$adatbazisnev="NEV";
$adatbazisjelszo="JELSZO";
$kapcsolat = mysql_connect($host, $adatbazisnev, $adatbazisjelszo);
if (!$kapcsolat) die("Nem siker�lt csatlakozni adatb�zishoz ,ha 24�r�ja fenn�l a hiba l�pjen kapcsolatba egy fejleszt�vel!");
mysql_select_db($adatbazisnev, $kapcsolat) or die("Nem siker�lt csatlakozni adatb�zishoz ,ha 24�r�ja fenn�l a hiba l�pjen kapcsolatba egy fejleszt�vel!");
?>