<?php 
if(!isset($path))	
	$path = "."; 

if(isset($_POST["tz"])) {
	$tz = htmlentities($_POST["tz"]);

	if(in_array($tz, DateTimeZone::listIdentifiers())) {
		$dt = new DateTime("now", new DateTimeZone($tz));
		
		$tzc = "UTC";
		if(isset($_POST["tzc"]))
			$tzc = $_POST["tzc"];
		
		$optsUrl = "http://".$_SERVER["SERVER_NAME"].
dirname(htmlentities($_SERVER["SCRIPT_NAME"]))."/lib/timestrings.php?list=all";
		$opts = json_decode(
			utf8_encode(file_get_contents($optsUrl)), true
		);
		
		$now = new DateTime('now', new DateTimeZone('UTC'));
		$defaults = array(
			"year"  => $now->format('Y'),
			"month" => $now->format('F'),
			"day"   => $now->format('d'),
			"hour"  => $now->format('H'),
			"min"   => $now->format('i'),
			"sec"   => $now->format('s'),
		);
		
		foreach(array_keys($opts) as $opt) {
			$var = isset($_POST[$opt])? $_POST[$opt] : $defaults[$opt];
			if(!in_array($var, $opts[$opt], true))
				$var = $defaults[$opt];
			$tc[$opt] = $var;
		}
		
		$response = "
<p><span class=\"valid\">'$tz'</span> <a href=\"http://en.wikipedia.org/wiki/$tz\">(wiki)</a> is a valid timezone.</p>
<p>The time in $tz is currently <strong>".str_replace('-', '&minus;', $dt->format(DateTime::RSS))."</strong>.</p>
<h3>Convert a date/time to $tz time</h3>\n
<div class=\"ui-widget\">
	<form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\">
		<input type=\"hidden\" name=\"tz\" value=\"$tz\" />
		<label for=\"timezone\">Timezone: </label>
		<input class=\"timezone\" name=\"tzc\" value=\"$tzc\" /><br />
		<label for=\"time\">DateTime: </label>
		<input class=\"time\" name=\"day\" size=\"1\" value=\"{$tc['day']}\" /><input class=\"time\" name=\"month\" size=\"9\" value=\"{$tc['month']}\" /><input class=\"time\" name=\"year\" size=\"3\" value=\"{$tc['year']}\"/>
		<input class=\"time\" name=\"hour\" size=\"1\"  value=\"{$tc['hour']}\" />:<input class=\"time\" name=\"min\" size=\"1\" value=\"{$tc['min']}\" />:<input class=\"time\" name=\"sec\" size=\"1\" value=\"{$tc['sec']}\" />
		<input type=\"submit\" value=\"Convert\" />
	</form>
</div>
";
		
		$datestring = $tc['year']."-".
		sprintf("%02s", array_search($tc['month'],$opts['month'])+1).
		"-".$tc['day']." ".$tc['hour'].":".$tc['min'].":".$tc['sec'];
		
		try {
			$rss_snip = "D, d M Y H:i:s";
			$dtc = new DateTime($datestring, new DateTimeZone($tzc));
			$response .= "<p><strong>".$dtc->format($rss_snip)."</strong> in <span class=\"valid\">$tzc</span> is<br />\n";
			$dtc->setTimezone(new DateTimeZone($tz));
			$response .= "<strong>".$dtc->format($rss_snip)."</strong> in <span class=\"valid\">$tz</span>.</p>";
		} catch(Exception $e) {
			$response .= "<p><span class=\"invalid\">'$tzc'</span> is not a valid timezone.</p>";
		}
			
	} else {
		$response = "<p><span class=\"invalid\">'$tz'</span> is not a valid timezone.</p>";
	}
} else {
	$response = "<p>No timezone chosen.</p>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>tz-info</title>
<link href="<?php echo $path ?>/css/main.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $path ?>/css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $path ?>/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo $path ?>/js/jquery-ui-1.8.21.custom.min.js" type="text/javascript"></script>
<script src="<?php echo $path ?>/js/site.js" type="text/javascript"></script>

</head>

<body>


<div id="main">

<div class="ui-widget">
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<label for="timezone">Timezone: </label>
		<input class="timezone" name="tz" value="<?php echo $tz ?>"/>
		<input type="submit" value="Get info" />
	</form>
</div>

<?php echo $response ?>

<hr />
<p id="footer">Written by RogerDodger (<a href="https://github.com/RogerDodger/tz-info">view source</a>).</p>

</div>

</body>