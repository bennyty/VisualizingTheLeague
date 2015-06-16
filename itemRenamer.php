<?php 

$itemsRef = unserialize(file_get_contents("itemsReference"));

// $itemsRef[$argv[1]]["name"] = $argv[2];

foreach ($itemsRef as $id => $arr) {
	if (strpos($arr["name"],'Enchantment') !== false){
		echo $id . "\n";
		$line = trim(fgets(STDIN));
		$itemsRef[$id]["name"] = $line;
	}
}

file_put_contents("itemsReference", serialize($itemsRef));

?>