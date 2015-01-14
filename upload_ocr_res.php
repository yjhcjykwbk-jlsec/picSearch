<?php
$r = $_REQUEST;
echo $r;
if(!isset($r['name']) || !isset($r['txt']) ) {
  echo "name or txt not set";
  return;
}
if(!file_exists("DATASET/".$name)){
  echo "file not uploaded";
  return;
}
include "db.php";
$name = $r['name'];
$txt = $r['txt'];

$id = upload($name, '', '', '', '');
if($id == -1){
  echo "insert db failed";
  return;
}
setOCR($id, $name, $txt);
echo "successed";
?>
