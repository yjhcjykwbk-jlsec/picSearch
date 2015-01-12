<?php
if(!isset($_REQUEST['query'])) echo json_encode(Array('res'=>'false','error'=>'query not set'));
else
{
  include_once "sphinxapi.php";
  include_once "../db.php";

  $query=$_REQUEST['query'];
  $sphinx=new SphinxClient();

  $sphinx->SetServer('localhost',9346);
  $sphinx->SetArrayResult(true);
  $sphinx->SetMaxQueryTime(10);
  $index='text_text';

  $res=$sphinx->Query($query,$index);//,$index);
  $result=Array();//[];
  // $result['cnt']=$res['total'];
  // $result['query']=$query;
  // $result['words']=$res['words'];
  //{'xx':{docs:n,hits:n},'yy'..}
  // $result['error']=$res['error'];
  //[ {id:.. weight:xx attrs:{name:..}} ]
  $matches=$res['matches'];
  foreach($matches as $match){
    $tmp['id']=$match['id'];
    $ocr=getOCR($match['id']); 
    if($ocr!=null) $ocr=$ocr[0]['text'];
    $tmp['text']=$ocr;
    $tmp['name']=$match['attrs']['name'];
    $result[]=$tmp;
  }
  echo json_encode($result);
}
?>

