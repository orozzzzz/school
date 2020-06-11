var reg = false;
var myInput1 = document.getElementById("psw1");
var myInput2 = document.getElementById("psw2");
var letter = document.getElementById("letter");
var number = document.getElementById("number");
var length = document.getElementById("length");
var same = document.getElementById("same");

myInput1.onfocus = function() {
    document.getElementById("message").style.display = "block";
}
myInput2.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

myInput1.onblur = function() {
    document.getElementById("message").style.display = "none";
}
myInput2.onblur = function() {
    document.getElementById("message").style.display = "none";
}

myInput1.onkeyup = function() {
	if (reg==false){
		document.getElementById("regbutton").disabled = true;
	}
	else {
		document.getElementById("regbutton").disabled = false;
	}
  
  var lowerCaseLetters = /[a-z]/g;
  var upperCaseLetters = /[A-Z]/g;
  if(myInput1.value.match(lowerCaseLetters) && myInput1.value.match(upperCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
    reg = true;
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
    reg = false;
  }
  
  
  var numbers = /[0-9]/g;
  if(myInput1.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
    reg = true;
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
    reg = false;
  }
  
  
  if(myInput1.value.length >= 8 && myInput1.value.length  <= 20) {
    length.classList.remove("invalid");
    length.classList.add("valid");
    reg = true;
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
    reg = false;
  }

  if(myInput1.value.length>=8 && myInput1.value == myInput2.value){
  	same.classList.remove("invalid");
    same.classList.add("valid");
    reg = true;
  } else {
    same.classList.remove("valid");
    same.classList.add("invalid");
    reg = false;
  }
}
myInput2.onkeyup = function(){
	if (reg==false){
		document.getElementById("regbutton").disabled = true;
	}
	else {
		document.getElementById("regbutton").disabled = false;
	}
	if(myInput1.value.length>=8 && myInput1.value == myInput2.value){
  	same.classList.remove("invalid");
    same.classList.add("valid");
    reg = true;
  } else {
    same.classList.remove("valid");
    same.classList.add("invalid");
    reg = false;
  }

}