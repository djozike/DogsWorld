<?php
include("sql.php");
include("session.php");
include("oop.php");
if(isset($_SESSION[id])){
$kuty=new kutya;
if($kuty->GetKutyaByID($_SESSION[id])){
if($kuty->PenzElvesz($KAJA)){
if($kuty->KajaValt($_GET[kaja])){
echo ok("Sikeres �tel v�lt�s! J� �tv�gyat!|"). penz($kuty->penz) ."|". $kuty->Talak();
}else{
echo ok("M�r most is ezt a fajta �telt eszi a kuty�d.");
$kuty->PenzHozzaad($KAJA);
}
}else{
echo hiba("Nincs el�g p�nzed, hogy �telt v�lts!");
}
}else{
header("Location: index.php");
}
}else{
header("Location: index.php");
}
?>
