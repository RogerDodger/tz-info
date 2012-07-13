<?php
/*
 * Returns JSON for autocompleting the timezone field
 */

$term = $_GET["term"];
$zones = DateTimeZone::listIdentifiers();
foreach ($zones as $zone)
	if (is_int(stripos($zone, $term)))
		$filteredZones[] = $zone;
header('Content-type: application/json');
echo json_encode($filteredZones);

?>