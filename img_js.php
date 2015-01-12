<?php
include_once "db.php";

if(!isset($_REQUEST['action'])) {echo "action not set";return;}
$action=$_REQUEST['action'];

if($action=="delImg"){
  if(!isset($_REQUEST['id'])||!isset($_REQUEST['img'])) {echo "id not set";return;}
  $id=$_REQUEST['id'];
  $img=$_REQUEST['img'];
  if(delImg($id,$img)) {echo "true";return;}
  echo "delete failed";
  return;
}
echo "action not known";
?>
