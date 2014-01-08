<?php

$result = array();
$items = array();
if(!isset($_GET['m'])) {
	console.log("m not set");
	return;
}
$m=$_GET['m'];
include "dir.php";
for ($i=$m; $i < count($files) && $i < $m+10; $i++) { 
    $item = array();
		$h=$i;
    // $h = rand(1,20);
    $item['src'] ="img/".$files[$i]; 
    $item['href'] ="img/".$files[$i]; 
    // $item['h'] = 400;
    $items[] = $item;
}
$result['items'] = $items;
	
echo json_encode($result);
?>
