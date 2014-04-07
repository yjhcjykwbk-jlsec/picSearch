<?php
include_once "../OCR/tesseract_ocr.php";
include_once "../db.php";
//api to js
function main(){
	$ocr=new TesseractOCR();
	if(!isset($_REQUEST['img'])&&!isset($img)) {
    myLog("image not set",true);
		return;
	}
	if(!isset($img)) $img=$_REQUEST['img'];
	if(!isset($id)) $id=$_REQUEST['id'];
	$txt="<p>input:$img</p>\n";
	try {
		$text=$ocr->recognize($img);
    echo $text;
    setOCR($id,$img,$text);
    // echo " ocr_img:$img ocr_res:".$text;
		$txt.="<p>output:$text</p>\n";
	}
	catch(exception $e){
		echo "ocr failed\n";
		$txt.="<p>$e</p>\n";
	}
	myLog($txt);
}
main();
?>
