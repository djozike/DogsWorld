<?php
include("sql.php");
include("session.php");
include("oop.php");
if(isset($_SESSION[id])){
$kuty=new kutya;
if($kuty->GetKutyaByID($_SESSION[id])){
if($kuty->PenzElvesz($KAJA)){
if($kuty->KajaValt($_GET[kaja])){
echo ok("Sikeres étel váltás! Jó étvágyat!|"). penz($kuty->penz) ."|". $kuty->Talak();
}else{
echo ok("Már most is ezt a fajta ételt eszi a kutyád.");
$kuty->PenzHozzaad($KAJA);
}
}else{
echo hiba("Nincs elég pénzed, hogy ételt válts!");
}
}else{
header("Location: index.php");
}
}else{
header("Location: index.php");
}
?>
