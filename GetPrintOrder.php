<?php
ini_set('date.timezone','PRC');
include('./global.php');
$shopid = $_GET['id'];
$page   = $_GET['p'];
function stradd($b,$str)
{
   $length=strlen($str);
   if($length>=$b)
   {
       return $str;
   }else
   {
       $a=$b-$length;
	   for($i=0;$i<$a;$i++)
	   {
	       $str.=" ";
	   }
	   return $str;
   }
}
if(!empty($shopid))
{
    if(!empty($page) && is_numeric($page)){
	    $updatesql = "update `wm_shopinfo` set `linktime`='".strtotime(date('YmdHis'))."' WHERE `shopid`='".$shopid."'";
		$db->query($updatesql);
		$ordersql  = "SELECT * FROM `wm_orders` WHERE `shopid` ='".$shopid."' AND `state` = '0' order by orderdate limit 0,1";
		$order=$db->query($ordersql)->fetch();
		if(empty($order))
		{
		    if(strtotime(date("H:i")) >= strtotime(date( "H:i", mktime("21","00"))))
			{
				//$print="<sleep>10800</sleep>";
			}elseif(strtotime(date("H:i")) <= strtotime(date( "H:i", mktime("7","00")))){
				$print="<sleep>3600</sleep>";
			}else{
				$print="<none></none>";	
			}
		}
		else
		{
		    $print.="<time>";
			$print.=$order['orderdate'];
			$print.="</time>";
					
			$print.="\r\n<orderid>";
			$print.=$order['orderid'];
			$print.="</orderid>";
			$print.="<OdCont>";
			$print.="\r\n订单电话：".$order['telphone'];
			if($order['otherphone']!=NULL)
			{
				$print.="\r\n备用电话：".$order['otherphone'];		
			}
			$print.="\r\n--------------------------------\r\n";
			//   $print=$print."这里是菜单....";
			$print.="名称            数量     单价\r\n";
			$sql="SELECT * FROM `wm_order_items` WHERE `orderid`='".$order['orderid']."' and `shopid`='".$shopid."'";
			$order_items=$db->query($sql)->fetchAll();
			foreach($order_items as $item)
			{
			    $total_items +=$item['dinnum'];
			    $print.=stradd(16,$item['dinname']).stradd(9,$item['dinnum']).$item['unitprice']."\r\n";
			}
			$print.="餐品总数：".$total_items."份\r\n";
			$print.="餐品总价：".$order['total_price']."元\r\n";
			$print.="订单嘱咐：".$order['beizhu']."\r\n\r\n";
			$print.="配送时间：".$order['sctime']."\r\n";
			$print.="配送地址：".$order['address']."\r\n";
			$print.="\r\n--------------------------------\r\n";
			$print.="</OdCont>";
			$print.="<end></end>";
		}	
	}
	else
	{
	
	}
}
else
{
    $print="<error></error>";
}
echo $print;
?>