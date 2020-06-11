<?php
session_start();
require_once "functions.php";
$DIR = "D:\Programs\OpenServer\OSPanel\domains\school";
if(isset($_POST['registration'])){
	require '../SMTP/PHPMailer.php';
	require '../SMTP/SMTP.php';
	require '../SMTP/Exception.php';
	$name1 = htmlentities(mysqli_real_escape_string($link, $_POST['name1']));
	$name2 = htmlentities(mysqli_real_escape_string($link, $_POST['name2']));
	$name3 = htmlentities(mysqli_real_escape_string($link, $_POST['name3']));
	$email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
	$address = htmlentities(mysqli_real_escape_string($link, $_POST['address']));
	$telephone = htmlentities(mysqli_real_escape_string($link, $_POST['telephone']));
	$password = md5(htmlentities(mysqli_real_escape_string($link, $_POST['password1'])));
	
	$testquery = "SELECT active FROM parent WHERE email = '$email'";
	$test = mysqli_query($link, $testquery); 
	if($test){
		if (mysqli_num_rows($test)>0){
			$row = mysqli_fetch_row($test);
			if($row[0]=='none'){
				alertredirect("Перейдите по ссылке в письме чтобы закончить регистрацию","http://school/");
			}
			elseif($row[0]=='YES'){
				alertredirect("Данный email уже занят","http://school/");
			}
		}
		elseif(mysqli_num_rows($test)==0)
		{
			$code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 50);
			$query ="INSERT INTO parent VALUES(NULL,'$name1','$name2','$name3','$email','$address','$telephone','$password','$code','none')";
			$result = mysqli_query($link, $query);
			if($result){
				$mail = new PHPMailer\PHPMailer\PHPMailer();
				try {
				    $mail->isSMTP();   
				    $mail->CharSet = "UTF-8";                                          
				    $mail->SMTPAuth   = true;
				    $mail->Host       = 'smtp.gmail.com';
				    $mail->Username   = 'reg.school.system@gmail.com'; 
				    $mail->Password   = 'Support24'; 
				    $mail->SMTPSecure = 'ssl';
				    $mail->Port       = 465;
				    $mail->setFrom('reg.school.system@gmail.com', 'Онлайн система'); 
				    $mail->addAddress($email);  
			        $mail->isHTML(true);
			        $mail->Subject = 'Подтверждение регистрации';
			        $mail->Body    = "<p>Здравствуйте </p>
			        <p>Перейдите пожалуйста по ссылке ниже чтобы закончить регистрацию</p><br>
			        <a href='http://school/req/confirm.php/?code=".$code."'>http://school/req/confirm.php/?code=".$code."</a>";

					if ($mail->send()) {
						alertredirect("Перейдите по ссылке в письме чтобы закончить регистрацию","http://school/");
					} 
					else {
						alertmsc("Ошибка");
					}
				} 
				catch (Exception $e) {
				    alertmsc("Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}");
				}
			}
			else{
				alertmsc(mysqli_error($link));
				echo $query;
				echo mysqli_error($link);
			}
		}
	}
	else{

	}

}
if(isset($_POST['adm_auth'])){
	$email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
	$password = md5(htmlentities(mysqli_real_escape_string($link, $_POST['password'])));
	$query ="SELECT school_id,type FROM user WHERE email = '$email' AND pass='$password'";
	$result = mysqli_query($link, $query);
	if($result){
		if (mysqli_num_rows($result)>0){
			$data = mysqli_fetch_row($result);
			if ($data[1]=='admin'){
				$_SESSION['status']='admin';
			}
			else{
				$_SESSION['sid']=$data[0];
				$_SESSION['status']='moderator';
			}
			jsredirect('http://school/');
		}
		else{
			alertredirect('Ошибка авторизации','http://school/#auth');
		}
	}
}
if(isset($_POST['user_auth'])){
	$email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
	$password = md5(htmlentities(mysqli_real_escape_string($link, $_POST['password'])));
	$query ="SELECT name1, name2, name3, id,active FROM parent WHERE email = '$email' AND pass='$password'";
	$result = mysqli_query($link, $query);
	if($result){
		if (mysqli_num_rows($result)>0){
			$data = mysqli_fetch_row($result);
			if ($data[4]=='YES'){
				$fio=explode(' ', $data[0]. " ". $data[1]. " ". $data[2]);
				$_SESSION['fio'] = $fio[0] . ' ' . substr($fio[1],0,2) . '.' . substr($fio[2],0,2) . '.' ;
				$FIO = $fio[0] . ' ' . substr($fio[1],0,2) . '.' . substr($fio[2],0,2) . '.'; 
				setrawcookie('FIO',$FIO,time()+7200,'/');
				setrawcookie('email',$email,time()+7200,'/');
				$_SESSION['status']='parent';
				$_SESSION['email']=$email;
				$_SESSION['id']=$data[3];
				jsredirect('http://school/');
			}
			else{
				alertredirect('Учетная запись не активирована','http://school/');
			}
		}
		else{
			alertredirect('Ошибка авторизации','http://school/#auth');
		}
	}
}
if(isset($_POST['request'])){
	 $fio = htmlentities(mysqli_real_escape_string($link, $_POST['fio']));
	 $email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
	 $text = htmlentities(mysqli_real_escape_string($link, $_POST['text']));

	 $query ="INSERT INTO messages VALUES(NULL,NOW(),'$fio','$email','$text','unanswered',NULL)";
	 $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	 if($result){
	 	alertredirect('Сообщение отправлено','http://school/#auth');
	 }
	 else{
	 	alertredirect('Ошибка','http://school/#auth');
	 }
}
if(isset($_POST['recovery'])){
	$email = htmlentities(mysqli_real_escape_string($link, $_POST['email']));
	$query = "SELECT active FROM parent WHERE email = '$email'";
	$result = mysqli_query($link, $query);
	if($result){
		if(mysqli_num_rows($result)>0){
			$active = mysqli_fetch_row($result);
			if ($active[0]=='YES'){
					$code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 50);
					$query ="UPDATE parent SET code='$code' WHERE email='$email'";
    				$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
    				if($result){
						require '../SMTP/PHPMailer.php';
						require '../SMTP/SMTP.php';
						require '../SMTP/Exception.php';
						$mail = new PHPMailer\PHPMailer\PHPMailer();
						try {
						    $mail->isSMTP();   
						    $mail->CharSet = "UTF-8";                                          
						    $mail->SMTPAuth   = true;
						    $mail->Host       = 'smtp.gmail.com';
						    $mail->Username   = 'reg.school.system@gmail.com'; 
						    $mail->Password   = 'Support24'; 
						    $mail->SMTPSecure = 'ssl';
						    $mail->Port       = 465;
						    $mail->setFrom('reg.school.system@gmail.com', 'Онлайн система'); 
						    $mail->addAddress($email);  
					        $mail->isHTML(true);
					        $mail->Subject = 'Сброс пароля';
					        $mail->Body    = "<p>Здравствуйте </p>
					        <p>Для восстановления пароля перейдите по ссылке ниже</p><br>
					        <a href='http://school/req/recovery.php/?code=".$code."'>http://school/req/recovery.php/?code=".$code."</a><br>
					        <p>Если вы не предпринимали попытки восстановить пароль, то оставьте данное письмо без внимания.</p><br>";

							if ($mail->send()) {
								alertredirect('Перейдите по ссылке в письме чтобы восстановить пароль','http://school/#auth');
							} 
							else {
								alertmsc("Ошибка");
							}
						} 
						catch (Exception $e) {
						    alertmsc("Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}");
						}
					}
			}
			elseif ($active[0]=='none'){
				alertredirect('Данная учетная запись еще не подтверждена, перейдите по ссылке в письме для завершения регистрации','http://school/#auth');
			}
		}
		else{
			alertredirect('Учетной записи с данным почтовым ящиком не существует','http://school/#recovery');
		}
	}
}
if(isset($_POST['upload1'])){
	if ($_FILES && $_FILES['file']['error']== UPLOAD_ERR_OK){
		$name = "..\\documents\\consideration_photos\\"."photo".$_COOKIE['id'].str_replace('/','.',stristr($_FILES['file']['type'],'/'));
   		move_uploaded_file($_FILES['file']['tmp_name'], $name);
		header("Location: http://school/?page=cabinet");	

	}
	else{
		alertredirect('Ошибка','http://school/?page=cabinet');
	}
}
if(isset($_POST['upload2'])){
	if ($_FILES && $_FILES['file']['error']== UPLOAD_ERR_OK){
		$name = "..\\documents\\consideration_photos\\"."cert".$_COOKIE['id'].str_replace('/','.',stristr($_FILES['file']['type'],'/'));
   		move_uploaded_file($_FILES['file']['tmp_name'], $name);
		jsredirect('http://school/?page=cabinet');
	}
	else{
		alertredirect('Ошибка','http://school/?page=cabinet');
	}
}
if(isset($_POST['upload3'])){
	if ($_FILES && $_FILES['file']['error']== UPLOAD_ERR_OK){
		$name = "..\\documents\\consideration_photos\\"."hcert".$_COOKIE['id'].str_replace('/','.',stristr($_FILES['file']['type'],'/'));
   		move_uploaded_file($_FILES['file']['tmp_name'], $name);
		jsredirect('http://school/?page=cabinet');
	}
	else{
		alertredirect('Ошибка','http://school/?page=cabinet');
	}
}
if(isset($_POST['addchild'])){
	$fio =htmlentities(mysqli_real_escape_string($link, trim($_POST['children_name'])));
	$gender =htmlentities(mysqli_real_escape_string($link, trim($_POST['gender'])));
	$day =htmlentities(mysqli_real_escape_string($link, trim($_POST['select1'])));
	$month =htmlentities(mysqli_real_escape_string($link, trim($_POST['select2'])));
	$year =htmlentities(mysqli_real_escape_string($link, trim($_POST['select3'])));
	$class =htmlentities(mysqli_real_escape_string($link, trim($_POST['select4'])));
	$birthdate = $year.'-'.$month.'-'.$day;
	$email=$_COOKIE['email'];
	$query ="INSERT INTO children (fio,birthdate,gender,class,parent_id) VALUES('$fio','$birthdate','$gender',$class,(SELECT id FROM parent WHERE email='$email'))";
	$result = mysqli_query($link, $query);
	if($result){
		alertredirect('Запись добавлена','http://school/?page=cabinet');
	}
	else{
		alertmsc(mysqli_error($link));
	}
}
if(isset($_POST['updatechild'])){
	$id =htmlentities(mysqli_real_escape_string($link, trim($_POST['children_id'])));
	$fio =htmlentities(mysqli_real_escape_string($link, trim($_POST['children_name'])));
	$gender =htmlentities(mysqli_real_escape_string($link, trim($_POST['gender'])));
	$day =htmlentities(mysqli_real_escape_string($link, trim($_POST['select1'])));
	$month =htmlentities(mysqli_real_escape_string($link, trim($_POST['select2'])));
	$year =htmlentities(mysqli_real_escape_string($link, trim($_POST['select3'])));
	$class =htmlentities(mysqli_real_escape_string($link, trim($_POST['select4'])));
	$birthdate = $year.'-'.$month.'-'.$day;
	$email=$_COOKIE['email'];
	$query ="UPDATE children SET fio = '$fio', birthdate = '$birthdate', gender = '$gender', class = $class WHERE id = '$id' AND parent_id = (SELECT id FROM parent WHERE email='$email')";
	$result = mysqli_query($link, $query);
	if($result){
		alertredirect('Запись обновлена','http://school/?page=cabinet');
	}
	else{
		alertmsc(mysqli_error($link));
	}
}
if(isset($_GET['deletechildid'])){
	$id = $_GET['deletechildid'];
	$email = $_COOKIE['email'];
	if (mysqli_num_rows(mysqli_query($link,"SELECT id FROM children WHERE id='$id' AND parent_id = (SELECT id FROM parent WHERE email = '$email')"))>0){
		$query ="DELETE FROM children WHERE id ='$id'";
		$result = mysqli_query($link, $query);
		if($result){
			if(file_exists($DIR."\documents\consideration_photos\photo".$id.".png")){
				unlink($DIR."\documents\consideration_photos\photo".$id.".png");
			}
			if(file_exists($DIR."\documents\consideration_photos\cert".$id.".png")){
				unlink($DIR."\documents\consideration_photos\cert".$id.".png");
			}
			if(file_exists($DIR."\documents\consideration_photos\hcert".$id.".png")){
				unlink($DIR."\documents\consideration_photos\hcert".$id.".png");
			}
			jsredirect('http://school/?page=cabinet');
		}
		else{
			alertmsc(mysqli_error($link));
		}
	}
	else
	{
		alertredirect('Ошибка доступа','http://school/?page=cabinet');
	}
}
if(isset($_GET['deletechildphoto'])){
	$id = $_GET['deletechildphoto'];
	$email = $_COOKIE['email'];
	if (mysqli_num_rows(mysqli_query($link,"SELECT id FROM children WHERE id='$id' AND parent_id = (SELECT id FROM parent WHERE email = '$email')"))>0){
		if(file_exists($DIR."\documents\consideration_photos\photo".$id.".png")){
			unlink($DIR."\documents\consideration_photos\photo".$id.".png");
		}
		jsredirect('http://school/?page=cabinet');
	}
	else
	{
		alertredirect('Ошибка доступа','http://school/?page=cabinet');
	}
}
if(isset($_GET['deletechildcert'])){
	$id = $_GET['deletechildcert'];
	$email = $_COOKIE['email'];
	if (mysqli_num_rows(mysqli_query($link,"SELECT id FROM children WHERE id='$id' AND parent_id = (SELECT id FROM parent WHERE email = '$email')"))>0){
			if(file_exists($DIR."\documents\consideration_photos\cert".$id.".png")){
				unlink($DIR."\documents\consideration_photos\cert".$id.".png");
			}
			jsredirect('http://school/?page=cabinet');
		}
		else
		{
			alertredirect('Ошибка доступа','http://school/?page=cabinet');
		}
}
if(isset($_GET['deletechildhcert'])){
	$id = $_GET['deletechildhcert'];
	$email = $_COOKIE['email'];
	if (mysqli_num_rows(mysqli_query($link,"SELECT id FROM children WHERE id='$id' AND parent_id = (SELECT id FROM parent WHERE email = '$email')"))>0){
		if(file_exists($DIR."\documents\consideration_photos\hcert".$id.".png")){
			unlink($DIR."\documents\consideration_photos\hcert".$id.".png");
		}
		jsredirect('http://school/?page=cabinet');
	}
	else
	{
		alertredirect('Ошибка доступа','http://school/?page=cabinet');
	}
}
if(isset($_POST['changeschoolinfo'])){
	$id = $_SESSION['sid'];
	$name =htmlentities(mysqli_real_escape_string($link, trim($_POST['name'])));
	$address =htmlentities(mysqli_real_escape_string($link, trim($_POST['address'])));
	$telephone =htmlentities(mysqli_real_escape_string($link, trim($_POST['telephone'])));
	$director =htmlentities(mysqli_real_escape_string($link, trim($_POST['director'])));
	$email =htmlentities(mysqli_real_escape_string($link, trim($_POST['email'])));
	$shorttitle =htmlentities(mysqli_real_escape_string($link, trim($_POST['shorttitle'])));
	$year =htmlentities(mysqli_real_escape_string($link, trim($_POST['year'])));
	$ccount =htmlentities(mysqli_real_escape_string($link, trim($_POST['ccount'])));
	$tcount =htmlentities(mysqli_real_escape_string($link, trim($_POST['tcount'])));
	$query ="UPDATE school SET name = '$name', address = '$address', telephone = '$telephone', director='$director',email='$email', shorttitle = '$shorttitle', year='$year', ccount='$ccount', tcount = '$tcount' WHERE id = $id";
	$result = mysqli_query($link, $query);
	if($result){
		jsredirect('http://school/?page=school&id='.$id);
	}
	else{
		echo mysqli_error($link);
	}
}
if(isset($_POST['contentchange'])){
	$id = $_SESSION['sid'];
	$oldheader =htmlentities(mysqli_real_escape_string($link, trim($_POST['oldheader'])));
	$newheader =htmlentities(mysqli_real_escape_string($link, trim($_POST['newheader'])));
	$content =mysqli_real_escape_string($link, trim($_POST['content']));
	$query = "UPDATE page SET title = '$newheader', content = '$content' WHERE school_id = $id AND title = '$oldheader'";
	if(mysqli_query($link,$query)){
		jsredirect('http://school/?page=school&id='.$id);
	}
	else{
		echo mysqli_error($link);
	}
}
if(isset($_POST['newcontent'])){
	$id = $_SESSION['sid'];
	$newheader =htmlentities(mysqli_real_escape_string($link, trim($_POST['newheader'])));
	$content =mysqli_real_escape_string($link, trim($_POST['content']));
	$query = "INSERT INTO page (school_id,title, content) VALUES ($id, '$newheader','$content')";
	if(mysqli_query($link,$query)){
		jsredirect('http://school/?page=school&id='.$id);
	}
	else {
		echo mysqli_error($link);
	}
}
if(isset($_GET['deletepage'])){
	$id = $_SESSION['sid'];
	$page = $_GET['deletepage'];
	if (isset($id)){
		$query = "DELETE FROM page WHERE school_id = $id AND title ='$page'";
		if(mysqli_query($link,$query)){
			jsredirect('http://school/?page=school&id='.$id);
		}
		else{
			echo mysqli_error($link);
		}
	}
	else
	{
		alertredirect('Ошибка','http://school/?page=school&id='.$id);
	}
}

