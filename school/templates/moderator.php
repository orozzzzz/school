<div id="picupload_field" opendiv=""></div>
<div id="new_note" class="picupload_frame" style="left:-225px; width:500px;">
    Новая запись<span id="message_number"></span><div class="picupload_close">X</div>
    <form style="height: 300px;" method="post" action="./req/POSTs.php">
    	<input type="text" name="email" hidden="" id="new_note_parent">
    	<input type="text" id="new_note_id" hidden="" name="id">
    	<p>Дата:<input type="date" name="new_note_date"> Время:<input type="time" name="new_note_time"></p>
	 	<textarea style="resize: none; height: 75%; width: 90%;" name="message"> </textarea>
    	<p style="margin:0;" align="center"><input type="submit" name="new_note" value="Ответить"></p>
    </form>
</div>
<div class="moderator_block">
		<?
		$id = $_SESSION['sid'];
		$query = "SELECT startdate, enddate FROM school WHERE id = $id";
		$result = mysqli_query($link,$query);
		if ($result){
			$row=mysqli_fetch_row($result);
			?><form method="post" action="./req/POSTs.php">	
				<p align="center">Прием заявок с 
				<input type="date" name="startdate" disabled="" value="<? echo $row[0];?>">
				по 
				<input type="date" name="enddate" disabled="" value="<? echo $row[1];?>">
				<input type="button" onclick="this.form.startdate.disabled=false;this.form.enddate.disabled=false;this.hidden=true;this.form.setdate.hidden=false;" value="Изменить" name="">
				<input type="submit" name="setdate" hidden="" value="Сохранить">
				</p>
				</form>
			<?
			}
		?>
		<fieldset style="margin: 10px; background-color: white;" class="notes_list">
			<legend>Входящие заявки</legend>
			<?
			$query = "SELECT notes.id, children.fio, children.class, parent.email,parent.telephone FROM notes,parent, children,school WHERE notes.children_id=children.id AND children.parent_id = parent.id AND school.id = notes.school_id AND notes.school_id = $id AND notes.meeting_date IS NULL ORDER BY children.class";
			$result = mysqli_query($link,$query);
			if ($result){
				if (mysqli_num_rows($result)==0)
				{
					echo "<p align='center'>Входящих заявок нет</p>";
				}
				else{
					while ($row = mysqli_fetch_row($result)) {
						?>
						<p style="font-size: 1.2em;">
							<? echo $row[1];?>
							<i><? echo $row[2]." класс" ;?></i>
							<button class="picupload" iddiv="new_note" onclick="document.getElementById('new_note_parent').value='<?echo $row[3]; ?>',document.getElementById('new_note_id').value='<?echo $row[0]; ?>'">Запланировать встречу</button>
						</p><br>
						<?
					}
				}
			}
			?>
		</fieldset>
		<fieldset style="margin: 10px; background-color: white;" >
			<legend>Запланированные встречи</legend>
			<?
				$query = "SELECT notes.id, children.fio, children.class,notes.meeting_date, parent.email,notes.status, children.id FROM notes,parent, children,school WHERE notes.children_id=children.id AND children.parent_id = parent.id AND school.id = notes.school_id AND notes.school_id = $id AND notes.meeting_date IS NOT NULL ORDER BY children.class";
				$result = mysqli_query($link,$query);
				if ($result){
					if (mysqli_num_rows($result)==0)
					{
						echo "<p align='center'>Запланированных встреч нет</p>";
					}
					else{
						echo "<table align=center>";
						echo "<tr><th width=300>ФИО</th><th width=130>Класс</th><th width=100>Дата</th><th width=100>Время</th><th width=100>Статус</th><th width=100>Результат</th></tr>";
						
						while ($row = mysqli_fetch_row($result)) {
							$date = explode(" ", $row[3]);
							if ($row[5]==''){
								$status = "<button><a style='text-decoration:none; color:black;' href='http://school/req/POSTs.php/?note_update=". $row[6] ."'".">Проведена</a></button>";
								}
							elseif ($row[5]=="Проведена"){
								$status = "Проведена✔";
							}
							elseif ($row[5]=="Принят"){
								$status = "Принят";
							}
							elseif ($row[5]=="Отказ"){
								$status = "Отказ";
							}
							if ($status!=''){
								$reply = 
								"<button><a style='text-decoration:none; color:black;' href='http://school/req/POSTs.php/?status_update1=". $row[6] ."'".">➕</a></button>".
								"<button><a style='text-decoration:none; color:black;' href='http://school/req/POSTs.php/?status_update2=". $row[6] ."'".">➖</a></button>";
							}
							?>
							<tr>
								<td align="center"><? echo $row[1];?></td>
								<td align=center><i><? echo $row[2]." класс" ;?></i></td>
								<td align=center><? echo date('d.m.Y',strtotime($date[0]));?>
								<td align=center><? echo substr($date[1], 0,5);?></td>
								<td align="center"><? echo $status;?></td>
								<td align="center"><? if(isset($reply)) echo $reply; ?></td>
							</tr>
							
							<?
						}
						echo "</table>";
					}
				}
			?>
		</fieldset>
</div>