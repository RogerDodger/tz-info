<?php 
if(!isset($path))	
	$path = "."; 
	
	date_default_timezone_set('UTC');
	$now = new DateTime('now');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<title>tz-info – Countdown</title>
<?php include 'head.php' ?>

</head>

<body>

<div id="main">

<?php if(isset($_GET["time"])): ?>
<?php $time = new DateTime($_GET["time"]) ?>

<h2>There’s a party, and (apparently) you’re invited!</h2>
<p>
	If the magic is working, the party starts for you on:
</p>
<p class="timebox">
	<time datetime="<?php echo $time->format(DATE_RSS)?>"></time>.
</p>
<p>
	The time given was 
	<strong><?php echo $time->format('D, d M Y H:i:s \U\T\C')?></strong>.
</p>
<p>
	If you believe this to be in error,
	<a href="<?php echo $path."/index.php" ?>">do a manual conversion</a>.
<hr />

<?php endif; ?>

<h2>Set a New Time</h2>
<p>Enter the time of your party to go to the desired URL.</p>
<div class="ui-widget">
	<form action="<?php echo $path."/_countdown.php"?>" method="post">
		<p>
			<input class="time" name="day" value="01" />
			<input class="time" name="month" value="January" />
			<input class="time" name="year" value="1970"/> &nbsp;
			<input class="time" name="hour" value="00" />:<input class="time" name="min" value="00" />:<input class="time" name="sec" value="00" /> &nbsp;
			<input class="timezone" name="timezone" value="UTC"/> 
			<input type="submit" value="Create" />
		</p>
	</form>
</div>

<?php include 'foot.php' ?>

</div>

</body>