if(isset($_POST['uploadschoolimage'])){
	$id = $_SESSION['sid'];
	if ($_FILES && $_FILES['file']['error']== UPLOAD_ERR_OK){
		$name = $DIR."\\schools\\".$id."\\"."main_pic.jpg";
		if(file_exists($DIR."\schools\\$id\main_pic.jpg")){
			unlink($DIR."\schools\\$id\main_pic.jpg");
		}
   		move_uploaded_file($_FILES['file']['tmp_name'], $name);
		jsredirect('http://school/?page=school&id='.$id);
	}
	else{
		alertredirect('Ошибка','http://school/?page=school&id='.$id);
	}
}

if(isset($_POST['editparentdata'])){
	$name1 = $_POST['name1'];
	$name2 = $_POST['name2'];
	$name3 = $_POST['name3'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];
	$address = $_POST['address'];
	$query = "UPDATE parent SET name1 = '$name1',name2 = '$name2',name3 = '$name3', email = '$email', telephone = '$telephone', address = '$address' WHERE email='$email'";
	$result = mysqli_query($link, $query);
	if ($result){
		$fio=explode(' ', $name1. " ". $name2. " ". $name3);
		$_SESSION['fio'] = $name1 . ' ' . substr($fio[1],0,2) . '.' . substr($fio[2],0,2) . '.' ;
		$_SESSION['email']=$email;
		$FIO = $name1 . ' ' . substr($fio[1],0,2) . '.' . substr($fio[2],0,2) . '.';
		setrawcookie('FIO',$FIO,time()+3600,'/');
		setrawcookie('email',$email,time()+3600,'/');
		jsredirect('http://school/?page=cabinet');
	}
	else{
		alertredirect(mysqli_error($link),'http://school/?page=cabinet');
	}
}

