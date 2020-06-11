function changechildinfo(id,row){
	document.getElementById('newchildform').hidden=false;
	document.getElementById('newchildbutton').hidden=true;
	document.getElementById('addchildbutton').hidden=true;
	document.getElementById('changechildbutton').hidden=false;
	var index = row.parentNode.parentNode.rowIndex;
	var table = document.getElementById("childrendata");
	document.getElementById('c_id').value=id
	document.getElementById('c_name').value=table.rows[index].cells[0].innerHTML;
	if (table.rows[index].cells[1].innerHTML=='Мужской'){
		document.getElementById('c_gender').selectedIndex=0;	
	}
	else{
		document.getElementById('c_gender').selectedIndex=1;	
	}
	var date = table.rows[index].cells[2].innerHTML.split('-');
	var day = document.getElementById('day');
	var month = document.getElementById('month');
	var year = document.getElementById('year');
	var _class = document.getElementById('_class');
	for (var i = 1; i<32;i++){
		day[i-1]=new Option(i,i);
	}
	for (var i = 1; i<13;i++){
		month[i-1]=new Option(i,i);
	}
	for (var i = 2000; i<2016;i++){
		year[i-2000]=new Option(i,i);
	}
	for (var i = 1; i<12;i++){
		_class[i-1]=new Option(i,i);
	}
	document.getElementById('year').selectedIndex = date[2]-2000;
	document.getElementById('month').selectedIndex = date[1]-1;
	document.getElementById('day').selectedIndex = date[0]-1;
	document.getElementById('_class').selectedIndex = (table.rows[index].cells[3].innerHTML)-1;
}

function newchildfunc(){
	document.getElementById('newchildbutton').hidden=true;
	document.getElementById('addchildbutton').hidden=false;
	document.getElementById('newchildform').hidden=false;
	var day = document.getElementById('day');
	var month = document.getElementById('month');
	var year = document.getElementById('year');
	var _class = document.getElementById('_class');
	for (var i = 1; i<32;i++){
		day[i-1]=new Option(i,i);
	}
	for (var i = 1; i<13;i++){
		month[i-1]=new Option(i,i);
	}
	for (var i = 2000; i<2016;i++){
		year[i-2000]=new Option(i,i);
	}
	for (var i = 1; i<12;i++){
		_class[i-1]=new Option(i,i);
	}
	document.getElementById('c_name').value="";
	document.getElementById('year').selectedIndex = 0;
	document.getElementById('month').selectedIndex = 0;
	document.getElementById('day').selectedIndex = 0;
	document.getElementById('_class').selectedIndex = 0;
}

function newchildformhide(){
	document.getElementById('newchildbutton').hidden=false;
	document.getElementById('newchildform').hidden=true;
	document.getElementById('addchildbutton').hidden=true;
	document.getElementById('changechildbutton').hidden=true;
}


