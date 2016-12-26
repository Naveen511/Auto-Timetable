<?php
	$host="localhost";
	$user="root";
	$pass="root123";
	$dbName="TimeTable1";
	$con=mysqli_connect($host,$user,$pass,$dbName);
	if(!$con){
		die ("Error" .mysqli_error());
	}
	//Defined Variables
	$class ='';
	$section = '';
	$priority='';
	$weight = '';
	$priority1='';
	$weight1 = '';
	$prior ='';
	$prior1 ='';
	$subject = '';
	
	if(isset($_POST)){
		// To get the values from form data
		$priority = $_POST["priority"];
		$class = $_POST["class_name"];
		$section = $_POST["section_name"];
		$staff =$_POST["staff"];
		//var_dump($staff);
		//echo"<pre>";
		//var_dump($class);
		$sum = 0;
		
		// To get the value from user for no of periods/days
		/*$priod = 9;
		$days = 5;
		$weight = [];*/
		// To calculate the periority using sum=0
		/*foreach($_POST["priority"] as $index =>$value ) {
			$sum = $sum+$value;	  
			
			// To calculate the weightage using priority value and no of periods and days
			//$weight[] = round(($value /100) * ($priod*$days));
		}return $sum;
		
		// If the periority is greater then 100 it shows error
		if($sum >100){
			echo "Please enter the priority is lessthan 100";
		}
		else{
			// That Sum(priority) is lessthan 100 to store the value in table
			foreach($_POST["subject"] as $key=>$value) {
				// to fetch the priority value into key
				$priority1 = $priority[$key];
				
				// To insert the field into table
				$sql="Insert into weight (class,section,subject_name,staff_name,priority) values('$class','$section','$value','$staff[$key]','$priority1')";
				
				var_dump($sql);
				mysqli_query($con,$sql);
			}
		}

	}

	mysqli_close($con);
	?>
