<?php
include("sql.php");
include("session.php");
include("oop.php");
if(isset($_SESSION['id']) and $_GET[kaja]){
$kuty=new kutya();
if($kuty->GetKutyaByID($_SESSION[id]))
{
 $kuty->Etet($_GET[kaja]);
 echo $kuty->Talak() ."|".$kuty->EtetMegjelenit();
}else{
header("Location: ../index.php");
}

}else{
header("Location: ../index.php");


}
?>
