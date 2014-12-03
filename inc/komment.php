<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id]) and $_POST[komment]!="" and $_POST[blog]!="0"){
	$en=new kutya();
	$en->GetKutyaByID($_SESSION[id]);
	if(( ($BLOGIRASTANULAS==1 and $en->Tanult("IR")) or $BLOGIRASTANULAS==0) and (($BLOGIRASMINNAP!=0 and $BLOGIRASMINNAP <= $en->kor) or $BLOGIRASMINNAP==0))
	{
		$uzenet=ubb_forum($_POST[komment]);
		mysql_query("INSERT INTO komment VALUES ('','". $_SESSION[id] ."','". $en->NevMegjelenit() ."', NOW(), '". $uzenet ."', '". $_POST[blog] ."')");
		header("Location: ../blog.php?blog=". $_POST[blog] ."#kommentek");
	}
	else{
		header("Location: ../index.php");
	}
}
elseif(isset($_SESSION[id]) and $_POST[blog]!="0")
{
	header("Location: ../blog.php?blog=". $_POST[blog] ."#kommentek");
}
else
{
	header("Location: ../index.php");
}
?>
