<?php
//api to js
function handleOCR($id,$img,$setOCR=true){
  $ocr=new TesseractOCR();
  $text=$ocr->recognize($img);
  // if($text=="") return;
  if($setOCR){
    setOCR($id,$img,$text); 
  }
}
?>
