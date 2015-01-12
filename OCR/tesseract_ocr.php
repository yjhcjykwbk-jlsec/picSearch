<?php
class TesseractOCR {

  function recognize($originalImage) {
		// echo "recognize():".$originalImage."\n";
    $tifImage       = TesseractOCR::convertImageToTif($originalImage);
		// echo "recognize():tifImage:".$tifImage."\n";
    $configFile     = TesseractOCR::generateConfigFile(func_get_args());
    $outputFile     = TesseractOCR::executeTesseract($originalImage, $configFile);
		// echo "recognize():outputFile:".$outputFile."\n";
    $recognizedText = TesseractOCR::readOutputFile($outputFile);
    // TesseractOCR::removeTempFiles($tifImage, $outputFile, $configFile);
    return $recognizedText;
  }

  function convertImageToTif($originalImage) {
    $tifImage = sys_get_temp_dir().'/tesseract-ocr-tif-'.rand().'.tif';
    exec("convert -colorspace gray +matte $originalImage $tifImage");
    return $tifImage;
  }

  function generateConfigFile($arguments) {
    $configFile = sys_get_temp_dir().'/tesseract-ocr-config-'.rand().'.conf';
    exec("touch $configFile");
    $whitelist = TesseractOCR::generateWhitelist($arguments);
    if(!empty($whitelist)) {
      $fp = fopen($configFile, 'w');
      fwrite($fp, "tessedit_char_whitelist $whitelist");
      fclose($fp);
    }
    return $configFile;
  }

  function generateWhitelist($arguments) {
    array_shift($arguments); //first element is the image path
    $whitelist = '';
    foreach($arguments as $chars) $whitelist.= join('', (array)$chars);
    return $whitelist;
  }

  function executeTesseract($tifImage, $configFile) {
    $outputFile = sys_get_temp_dir().'/tesseract-ocr-output-'.rand();
    // $ex="tesseract $tifImage $outputFile -l eng";
    exec("tesseract $tifImage $outputFile -l eng");// nobatch $configFile 2> /dev/null");
    // echo $ex;
    return $outputFile.'.txt'; //tesseract appends txt extension to output file
  }

  function readOutputFile($outputFile) {
    return trim(file_get_contents($outputFile));
  }

  function removeTempFiles() { array_map("unlink", func_get_args()); }
}
?>