if(isset($_POST['send_answer'])){
	require '../SMTP/PHPMailer.php';
	require '../SMTP/SMTP.php';
	require '../SMTP/Exception.php';
	$id = $_POST['id'];
	$message = $_POST['message'];
	$email = $_POST['email'];
	$query = "UPDATE messages SET status = 'answered', answer_date = NOW() WHERE id = $id";
	$result = mysqli_query($link, $query);
	if($result){
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		try {
		    $mail->isSMTP();   
		    $mail->CharSet = "UTF-8";                                          
		    $mail->SMTPAuth   = true;
		    $mail->Host       = 'smtp.gmail.com';
		    $mail->Username   = 'reg.school.system@gmail.com'; 
		    $mail->Password   = 'Support24'; 
		    $mail->SMTPSecure = 'ssl';
		    $mail->Port       = 465;
		    $mail->setFrom('reg.school.system@gmail.com', 'Онлайн система'); 
		    $mail->addAddress($email);  
	        $mail->isHTML(true);
	        $mail->Subject = 'Ответ на вопрос';
	        $mail->Body    = "<p>" .$message. "</p>";

			if ($mail->send()) {
				alertredirect("ответ отправлен","http://school/?page=cabinet");
			} 
			else {
				
				echo $mail->ErrorInfo;
			}
		} 
		catch (Exception $e) {
		    alertredirect("Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}","http://school/?page=cabinet");
		}
	}
	else{

		alertredirect(mysqli_error($link),"http://school/?page=cabinet");
	}
}

