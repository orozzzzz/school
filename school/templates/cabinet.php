<?php
$DIR = "D:\Programs\OpenServer\OSPanel\domains\school";

if($_SESSION['status']=='parent'){
	require_once "parent.php";
}
elseif($_SESSION['status']=='admin'){
	require_once "admin.php";
}
elseif($_SESSION['status']=='moderator'){
	require_once "moderator.php";
}
else{
	alertredirect('Вы не авторизованы','http://school/#auth');
}
?>

