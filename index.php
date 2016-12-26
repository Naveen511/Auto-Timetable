<!DOCTYPE HTML>
<?php
$array = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; //Display an array in checkbox

	$dbhost="localhost";
	$dbuser="root";
	$dbpass="root123";
	$dbName="TimeTable";
	$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbName); // Connection Establishment
	if(!$con){
		die ("Connection error" . mysqli_error());
	}
	$db_selected = mysqli_select_db($con, 'TimeTable1');
			if (!$db_selected) {
				die ('Can\'t use db : ' . mysqli_error());
			}
?>

<html>
	<head>
		<meta name = "viewport" content = "width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<link rel="shortcut icon" href="images/logo.png" type="image/png">
		<title style="font-family:Courier 10 Pitch">TimeTable creation</title>
		<meta name="keywors" content="layout">
		<meta name="description" content="design of static page">
		<meta name="author" content="creaters">
		<title>TimeTable creation</title>
		<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="../../load/timepicker/jquery.timepicker.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
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
							<form id="form" name="form" method="POST" action="main.php" >
							<h2 style="font-family:rusia;">Time Table Creation</h2>
							<table >
								<tr>
									<td>Select Class</td>
									<td>
										<select class="class drop input" id="class" name="class" onchange="getSection()">
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
										<select class="class drop input" id="section" name="section" onchange="checksection()">
											<option value="">Select Section </option>
										</select>
										<div id="resultdiv"></div>
									</td>
								</tr>	
		
								<tr>
									<td>Start Time </td><td><input type="text" class="start input" id="start_time" placeholder ="Enter the Start Time" name="start_time"></td>
								</tr>
								<tr>
									<td>End Time</td><td><input type="text" class="end input" id="end_time" placeholder = "Enter the End Time" name="end_time"></td>			
								</tr>
								<tr>
									<td>No of Break </td><td><input type="text" class="css input" id="no_of_break" pattern ="[0-9]+" placeholder= "Enter the no of Breaks" name="break1" ></td>
								</tr>
								<tr>
									<td>Break Time </td><td><input type="text" class="css input" id="break_time" pattern = "[0-9]+" placeholder = "Enter the break time in minutes" name ="break_min" ></td>
								</tr>
								<tr>
									<td><input type ="checkbox" id ="morning"> Morning</td><td class="hiden css"> After which period want break  </td>
									<td> <input type="text" class="hiden css" id="morning_break" pattern ="[0-9]+" name="morning_break"></td>
								</tr>
								<tr>
									<td><input type ="checkbox" id ="afternoon"> Afternoon</td> <td class="hide1 css">After which period want break</td>
									<td> <input type="text" class=" hide1 css" id="afternoon_break" pattern ="[0-9]+" name="afternoon_break"></td>
								</tr>
								<tr>
									<td>Lunch Break</td><td><input type="text" class="css input" id="lunch_break" pattern = "[0-9]+" placeholder = "Enter Lunch break time in minutes" name="lunch_break"></td>
								</tr>
								<tr> 
									<td>No of hours / Period </td><td><input type="text" id="hours_min" class="css input" pattern= "[0-9]+" placeholder= "Enter no of minutes/period" name="hours_period"></td>
								</tr>
								<tr>
									<td colspan="2">Which day you want to create time table</td>
								</tr>
								<tr>
									<td></td>
									<td colspan ="5">
										<!-- To display array in checkbox stored in temp value-->
										<?php  foreach($array as $key => $temp) { 
										$checked = '';
										
										if (isset($_GET['days'])){
											if(in_array($temp, $_GET['days'])) {
												$checked = 'checked';
												
											}
										}

										?>
										<input type= "checkbox" name="days[]" value="<?php echo $temp; ?>" 
										<!--Display the Checkbox Value when the user checked-->
										<?php echo $checked;
										/*$checked_arr = $_GET['days'];
										$count = count($checked_arr);
										echo "There are ".$count." checkboxe(s) are checked";*/
										?><?php echo $temp;?></input> 
									<?php } ?>
									</td>
								</tr>
								<tr>
									<td><input type="submit" id="submit" value="submit" name="submit"></td>			
								</tr>
							</table>
						</form>
						<a href="display.php">ALLOCATE STAFF AND SUBJECTS!</a>
					  </div><!--jumbotron ends-->
					  <div class="footer">
			@Just Create
		</div>
			    </div><!--container jumbotron ends-->
		

	</body>
	<script>
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
	
	function checksection(name)
	{
		var section=$("#section").val();
		$.ajax({
			type :"POST",
			url :"db_section.php",
			data:{'section':section},
			success: function(result){
				 //document.write("resultdiv").innerHTML += result;
				 $('#resultdiv').html(result).fadeIn('slow');
			}
		});
		//$.post('index.php',{se:sect});
		//$choose="SELECT class,section FROM first where class=$cl AND section=$se";
		//$get_result=mysqli_query($con,$choose);
	
	}
	
	<?php
		/*$se=$_POST['se'];
		var_dump($se);
		$conn = new mysqli($dbhost,$dbuser,$dbpass,$dbName);
		$stmt = $conn->prepare("SELECT section FROM first WHERE section = ?");
		$stmt->bind_param("section",$se);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		print_r($row);*/
		?>

	</script>
	<script src="../../load/bootstrap/js/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="../../load/timepicker/jquery.timepicker.js"> </script>
	<script src="js/user.js"></script>
	
</html>
