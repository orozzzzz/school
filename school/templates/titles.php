<?php
$title = "";
if (isset($_GET['page'])){
	switch ($_GET['page']) {
		case "test":
			$title = "ТЕСТ";
			break;
		case "school":
			$title = "Школа";
			break;
		case 'cabinet':
			$title = "Личный кабинет";
			break;
		default:
			$title = "Ошибка";
			break;	
	}
}
else{?>
	<script type="text/javascript">
		document.onkeydown = function(e){
		  e = e || window.event;
		  if(e.keyCode === 27) {
		    document.location.href = "/#";
		  }
		}
	</script><?
	$title = "Главная страница";
}?>