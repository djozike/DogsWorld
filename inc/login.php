<? 
include("sql.php");
include("session.php");
include("oop.php"); 
if(isset($_SESSION[nev])){
header("Location: ../kutyam.php");
}else{
if(($_POST[nev]) and ($_POST[jelszo])){
$kutya=new kutya();
if($kutya->Login($_POST[nev], $_POST[jelszo]))
{
if($kutya->oldalroltiltva==0)
{
$_SESSION[nev]=$_POST[nev];
header("Location: ../kutyam.php");
}else{
$_SESSION['hiba']='<script>alert("Opsz ki vagy tiltva az oldalr�l, n�zz vissza '. $kutya->oldalroltiltva .' nap mulva!");</script>';
header("Location: ../index.php");
}
}else{
$_SESSION['hiba']='<script>alert("Hib�s n�v vagy jelsz�!");</script>';
header("Location: ../index.php");
}
}else{
$_SESSION[hiba]='<script>alert("Nem adt�l meg minden adatot!");</script>';
header("Location: ../index.php");
}
}
?>
