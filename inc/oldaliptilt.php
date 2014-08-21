<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id])){
$kutyuli = new kutya;
$kutyuli->GetKutyaByID($_SESSION[id]);
if($kutyuli->rang>=2){
if(isset($_POST[ip]))
{
       mysql_query("INSERT INTO oldaliptilt VALUES ('". $_POST[ip] ."', '". $_POST[megjegyzes] ."')");
       mysql_query("DELETE FROM session WHERE nev IN(
        SELECT kutya_nev FROM kutya WHERE kutya_belepip = '". $_POST[ip] ."')");
       $_SESSION[hiba]=ok('Sikeres IP tiltás!');  
}
else if ($_GET[ip]){
         mysql_query("DELETE FROM oldaliptilt WHERE oldaliptilt_ip = '". $_GET[ip] ."'");
} else{
 $_SESSION[hiba]=hiba('HIányos adatok!!!');
}

header("Location: ../admin.php?p=t");
}
else{
  header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
