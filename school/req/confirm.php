<?php
require_once "functions.php";
$code = $_GET['code'];
$query = "SELECT id FROM parent WHERE code = '$code'";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
if ($result){
	 $rows = mysqli_num_rows($result);
	 if ($rows>0){
	 	$id = mysqli_fetch_row($result)[0];
	 	mysqli_free_result($result);
	 	$query = "UPDATE parent SET active = 'YES' , code='0' WHERE id = '$id'";
	 	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	 	if($result){
	 		echo "Регистрация завершена<br>Вы будете перенаправлены на страницу входа";
	 		?>
	 		<script type="text/javascript">
				setTimeout(() => location.href = 'http://school/#auth', 3000);
			</script>
	 		<?
	 	}
	 	else{
	 		echo "Ошибка регистрации<br>";
	 		echo mysqli_error($link);
	 	}
	 }
	 else{
	 	echo "Неправильный код активации";
	 }
}
?>
