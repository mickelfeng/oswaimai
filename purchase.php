<?php
// The shopping cart needs sessions, so start one
include_once('./global.php');
include_once './jcart/jcart.php';
//require_once ('./email.class.php');
include "./header.php";
session_start();

if($_SERVER['REQUEST_METHOD']=='POST')
{   
	$cart    = & $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();
	$email   = !empty($_SESSION['email'])?$_SESSION['email']:0;
	//$msg     = "您的订单已生效，";
	$mark    = array();
	$temp    = "";
	extract($_POST);
	
	if(empty($address)||empty($telphone)){
		echo "地址或电话不能为空！<a href='./index.php'>返回首页</a>";exit;
	}
	
	if ($cart->get_contents())
	{
		$fee = $cart->get_shopfee();
		$orderdate  = date("Y-m-d H:i:s");
		foreach ($cart->get_contents() as $item){
			$total_price[$item['shop']] += $item['price']*$item['qty'];
			$contents[$item['shop']][]=$item;
		}
		
		try{
			$db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->beginTransaction();
			foreach ($contents as $shopid=>$content)
			{
				$tprice = $total_price[$shopid]+$fee[$shopid];
				$orderid    = "1".$shopid.get_orders($db,$shopid).rand(0,9);
				$query = "insert into wm_orders set `orderid`='$orderid',`user_id`='$email',`shopid`='$shopid',`fee`='$fee[$shopid]',`address`='$address',`telphone`='$telphone',`otherphone`='$otherphone',`orderdate`='$orderdate',`sctime`='$deliver_time',`state`='0',`total_price`='$tprice',`beizhu`='$bzxx'";
				$db->exec($query);
				$temp.="<font size='3'><b>".get_shopname($db,$shopid).":订单号为：$orderid"."</b></font><br>";
				/*if($shopid!=1){
					$msg.=get_shopname($db,$shopid).":订单号为：$orderid";
				}*/
				$mark[]=$shopid;			
						
				foreach($content as $item)
				{
					$item_id	= $item['id'];
					$detail     = get_din_details($db,$item_id);
					$item_name	= $item['name'];
					$item_price	= $item['price'];
					$item_qty	= $item['qty'];
					$shopid     = $item['shop'];
					$type       = get_dintypename($db,$shopid,$detail['dintype']);
	
					//$sqlquery = "insert into wm_order_items values('$orderid','$item_id','".$shopid."','".$item['name']."','".$type."',$item_qty ,'".$item_price*$item_qty ."','".$item_price."' , '".$orderdate."','','')";
					$price = $item_price*$item_qty;
					$sqlquery = "insert into wm_order_items set `orderid`='$orderid',`dinid`='$item_id',`shopid`='$shopid',`dinname`='$item[name]',`dintype`='$type',`dinnum`='$item_qty',`dinprice`='$price',`unitprice`='$item_price',`orderdate`='$orderdate'";
					$db->exec($sqlquery);
				}
			}		
			$temp.="<br><b><font size=3>订餐成功，我们将尽快为你配送，谢谢下次光临!</b></font>";
			//$msg.="【我饿啦外卖】";
			//count($mark)==1&&$mark[0]==1?'':sendSMS($uid,$pwd,$telphone,$msg);
			$cart->empty_cart();
			$db->commit();
		}catch(PDOException $e){
			$db->rollBack();
			$temp="<p><font size='3'><b>数据提交失败，请联系管理员MR QIAN 【QQ:312181918】!</b></font></p>";
		}
	}else{ 
		$temp.="<p>您的购物车为空，请选择餐品!</p>";
	}
}
$smarty->assign('temp',$temp);
$smarty->display('purchase.tpl');
include "./footer.php";
?>
