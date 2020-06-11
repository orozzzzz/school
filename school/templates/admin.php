<div id="picupload_field" opendiv=""></div>
<div id="message_modal" class="picupload_frame" style="left:-225px; width:500px;">
    Ответ на сообщение #<span id="message_number"></span><div class="picupload_close">X</div>
    <form style="height: 300px;" method="post" action="./req/POSTs.php">
    	<input type="text" hidden="" name="id" id="question_id">
    	<input type="text" hidden="" name="email" id="question_email">
	 	<textarea style="resize: none; height: 85%; width: 90%;" name="message"> </textarea>
    	<p style="margin:0;" align="center"><input type="submit" name="send_answer" value="Ответить"></p>
    </form>
</div>
<div id="upload_pic_message" class="picupload_frame" style="left:-225px; width:500px;">
    Сообщение<div class="picupload_close">X</div>
    <form style="height: 300px;" method="post" action="./req/POSTs.php">
    	<p align="left" style="margin-left: 20px;">Тема: <input type="text" name="theme" value="Фотографии документов" size="54"></p>
    	<input type="text" name="email" hidden="" id="parent_email">
	 	<textarea style="resize: none; min-height: 75%; width: 90%;" name="message"> </textarea>
    	<p style="margin:0;" align="center"><input type="submit" name="send_message" value="Ответить"></p>
    </form>
</div>
<div id="new_school_modal" class="picupload_frame" style="left:-275px; top: 10px; width:550px;">
    Добавление новой школы<div class="picupload_close">X</div>
    <form style="height: 400px;" method="post" action="./req/POSTs.php">
		<p align="left"><b>Название:</b></p><p><textarea rows="3" cols="63" name="name"></textarea></p>
		<p align="left"><b>Адрес:</b><input size="60" type='text' name="address"></p>
		<p align="left"><b>Телефон:</b><input size="15" type='text' name="telephone">
						<b style="margin-left: 10px;">E-mail:</b><input size="20"type='text' name="email"></p>
		<p align="left"><b>Короткое название:</b><input size="50" type='text' name="shorttitle"></p>
		<p align="left"><b>Руководитель:</b><input size="40" type='text' name="director"></p>
		<p align="left"><b>Год основания:</b><input size="5" type='text' name="year">
						<b style="margin-left: 10px;">Количество учеников:</b><input size="5" type='text' name="ccount"></p>
		<p align="left"><b>Количество преподавателей:</b><input size="4" type='text' name="tcount"></p>
		<p align="left"><b>Координаты по X:</b><input size="10" type='text' name="cor1">
						<b style="margin-left: 10px;">Координаты по Y:</b><input size="10" type='text' name="cor2"></p>
		<p align="left"><b>Логин</b><input size="20" type='text' name="login">
						<b style="margin-left: 10px;">Пароль:</b><input size="20" type='password' name="pass"></p>

		<p align="center"><input type="submit" name="new_school" value="Сохранить"></p>
    </form>
