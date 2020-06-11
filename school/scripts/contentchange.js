function insertTextAtCursor(el, text, offset) {
    var val = el.value, endIndex, range, doc = el.ownerDocument;
    if (typeof el.selectionStart == "number"
            && typeof el.selectionEnd == "number") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
    } else if (doc.selection != "undefined" && doc.selection.createRange) {
        el.focus();
        range = doc.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
    }
}
function taginput(tag) {
	var text;
	var content = document.getElementById('content');
	switch(tag){
		case "date":
			var now = new Date();
			var date = now.getDate();
			var month = now.getMonth()+1;
			if (String(date).length<2)
				date="0"+date;
			if (String(month).length<2)
				month="0"+month;
			text = date+"."+month+"."+now.getFullYear();
			break;
		case "paragraph":
			text = "<p></p>";
			break;
		case "header":
			text = "<h3></h3>";
			break;
		case "ul":
			text = "<ul></ul>";
			break;
		case "li":
			text = "<li></li>";
			break;
		default:
			alert("Ошибка");
	}
	insertTextAtCursor(content,text);
	
}