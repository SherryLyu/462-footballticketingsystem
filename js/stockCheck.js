var fun = function(){
	var gameid = $(this).val().split("section")[0];
	var outputaddr = "#stockoutput" +gameid;
	var game = parseInt($(this).val().split("section")[0])+1;
	var section = parseInt($(this).val().split("section")[1]);
    $.ajax({
    	url: "././specialphp/stockCheck.php",
        type: "POST",
        data: {
          game: game,
          section: section
        },
        cache: false,
        success: function(data) {
			if(data.status == 'success'){
				$(outputaddr).html("<b style='color:#C0392B;'> Stock: ").append(data.message).append("</b>");
			}else if(data.status == 'error'){
				$(outputaddr).html("<b style='color:#C0392B;'> Stock: not available </b>");
			}
		},
		error: function() {
			$(outputaddr).html("<b style='color:#C0392B;'> Error </b>");
		}
    })
}
$(document).ready(function() {$("select[id^='sectionresult']").change(fun)});
