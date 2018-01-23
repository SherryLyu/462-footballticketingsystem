var CheckAmount = function(){
	var currentId = $(this).attr('id');
	var currentSection = parseInt($(this).attr('id').split("section")[1].split("type")[0]);
	var currentType = parseInt($(this).attr('id').split("section")[1].split("type")[1]);
	var gameid = $(this).attr('id').split("section")[0].slice($(this).attr('id').split("section")[0].indexOf("ticketamount")+12);
	var game = parseInt(gameid)+1;
	var outputaddr = "#warning" + gameid;
	var cost = "#howmuchtopay" + gameid;
	var re = new RegExp("^(\\s*|\\d+)$");
	if(re.test($(this).val())){
		if( parseInt($(this).val()) > 10 ){
			//$("#warning").html("<b>purchaseTicket"+$(this).val()+$(this).attr('id')+"</b>");
			$(outputaddr).html("<b role=\"alert\" style=\"color:red;\"><li> Not greater than 10 </li></b>");
/*			$($button).attr('value', 'notdisable');*/
			if(currentId.indexOf("Disabled") < 0 && currentId.indexOf("Able") < 0){
				$(this).attr('id', currentId+"Disabled");
			}else if(currentId.indexOf("Able") >= 0){
				$temp = currentId.replace("Able", "Disabled");
				$(this).attr('id', $temp);
			}
			var amount = parseInt($(this).val());
			$.ajax({
				url: '././specialphp/costCheck.php',
				type: "POST",
				data: {
				  game: game,
				  section: currentSection,
				  type: currentType,
				  amount: amount
				},
				success: function(data){
					$(cost).html("<b style='color:#C0392B;'> Cost: ").append(data.cost).append(" dollars </b>");
				}
			});
		}else if (parseInt($(this).val()) <= 0) {
			$(outputaddr).html("<b role=\"alert\" style=\"color:red;\"><li> Not an invalid ticket amount </li></b>");
			if(currentId.indexOf("Disabled") < 0 && currentId.indexOf("Able") < 0){
				$(this).attr('id', currentId+"Disabled");
			}else if(currentId.indexOf("Able") >= 0){
				$temp = currentId.replace("Able", "Disabled");
				$(this).attr('id', $temp);
			}
			$(cost).html("<b style='color:#C0392B;'> Cost: invalid </b>");
		}else{
			$(outputaddr).html("");
			if(currentId.indexOf("Disabled") >= 0){
				$temp = currentId.replace("Disabled", "Able");
				$(this).attr('id', $temp);
			}else if(currentId.indexOf("Able") < 0){
				$(this).attr('id', currentId+"Able");
			}
			var amount = parseInt($(this).val());
			$.ajax({
				url: '././specialphp/costCheck.php',
				type: "POST",
				data: {
				  game: game,
				  section: currentSection,
				  type: currentType,
				  amount: amount
				},
				success: function(data){
					$(cost).html("<b style='color:#C0392B;'> Cost: ").append(data.cost).append(" dollars </b>");
				}
			});
		}
	}else{
		$(outputaddr).html("<b role=\"alert\" style=\"color:red;\"><li>Not an invalid ticket amount </li></b>");
		if(currentId.indexOf("Disabled") < 0 && currentId.indexOf("Able") < 0){
			$(this).attr('id', currentId+"Disabled");
		}else if(currentId.indexOf("Able") >= 0){
			$temp = currentId.replace("Able", "Disabled");
			$(this).attr('id', $temp);
		}
		$(cost).html("<b style='color:#C0392B;'> Cost: invalid </b>");
	}
}

var funTicket = function(){
	if($(this).attr('id').indexOf("Disabled") < 0){
		var amount = parseInt($(this).attr('id').split("Able")[0].split("ticketamount")[0].slice($(this).attr('id').split("Able")[0].split("ticketamount")[0].indexOf("purchaseTicket")+14));
		var game = parseInt($(this).attr('id').split("Able")[0].split("ticketamount")[1].split("section")[0])+1;
		var section = parseInt($(this).attr('id').split("Able")[0].split("ticketamount")[1].split("section")[1].split("type")[0]);
		var type = parseInt($(this).attr('id').split("Able")[0].split("type")[1]);
		var user = parseInt($(this).attr('id').split("Able")[1].split("userid")[1]);
		var outputaddr = "#successPurchase" + $(this).attr('id').split("Able")[0].split("ticketamount")[1];
		var changestockoutputaddr = "#stockoutput" +(game-1);
		var changebalanceoutputaddr = "#balanceoutput" +(game-1);
		var resetaddr = "#ticketamount" + $(this).attr('id').split("Able")[0].split("ticketamount")[1] + "Able";
	    $.ajax({
	    	url: "././specialphp/purchaseCheck.php",
	        type: "POST",
	        data: {
	          game: game,
	          section: section,
	          type: type,
	          amount: amount,
	          user: user
	        },
	        cache: false,
	        success: function(data) {
				if(data.status == 'success'){
					$(outputaddr).html("<div class='alert alert-success'>");
		            $(outputaddr + '> .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
		              .append("</button>");
		            $(outputaddr + '> .alert-success').append($("<strong>").text(data.message));
		            $(outputaddr + '> .alert-success').append('</div>');  
		            $(changestockoutputaddr).html("<b style='color:#C0392B;'> Stock: ").append(data.newstock).append("</b>");
		            $(changebalanceoutputaddr).html("<b>Your <span style='color:#C0392B;'>current balance: </span>").append(data.newbalance).append(" dollars</b>");
		            //clear all fields
		            $(resetaddr).val('');
				}else if(data.status == 'error'){
					$(outputaddr).html("<div class='alert alert-danger'>");
		            $(outputaddr + ' > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
		              .append("</button>");
		            $(outputaddr + ' > .alert-danger').append($("<strong>").text(data.message));
		            $(outputaddr + ' > .alert-danger').append('</div>');
				}
			},
			error: function() {
				$(outputaddr).html("<b style='color:#C0392B;'> Error </b>");
			}
	/*		complete: function() {
	          setTimeout(function() {
	            $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
	          }, 1000);
	        }*/
	    })
	}
}

$("select[id^='sectionresult']").change(function(){
	$("input[id^='ticketamount']").on("input",CheckAmount);
	$("input[id^='ticketamount']").change(function(){
		$("button[id^='purchaseTicket']").click(funTicket);
		/*function(e){
				e.stopPropagation();
				$('document, html').click(funTicket);
		})		*/
	})
});