if(isset($_GET['delete_question'])){
	$id = $_GET['delete_question'];
	if ($_SESSION['status']=='admin'){
		$query = "DELETE FROM messages WHERE id = $id";
		$result = mysqli_query($link,$query);
		if($result){
			jsredirect('http://school/?page=cabinet');
		}
		else{
			alertredirect(mysqli_error($link),'http://school/?page=cabinet');
		}
	}
	else{
		alertredirect('Ошибка','http://school/?page=cabinet');
	}
}
if(isset($_POST['new_school'])){
	$name =trim($_POST['name']);
	$address =trim($_POST['address']);
	$telephone =trim($_POST['telephone']);
	$email =trim($_POST['email']);
	$shorttitle =trim($_POST['shorttitle']);
	$director =trim($_POST['director']);
	$year =trim($_POST['year']);
	$ccount =trim($_POST['ccount']);
	$tcount =trim($_POST['tcount']);
	$cor1 =trim($_POST['cor1']);
	$cor2 =trim($_POST['cor2']);
	$login =trim($_POST['login']);
	$pass =md5(trim($_POST['pass']));
	$query = "INSERT INTO school(name,address,telephone,director,email,shorttitle,year,ccount,tcount,cor1,cor2,active)
			  VALUES ('$name','$address','$telephone', '$director', '$email', '$shorttitle', $year, $ccount, $tcount, $cor1,$cor2,'false')";
	$result = mysqli_query($link,$query);
	if($result){
		$query = "INSERT INTO page(school_id,title,content)
				  VALUES ((SELECT id FROM school WHERE name = '$name'),'Основная информация','<h3>Первая тема школы</h3>')";
		if(mysqli_query($link,$query)){
			$query = "INSERT INTO user (email, pass, type, school_id)
					  VALUES('$email','$pass','moderator',(SELECT id FROM school WHERE name = '$name'))";
			if(mysqli_query($link,$query)){
				$query = "SELECT id FROM school WHERE name = '$name'";
				$result = mysqli_query($link,$query);
				if($result){
					$id = mysqli_fetch_row($result)[0];
					mkdir($DIR."\\schools\\" . $id);
					mkdir($DIR."\\schools\\".$id."\\" . 'files');
				}
				require '../SMTP/PHPMailer.php';
				require '../SMTP/SMTP.php';
				require '../SMTP/Exception.php';
				$mail = new PHPMailer\PHPMailer\PHPMailer();
				try {
				    $mail->isSMTP();   
				    $mail->CharSet = "UTF-8";                                          
				    $mail->SMTPAuth   = true;
				    $mail->Host       = 'smtp.gmail.com';
				    $mail->Username   = 'reg.school.system@gmail.com'; 
				    $mail->Password   = 'Support24'; 
				    $mail->SMTPSecure = 'ssl';
				    $mail->Port       = 465;
				    $mail->setFrom('reg.school.system@gmail.com', 'Онлайн система'); 
				    $mail->addAddress($email);  
			        $mail->isHTML(true);
			        $mail->Subject = $theme;
			        $mail->Body    = "<p>"."Здравствуйте, Ваша заявка на добавление школы одобрена.</p><br>".
			        				 "<p>"."Данные для авторизации в системе:<br></p>".
			        				 "<p><b>Логин:</b>".$login."</p><br>".
			        				 "<p><b>Пароль:</b>".$pass."</p><br>";

					if ($mail->send()) {
						alertredirect("Школа зарегистрирована","http://school/?page=cabinet");
					} 
					else {
						echo $mail->ErrorInfo;
					}
				} 
				catch (Exception $e) {
				    alertredirect("Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}","http://school/?page=cabinet");
				}
				jsredirect('http://school/?page=cabinet');
			}
		}
	}
	else{
		alertredirect(mysqli_error($link),'http://school/?page=cabinet');
	}	  

}

