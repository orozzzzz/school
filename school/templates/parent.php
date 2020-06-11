<?
$email = $_SESSION['email'];
$id = $_SESSION['id'];
?>
<h2>Личный кабинет</h2>
<?
$query ="SELECT name1, name2,name3,email,telephone,address FROM parent WHERE email = '$email'";
$result = mysqli_query($link, $query);
if($result){
	$data = mysqli_fetch_row($result);
	?>
	<div id="picupload_field" opendiv=""></div>
	<fieldset style="padding: 0px 50px 0px 50px; background-color: white; margin: 0px 10px 0px 10px">
		<legend>Мои данные</legend>
		<ul class="userdatalist"> 
			<li><b style="padding-right: 10px;">Фамилия:</b> <? echo $data[0];?></li>
			<li><b style="padding-right: 10px;">Имя:</b> <? echo $data[1];?></li>
			<li><b style="padding-right: 10px;">Отчество:</b> <? echo $data[2];?></li>
			<li><b style="padding-right: 10px;">E-mail:</b> <? echo $data[3];?></li>
			<li><b style="padding-right: 10px;">Телефон:</b> <? echo $data[4];?></li>
			<li><b style="padding-right: 10px;">Адрес:</b> <? echo $data[5];?></li>
		</ul>
		<div id="editdata" class="picupload_frame" style="left:-165px; width:350px;">
	      Редактирование личных данных<div class="picupload_close">X</div>
	      <div style="height:260px; ">
	          <form method="post" action="./req/POSTs.php" class="editparentdata">
	          		<p align="right"><label style="float: left; padding-left: 10px;">Фамилия</label><input class="textinput" type="text" name="name1" value=<? echo $data[0];?>></p>
	          		<p align="right"><label style="float: left;  padding-left: 10px;">Имя</label><input class="textinput" type="text" name="name2" value='<? echo $data[1];?>'></p>
	          		<p align="right"><label style="float: left;  padding-left: 10px;">Отчество</label><input class="textinput" type="text" name="name3" value='<? echo $data[2];?>'></p>
	          		<p align="right"><label style="float: left;  padding-left: 10px;">E-mail</label><input class="textinput" type="email" name="email" value='<? echo $data[3];?>'></p>
	          		<p align="right"><label style="float: left;  padding-left: 10px;">Телефон</label><input class="textinput" type="text" name="telephone" value='<? echo $data[4];?>'></p>
	          		<p align="right"><label style="float: left; padding-left: 10px;">Адрес</label><input class="textinput" type="text" name="address" value='<? echo $data[5];?>'></p>
		          	<p align="center"><input type="submit" name="editparentdata" value="Сохранить"></p>
	          </form>
	      </div>
	    </div>
		<p align="center"><input type="button" id='editdata' class="picupload" iddiv='editdata' value="Редактировать"></p>			
	</fieldset>	
	<?
	mysqli_free_result($result);
}
$query ="SELECT id, fio, birthdate, gender,class FROM children WHERE parent_id = (SELECT id FROM parent WHERE email='$email')";
$result = mysqli_query($link, $query);
if($result){
	?>
	<fieldset style="padding: 0px 10px 0px 0px; background-color: white; margin: 0px 10px 0px 10px">
		<legend style="margin-left: 30px;">Мои дети</legend>
		<table id="childrendata" align="center" class="childtable" >
			<tr>
				<th width="280">ФИО</th>
				<th width="80">Пол</th>
				<th width="80">Дата рождения</th>
				<th width="5">Класс</th>
				<th width="160">Фото</th>
				<th width="160">Свидетельство о рождении</th>
				<th width="160">Справка о здоровье</th>
				<th></th><th></th>
			</tr>
			<?
			while ($row = mysqli_fetch_row($result)) {
				echo "<tr>";
				echo "<td align=center>".$row[1]."</td>";
				if ($row[3]=='M'){
					echo "<td align=center>Мужской</td>";
				}
				if ($row[3]=='F'){
					echo "<td align=center>Женский</td>";
				}
				
				echo "<td align=center>".date('d-m-Y',strtotime($row[2]))."</td>";
				echo "<td align=center>".$row[4]."</td>";
				if (file_exists($DIR."\documents\confirmed_photos\photo".$row[0].".png")){
					echo "<td align=center style='color:green;'>"."✔Подтверждено"."</td>";	
				}
				elseif (file_exists($DIR."\documents\consideration_photos\photo".$row[0].".png")){
					echo "<td align=center>"."🕛На рассмотрении"."<br><a onClick='return confirm(\"Намжите ОК для удаления фотографии\")' href='http://school/req/POSTs.php/?deletechildphoto=".$row[0]."' style='text-decoration:none; color:grey;'>удалить️</a>". "</td>";	
				}
				elseif(!file_exists($DIR."\documents\confirmed_photos\photo".$row[0].".png") && !file_exists($DIR."\documents\consideration_photos\photo".$row[0].".png")){
					echo "<td align=center style='color:red;'>"."✖Отсутствует<br><a href='#' iddiv='upload1' class='picupload' onclick=document.cookie=\"id=".$row[0]."\">Загрузить</a>"."</td>";	
				}
				/////////////////////////////////////////////////////////////////////////////////
				if (file_exists($DIR."\documents\confirmed_photos\cert".$row[0].".png")){
					echo "<td align=center style='color:green;'>"."✔Подтверждено"."</td>";	
				}
				elseif (file_exists($DIR."\documents\consideration_photos\cert".$row[0].".png")){
					echo "<td align=center>"."🕛На рассмотрении"."<br><a onClick='return confirm(\"Намжите ОК для удаления свидетельства о рождении\")' href='http://school/req/POSTs.php/?deletechildcert=".$row[0]."' style='text-decoration:none; color:grey;'>удалить️</a>"."</td>";	
				}
				elseif(!file_exists($DIR."\documents\confirmed_photos\cert".$row[0].".png") && !file_exists($DIR."\documents\consideration_photos\cert".$row[0].".png")){
					echo "<td align=center style='color:red;'>"."✖Отсутствует<br><a href='#'  iddiv='upload2' class='picupload' onclick=document.cookie=\"id=".$row[0]."\">Загрузить</a>"."</td>";	
				}
				/////////////////////////////////////////////////////////////////////////////////
				if (file_exists($DIR."\documents\confirmed_photos\hcert".$row[0].".png")){
					echo "<td align=center style='color:green;'>"."✔Подтверждено"."</td>";	
				}
				elseif (file_exists($DIR."\documents\consideration_photos\hcert".$row[0].".png")){
					echo "<td align=center>"."🕛На рассмотрении"."<br><a onClick='return confirm(\"Намжите ОК для удаления справки о здоровье\")' href='http://school/req/POSTs.php/?deletechildhcert=".$row[0]."' style='text-decoration:none; color:grey;'>удалить️</a>"."</td>";	
				}
				elseif(!file_exists($DIR."\documents\confirmed_photos\hcert".$row[0].".png") && !file_exists($DIR."\documents\consideration_photos\h".$row[0].".png")){
					echo "<td align=center style='color:red;'>"."✖Отсутствует<br><a href='#' iddiv='upload3' class='picupload' onclick=document.cookie=\"id=".$row[0]."\">Загрузить</a>"."</td>";	
				}
				echo "<td><a onClick='changechildinfo(".$row[0].",this)' style='cursor:pointer;'>🖊️</a></td>";
				echo "<td><a onClick='return confirm(\"Намжите ОК для удаления записи\")' href='http://school/req/POSTs.php/?deletechildid=".$row[0]."' type='button' style='text-decoration:none;'>🗑️</a>";
				echo "</tr>";
			}
			?>
		</table>
		<form id="newchildform" method="POST" name="newchild" align="center" action="./req/POSTs.php" hidden="">
			<input type="number" id="c_id" name="children_id" hidden="">
			<label>Ф.И.О.</label> <input id="c_name" type="text" name="children_name" size="50" required="">
			<label>Пол</label> <select id="c_gender" name="gender"><option value="M">Мужской</option> <option value="F">Женский</option></select>
			<label>Дата рождения</label><select name="select1" id="day"> </select>
										<select name="select2" id="month"> </select>
										<select name="select3" id="year"> </select>
			<label>Класс</label><select name="select4" id="_class"> </select>
			<input type="submit" name="addchild" id="addchildbutton" value="✔" hidden="" style="cursor: pointer; color: green;">
			<input type="submit" name="updatechild" id="changechildbutton" value="✔" hidden="" style="cursor: pointer; color: green;">
			<input type="button" onclick="newchildformhide();" value="✖" style="cursor: pointer; color: red;">
		</form>
		<p align="center"><input type="button" value="Добавить" name="" id="newchildbutton" align="right" onclick="newchildfunc();"></p>
		
	    <div id="upload1" class="picupload_frame" style="left:-225px; width:500px;">
	      Загрузка фотографии<div class="picupload_close">X</div>
	      <div class="picupload_body" style="height:260px; ">
	          <form method="post" enctype='multipart/form-data' action="./req/POSTs.php">
		          	<span id="uploadimage1"><img src="./attach/no_photo.png"></span>
		          	<input type='file' id="file1" name='file' align="right" style="width: 115px;"/>
		          	<br>
		          	<input align="right" type='submit' value='Удалить' />
		          	<input type='submit' value='Загрузить' align="right" name="upload1"/>
	          </form>
	      </div>
	    </div>

	    <div id="upload2" class="picupload_frame" style="left:-225px; width:500px;">
	      Загрузка свидетельства о рождении<div class="picupload_close">X</div>
	      <div class="picupload_body" style="height:260px; ">
	       <form method="post" enctype='multipart/form-data' action="./req/POSTs.php">
		          	<span id="uploadimage2"><img src="./attach/no_photo.png"></span>
		          	<input type='file' id="file2" name='file' align="right" style="width: 115px;"/>
		          	<br>
		          	<input align="right" type='submit' value='Удалить' />
		          	<input type='submit' value='Загрузить' align="right" name="upload2"/>
	          </form>
	    </div>
	    </div>

	    <div id="upload3" class="picupload_frame" style="left:-225px; width:500px;">
	      Загрузка справка о здоровье<div class="picupload_close">X</div>
	      <div class="picupload_body" style="height:260px; ">
	       <form method="post" enctype='multipart/form-data' action="./req/POSTs.php">
		          	<span id="uploadimage3"><img src="./attach/no_photo.png"></span>
		          	<input type='file' id="file3" name='file' align="right" style="width: 115px;"/>
		          	<br>
		          	<input align="right" type='submit' value='Удалить' />
		          	<input type='submit' value='Загрузить' align="right" name="upload3"/>
	          </form>
	    </div>
	    </div>

	</fieldset>

	<fieldset style="padding: 0px 10px 0px 0px; background-color: white; margin: 0px 10px 0px 10px">
		<legend>Мои заявки</legend>
		<?
		$query = "SELECT DISTINCT children.fio, children.class, school.shorttitle,notes.meeting_date, notes.status 
				  FROM parent, children, notes,school 
				  WHERE children.parent_id = $id AND notes.children_id=children.id AND notes.school_id=school.id";
		$result = mysqli_query($link, $query);
		if($result){
			if (mysqli_num_rows($result)==0){
				echo "<p align='center'>Заявок нет</p>";
			}
			else{
				echo "<table>";
				echo "<tr>
						<th width=300>ФИО</th>
						<th width=100>Класс</th>
						<th width=250>Школа</th>
						<th width=100>Дата</th>
						<th width=80>Время</th>
						<th width=300>Статус</th>
   					 </tr>";
				while ($row = mysqli_fetch_row($result)) {
					$date = explode(" ", $row[3]);
					if ($row[4]==''){
						$status = 'Неизвестно';
						$date[0]="-";
						$date[1]="-";
					}
					else{
						$status = $row[4];
						$date[0]=date('d.m.Y',strtotime($date[0]));
						$date[1]=substr($date[1],0,5);
					}
					echo "<tr>";
					echo "<td align='center' style='padding-bottom:10px;'>".$row[0]."</td>";
					echo "<td align='center'>".$row[1]." класс</td>";
					echo "<td align='center'>".$row[2]."</td>";
					echo "<td align='center'>".$date[0]."</td>";
					echo "<td align='center'>".$date[1]."</td>";
					echo "<td align='center'>".$status."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
		}
		?>
	</fieldset>

	<?
}
else{
	?>
	<script type="text/javascript">
		alert("Что-то пошло не так");
		window.location.href = 'http://school/templates/404.html';
	</script>
	<?
}