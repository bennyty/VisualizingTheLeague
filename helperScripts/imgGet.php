<?php 
$items = unserialize(file_get_contents("itemsTotals"));

foreach($items as $rank => $data) {
	foreach ($data as $itemId => $valueArray) {
		file_put_contents("../public/media/" . $itemId . ".png", file_get_contents("http://ddragon.leagueoflegends.com/cdn/5.11.1/img/item/" . $itemId . ".png"));
	}
}

?>