if(isset($_POST['send_message'])){
	require '../SMTP/PHPMailer.php';
	require '../SMTP/SMTP.php';
	require '../SMTP/Exception.php';
	$theme = $_POST['theme'];
	$message = $_POST['message'];
	$email = $_POST['email'];
	
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	try {
	    $mail->isSMTP();   
	    $mail->CharSet = "UTF-8";                                          
	    $mail->SMTPAuth   = true;
	    $mail->Host       = 'smtp.gmail.com';
	    $mail->Username   = 'reg.school.system@gmail.com'; 
	    $mail->Password   = 'Support24'; 
	    $mail->SMTPSecure = 'ssl';
	    $mail->Port       = 465;
	    $mail->setFrom('reg.school.system@gmail.com', 'Онлайн система'); 
	    $mail->addAddress($email);  
        $mail->isHTML(true);
        $mail->Subject = $theme;
        $mail->Body    = "<p>" .$message. "</p>";

		if ($mail->send()) {
			alertredirect("Сообщение отправлено","http://school/?page=cabinet");
		} 
		else {
			echo $mail->ErrorInfo;
		}
	} 
	catch (Exception $e) {
	    alertredirect("Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}","http://school/?page=cabinet");
	}
	
}
if(isset($_POST['setdate'])){
	$startdate = $_POST['startdate'];
	$enddate = $_POST['enddate'];
	$id = $_SESSION['sid'];
	$query = "UPDATE school SET startdate = '$startdate', enddate='$enddate' WHERE id=$id";
	$result = mysqli_query($link,$query);
	if($result){
		jsredirect("http://school/?page=cabinet");
	}
	else{
		echo mysqli_error($link);
	}
}
if(isset($_POST['new_note'])){
	$message = $_POST['message'];
	$date = $_POST['new_note_date'];
	$time = $_POST['new_note_time'];
	$email = $_POST['email'];
	$id = $_POST['id'];
	if( $message=='' || $date=='' || $time==''){
		alertredirect("Поля не могут быть пустыми","http://school/?page=cabinet");
	}
	else{
		$datetime = $date." ".$time;
		require '../SMTP/PHPMailer.php';
		require '../SMTP/SMTP.php';
		require '../SMTP/Exception.php';
		
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		try {
		    $mail->isSMTP();   
		    $mail->CharSet = "UTF-8";                                          
		    $mail->SMTPAuth   = true;
		    $mail->Host       = 'smtp.gmail.com';
		    $mail->Username   = 'reg.school.system@gmail.com'; 
		    $mail->Password   = 'Support24'; 
		    $mail->SMTPSecure = 'ssl';
		    $mail->Port       = 465;
		    $mail->setFrom('reg.school.system@gmail.com', 'Онлайн система'); 
		    $mail->addAddress($email);  
	        $mail->isHTML(true);
	        $mail->Subject = "Запись на встречу";
	        $mail->Body    = "<p>" .$message. "</p>";

			if ($mail->send()) {
				$query = "UPDATE notes SET meeting_date = '$datetime' WHERE id = $id";
				$result = mysqli_query($link,$query);
				if($result){
					alertredirect("Сообщение отправлено","http://school/?page=cabinet");
				}
				else{
					alertredirect(mysqli_error($link),"http://school/?page=cabinet");
				}
			} 
			else {
				echo $mail->ErrorInfo;
			}
		} 
		catch (Exception $e) {
		    alertredirect("Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}","http://school/?page=cabinet");
		}
	}
}
if(isset($_GET['note_update']) && ($_GET['note_update'])>0){
	if($_SESSION['status']=='moderator'){
		$id = $_GET['note_update'];
		$sid = $_SESSION['sid'];
		$query = "UPDATE notes SET status = 'Проведена' WHERE children_id = $id AND school_id = $sid";
		if(mysqli_query($link,$query)){
			jsredirect("http://school/?page=cabinet");	
		}
		else
		{
			alertredirect("Ошибка","http://school/?page=cabinet");	
		}
	}
	else{
		alertredirect('Ошибка авторизации',"http://school/?page=cabinet");
	}
	
}
if(isset($_GET['status_update1'])){
	if($_SESSION['status']=='moderator'){
		$id = $_GET['status_update1'];
		$sid = $_SESSION['sid'];
		$query = "UPDATE notes SET status = 'Принят' WHERE children_id = $id AND school_id = $sid";
		if(mysqli_query($link,$query)){
			jsredirect("http://school/?page=cabinet");	
		}
		else
		{
			alertredirect("Ошибка","http://school/?page=cabinet");	
		}
	}
	else{
		alertredirect('Ошибка авторизации',"http://school/?page=cabinet");
	}
}
if(isset($_GET['status_update2'])){
	if($_SESSION['status']=='moderator'){
		$id = $_GET['status_update2'];
		$sid = $_SESSION['sid'];
		$query = "UPDATE notes SET status = 'Отказ' WHERE children_id = $id AND school_id = $sid";
		if(mysqli_query($link,$query)){
			jsredirect("http://school/?page=cabinet");	
		}
		else
		{
			alertredirect("Ошибка","http://school/?page=cabinet");	
		}
	}
	else{
		alertredirect('Ошибка авторизации',"http://school/?page=cabinet");
	}
}
if(isset($_POST['send_note'])){
	$id = $_POST['children_id'];
	$sid = $_POST['school_id'];
	$query = "INSERT INTO notes (children_id, school_id) VALUES ($id, $sid)";
	$result = mysqli_query($link,$query);
	if($result){
		alertredirect('Заявка отправлена',"http://school/?page=cabinet");
	}
	else{
		alertredirect('Ошибка отправки заявки',"http://school/?page=cabinet");
	}
}
?>
