function handleFileSelectSingle(evt) {
	var file = evt.target.files;
	var n = evt.target.id.substr(evt.target.id.length - 1);
	var f = file[0];
	if (!f.type.match('image.*')) {
		alert("Неправильный формат изображения");
	}
	else{
		var reader = new FileReader();

		reader.onload = (function(theFile) {
		return function(e) {
			var span = document.createElement('span');
			span.innerHTML = ['<img class="img-thumbnail" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
			document.getElementById('uploadimage'+n).innerHTML = "";
			document.getElementById('uploadimage'+n).insertBefore(span, null);
		};
		})(f);
		reader.readAsDataURL(f);
	}
}
document.getElementById('file1').addEventListener('change', handleFileSelectSingle, false);
document.getElementById('file2').addEventListener('change', handleFileSelectSingle, false);
document.getElementById('file3').addEventListener('change', handleFileSelectSingle, false);

function changeOption(){
	var d30 = ['1','3','5','7','8','10','12'];
	var d31 = ['4','6','9','11'];
	var selectedind = document.getElementById('day').selectedIndex;
	if(document.getElementById('year').value%4==0 && document.getElementById('month').value==2){
		var select = document.getElementById("day");
		var length = select.options.length;
		for (i = length-1; i >= 0; i--) {
			select.options[i] = null;
		}
		for (var i = 1; i<30;i++){
			select[i-1]=new Option(i,i);
		}
	}
	if(document.getElementById('year').value%4!=0 && document.getElementById('month').value==2){
		var select = document.getElementById("day");
		var length = select.options.length;
		for (i = length-1; i >= 0; i--) {
			select.options[i] = null;
		}
		for (var i = 1; i<29;i++){
			select[i-1]=new Option(i,i);
		}
	}
	if(document.getElementById('month').value!=2 && d31.indexOf(document.getElementById('month').value)>-1){

		var select = document.getElementById("day");
		var length = select.options.length;
		for (i = length-1; i >= 0; i--) {
			select.options[i] = null;
		}
		for (var i = 1; i<31;i++){
			select[i-1]=new Option(i,i);
		}
	}
	if(document.getElementById('month').value!=2 && d30.indexOf(document.getElementById('month').value)>-1){
		var select = document.getElementById("day");
		var length = select.options.length;
		for (i = length-1; i >= 0; i--) {
			select.options[i] = null;
		}
		for (var i = 1; i<32;i++){
			select[i-1]=new Option(i,i);
		}
	}
	document.getElementById('day').selectedIndex = selectedind;

}
newchild.select2.addEventListener("change",changeOption);
newchild.select3.addEventListener("change",changeOption);