</div>
<div class="tabs">
	<input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
	<label for="tab-btn-1" >Сообщения</label>
	<input type="radio" name="tab-btn" id="tab-btn-2" value="">
	<label for="tab-btn-2" >Школы</label>
	<input type="radio" name="tab-btn" id="tab-btn-3" value="" >
	<label for="tab-btn-3">Документы</label>
	<div id="message_block">
		<div class="form_toggle">
			<div class="form_toggle-item item-1">
				<input id="fid-1" type="radio" name="radio" value="off" checked onclick="document.getElementsByClassName('unanswered_messages')[0].style.display='none',document.getElementsByClassName('all_messages')[0].style.display='block'">
				<label for="fid-1">Все сообщения</label>
			</div>
			<div class="form_toggle-item item-2">
				<input id="fid-2" type="radio" name="radio" value="on" onclick="document.getElementsByClassName('all_messages')[0].style.display='none',document.getElementsByClassName('unanswered_messages')[0].style.display='block'">
				<label for="fid-2">Неотвеченные</label>
			</div>
		</div>
	  <?
	  echo "<div class=all_messages>";
	  $query = "SELECT * FROM messages";
	  $result = mysqli_query($link,$query);
	  if($result){
	  	if (mysqli_num_rows($result)==0){
	  		?>
	  		<p align="center">Новых сообщений нет</p>
	  		<?
	  	}
	  	else{
	      	while ($row = mysqli_fetch_row($result)) {
	      		$datetime = explode(" ", $row[1]);
	      		$answerdatetime = explode(" ", $row[6]);
			   ?>
				<div class="msg"> 
					<p align="left"><i>#<? echo $row[0];?></i> <span style="margin-left: 20px;">
						<? echo "Дата: ".date('d.m.Y',strtotime($datetime[0]))." Время: ".$datetime[1];?></span>
						<? if (isset($row[6])) {?>
						<span style="float: right;">Ответ был дан: <? echo date('d.m.Y',strtotime($answerdatetime[0]))." ".$answerdatetime[1];?></span></p><? }?>
					<p align="center"><? echo $row[4];?></p>
					<p align="right"><? echo $row[2];?></p>
					<p align="center">
						<button onclick="delete_question(<? echo $row[0];?>);">Удалить</button>
						<button iddiv="message_modal" onclick="answer_form(<? echo $row[0]; ?>,'<? echo $row[3]; ?>');" class="picupload">Ответить</button></p>
				</div>
			   <?
			}
		}
	  }
	  echo "</div>";
	  echo "<div class=unanswered_messages style='display:none;'>";
	  $query = "SELECT * FROM messages WHERE status NOT IN ('answered')";
	  $result = mysqli_query($link,$query);
	  if($result){
	  	if (mysqli_num_rows($result)==0){
	  		?>
	  		<p align="center">Новых сообщений нет</p>
	  		<?
	  	}
	  	else{
	      	while ($row = mysqli_fetch_row($result)) {
	      		$datetime = explode(" ", $row[1]);
			   ?>
				<div class="msg"> 
					<p align="left"><i>#<? echo $row[0];?></i> <span style="margin-left: 20px;">
						<? echo "Дата: ".date('d.m.Y',strtotime($datetime[0]))." Время: ".$datetime[1];?></span>
					<p align="center"><? echo $row[4];?></p>
					<p align="right"><? echo $row[2];?></p>
					<p align="center">
						<button onclick="delete_question(<? echo $row[0];?>);">Удалить</button>
						<button iddiv="message_modal" onclick="answer_form(<? echo $row[0]; ?>,'<? echo $row[3]; ?>');" class="picupload">Ответить</button></p>
				</div>
			   <?
			}
		}
	  }
	  echo "</div>";
	  ?>
	</div>
	<div id="school_block">
			<?
	  	$query = "SELECT id,name,active FROM school WHERE name IS NOT NULL";
	  	$result = mysqli_query($link, $query);
	  	if($result){
	  		$i = 1;
	  		?>
	  		<span style="display: block; float: left;width: 65%; border-bottom: 1px solid black;padding-left: 15%; padding-bottom: 10px;"><p align="center">Название</p></span>
	  		<span style="display: block; float: right;width: 20%; border-bottom: 1px solid black;padding-bottom: 10px;"><p style="padding-left: 40px;" align="center">Активна?</p></span>

	  		<?
	  		while ($row = mysqli_fetch_row($result)) {
	  			$i++;
	  			?>
	  			<div class="school_row" style="display: inline-block; <? if($i%2==0) {echo "background-color: #e5e5e5;";} ?>">
	  				<span class="span1">
	      				<? if (file_exists($DIR."\schools\\".$row[0]."\\main_pic.jpg")){
	      						echo "<img src='schools/".$row[0]."/main_pic.jpg' height=70 width=70>";
	      					}
	      				   else{
	      				   	 	echo "<img src='attach/no_photo.png' height=70 width=70>";
	      				   }
	      				?>
	  				</span>
	  				<span class="span2">
	  					<p align="center" style="margin-top: 5px;"><?echo $row[1];?></p>
	  					<p align="center"><a href="http://school/?page=school&id=<? echo $row[0];?>">ссылка</a> </p>
	  				</span>
	  				<span class="span3">
	  					<div class="checkboxbtn r" id="checkboxbtn-1">
						    <input type="checkbox" class="checkbox" <?if($row[2]=='false'){echo "checked";} ?> value="<? echo $row[0]; ?>">
						    <div class="knobs"></div>
						    <div class="layer"></div>
						  </div>
	  				</span>
	  			</div>
	  			<br>
	  			<?
	  		}
	  	}
		?>
		<p align="center"><button><a href='#' style="text-decoration: none; color: black; " iddiv='new_school_modal' class='picupload'>Добавить новую школу</a></button></p>
	</div>
	<div id="document_block">
	    <?php
		    if ($dh = opendir($DIR.'\\documents\\consideration_photos\\'))
		    {
		    	$pic = array();
		    	$children = array();
		    	$query = "SELECT children.id,children.fio,children.birthdate,children.class,parent.email FROM children, parent WHERE children.parent_id=parent.id";
		    	$result = mysqli_query($link,$query);
		    	if($result){
		    		while ($row = mysqli_fetch_row($result)){
		    			$children[]=array('id' => $row[0], 'fio' => $row[1],'birthdate' => $row[2],'class' => $row[3], 'email' => $row[4]);
		    		}
		    	}
		    	$count = 0;
		        while (($file = readdir($dh)) !== false) 
		        {
		            if($file=='.' || $file=='..') continue;
		            if(!is_dir($file))
		            	$pic[] = array('date' => filectime($DIR.'\\documents\\consideration_photos\\'.$file), 'value' => $file);
		            $count++;
		        }
		        closedir($dh); 
		        $date  = array_column($pic, 'date');
				$value = array_column($pic, 'value');
		        array_multisort($date, SORT_ASC,$pic);
		    }
		    $i=0;
		    foreach($pic as $key){
		    	$href =  $key['value'];
		    	$type = '';
		    	$id = search_array($children,preg_replace("/[^0-9]/", '', $href));
		    	?>
					<div class='consideration' >
						<span style="display: block; float: left;">
							<p><? echo $children[$id]['fio']; ?>
							   <? echo date('d.m.Y',strtotime($children[$id]['birthdate']))." "; ?>
							   <? echo $children[$id]['class']." класс"; ?>
							<i><?
								if(mb_strimwidth($href,0,5)=='photo'){
									echo "Фотография";
									$type = 'photo';
								}
								elseif (mb_strimwidth($href,0,5)=='hcert') {
									echo "Справка о здоровье";
									$type = 'hcert';
								}
								elseif (mb_strimwidth($href,0,4)=='cert') {
									echo "Свидетельство о рождении";
									$type = 'cert';
								}
								?></i></p>
						</span>
						<span style="display: block; float: left;">
							<button><a style="text-decoration: none;" href="<? echo '\\documents\\consideration_photos\\'.$href; ?>" target="_blank">👁️</a></button>
							<button class='<? echo $type;?>' confirmed="true" name="<? echo $i;?>" value="<? echo $children[$id]['id']; ?>">✔️</button>
							<button class='<? echo $type;?>' confirmed="false" name="<? echo $i;?>" value="<? echo $children[$id]['id']; ?>">❌</button>
							<button iddiv="upload_pic_message" class="picupload" onclick="document.getElementById('parent_email').value='<? echo $children[$id]['email'];?>'">✉️</button>
						</span>
					</div>
		    	<?
		    	$i++;
		    }
		?>
	</div>
</div>
