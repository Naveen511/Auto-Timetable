<?php
/**
 * Class header file 
 * This Class is used to create TimeTable
 */

 //$starttime=$_POST['start_time'];
  
if (isset($_POST)) {  
	//$clas=$_POST['classes'];
	//$secti=$_POST['sections'];
	$starttime =$_POST['start_time'];
	$endtime = $_POST['end_time'];
	$break = $_POST['break1'];
	$breaktime = $_POST['break_min'];
	$mbreak = $_POST['morning_break'];
	$ebreak = $_POST['afternoon_break']+1;
	$lunchtime = $_POST['lunch_break'];
	$hours_time=$_POST['hours_period'];
 
	// Defined variables
	$lbreak =5;
	$newtime=0;
	$remaining_time = 0;
	$var;
	$check = '';
	
	//Time taken from user stime
	$addtime = $starttime;
	//$stime = $starttime;
	
	$total_breaktime = (2*($breaktime)) + ($lunchtime);
	$total_time = (strtotime($endtime)-strtotime($starttime))/60;
	$total = $total_time - $total_breaktime;
	//var_dump($total);
	$var = ceil($total/$hours_time);
	$output = [];
	$periodTime = 0;
	for($i = 0; $i < ($var + 3); $i++) {
		$key = $i;
		$fromTime = $addtime;
		if($total>=$hours_time) {
			
			if($mbreak == $key || $ebreak == $key) {
				$addtime = $eTime = date('H:i:s',(strtotime($addtime." +$breaktime minutes")));
				// $total=$total-$this->breaktime;
			} else if($lbreak == $key) {
				$addtime = $eTime = date('H:i:s',(strtotime($addtime." +$lunchtime minutes")));
				// $total=$total-$this->lunchtime;
			} else {
				$addtime = $eTime = date('H:i:s',(strtotime($addtime." +$hours_time minutes")));				
				//var_dump($periodTime);
				$periodTime += 1;
				$total=$total-$hours_time;
			}
			$output[] = $fromTime.'-'.$eTime;
		} else if($periodTime == $lbreak) {
			$addtime = $eTime = $eTime=date('H:i:s',(strtotime($addtime." +$lunchtime minutes")));
			// $total=$total-$breaktime;
			$output[] = $fromTime.'-'.$eTime;
		} else if(($total > $breaktime) && ($mbreak == $periodTime || $ebreak == $periodTime)) { 
			$addtime = $eTime = $eTime=date('H:i:s',(strtotime($addtime." +$breaktime minutes")));
			$total=$total-$breaktime;
			$output[] = $fromTime.'-'.$eTime;
		} else { 
			$remaining_time = $total;
		} 
	}
	// var_dump($check);
	// condition to add study hour
	 if ($check == "Study Hour") {
		$time = date('H:i:s',(strtotime($addtime." +$remaining_time minutes")));
		$studytime = $eTime.'-'.$time;
		array_push($output,"$studytime");
	} else if($check == "Extra Hour") { // condition to add extra hour
		//var_dump($time);
		$time = date('H:i:s',(strtotime($addtime." +$hours_time minutes")));
		$studytime = $eTime.'-'.$time;
		array_push($output,"$studytime");
	} 
	
	// var_dump($output);
	// returns the time as output
}
?>
