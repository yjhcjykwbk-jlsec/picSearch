<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/container.css" />
	<link rel="stylesheet" type="text/css" href="css/item.css" />
	<link rel="stylesheet" type="text/css" href="css/contextMenu.css" />
  <style>  td.ocr_res{ height:80px; }</style>
</head>
<body>

<script type="text/javascript" src="src/jquery.min.js"></script>
<script type="text/javascript" src="src/jquery.contextmenu.js"></script>
<script type="text/javascript" src="src/jquery.waterfall.js"></script>
<script type="text/javascript" src="index.js"></script>

<center><h1>OCR's result demonstration</h1></center>

<?php 
include_once "db.php";
$files=getImage();
for($i=0;$i<count($files);$i++){
  $file=$files[$i];
  $file['ocr']="not valid";
  if($file['handled']){
    $text=getOCR($file['id']); 
    if($text!=null)
      $files[$i]['ocr']=$text[0]['text'];
  } 
}
?>
<table border="2" style="margin:auto;">
<?php
for($i=0;$i<count($files);$i++){
  $file=$files[$i];
?>
<tr><td class="ocr_res"><img src="<?php echo "DATASET/".$file['name'];?>"></td>
  <td class="ocr_res"><pre><?php echo $file['ocr'];?></pre></td>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>
