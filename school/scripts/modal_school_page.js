	var modal = document.getElementsByClassName("maininfochangemodal")[0];
	var btn = document.getElementById("maininfochangebutton");
	var span = document.getElementsByClassName("close")[0];
	btn.onclick = function() {
		modal.style.display = "block";
	}
	span.onclick = function() {
		modal.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	var cmodal = document.getElementsByClassName("contentchangemodal")[0];
	var cbtn = document.getElementById("crudbutton1");
	var cspan = document.getElementsByClassName("cclose")[0];
	function changecontent(title, content) {
		var old_h= document.getElementById('oldheader').value = title;
		var new_h = document.getElementById('newheader').value = title;
		document.getElementById('contentchangebutton').hidden = false;
		document.getElementById('newcontentbutton').hidden = true;
		var header = document.querySelector('.pagecontent--'+content);
		document.getElementById('content').value = header.innerHTML;
		cmodal.style.display = "block";
	}
	function addcontent(){
		document.getElementById('newcontentbutton').hidden = false;
		document.getElementById('contentchangebutton').hidden = true;
		document.getElementById('content').value="";
		document.getElementById('newheader').value="";
		cmodal.style.display = "block";
	}
	cspan.onclick = function() {
		cmodal.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == cmodal) {
			cmodal.style.display = "none";
		}
	}

	function uploadimagefunc(button){
		button.hidden=true;
		document.getElementById('uploadimageframe').hidden = false;

	}
