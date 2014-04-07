<?php
//上传文件类型列表
$ServerHost="http://219.223.194.207/pic/";
$uptypes=array(
    'image/jpg',
    'image/jpeg',
    'image/png',
    'image/pjpeg',
    'image/gif',
    'image/bmp',
    'image/x-png'
);

$class=isset($_REQUEST['class'])?$_REQUEST['class']:'';
$max_file_size=2000000;     //上传文件大小限制, 单位BYTE
$destination_folder="DATASET/";//"img/$class/"; //上传文件路径

include_once "db.php";
myLog("a new upload request:".print_r($_FILES,true));
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))
    //是否存在文件
    {
         myLog( "图片不存在!",true);
         exit;
    }

    $file = $_FILES["upfile"];
    if($max_file_size < $file["size"])
    //检查文件大小
    {
        myLog( "文件太大!",true);
        exit;
    }

    if(!file_exists($destination_folder))
    {
        mkdir($destination_folder);
    }

    $filename=$file["tmp_name"];
    $image_size = getimagesize($filename);
    $ftype=pathinfo($file["name"])['extension'];
		$time=time();
    $destination = $destination_folder.$time.".".$ftype;
    if (file_exists($destination) && $overwrite != true)
    {
        myLog( "同名文件已经存在了",true);
        exit;
    }

    if(!move_uploaded_file ($filename, $destination))
    {
				myLog( "move_uploaded_file:$filename to $destination");
        myLog( "移动文件出错",true);
        exit;
    }

    $fname=$destination;//pathinfo($destination)[basename];
		$url=isset($_REQUEST['url'])?$_REQUEST['url']:'';
		$desp=isset($_REQUEST['desp'])?$_REQUEST['desp']:'';

    $id=upload($fname,$url,$desp,$class,$time);
    if($id==-1){
			myLog( "录入数据库出错",true);
			exit;
		}

    include_once "OCR/tesseract_ocr.php";
    include_once "OCR/ocr_db.php";
    include_once "ALARM/alarm.php";

    myLog("handling with ocr:");
    $text=handleOCR($id,$fname);
    //to alarm if sensitive message found
    detect($text,$ServerHost.$fname);

    myLog("上传成功:".$fname);

    echo $ServerHost.$fname;
}
?>
