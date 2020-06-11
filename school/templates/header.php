<div class="header_block">
<div class="homeicon"><a href='http://school/'><img src="attach/home_icon.png" height="30" width="30"></a></div>
<p>Онлайн поступление в школу</p>
<?
if (!isset($_SESSION['status'])){ ?>
		<div class="modal">
		<a class="btn" href="#reg">Регистрация</a>
			<div id="reg" class="regmodalDialog">
				<div class="regmodal">
					<a href="#" title="Закрыть" class="close">X</a>
					<h2>Регистрация</h2>
					<form method="POST" action="./req/POSTs.php">
						Ф.И.О.<input type="text" name="name1" maxlength="30" required="" size="15"><input type="text" name="name2" maxlength="30" required size="10"><input type="text" name="name3" maxlength="30" required="" size="15">
						<br>
						E-mail  <input type="email" name="email" maxlength="30" required="" size="30">
						  Телефон<input type="text" name="telephone" required placeholder="8xxxxxxxxxx" pattern="8[0-9]{10}" size="10">
						<br>
						Адрес проживания <input type="text" name="address" required="" size="43">
						Пароль <input type="password" name="password1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="psw1" required="" size="18">
						Подтверждение <input type="password" name="password2" id="psw2" required="" size="17">
						<div id="message">
						  <h3>Пароль должен соответствовать требованиям:</h3>
						  <p id="letter" class="invalid">Латинские символы верхнего и нижнего регистра</p><br>
						  <p id="number" class="invalid">Наличие хотя бы одной цифры</p><br>
						  <p id="length" class="invalid">От 8 до 20 символов</p><br>
						  <p id="same" class="invalid">Пароли не совпадают</p><br>
						</div>
						<br><br>
						<input type="submit" name="registration" id="regbutton" style="margin-left: 240px;">
					</form>
				</div>
			</div>	

		<a class="btn" href="#auth" >Войти</a>
			<div id="auth" class="authmodalDialog">
				<div>
					<a href="#" title="Закрыть" class="close">X</a>
					<h2>Авторизация</h2>
					<form method="POST" action="req/POSTs.php">
						<p>E-mail  <input type="email" name="email" required="" size="20" style="float: right;"></p>
						<p>Пароль <input type="password" name="password" required="" size="20" style="float: right;"></p>
						<p>Войти как <input type="submit" name="adm_auth" value="модератор"><input type="submit" name="user_auth" value="родитель"></p>
						<a href="#recovery" style="padding: 0;margin: 0;margin-left: 60px;font-size: 0.8em;">восстановить пароль</a>
					</form>
				</div>
			</div>
			<div id="recovery" class="recmodalDialog">
				<div>
					<a href="#" title="Закрыть" class="close">X</a>
					<h2>Восстановление пароля</h2>
					<form method="POST" action="req/POSTs.php">
						<p>Введите свой e-mail.<br> На него придет письмо с инструкцией по восстановлению доступа к системе<input type="email" name="email" required="" size="28"></p>
						<p align="center"><input type="submit" name="recovery" value="Отправить"></p>
					</form>
				</div>
			</div>	
		</div>
		<?
	}
else{
	?>
	<div class="userinfo"><span id="FIO"><? 
	if($_SESSION['status']=='moderator')
	{
		echo '</a></p><a href="http://school/?page=school&id='.$_SESSION['sid'].'">Моя школа</a>';
	}
	if($_SESSION['status']=='parent'){
		echo $_COOKIE['FIO']; 
	}
	?></span>  <a href="http://school/?page=cabinet">Личный кабинет</a><a href="http://school/req/exit.php"><img src="attach/exit.png" height="20" width="20"></a></div>
	<?
}?>
</div>