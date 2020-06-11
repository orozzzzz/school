$(document).ready(function () {
		$(".picupload").click(function () {
			$('#picupload_field').fadeIn(300);
			var iddiv = $(this).attr("iddiv");
			$('#' + iddiv).fadeIn(300);
			$('#picupload_field').attr('opendiv', iddiv);
			return false;
		});

		$('#picupload_field, .picupload_close').click(function () {
			var iddiv = $("#picupload_field").attr('opendiv');
			$('#picupload_field').fadeOut(300);
			$('#' + iddiv).fadeOut(300);
		});

		$(document).keydown(function(eventObject){
			if( eventObject.which == 27 ){
				$('#picupload_field, .picupload_close').click();
			};
		});
	});