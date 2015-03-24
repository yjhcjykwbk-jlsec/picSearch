<!DOCTYPE HTML>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/container.css" />
  <link rel="stylesheet" type="text/css" href="css/item.css" />
  <link rel="stylesheet" type="text/css" href="css/contextMenu.css" />
  <style>
  td.ocr_res { max-width:300px; min-width:250px; margin:10px; min-height:100px; font-weight:bold;} 
  img.ocr_pic{ max-width:600px; max-height:200px;} 
  body{background:#333;}
  .container,table{background:#000;}
  </style>
</head>
<body>

<script type="text/javascript" src="src/jquery.min.js"></script>
<script type="text/javascript" src="src/jquery.contextmenu.js"></script>
<script type="text/javascript" src="src/jquery.waterfall.js"></script>
<script type="text/javascript" src="index.js"></script>

<center><h1>OCR's result demonstration</h1></center>
<center><h3><a href="index.html">go back to OCR DATASET</a></h3></center>


<script>
function search(query){
  $.ajax({
    url:"SEARCH/search_js.php", 
      data:"query="+query,
      type:'post', 
      dataType:'json', 
      success:function(result){
        // window.ocr_table=ocr_table;
        $("#ocr_table").empty();
        console.log(result);
        for(i=0;i<result.length;i++){
          var newRow="<tr><td>"+result[i]['name']+"</td><td><img class='ocr_pic' src='"+result[i]['name']+"'></td>"+"<td class='ocr_res'><pre>"+result[i]['text']+"</pre></td>";
          $('#ocr_table').append(newRow);
        }
      }
  });
}
</script>
<center><p><label>搜索:</label>
<input id="query" name="query"></input>
<button onclick="search(query.value);">提交</button></p>
共找到<span id='search_cnt'>  </span>副图片
</center>

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

<table id="ocr_table" border="2" style="margin:auto;">
<?php
for($i=0;$i<count($files);$i++){
  $file=$files[$i];
  $filepath=$file['name'];
  $_t=split("/", $filepath);
  $dir=$_t[0];
  $fname=$_t[1];
?>
<tr><td><?php echo $filepath ?></td>
<td><img style="max-width:230px;overflow:hidden;" class="ocr_pic" src="<?php echo $file['name'];?>"></td> 
<td><img style="max-width:230px;overflow:hidden;" class="detect_pic" src="<?php echo $dir."/detect/".$fname; ?>"></td> 
<td><img style="max-width:230px;overflow:hidden;" class="seg_pic" src="<?php echo $dir."/seg/".$fname; ?>"></td> 
<td class="ocr_res"><pre><?php echo $file['ocr'];?></pre></td<>
</tr>
<?php } ?>
</table>

</div>
</body>
</html>
