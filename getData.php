<?php

$items = unserialize(file_get_contents("itemsTotals"));
$itemsRef = unserialize(file_get_contents("itemsReference"));

$rows = array();
$table = array();
$table['cols'] = array(
	array('label' => 'Win Percentage', 'type' => 'number'),
	array('label' => 'Buy Percentage', 'type' => 'number'),
	array('role' => 'tooltip', 'type' => 'string')
);

$bitCheck = array();

/* Extract the information from $result */
foreach($items as $rank => $data) {

	foreach ($data as $itemId => $valueArray) {
		$totalItemsInThisRank += ($valueArray[0] + $valueArray[1]);
		if ($bitCheck[$itemId] > 0) {
			echo "  ERROR: " . $rank . " " . $bitCheck[$itemId] . " " . $itemsRef[$itemId]["name"] . " \n";
		}
		$bitCheck[$itemId]++;
	}
	$bitCheck = array();
	foreach ($data as $itemId => $valueArray) {
		$temp = array();
		$temp[] = array('v' => $valueArray[0]/($valueArray[0]+$valueArray[1]));
		$temp[] = array('v' => (($valueArray[0]+$valueArray[1])/$totalItemsInThisRank));
		$temp[] = array('v' => $itemsRef[$itemId]["name"]."\n" . $itemId . " " . $rank); 
		$rows[] = array('c' => $temp);
	}

	$table['rows'] = $rows;
	$rows = array();
	// convert data into JSON format
	$jsonTable = json_encode($table);
	file_put_contents("public/data/" . $rank . ".json", $jsonTable);
	echo $rank . " " . $totalItemsInThisRank . " \n";
}

?>