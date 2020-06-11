<?php
header("Content-Type: text/html; charset=utf-8");

$host = 'localhost';
$database = 'school';
$user = 'root';
$password = '';

$link = mysqli_connect($host, $user, $password, $database) or mysqli_error($link);

function alertmsc($text)
{
	echo "<script>
			alert('" . $text . "');
		</script>";
}
function alertredirect($text,$location){
	echo "<script>
			alert('" . $text . "');
			window.location.href='" . $location . "';
		</script>";
}
function jsredirect($location){
	echo "<script>
			window.location.href='" . $location . "';
		</script>";
}
function conlog($message){
	echo "<script>
			console.log('" . $message . "');
		</script>";
}
function search_array($array, $needle)
  {
  foreach ($array as $key => $value)
       {
       if (array_search ($needle, $value))
            {
            	return $key;
            }   
       }
  }