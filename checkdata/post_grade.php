<?php
include_once('../global.php');
session_start();
extract($_POST);

if(is_utf8($pj_content)){
	$pj_content=iconv('utf-8','gb2312',$pj_content);
}
$gradeid = $did==0?$oid:$did;

$db->query("insert into `wm_grade`(`gradeid`,`shopid`,`speed`,`grade`,`content`,`email`,`postdate`) values('".$gradeid."','".$shopid."','".$speed."','".$pinjia."','".$pj_content."','".$_SESSION['email']."',now())");

if((int)$db->lastInsertId())
{
	if($did==0){   //更新订单状态为6 为已评价
		$sql="update `wm_orders` set `state`='6' WHERE `orderid`='$oid'";
	}else{
		$sql="update `wm_order_items` set `state`='1' WHERE `dinid`='$did' and `orderid`='$oid'";
	}
	echo $db->query($sql)->rowCount();
}

function is_utf8($word) 
{ 
	  return preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true?true:false;
} 
?>