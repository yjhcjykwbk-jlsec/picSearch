<?php
$res= scandir("../../img");
$files=array();
foreach($res as $d){
	// echo $d;
 //如果是文件，并且后缀名为jpg png的文件
 $tmp=explode('.',$d);
 $k=end($tmp);
 if(in_array($k,array('jpg','png'))){
  $files[]=$d;
 }
}
sort($files,SORT_STRING);
?>
