<?php

$items = unserialize(file_get_contents("itemsTotals"));
$itemsRef = unserialize(file_get_contents("itemsReference"));

$rows = array();
$table = array();
$table['cols'] = array(
	// array('label' => 'Name', 'type' => 'string'),
	array('label' => 'Win Percentage', 'type' => 'number'),
	array('label' => 'Buy Percentage', 'type' => 'number')
);
/* Extract the information from $result */
foreach($items as $rank => $data) {

	foreach ($data as $itemId => $valueArray) {
		$totalItemsInThisRank += ($valueArray[0] + $valueArray[1]);
	}
	foreach ($data as $itemId => $valueArray) {
		$temp = array();

		// the following line will be used to slice the Pie chart

		// $temp[] = array('v' => (string) $itemRef[$itemId]["name"]); 

		// Values of each slice

		$temp[] = array('v' => $valueArray[0]/($valueArray[0]+$valueArray[1]));
		$temp[] = array('v' => (($valueArray[0]+$valueArray[1])/$totalItemsInThisRank));
		$rows[] = array('c' => $temp);
	}

	$table['rows'] = $rows;

	// convert data into JSON format
	$jsonTable = json_encode($table);
	file_put_contents("public/data/" . $rank . ".json", $jsonTable);
	echo $rank . "\n";
}

?>