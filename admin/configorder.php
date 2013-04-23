<?php
include "../global.php";
$orderid = $_POST['orderid'];
$tag     = $_POST['tag'];
$state   = $_POST['state'];
if($state==1&&$tag==4){
	$sql="UPDATE `wm_orders` SET `state` = '5' WHERE `orderid` = '".$orderid."'";
}else{
	$sql="UPDATE `wm_orders` SET `state` = '".$tag."' WHERE `orderid` = '".$orderid."'";
	if($tag==3){
		//成功了就给食客积分同时给商家商品累加
		$osql  = "SELECT `user_id`,`total_price` FROM `wm_orders` WHERE `orderid`='".$orderid."'";
		$oinfo = $db->query($osql)->fetch();
		$jifen = (int)$oinfo['total_price']*10;
		$oinfo['user_id'];
		if($oinfo['user_id']!='0')
		{
			$db->query("update `wm_admin_c` set `jifen`=`jifen`+".$jifen." where `email`= '".$oinfo['user_id']."'");
		}
		
		$itemsql ="SELECT `dinid`,`dinnum` FROM `wm_order_items` WHERE `orderid`='".$orderid."'";
		$iteminfo = $db->query($itemsql)->fetchall();
		
		foreach($iteminfo as $row)
		{			
			$db->query("update wm_dininfo set popnum=popnum+'".$row['dinnum']."' where dinid='".$row['dinid']."'");	
		}
	}
}
if($db->query($sql)->rowCount())
{
echo $tag;
}

?>
