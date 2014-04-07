<?php
function detect($text,$imgUri){
  $admin="abc";
  notify("[web security alarm]Find sensitive message",$text,$imgUri,$admin);
  return true;
}
function notify($title,$message,$uri,$user){
  // if (empty(str(str1,str2)) and str(str1,str2)!=0)
  $data = array('title'=>$title,'message'=>$message, 'uri'=>$uri,'broadcast'=>'N','username'=>$user); //定义参数
  $data = http_build_query($data); //把参数转换成URL数据
  $aContext = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $data));
  $cxContext = stream_context_create($aContext);
  $sUri = 'http://127.0.0.1:8080/notification.do?action=admin_send'; //此处必须为完整路径
  $reply=file_get_contents($sUri,false,$cxContext);
}
// if (str($text,"goverment")!=null)
// detect("fdfd");
//
?>
