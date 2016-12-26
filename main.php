<?php include_once("time.php");

$cl=$_POST['class'];
$se=$_POST['section'];
		$con = mysqli_connect("localhost", "root", "root123");
			if (!$con) {
				die("Could not connect: " . mysqli_error());
			}
			// selection of database
			$db_selected = mysqli_select_db($con, 'TimeTable1');
			if (!$db_selected) {
				die ('Can\'t use db : ' . mysqli_error());
			}
			$choose="SELECT class,section FROM first where class=$cl AND section=$se";
			$get_result=mysqli_query($con,$choose);

?>
<html>
	<head>
		<meta name = "viewport" content = "width = device-width, initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
		<link rel="shortcut icon" href="images/logo.png" type="image/png">
		<title style="font-family:Courier 10 Pitch">TimeTable creation</title>
		<meta name="keywors" content="layout">
		<meta name="description" content="design of static page">
		<meta name="author" content="Creaters">
		<title>TimeTable creation</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">	
		<style>
			.tab{
				width:970px;
				//height:300px;
				overflow:auto;
			}
			#table-1{
				border:2px solid #ff00ff;
				width:700px;
			}
			td{
				text-align:center;
				font-size:16px;
			}
			tr{
				border:2px solid #ff00ff;
			}
		</style>
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
						  
		<?php
		$classes=$_POST['class'];
		$section=$_POST['section'];
		echo "your class is : <pre>". $classes ."</pre>";
		echo "your section is :". $section;
		//echo $_POST['class'];
			$var = 0;
			/************************ Connection Establishment**************************************/
			// connection to localhost
			$con = mysqli_connect("localhost", "root", "root123");
			if (!$con) {
				die("Could not connect: " . mysqli_error());
			}
			// selection of database
			$db_selected = mysqli_select_db($con, 'TimeTable1');
			if (!$db_selected) {
				die ('Can\'t use db : ' . mysqli_error());
			}
			/* select subject and staffs from table 
			store the values in the values[] array
			subject,staff and subject priority are stored */ 
			$sql="SELECT subject_name,subject_priority,staff_name FROM allocation 									
											LEFT JOIN staff on allocation.staff_id=staff.id
											LEFT JOIN subject on allocation.subject_id=subject.id 
											where class_id=1
											ORDER BY subject_priority";
			$result=mysqli_query($con,$sql);
			$values = [];
			while($row = mysqli_fetch_array($result)){
				$values[] = [$row['subject_name'], $row['subject_priority'], $row['staff_name']];
			}
			
		 
		    /******************** Time Allocation (Bhawya Module)*****************************************/
		    
			// var_dump($_POST);
			/*
			echo "<table>";
			echo "<tr>";
			echo "<tr><th>starting time </th><td>" .$starttime."</td></tr>";
			echo "<tr><th>your end time is</th><td> " .$endtime."</td></tr>";
			echo "<tr><th>break count  is</th><td> " .$break."</td></tr>";
			echo "</tr>";
			echo "</table>";*/
			$result = [];
			// initialization of using variables..
			$rtime='';
			// var_dump($ebreak);
			// var_dump($lunch);
			// $mrtime = '';$rtime='';$mbreak = '';$ebreak = '';$lbreak='';
			/* Getting the values from time.php
			stores the values */
			/*if(isset($_POST['hours_time']))
			/*{
					//$time = $_POST['hours_time'];
					$result=$_POST['hours_time'];
					$check=isset($_POST['check']) ? $_POST['check'] : null;
					var_dump($hours_time);
					$new=new Timecreation;
					$result=$new->timetable($time,$check);
					$mrtime=$new->starttime;
					$rtime=$new->remaining_time;
					$mbreak=$new->mbreak;
					$ebreak=$new->ebreak;
					$lbreak=$new->lbreak;
				
			}*/
		?>
		<form action ="#" method = "POST"> 
			<?php 
				// initialization of days
				//$time=isset($_POST['time']) ? $_POST['time'] : null;
				$array = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
			?>
			
		
			<?php 
				// remaining hours calculation 
		    	echo "your remaining time $remaining_time";
		    	if($remaining_time>0){
					$array1 = ['Study Hour', 'Extra Hour'];
					foreach($array1 as $key => $temp) { 
						$checked = '';
						if (isset($_POST['check'])){
							if($_POST['check'] == $temp) {
								$checked = 'checked';
							}
						} ?>
						<br>Add it in<br>
						<input type="radio" name="check" value="<?php echo $temp; ?>"
							<?php echo $checked;?>><?php echo $temp;?></input><br>
					<?php }
				} ?>
			<!--<button type="submit">Go</button>-->
			
		</form>
		

		<!-- ************************ Time allocation module ends here ************************ -->
		<!-- ********************** subject allocation module starts here ********************* -->
		<div class="tab">
		<table border="1" style="border-collapse:collapse;height:300px;" id="table-1" cellspacing="0" cellpadding="2">
			<tr style="background-color:#349876;">
				<td style="width:20px;">
					<label>Time</label>
				</td>
				
				<?php foreach($output as $key => $temp) { ?>				
					<td style="width:100px;">
						<?php echo $temp; ?>
					</td>
				<?php }$s=count($output); //echo "your time slot is ".$s;
				//echo "before break count  is " .$break;
				$priority_break=$break+1;
				
				//echo $bbk;
				$slot=$s-$priority_break;$s++;
				$day_count=count($_POST['days']);
				echo "total day is".$day_count;
				echo "total period".$slot; 
				// To get the value from user for no of periods/days
		$priod = $slot;
		$days = $day_count;
		$weight = [];
		
		//var_dump($_POST);
		
		?>
			</tr>
			<?php
				echo "<pre>";
				
				$ss="select subject_name,weight,priority from weight where section='1a' order by weight desc" ;
				$ret_s=mysqli_query($con,$ss);
				// var_dump($ret_s);
				$subjects = '';
				$weight=[];
				$subject = [];
				$sum=0;
				$integerIDs=[];
				while($row_s=mysqli_fetch_assoc($ret_s))
				{
					//var_dump($row_s);
					$w = isset($row_s['weight']) ? $row_s['weight'] : '';
					for($i = 0 ; $i < $w ; $i++) {
						$subject[] =  isset($row_s['subject_name']) ? $row_s['subject_name'] : '';
					}
					// To calculate the weightage using priority value and no of periods and days 
					//var_dump($row_s['priority']);
				
					//$val[]=(int)$row_s['priority'];
					$integerIDs = array_map('intval', explode(',', $row_s['priority']));
					//var_dump($integerIDs);
					foreach($integerIDs as $index=>$value ) {
						$sum +=$value;
						
					//var_dump(count($row_s['priority']));
						}//echo $sum;
						//var_dump($integerIDs);
					$weight[$row_s['subject_name']] = floor(($row_s['priority'] /60) * ($priod*$days));
			
					//echo $row_s['subject_name']. '-'. $row_s['priority']."&nbsp;";
					$weight_value = $weight[$row_s['subject_name']];
					//echo $weight_value."<br>";
					$sub = $row_s['subject_name'];
			
					//$up="update weight where select subject_name,weight,priority from weight where section='10a' order by weight desc" ;
					//$ret_s=mysqli_query($con,$ss);
					//$ins = "insert into weight(weight) values('$weight_value')";
					//var_dump($ins);
					
						// To insert the field into table
						$ups = "update weight set weight = '$weight_value' where section = '$section' AND subject_name='$sub'";
						mysqli_query($con,$ups);
						//$sql="Insert into weight (class,section,subject_name,staff_name,priority) values('$class','$section','$value','$subject1')";
					
				}
		
		$subjects = ($subjects) ? array_merge($subjects,$subject) : $subject;
				
				//var_dump(rand($subjects));
				function array_random($subject, $subjectCount = 1) {
					//var_dump($subject);
					if ($subject) {
						// var_dump($arr);
						shuffle($subject);
					   
						$r = array();
						for ($i = 0; $i < $subjectCount; $i++) {
							$r[] = $subject[$i];
						}
						return $subjectCount == 1 ? $r[0] : $r;
					}
					
				}
				
				
				$randSubjects = array_random($subjects, count($subjects));
				//var_dump($randSubjects);
				$arr = [];
				$count = 0;
				$subjectCount = 0;
				// Getting the days as $day
			 	foreach($array as $index => $day) { 
					if(in_array($day, $_POST['days'])) {
			?>
			<tr style="background-color:#F5F7F6;color:#3D5085;">
				<td >
					<label><?php echo $day;?></label>
				</td>
				<?php 
					foreach($output as $key => $temp) { 
						$explode_time = explode("-",$temp);
						$start_time = $explode_time[0];
						$end_time = $explode_time[1];
						//var_dump($start_time);
						// select
						//$sql_full = "select * from time_table where day='$day' and class='VII' and section='A' and start_time = '$start_time' and end_time = '$end_time'";
						//$retval_full = mysqli_query($con,$sql_full);
						//$row_full = mysqli_fetch_assoc($retval_full);
						//var_dump($ret_s);
						
						
						//var_dump($val[]);
						// echo "<pre>";
						// var_dump($_POST);
				?>
				<!-- checking the break time and inserting the value as break-->
				<?php 
				// var_dump($period);
				// var_dump($period == $mbreak);
				if( $key == $mbreak || $key == $ebreak ) { ?>
					<td >
						<?php echo "Break";
							if($row_s == null){
								$breakTime = ($key == $mbreak) ? 1 : 2;
								$sql_insert = "insert into first(class,section,day,start_time,end_time,break) values('$classes','$section','$day','$start_time','$end_time',$breakTime)";
								$retval_insert = mysqli_query($con, $sql_insert);
								//var_dump($breakTime);
							}
						?>
					</td>
				<!-- checking the lunch time and inserting the value as lunch-->
				<?php } elseif ($key == $lbreak){ ?>
					<td >
						<?php echo "Lunch"; 
							if($row_s == null){
								$lunchTime = 3;
								$sql_insert = "insert into first(class,section,day,start_time,end_time,break) values('$classes','$section','$day','$start_time','$end_time',$lunchTime)";
								$retval_insert = mysqli_query($con, $sql_insert);
							}
						?>
					</td>
				<?php } else { 
					
					// allocation of subjects 
					$count = count($values);
					if ($var >= $count) {
						$var = 0;
					}
					?>
					<td>
						<?php
						
						//echo $randSubjects[$subjectCount];$randSubjects[0]
							if (isset($randSubjects[$subjectCount])) {
								$sub = $randSubjects[$subjectCount];
								//var_dump($randSubjects[$subjectCount]);
								//echo $sub;
								$subjectCount += 1;
							} else {
								//$sub = $subject[5]; 
								//var_dump($subjects[0]);
								$sub=$subjects[0];
								//var_dump($sub);
							}
							
							echo $sub;
						//here to write in table 
								$sq="INSERT INTO `TimeTable1`.`first` (`class`,`section`,`day`,`start_time`,`end_time`,`subject`) VALUES ('$classes', '$section', '$day', '$start_time', '$end_time', '$sub')";
								$retval_sub=mysqli_query($con,$sq);
								// var_dump($retval_sub);
							
						/*if($row_s==null)
						{
							$sq="insert into first(class,section,day,start_time,end_time,subject)values('I''A','$day','$start_time','$end_time','$subject')";
							$retval_sub=mysqli_query($con,$sq);
							$sub=mysqli_fetch_assoc($retval_sub);
						}*/
							$arr[]= $values[$var][0];
							$staff = $values[$var][2];
							$subject = $values[$var][0];
							// to check the staff availability time 
							/*if($row_s == null){
								//$ss="select subject_name,weight from weight where section='12a' order by weight desc" ;
								$sql_retrive = "select * from time_table where day = '$day' and staff = '$staff' and 
										(start_time between '$start_time' and '$end_time' or end_time between '$start_time' and '$end_time')";
								$retval_staff = mysqli_query($con,$sql_retrive);
								$staffs = mysqli_fetch_assoc($retval_staff);
								// var_dump($staffs);
								if ($staffs == null) {
									# code...
									// save
									$sql_insert = "insert into time_table(class,section,day,start_time,end_time,staff,subject) values('VII','A','$day','$start_time','$end_time','$staff','$subject')";
									$retval_insert = mysqli_query($con, $sql_insert);
								} else {
									// checking the other staff availability time 
									// select
									$sql_select = "select * from subject_allocation where class='VII' and section='A' and subject='$subject'";
									$retval_select = mysqli_query($con,$sql_select);
									$count = 0;
									while($row = mysqli_fetch_assoc($retval_select) ) {
										if($row['staff'] != $staff && $count == 0) {
											$remaining_staff = $row['staff'];
											//select
											$sql_retrive = "select * from time_table where day = '$day' and 
												staff = '$remaining_staff' and (start_time between '$start_time' and '$end_time' or end_time between '$start_time' and '$end_time')";
											$retval_staff = mysqli_query($con,$sql_retrive);
											$staffs_other = mysqli_fetch_assoc($retval_staff); 
											if ($staffs_other == null) {
												# code...
												// save
												$sql_insert = "insert into time_table(class,section,day,start_time,end_time,staff,subject) values('VII','A','$day','$start_time','$end_time','$remaining_staff','$subject')";
												$retval_insert = mysqli_query($con, $sql_insert);
												$count += 1;
											} 
										}
									}
								}
							}*/
							// var_dump($period);
							$var++; 
						?>
					</td>
				<?php } ?>
			<?php }?>
			</tr>
			<?php } 
			}?>
		</table>
		</div>
		</div><!--jumbotron ends-->
					  <div class="footer">
			<i>Just Create</i>
		</div>
			    </div><!--container jumbotron ends-->
	</body>
</html>
