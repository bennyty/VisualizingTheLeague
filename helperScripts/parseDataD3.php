<?php

$items = unserialize(file_get_contents("itemsTotals"));
$itemsRef = unserialize(file_get_contents("itemsReference"));

$table = array();
/* Extract the information from $result */
foreach($items as $rank => $data) {
	$totalItemsInThisRank = 0;
	foreach ($data as $itemId => $valueArray) {
		$totalItemsInThisRank += ($valueArray[0] + $valueArray[1]);
	}
	foreach ($data as $itemId => $valueArray) {
		$table[] = array('winPercent' => $valueArray[0]/($valueArray[0]+$valueArray[1]),
						'buyPercent' => (($valueArray[0]+$valueArray[1])/$totalItemsInThisRank),
						'name' => $itemsRef[$itemId]["name"],
						// ."\n" . $itemId . " " . $rank,
						'id' => $itemId);
		if ($itemsRef[$itemId]["name"] == "Prototype Hex Core") {
			print_r($valueArray);
		}
	}
	// convert data into JSON format
	$jsonTable = json_encode($table);
	$table = array();
	file_put_contents("../public/data/" . $rank . ".json", $jsonTable);
	echo $rank . " " . $totalItemsInThisRank . " \n";
}

?>