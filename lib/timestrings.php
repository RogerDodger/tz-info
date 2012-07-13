<?php
/*
 * Returns JSON for autocompleting the time fields
 */

$lists = array(
	"day"   => range(1,31),
	"month" => array("January", "February", "March", "April", "May", "June",
	          "July", "August", "September", "October", "November", "December"),
	"year"  => range(1902, 2037),
	
	"hour"  => range(0,23),
	"min"   => range(0,59),
	"sec"   => range(0,59),
);

foreach(array_keys($lists) as $list) {
	$lists[$list] = array_map(function($a) {
		return sprintf("%02s", $a);
	}, $lists[$list]);
}
 
$list = $_GET["list"];
if($list === 'all') {
	$filteredOpts = $lists;
} else {
	$opts = $lists[$list];

	$term = $_GET["term"];
	foreach ($opts as $opt)
		if (is_int(stripos($opt, $term)))
			$filteredOpts[] = $opt;
}

header('Content-type: application/json');
echo json_encode($filteredOpts);
?>