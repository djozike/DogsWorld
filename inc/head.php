<?
$datum=getdate();
if(($datum["mon"]==12) or ($datum["mon"]==1 and $datum["mday"]<7)){
$style='<link href="style_karacsony.css" rel="stylesheet" type="text/css">';
}else{
$style='<link href="style.css" rel="stylesheet" type="text/css">';
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>DogsWorld - legyen egy sajat virtualis kutyad</title>
	<? echo $style; ?>
	<link rel="Shortcut Icon" type="image/x-icon" href="pic/icon.ico">
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-2">
	<meta name="keywords" content="kutya, kutya nevelde, kutyanevelde, saját kutya, dogsworld, virtuális nevelde, nevelde, játék, online játék, böngészős játék" />
	<meta http-equiv="content-language" content="hu">
	<meta name="description" content="Online ingyenes kutya nevelde, gyere és probáld ki, válj a legjobb gazdivá!" />
	<meta name="ROBOTS" content="all" />
</head>
<body><div style="width:940px;margin:auto;">
