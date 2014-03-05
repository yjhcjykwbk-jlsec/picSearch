<?php
//api to js
function handleOCR($id,$img){
  $ocr=new TesseractOCR();
  $text=$ocr->recognize($img);
  if($text=="") return;
  setOCR($id,$img,$text); 
}
?>
