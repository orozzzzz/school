<?php
session_start();
require_once "req/functions.php";
require_once "templates/titles.php"
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<link rel="shortcut icon" href="attach/favicon.ico">
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>
<body>
	<header>
		<?include_once 'templates/header.php'; ?>
	</header>
	<div class='content'><?
		if (!isset($_GET['page']))
			include "templates/main.php";
		else{
			switch ($_GET['page']) {
				case 'school':
					include "templates/school.php";
					break;
				case 'cabinet':
					include "templates/cabinet.php";
					break;
				default:
					jsredirect("http://school/templates/404.html");
					break;
			}
		}?>
	</div>
	<footer><? include_once 'templates/footer.php'; ?></footer>
	<script src="scripts/regcheck.js" type="text/javascript"></script>
	<script src="scripts/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="scripts/cabinet_modalframe.js"></script>
	<script type="text/javascript" src="scripts/activechange.js"></script>
	<script type="text/javascript" src="scripts/cabinet_admin.js"></script>
		<script type="text/javascript" src="scripts/cabinet_parent.js"></script>
		<script type="text/javascript" src="scripts/cabinet_childchange.js"></script>
</body>
</html>