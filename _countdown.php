<?php
	/*
	 * Redirects to desired URL with correct GET parameters
	 * from POST data given by countdown.php
	 */
	
	// Grab JSON for validation
	$optsUrl = "http://".$_SERVER["SERVER_NAME"].
dirname(htmlentities($_SERVER["SCRIPT_NAME"]))."/lib/timestrings.php?list=all";
	$opts = json_decode(
		utf8_encode(file_get_contents($optsUrl)), true
	);
	
	$valid = true;
	/* Check that the desired POST elements are set */
	foreach(array('year','month','day','hour','min','sec','timezone') as $i)
		if(!isset($_POST[$i])) $valid = false;
	
	/* Check that the date/time is valid */
	foreach($_POST as $key => $value) {
		if(isset($opts[$key]) && !in_array($value, $opts[$key], true))
			$valid = false;
	}
	
	try {
		// Format the POST times into something readable by the DateTime class
		$MySQL_DateTime = $_POST['year']."-".
		sprintf("%02s", array_search($_POST['month'],$opts['month'])+1).
		"-".$_POST['day']." ".$_POST['hour'].":".$_POST['min'].":".$_POST['sec'];
		
		// Make new DateTime object in given time zone, then set it to UTC
		$t = new DateTime($MySQL_DateTime, new DateTimeZone($_POST['timezone']));
		$t->setTimeZone(new DateTimeZone('UTC'));
		
	} catch(Exception $e) { header("Location: countdown.php"); }
	
	if($valid) header("Location: countdown.php?time=".$t->format('Y-m-d\TH:i:s'));
	else header("Location: countdown.php");
?>