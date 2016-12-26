<!DOCTYPE HTML>
<?php
$array = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; //Display an array in checkbox
	//Connection Establishment
	$dbhost="localhost";
	$dbuser="root";
	$dbpass="root123";
	$dbName="TimeTable";
	$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbName); 
	//To check the Connection
	if(!$con){
		die ("Connection error" . mysqli_error());
	}
?>

<html>
	<head>
		<meta name = "viewport" content = "width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<link rel="shortcut icon" href="images/logo.png" type="image/png">
		<title style="font-family:Courier 10 Pitch"> TimeTable creation</title>
		<meta name="keywors" content="layout">
		<meta name="description" content="design of static page">
		<meta name="author" content="creaters">
		<title>TimeTable creation</title>
		<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="../../load/timepicker/jquery.timepicker.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="../../load/timepicker/jquery.timepicker.js"> </script>
	<script src="js/user.js"></script>
	</head>
	<body>
		<div class="back">
			<div class="menu-right">
				<nav class="navbar navbar-inverse navbar-fixed-top ">
					<div class="container">
								<p style="color:#fff;font-size:30px;text-align:center;font-family:rusia;">TimeTable</p>				
				</div><!-----------container ends---->
			</nav><!--------navbar-inverse--------->
		</div><!-------------menu right ends here----------->		
	</div><!------------------back---------------->
		 <div class="container theme-showcase" role="main">
					  <!-- Main jumbotron for a primary marketing message or call to action -->
					  <div class="jumbotron">
	<table>
	<h2>Time table creation</h2>
		<tr>
			<td>Select Class</td>
			<td>
				<select class="class drop" id="class" onchange="getSection()">
					<?php
						// To retreive the class from the class_section table
						$sql = "select class from class_section  group by class"; 
						$retval = mysqli_query($con,$sql);
					?>
					<option value="">Select Class </option>
					<?php
						//To fetch the value of class in class_section table
						while($row = mysqli_fetch_array($retval)) { 
					?>
					<option value="<?php echo $row['class']; ?>" ><?php echo $row['class']; ?></option>
					<?php } ?>
				</select>				
			</td>		
			<td>Select Section  </td>
			<td>
				<select class="class drop" id="section">
					<option value="">Select Section </option>
				</select>
			</td>
		</tr>		
	</table>
	<form name="add_form" id="add_form" action="dynamic_class.php">
		<div class="field_wrapper">
			<div>
				<input type="hidden" id="class_name" name="class_name">
				<input type="hidden" id="section_name" name="section_name">
				Select Subject <select name="subject[]" id="subject1" class="drop">
					<?php
						// To retreive the value of subject name from the subject table
						$sql = "select subject_name from subject"; 
						$retval = mysqli_query($con,$sql);
						//subject name variable
						$val = [];
					?>
					<option>Select Subject</option>
					<?php
						//To fetch the subject name into row and display row in input box
						while($row = mysqli_fetch_assoc($retval)) {
						//subject name
						$val[] = $row['subject_name'];
					?>
					<option value="<?php echo $row['subject_name']; ?>" id="subject" > <?php echo $row['subject_name']; ?> </option>
					<?php } ?>
					</select>
					Enter Priority<input type="text" class= "drop" name="priority[]"pattern = "[0-9]+" value=""/>
					Select Staff <select name="staff[]" id="staff" class="drop">
					<?php
						// To retreive the value of Staff_name from the staff table
						$sql = "select staff_name from staff"; 
						$retval = mysqli_query($con,$sql);
						//staff name variable
						$val1 = [];
					?>
					<option>Select Subject</option>
					<?php
						//To fetch the value of staff_name into row and display the value in input box
						while($row = mysqli_fetch_assoc($retval)) {
						//staff name variable
						$val1[] = $row['staff_name'];
					?>
					<option value="<?php echo $row['staff_name']; ?>" id="subject" > <?php echo $row['staff_name']; ?> </option>
					<?php } ?>
					</select>
					
					<button class="add_button" type="button">Add</button>
			</div>
		</div>
		<a href="#" onclick="saveDetails()" type="button">Submit</a>
		<!--<button onclick="saveDetails()" type="button">Submit</button> -->
		<div id="pass">
			</div>
	</form>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	//To add dynamically selection option,input box that is maximum 10
	var maxField = 10; 
	
	//Subject name is stored into $val
	var getvalue = "<?php echo implode(',', $val);?>"; 
	
	//staff name
	var getvalue1 ="<?php echo implode(',',$val1);?>";
	
	//subject name
	var value = getvalue .split(',');
	
	//staff name
	var value1 = getvalue1 .split(',');
	
	//To appen the data in button click
	var addButton = $('.add_button'); 
	var wrapper = $('.field_wrapper');
	
	var fieldHTML = '<div>Select Subject <select name="subject[]" class="drop">';
	fieldHTML = fieldHTML+'<option>Select Subject</option>';
	
	// Display the subject array using value[i]
	for(var i = 0; i < value.length;i++) {
		fieldHTML = fieldHTML+'<option>'+value[i]+'</option>';
	}
	fieldHTML = fieldHTML+'</select> Enter Priority<input type="text" name="priority[]" value="" class="drop"/>Select Staff <select name="staff[]" class="drop">'
	fieldHTML = fieldHTML + '<option>Select Staff</option>';
	
	//To display the staff using value[j]
	for(var j=0; j<value1.length; j++){
		fieldHTML =fieldHTML +'<option>'+value1[j]+'</option>';
	}
	fieldHTML= fieldHTML +'</select><button class="remove_button">Remove</button></div>'; //New input field html 
	var x = 1;
	
	//To append the row 
		$(addButton).click(function(){ 
		if(x < maxField){
			x++;
			$(wrapper).append(fieldHTML); 
		}
	});
	
	//To remove the row
	$(wrapper).on('click', '.remove_button', function(e){
		e.preventDefault();
		$(this).parent('div').remove(); 
		x--; 
    });
});

	//To send the value sing formdata
	function saveDetails(){	   
	   	var section_name = $("#section").val();
	   	$("#section_name").val(section_name);
	   	console.log(section_name);
	  	var formData = new FormData($("#add_form")[0]);
		$.ajax({
			type : 'post',
			url : 'form.php',
			data : formData,
			contentType: false,
			processData: false,
			async : false,
			success : function (data) {
				//To append the resukt into pass id
				$("#pass").html(data);
				alert("Suceess");
			},
		}); 
	}
	
	//To get the section from class
	function getSection() {
		var class1 = $("#class").val();
		$("#class_name").val(class1);
		$.ajax({
			type : "POST",
			url  : "db_section.php", 
			data : {'class1' : class1},
			success: function(result){
				$("#section").html('<option value="">Select Section</option>' + result);		
			}
		});
	}
	
</script>
					   </div><!--jumbotron ends-->
					  <div class="footer">
			@Just Create
		</div>
			    </div><!--container jumbotron ends-->
		

	</body>
</html>
