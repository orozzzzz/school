<?
$host = 'localhost';
$database = 'school';
$user = 'root';
$password = '';
$link = mysqli_connect($host, $user, $password, $database) or mysqli_error($link);
$DIR1 = "D:\Programs\OpenServer\OSPanel\domains\school\documents\consideration_photos";
$DIR2 = "D:\Programs\OpenServer\OSPanel\domains\school\documents\confirmed_photos";
if(isset($_POST["id1"]))  
  {  
	$id = $_POST['id1'];
	$check = "SELECT active FROM school WHERE id = $id";
	if (mysqli_fetch_row(@mysqli_query($link,$check))[0]=='true'){
		$query = "UPDATE school SET active = 'false' WHERE id = $id";
	}
	if (mysqli_fetch_row(@mysqli_query($link,$check))[0]=='false'){
		$query = "UPDATE school SET active = 'true' WHERE id = $id";
	}
	@mysqli_query($link,$query);
  }
 if(isset($_POST["photo"])){  
	$id = $_POST['photo'];
	$status = $_POST['status'];
	if ($status=='true'){
		if (file_exists($DIR1."\\photo".$id.".png")){
			copy($DIR1."\\photo".$id.".png", $DIR2."\\photo".$id.".png");
		   	unlink($DIR1."\\photo".$id.".png");
		}
	    else{
	    	echo "Ошибка";
	    }
	}
	elseif($status=='false'){
		if (file_exists($DIR1."\\photo".$id.".png")){
		   	unlink($DIR1."\\photo".$id.".png");
		}
	    else{
	    	echo "Ошибка";
	    }
	}
  }
  if(isset($_POST["hcert"])){  
	$id = $_POST['hcert'];
	$status = $_POST['status'];
	if ($status=='true'){
		if (file_exists($DIR1."\\hcert".$id.".png")){
			copy($DIR1."\\hcert".$id.".png", $DIR2."\\hcert".$id.".png");
		   	unlink($DIR1."\\hcert".$id.".png");
		}
	    else{
	    	echo "Ошибка";
	    }
	}
	elseif($status=='false'){
		if (file_exists($DIR1."\\hcert".$id.".png")){
		   	unlink($DIR1."\\hcert".$id.".png");
		}
	    else{
	    	echo "Ошибка";
	    }
	}
  } 
  if(isset($_POST["cert"])){  
	$id = $_POST['cert'];
	$status = $_POST['status'];
	if ($status=='true'){
		if (file_exists($DIR1."\\cert".$id.".png")){
			copy($DIR1."\\cert".$id.".png", $DIR2."\\cert".$id.".png");
		   	unlink($DIR1."\\cert".$id.".png");
		}
	    else{
	    	echo "Ошибка";
	    }
	}
	elseif($status=='false'){
		if (file_exists($DIR1."\\cert".$id.".png")){
		   	unlink($DIR1."\\cert".$id.".png");
		}
	    else{
	    	echo "Ошибка";
	    }
	}
  } 
?>