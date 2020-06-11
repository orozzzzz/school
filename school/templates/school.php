<?php
if (isset($_GET['id'])){?>
<div class="school">
	<?
	$id = $_GET['id'];
	$moderator_id = $_SESSION['sid'];
	if($moderator_id==$id && $_SESSION['status']=='moderator'){
		$change = true;
	}
	$result = mysqli_query($link,"SELECT * FROM school WHERE id = $id");
	$school = mysqli_fetch_row($result);
	?>
	<h1 align="center"><? echo $school[1]; ?></h1>
	<? if ($_SESSION['status']=='parent'){?>
			<div id="picupload_field" opendiv=""></div>
			<div id="send_note" class="picupload_frame" style="left:-225px; width:500px; ">
		      Отправка заявки<div class="picupload_close">X</div>
		      <div class="picupload_body" style="min-height:200px; ">
		          <form method="post" enctype='multipart/form-data' action="./req/POSTs.php">
		          		<input type="text" hidden="" name="school_id" value="<? echo $id; ?>">
			          	<p style="margin: 0;" align="center">Выберите ребёнка из списка</p>
			          	<?
			          		$parent_id = $_SESSION['id'];
			          		$DIR = 'documents\confirmed_photos\\';
			          		$query = "SELECT id,fio,class FROM children WHERE parent_id = $parent_id";
			          		$result = mysqli_query($link,$query);
			          		if($result){
			          			echo "<table class='children_table' align='left'>";
			          			while ($row = mysqli_fetch_row($result)) {
			          				?>
			          				<tr>
			          					<td width="250">
			          						<? echo $row[1]; ?>
			          					</td>
			          					<td>
			          						<? echo $row[2]." класс"; ?>
			          					</td>
			          					<td>
			          						<? 
												if (file_exists($DIR."cert".$row[0].".png") && file_exists($DIR."photo".$row[0].".png") && file_exists($DIR."hcert".$row[0].".png")){?>
													<input style="margin: 0;" type="radio" value="<? echo $row[0]; ?>" name="children_id">
												<?}?>
			          					</td>
			          				</tr>
			          				<?
			          			}
			          			echo "</table>";
			          		}
			          	?>
			          	<br>
			          	<p style="margin: 0;" align="center"><i style="font-size: 0.8em;">Отправлять заявку для поступления ребёнка можно только после подтверждения всех документов</i></p>
			          	<input type="submit" name="send_note">
		          </form>
		      </div>
		    </div>
			<?
			$date = date('Y-m-d');
			$query = "SELECT id FROM school WHERE startdate <= '$date' AND enddate >= '$date' AND id = $id";
			$result = mysqli_query($link,$query);
			if($result){
				$rows = mysqli_num_rows($result);
				if ($rows>0){
					?>
					<p align="center" style="padding-bottom:10px; margin: 0;"><input type="button" class="picupload" iddiv='send_note' value="Отправить заявку"></p>
					<?
				}
			}
			?>
			
			
		<?}?>
	<div class="mainpic">
		<img src=<? if (file_exists('schools\\'.$school[0].'\\main_pic.jpg')){ echo "schools/$school[0]/main_pic.jpg?clear=".rand(); } else {echo "attach/no_photo.png"; } ?> >
		<?
		if ($change){
			?>
			<form method="post" enctype='multipart/form-data' action="./req/POSTs.php" class="uploadimage">
				<p align="center"><input type="button" onclick="uploadimagefunc(this)" value='Изменить' ></p>
				<p align="center" hidden="" id="uploadimageframe"><input type='file' name='file' size='10' style="width: 115px;">
				<input type='submit' name="uploadschoolimage" value='Загрузить' /></p>
			</form>
			<?
		}
		?>
	</div>
	<div class="sinfo">
			<h3>Основная информация:</h3>
			<p><b>Адрес:</b><span><? echo $school[2]; ?></span></p>
			<p><b>Телефон:</b><span><? echo $school[3]; ?></span></p>
			<p><b>E-mail:</b><span><? echo $school[5]; ?></span></p>
			<p><b>Короткое название:</b><span><? echo $school[6]; ?></span></p>
			<p><b>Руководитель:</b><span><? echo $school[4]; ?></span></p>
			<p><b>Год основания:</b><span><? echo $school[7]; ?>г.</span></p>
			<p><b>Количество учеников:</b><span><? echo $school[8]; ?> детей</span></p>
			<p><b>Количество преподавателей:</b><span><? echo $school[9]; ?> человек</span></p>
			<? if($change){
				?>
				<p align="center"><button id='maininfochangebutton'>редактировать</button></p>
				<?
			}?>

			<script>document.title='<? echo $school[1];?>';</script>
	</div>
	<?
	$result = mysqli_query($link,"SELECT title, content FROM page WHERE school_id = '$id'");
	 while ($row = mysqli_fetch_row($result)) {
	    $titles[] = $row[0];
	    $contents[] = $row[1];
	}
	?>
	<div class="schoolhreflist">
		<ul>
			<?
				$j=1;
				foreach ($titles as $title) {
					if( $j==1){
						echo "<li><div class='sbutton chosen' data-value=\"$j\">$title";
						if ($change){
							echo "<a class='crudbuttons' id='crudbutton1' onclick='changecontent(\"$title\",$j)'>✒️</a>
							<a class='crudbuttons' id='crudbutton2' onClick='return confirm(\"Намжите ОК для удаления\")' href='http://school/req/POSTs.php/?deletepage=".$title."' style='text-decoration:none;'>🗑️</a>";
						}
						echo "</div></li>";
					}
					else{
						echo "<li><div class='sbutton ' data-value=\"$j\">$title";
						if($change){
							echo "<a class='crudbuttons' id='crudbutton1' onclick='changecontent(\"$title\",$j)'>✒️</a>
							<a class='crudbuttons' id='crudbutton2' onClick='return confirm(\"Намжите ОК для удаления\")' href='http://school/req/POSTs.php/?deletepage=".$title."' style='text-decoration:none;'>🗑️</a>";
						}
						echo "</div></li>";
					}
					$j=$j+1;
				}
			?>
		</ul>
		<? if ($change){?>
			<p align="center" style="padding: 0; margin: 0;"><button onclick="addcontent()">добавить</button></p>
		<?}?>
		
	</div>
	<div class="schoolcontent">
	    <?
			$j=1;
			foreach ($contents as $content) {
				if ($j==1){
					echo "<div class='tab tab--$j active'>";
					echo "<h2>".$titles[$j-1]."</h2>";
					echo "<div class='pagecontent--$j'>";
					echo $content;
					echo "</div>";
					echo "</div>";	
				}
				else{
					echo "<div class='tab tab--$j'>";
					echo "<h2>".$titles[$j-1]."</h2>";
					echo "<div class='pagecontent--$j'>";
					echo $content;
					echo "</div>";	
					echo "</div>";	
				}
				$j=$j+1;
			}
		?>
	</div>
</div>
<div class="maininfochangemodal">
	<div class="modal-content">
		<form method="POST" action="./req/POSTs.php">
		<span class="close">&times;</span>
		<p><b>Название:</b><textarea  rows="3" cols="60" name="name"><? echo $school[1]; ?></textarea></p><br>
		<p><b>Адрес:</b><input size="59" type='text' value='<? echo $school[2]; ?>' name="address"></p>
		<p><b>Телефон:</b><input size="30" type='text' value='<? echo $school[3]; ?>' name="telephone"></p>
		<p><b>E-mail:</b><input size="30"type='text' value='<? echo $school[5]; ?>' name="email"></p>
		<p><b>Короткое название:</b><input size="30" type='text' value='<? echo $school[6]; ?>' name="shorttitle"></p>
		<p><b>Руководитель:</b><input size="30" type='text' value='<? echo $school[4]; ?>' name="director"></p>
		<p><b>Год основания:</b><input size="30" type='text' value='<? echo $school[7]; ?>' name="year"></p>
		<p><b>Количество учеников:</b><input size="30" type='text' value='<? echo $school[8]; ?>' name="ccount"></p>
		<p><b>Количество преподавателей:</b><input size="30" type='text' value='<? echo $school[9]; ?>' name="tcount"></p>
		<p align="center"><input type="submit" name="changeschoolinfo" value="Сохранить"></p>
		</form>
	</div>
</div>
<div class="contentchangemodal" >
	<div class="modal-content">
	<form method="POST" action="./req/POSTs.php">
		<span class="cclose">&times;</span>
		<input type="text" name="oldheader" id="oldheader" hidden="">
		<p align="left">Заголовок: <input type="text" required="" id="newheader" name="newheader" size="60"></p>
		<p align="left" style="margin-bottom: 0;">
			Содержимое: <textarea name="content" required="" id="content" style="height: 280px; width: 100%;"></textarea></p>
		<input type="button" onclick="taginput('date')" value="Дата">
		<input type="button" onclick="taginput('header')" value="Заголовок">
		<input type="button" onclick="taginput('paragraph')" value="Параграф">
		<input type="button" onclick="taginput('ul')" value="Список">
		<input type="button" onclick="taginput('li')" value="Элемент списка">
		<p align="center">
			<input type="submit" hidden="" id="contentchangebutton" name="contentchange" value="Сохранить">
			<input type="submit" id="newcontentbutton" hidden="" name="newcontent" value="Добавить">
		</p>
	</form>
	</div>
</div>
<script src="./scripts/modal_school_page.js"></script>
<script src="./scripts/schoolpage.js"></script>
<script src="./scripts/contentchange.js"></script>
<script src="scripts/jquery-1.11.1.js"></script>
<script type="text/javascript" src="scripts/cabinet_modalframe.js"></script>
<?}
	else
		header("Location: http://school/templates/404.html");
?>