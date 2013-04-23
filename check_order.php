<?php
include_once('./global.php');
include "./header.php";
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $orderid=$_POST['orderid'];
	if(is_numeric($orderid))
	{
	    $cksql ="SELECT `wm_orders`.*,`wm_order_items`.dinname,`wm_order_items`.dintype,`wm_order_items`.dinnum,`wm_order_items`.dinprice,`wm_order_items`.unitprice FROM `wm_orders` right join `wm_order_items` on `wm_orders`.`orderid` = `wm_order_items`.`orderid` where `wm_orders`.`orderid`='".$orderid."'";
		$order   = $db->query($cksql)->fetchall();
		$shopname= get_shopname($db,$order[0]['shopid']);
		$smarty->assign('shopname',$shopname);
		if($order)
		{
		    $smarty->assign('order',$order);
		}else
		{
		    echo "对不起，您输入的订单号不存在";
		}
	}
	else
	{
	    echo "对不起，您输入的不是有效订单号！";
	}
}
$smarty->display("check_order.tpl");

include "./footer.php";
?>