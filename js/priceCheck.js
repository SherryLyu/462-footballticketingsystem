var funPrice = function(){
	var game = parseInt($(this).val().split("section")[0])+1;
	var gameinfo = $(this).val().split("section")[1];
	var section = parseInt(gameinfo.split("type")[0]);
	var type = parseInt(gameinfo.split("type")[1]);
	var outputaddr = "#utoutput" + $(this).val().split("type")[0];
    $.ajax({
    	url: "././specialphp/priceCheck.php",
        type: "POST",
        data: {
          game: game,
          section: section,
          type: type
        },
        cache: false,
        success: function(data) {
			if(data.status == 'success'){
				$(outputaddr).html("<b style='color:#C0392B;'> Price: ").append(data.message).append(" dollars</b>");
			}else if(data.status == 'error'){
				$(outputaddr).html("<b style='color:#C0392B;'> Price: not available </b>");
			}
		},
		error: function() {
			$(outputaddr).html("<b style='color:#C0392B;'> Error </b>");
		}
    })
}

var funPriceForFix = function(a){
	var game = parseInt(a.split("section")[0])+1;
	var gameinfo = a.split("section")[1];
	var section = parseInt(gameinfo.split("type")[0]);
	var type = parseInt(gameinfo.split("type")[1]);
	var outputaddr = "#utoutput" + a.split("type")[0];
    $.ajax({
    	url: "././specialphp/priceCheck.php",
        type: "POST",
        data: {
          game: game,
          section: section,
          type: type
        },
        cache: false,
        success: function(data) {
			if(data.status == 'success'){
				$(outputaddr).html("<b style='color:#C0392B;'> Price: ").append(data.message).append(" dollars</b>");
			}else if(data.status == 'error'){
				$(outputaddr).html("<b style='color:#C0392B;'> Price: not available </b>");
			}
		},
		error: function() {
			$(outputaddr).html("<b style='color:#C0392B;'> Error </b>");
		}
    })
}

$("select[id^='sectionresult']").change(function(){
	$("select[id^='utresult']").on("change", funPrice);
});
