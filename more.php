<?php

$result = array();
$items = array();
$m=!isset($_GET['m'])?0:$_GET['m'];
// include "dir.php";
include_once "db.php";
$files=getImage();
$files=json_decode($files,true);
for ($i=$m; $i < count($files) && $i < $m+10; $i++) { 
		$item = array();
		// $h = rand(1,20);
		// print_r( $files["$i"] );
		$file=$files["$i"];
		$item['src'] ="DATASET/".$file["name"]; 
		$item['href'] =$file['ref'];
    $item['alt']=$file['desp'];
    $item['id']=$file['id'];
		// $item['h'] = 400;
		$items[] = $item;
}
$result['items'] = $items;
	
echo json_encode($result);
?>
