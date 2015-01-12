<?php
// include_once "db.php";
// include_once "OCR/tesseract_ocr.php";
// myLog("stage 2",false);
// include_once "OCR/ocr_db.php";
// myLog("stage 3",false);
// myLog("handling with ocr:",false); 
// $id=100;
// $fname="DATASET/1393922866.png";
// handleOCR($id,$fname,false);
include_once "thumb.php";
img2thumb("DATASET/1.jpg","THUMB/1.jpg",100,100,0);
?>
