$("document").ready(function() {
	// To store the value in temporarily
	$("#submit").click(function() {
		var start_time = $("#start_time").val();
		var end_time = $("#end_time").val();
		var no_break = parseInt($("#no_of_break").val());
		var break_time = parseInt($("#break_time").val());
		var morning_break = $("#morning_break").val();
		var afternoon_break =$("#afternoon_break").val();	
		var lunch_break = parseInt($("#lunch_break").val());
		var hours_period = $("#hours_min").val();	
	    var clas=$("#class").val();
	    var sec=$("#section").val();
		
		
		if (clas == ''||sec ==''||start_time == '' || no_break >='3' || end_time == '' || break_time =='' || morning_break=='' || afternoon_break=='' || lunch_break==''||hours_period =='' ) {
			alert("To fill all the fields and break is minimum 2");
			return false
			}
		else {
			// Returns successful data submission message when the entered information is stored in post file
			$.post("main.php", {
				clas	:classes,
				sec		:sections,
				stime	: start_time,
				etime 	: end_time,
				break1	: break1,
				break_min : break_min,
				m_break : morning_break,
				a_break	: afternoon_break,
				l_break : lunch_break,
				h_period: hours_period },
				function(data) {
				alert("Successfully Entered");
				//$('#form')[0].reset(); // To reset form fields
			});
		}
	});
		
	//Ckeckbox for break session
   $(document).ready(function(){
		$(".hiden,.hide1").hide();
		});
   $("#morning").click(function(){
		$(".hiden").toggle();
	});
	
	$("#afternoon").click(function(){
		$(".hide1").toggle();
	});
			
	//Time picker
	$(function(){
		$(".start").timepicker();
		$(".end").timepicker();			
	});
	
});
