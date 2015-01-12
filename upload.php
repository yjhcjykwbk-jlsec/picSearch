<?php
//上传文件类型列表
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
$watermark=0;      //是否附加水印(1为加水印,其他为不加水印);
$watertype=1;      //水印类型(1为文字,2为图片)
$waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
$waterstring="http://www.xxx/";  //水印字符串
$waterimg="xplore.gif";    //水印图片
$imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);
$imgpreviewsize=1/4;    //缩略图比例

?>
<html>
<head>
<title>ZwelL图片上传程序</title>
<style type="text/css">
<!--
body
{
     font-size: 9pt;
}
input
{
     background-color: #66CCFF;
     border: 1px inset #CCCCCC;
}
-->
</style>
</head>

<body>
<?php
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

    // if(!in_array($file["type"], $uptypes))
    // //检查文件类型
    // {
        // myLog( "文件类型不符!".$file["type"]);
        // exit;
    // }

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

    //record the image into datebase
    $id=upload($fname,$url,$desp,$class,$time);
    if($id==-1){
			myLog( "录入数据库出错",true);
			exit;
		}

    include_once "OCR/tesseract_ocr.php";
    include_once "OCR/ocr_db.php";
    myLog("handling with ocr:");
    handleOCR($id,$fname);
    myLog("上传成功:".$fname);

    echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";
    echo " 宽度:".$image_size[0];
    echo " 长度:".$image_size[1];
    echo "<br> 大小:".$file["size"]." bytes";
		echo "<script> setTimeout(function(){window.location.href='uploadpage.html';},3000);</script>";


    if($watermark==1)
    {
        $iinfo=getimagesize($destination,$iinfo);
        $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
        $white=imagecolorallocate($nimage,255,255,255);
        $black=imagecolorallocate($nimage,0,0,0);
        $red=imagecolorallocate($nimage,255,0,0);
        imagefill($nimage,0,0,$white);
        switch ($iinfo[2])
        {
            case 1:
            $simage =imagecreatefromgif($destination);
            break;
            case 2:
            $simage =imagecreatefromjpeg($destination);
            break;
            case 3:
            $simage =imagecreatefrompng($destination);
            break;
            case 6:
            $simage =imagecreatefromwbmp($destination);
            break;
            default:
            myLog("不支持的文件类型",true);
            die("不支持的文件类型");
            exit;
        }

        imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
        imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);

        switch($watertype)
        {
            case 1:   //加水印字符串
            imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
            break;
            case 2:   //加水印图片
            $simage1 =imagecreatefromgif("xplore.gif");
            imagecopy($nimage,$simage1,0,0,0,0,85,15);
            imagedestroy($simage1);
            break;
        }

        switch ($iinfo[2])
        {
            case 1:
            //imagegif($nimage, $destination);
            imagejpeg($nimage, $destination);
            break;
            case 2:
            imagejpeg($nimage, $destination);
            break;
            case 3:
            imagepng($nimage, $destination);
            break;
            case 6:
            imagewbmp($nimage, $destination);
            //imagejpeg($nimage, $destination);
            break;
        }

        //覆盖原上传文件
        imagedestroy($nimage);
        imagedestroy($simage);
    }

    if($imgpreview==1)
    {
    echo "<br>图片预览:<br>";
    echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);
    echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";
    }
}
?>
</body>
</html>
