<?php
 include("session.php");
include("sql.php");
include("functions.php");
include("oop.php");

if(isset($_SESSION[id])){
$kutyuli = new kutya;
$kutyuli->GetKutyaByID($_SESSION[id]);
if($kutyuli->rang==3){
if($_POST[kutya])
{
     if($kutyuli->GetKutyaByNev($_POST[kutya]))
     {
       $kutyuli->SetRang($_POST[rang]);
       $_SESSION[hiba]=ok("Sikeres rang változtatás!"); 
     }else{
       $_SESSION[hiba]=hiba("Nem létezik ilyen nevû kutya!"); 
     }

}
else{
$_SESSION[hiba]=hiba("Nem töltöttél ki minden adatot!"); 
}


header("Location: ../admin.php");
}
else{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}

?>
