<?php
include_once('./global.php');
include 'jcart/jcart.php';
include "./header.php";
session_start();
$cart =& $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();
$bulid = isset($_COOKIE['bid'])?$_COOKIE['bid']:8;

$search = $_POST['txtSuggestEntity'];
if($search==''||$search=='搜索餐品:名称')
{echo "请输入要搜索的餐品名称！！！";}else
{
$searchshops  = get_searchshops($db,$search,$bulid);
$dinners= get_searchdinners($db,$search,$bulid);
foreach($dinners as $row)
{
    //$row['dinname']=preg_replace("/($search)/i","<font color=red><b>\${1}</b></font>",$row['dinname']);
	if($shopid!=$row['shopid'])
	{
		$shops[$row['shopid']]=get_shop_details($db,$row['shopid']);
	}
	$shopid=$row['shopid'];
}
$now = strtotime(date("YmdHis"));
$smarty->assign("searchshops",$searchshops);
$smarty->assign("bulid",$bulid);	
$smarty->assign("now",$now);
$smarty->assign("search",$search);
$smarty->assign('shops',$shops);
$smarty->assign("dinners",$dinners);
$smarty->assign("shopcart",$cart->display_cart($jcart));
$smarty->display("searchdinners.tpl");
}
include "./footer.php";
?>