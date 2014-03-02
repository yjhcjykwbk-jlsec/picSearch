<?php
/////datatype
class mydb{
    var $Host="127.0.0.1:3306";
    var $Database="ocr";
    var $User="root";
    var $Pwd="1234";
    var $Link_ID=0;//
    var $Query_ID=0;
    var $Fields_Array;//缓存返回集合的各列名字
    var $Rows_Array;//缓存返回集合的各行
    function connect($Database="",$Host="",$User="",$Pwd=""){
        if($Database=="") $Database=$this->Database;
        if($Host=="") $Host=$this->Host;
        if($User=="") $User=$this->User;
        if($Pwd=="")  $Pwd=$this->Pwd;
        if($this->Link_ID==0){
            $this->Link_ID=@mysql_pconnect($Host,$User,$Pwd);
            if(!$this->Link_ID){
                $this->halt("connect mysql failed");
						}
            if(!mysql_select_db($this->Database,$this->Link_ID))
						{
                $this->halt("use database error");
						}
        }
        return $this->Link_ID;
    }function __construct(){
        $this->connect();
    }function __destruct(){
        mysql_close($this->Link_ID);
    }function query($query,$log=false){
        if(!$this->Query_ID)
            $this->free();
        if(!$this->Link_ID) 
            $this->connect();
				if($log)$this->log($query);
        $this->Query_ID=mysql_query($query,$this->Link_ID);
        if(!$this->Query_ID)
            $this->halt("sql query failed");
        return $this->Query_ID;
    }function get_rows(){
        return mysql_num_rows($this->Query_ID);
    }function get_rows_array(){
        $rows=mysql_num_rows($this->Query_ID);
        for($i=0;$i<$rows;$i++){
            if(!mysql_data_seek($this->Query_ID,$i))
                $this->halt("mysql_data_seek failed at row".$i);
						else $this->Rows_Array[$i]=mysql_fetch_array($this->Query_ID,MYSQL_ASSOC);
        }
        return $this->Rows_Array;
    }function get_fields(){
        return mysql_num_fields($this->Query_ID);
    }function get_fields_array(){//返回结果中的各列名
        $fields=mysql_num_fields($this->Query_ID);
        for($i=0;$i<$fields;$i++)
            $this->Fields_Array[$i]=mysql_fetch_fields($this->Query_ID,$i)->name;
        return $this->Fields_Array;
    }function halt($msg){
        $error=mysql_error();
        printf("<BR><b>database has error</b>%s<br>\n",$msg);
        printf("<BR><b>mysql return error msg</b>%s<br>\n",$error);		
    }function free(){
        if($this->Query_ID){
            @mysql_free_result($this->Query_ID);
            $this->Query_ID=0;
        }
    } function log($sql){
			$end="\n";
			$file=fopen("log.sql","a");
			fwrite($file,$sql.$end);
			fclose($file);
		}
};
$db=new Mydb();
function ESCAPE($str){
	return mysql_escape_string($str);
}
function upload($name,$url,$desp,$class,$time){
	global $db;
	$url=ESCAPE($url);
	$name=ESCAPE($name);
	$desp=ESCAPE($desp);
	$class=ESCAPE($class);
	$sql="insert into pic(name,ref,desp) values('$name','$url','$desp');";
	echo $sql;
	return $db->query($sql);
}
function setOCR($id,$name,$text){
	global $db;
  $sql="insert into text(id,name,text) values('$id','$name','$text');";
  $db->query($sql,true);
  $sql="update pic set handled='1' where id='$id'";
  $db->query($sql,true);
}
function getOCR($id){
	global $db;
  $sql="select * from text where id='$id'";
  return $db->query($sql);
}
function indexed($name){
	global $db;
	$sql="update table pic set indexed=true where name='$name'";
	$db->query($sql);
}
function getImage(){
	global $db;
	$sql="select * from pic";
	$db->query($sql);
	$res=$db->get_rows_array();
	return json_encode($res);
}
function getImageByDate($date){
	global $db;
	$sql="select * from pic where date(timestamp)=$date";
	$db->query($sql);
	$res=$db->get_rows_array();
	return $res;
}
function getImageByTime($time){
	global $db;
	$sql="select * from pic where timestamp>=$time";
	$db->query($sql);
	$res=$db->get_rows_array();
	return $res;
}
//test
// setOCR(1,"changweibo","sfsd");
?>
