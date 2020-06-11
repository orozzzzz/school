function answer_form(number,email){
	var num = document.getElementById('message_number');
	num.innerHTML = number;
	var id = document.getElementById('question_id');
	id.value = number;
	var email_field = document.getElementById('question_email');
	email_field.value = email;
}
function delete_question(id){
	if (confirm("Удалить вопрос #"+id+"?")==true){
		window.location.href='http://school/req/POSTs.php/?delete_question='+id;
	}
}
