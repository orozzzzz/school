<?php
require_once "functions.php";
if(!isset($_GET['code'])){
	header("Location: http://school/");
}
	if(isset($_POST['change'])){
		$code=$_GET['code'];
		$pass = md5(htmlentities(mysqli_real_escape_string($link, $_POST['password1'])));
		$query ="UPDATE parent SET pass='$pass' WHERE code='$code'";
   		$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
   		if($result){
   			?>
			<script type="text/javascript">
				alert("Пароль успешно изменен");
				window.location.href = 'http://school/#auth';
			</script>
			<?
   		}
   		else{
   			alertmsc("Ошибка");
   		}
	}
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Восстановление пароля</title>
		<link rel="shortcut icon" href="/attach/favicon.ico">
		<link rel="stylesheet" type="text/css" href="/styles/recovery_styles.css">
	</head>
	<body>
	<div class="recovery">
		<div class="regmodal">
		<form method="POST">
			<!-- <p>Введите новый пароль <input type="password" name="pass1" style="float: right;"></p> -->
			<!-- <p>Повторите пароль <input type="password" name="pass2" style="float: right;"></p> -->
			<p>Введите новый пароль<input type="password" name="password1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="psw1" required="" size="18"></p>
			<p>Повторите пароль<input type="password" name="password2" id="psw2" required="" size="17"></p>
			<div id="message">
			  <h3>Пароль должен соответствовать требованиям:</h3>
			  <p id="letter" class="invalid">Латинские символы верхнего и нижнего регистра</p>
			  <p id="number" class="invalid">Наличие хотя бы одной цифры</p>
			  <p id="length" class="invalid">От 8 до 20 символов</p>
			  <p id="same" class="invalid">Пароли не совпадают</p>
			</div>
			<p align="center"><input type="submit" name="change" id="regbutton" value="Изменить"></p>
		</form>
		</div>
	</div>
	</body>
	<script src="/scripts/regcheck.js" type="text/javascript"></script>	
	</html>
