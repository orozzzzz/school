<hr>
<ul style="display: block;" class="footerlist">
	<li><a href='http://school/'>Главная</a></li>
	<li><a href='http://school/#schools'>Школы</a></li>
	<li><a href='http://school/?page=cabinet'>Личный кабинет</a></li>
</ul>
<hr>
<p class="footerright">Для того, чтобы обратиться в техническую поддержку, нажмите <a href="#request">сюда</a></p>
<div class="modal">
	<div id="request" class="reqmodalDialog">
		<div>
			<a href="#" title="Закрыть" class="close">X</a>
			<h2>Обратная связь</h2>
			<form method="POST" action="./req/POSTs.php">
				<p>Ф.И.О.<input type="text" name="fio" required="" size="25"></p>
				<p>E-mail<br><input type="email" name="email" required="" size="25"></p>
				<p>Текст сообщения</p>
				<textarea name="text" id="" cols="27" rows="10" required="" style="resize: none; text-align: left;"></textarea>
				<p align="center"><input type="submit" name="request" value="Отправить"></p>
			</form>
		</div>
	</div>	
</div>
</div>
