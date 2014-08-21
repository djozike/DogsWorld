<?php
include("session.php");
include("sql.php");
include("oop.php");
if(isset($_SESSION[id]) and $_GET[id]){
$leker=mysql_query("SELECT * FROM uzenetek WHERE uzenet_id = '". $_GET[id] ."'");
if(mysql_num_rows($leker)>0){
while($kellenek=mysql_fetch_object($leker)){
	if($_SESSION[id]==$kellenek->uzenet_kuldo){
		mysql_query("UPDATE uzenetek SET uzenet_torol_kuldo = '1' WHERE uzenet_id = '". $_GET[id] ."'");
		if(isset($_GET['page']) && $_GET['page']>0)
		{
			echo uzenet_listazas($_SESSION['id'], $kellenek->uzenet_kapo);
		}
		else if(isset($_GET['page']))
		{
			echo osszes_uzenet_listazasa($_SESSION['id']);
		}
		else
		{
			header("Location: ../uzenetek.php?page=kimeno");
		}
	}else if($_SESSION[id]==$kellenek->uzenet_kapo){
		mysql_query("UPDATE uzenetek SET uzenet_torol_kapo = '1', uzenet_olvas = '1' WHERE uzenet_id = '". $_GET[id] ."'");
		if(isset($_GET['page'])  && $_GET['page']>0)
		{
			echo uzenet_listazas($_SESSION['id'], $kellenek->uzenet_kuldo);
		}
		else if(isset($_GET['page']))
		{
			echo osszes_uzenet_listazasa($_SESSION['id']);
		}
		else
		{
			header("Location: ../uzenetek.php");
		}
	}
	else
	{
		header("Location: ../index.php");
	}
}
}
else
{
header("Location: ../index.php");
}
}else{
header("Location: ../index.php");
}
?>
