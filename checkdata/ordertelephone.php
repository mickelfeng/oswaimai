<?php
	include_once('../global.php');
	include_once '../jcart/jcart.php';
	session_start();
	$cart    = & $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();
	$email   = !empty($_SESSION['email'])?$_SESSION['email']:0;

if ($cart->get_contents()){
	extract($_POST);
	$orderdate  = date("Y-m-d H:i:s");
	foreach ($cart->get_contents() as $item)
	{
		$total_price[$item['shop']] += $item['price']*$item['qty'];
	}
	foreach ($cart->get_contents() as $item)
	{
		$item_id	= $item['id'];
		$detail     = get_din_details($db,$item_id);
		$item_name	= $item['name'];
		$item_price	= $item['price'];
		$item_qty	= $item['qty'];
		$shopid     = $item['shop'];
		$type       = get_dintypename($db,$shopid,$detail['dintype']);
		
		if($shopid!=$shop)
		{
			$orderid    = "3".$shopid.get_orders($db,$shopid);
			$query = "insert into wm_orders values('$orderid$shopid','$email','$shopid','','','','','','','$orderdate','','2','$total_price[$shopid]','')";
			$db->query($query);	
		}
		
		$sqlquery = "insert into wm_order_items values('$orderid$shopid','$item_id','".$shopid."','".$item['name']."','".$type."',$item_qty ,'".$item_price*$item_qty ."','".$item_price."' , '".$orderdate."','')";
			
		if(!$db->query($sqlquery)){echo "数据操作失误，请联系管理员！电话：15251435057";exit();}
		$shop=$shopid;
	}

	$cart->empty_cart();
}
?>