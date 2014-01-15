<?php

$result = array();
$items = array();
$m=!isset($_GET['m'])?0:$_GET['m'];
// include "dir.php";
include "db.php";
$files=getImage();
$files=json_decode($files,true);
for ($i=$m; $i < count($files) && $i < $m+10; $i++) { 
		$item = array();
		// $h = rand(1,20);
		echo "\n";
		// print_r( $files["$i"] );
		$file=$files["$i"];
		$item['src'] ="img/".$file["class"]."/".$file["name"]; 
		$item['href'] =$item['src'];
		// $item['h'] = 400;
		$items[] = $item;
}
$result['items'] = $items;
	
echo json_encode($result);
?>
