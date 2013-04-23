<?php
include_once('./global.php');
include "./header.php";
function get_items($db,$orderid)
{
	$sql="SELECT * FROM `wm_order_items` WHERE `orderid`='$orderid'";
	return $db->query($sql)->fetchall();
}
if(isset($_SESSION['email']))
{
	$smarty->assign("tag",1);	
	$orders = get_userhistroyorders($db,$_SESSION['email']);
	foreach($orders as $row)
	{
		$shopnames[$row['orderid']]=get_shopname($db,$row['shopid']);
		$orderitems[$row['orderid']]=get_items($db,$row['orderid']);
	}
	$smarty->assign("orderitems",$orderitems);
	$smarty->assign("shopnames",$shopnames);
	$smarty->assign("orders",$orders);
}
$smarty->display("ordercenter.tpl");
include "./footer.php";
?>