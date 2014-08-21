<?
include("session.php");
include("sql.php");
include("functions.php");
include("stilus.php");
if(isset($_GET[blog]))
{
$blog=str_replace("[br>","<br>",ubb_adatlap($_GET[blog]));
echo $blog;
}


?>