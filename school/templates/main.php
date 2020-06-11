<div class="mainpage">
	<a name="schools"></a>
	<img src="attach/main_pic.png">
	<h2 align="center">Школы г. Казань</h2>
	<div id="map"></div>
	<div class="schoollist">
	<?
	$query ="SELECT id,shorttitle FROM school WHERE active = 'true'";
	 
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	if($result){
		echo "<ul>";
		while($row=mysqli_fetch_array($result)){
			echo "<li><a href='?page=school&id=".$row['id']."'>".$row['shorttitle']."</a></li>";
		}
		echo "</ul>";
	}
	?>
	</div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=03ab3828-72d4-403a-964b-7379f4ddd5b1>" type="text/javascript"></script>
<script src="scripts/placemark.js" type="text/javascript"></script>