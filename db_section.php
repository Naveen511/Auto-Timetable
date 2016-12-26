
<?php
	$host="localhost";
	$user="root";
	$pass="root123";
	$dbName="TimeTable1";
	//Connection Establishment
	if(isset($_POST)){
		$class = isset($_POST['class1']) ? $_POST['class1'] : '';
		$con=mysqli_connect($host,$user,$pass,$dbName);
		if(!$con){
			die ("Error" .mysqli_error());
		}
		//To retreive the query value
		$sql="select section from class_section where class= '$class'" ;
		$retval= mysqli_query($con,$sql);
		if(!$retval){
			die ("error". mysqli_error($con));
		}
		//Fetch the Section	
		while($row=mysqli_fetch_array($retval)){ 
			$class1=isset($row['section']) ? $row['section'] : '';
			 echo "<option value='$class1'>$class1</option>";
			 //var_dump($row['section']);
		}
		//to check if section timetable is available
		$section=$_POST['section'];
		//var_dump($section);
		 $stmt = $con->prepare("SELECT section FROM first WHERE section = '$section'");
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		if($row!==NULL)
		{
			echo "TimeTable is availabe for your choosed section";
		}else{
			echo "TimeTable is not availabe for your choosed section";
		}
		
		/*function submit()
		{
		 $sql1="update set subject_priority=$prior where section_id='$class1' AND subject_id='$value['subject_name']'";
		}*/
		mysqli_close($con);
		
	}
?>




