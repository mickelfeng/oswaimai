<?php
include_once('./global.php');
include 'jcart/jcart.php';
include "./header.php";
session_start();
$cart =& $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();

$fsql="SELECT * FROM `wm_dincategory` WHERE `shopid`=6 and `fid`=0 and `dintype`<>'NULL'";
$ftype=$db->query($fsql)->fetchAll();
foreach ($ftype as $row)
{
    $ssql="SELECT * FROM `wm_dincategory` WHERE `shopid`=6 and `fid`='".$row['id']."' and `dintype`<>'NULL'";
    $stype[$row['id']]=$db->query($ssql)->fetchAll();
}
$smarty->assign('ftype',$ftype);
$smarty->assign('stype',$stype);

$pid=$_GET['pid'];
$psql="SELECT * FROM `wm_dininfo` WHERE `dinid` = $pid";
$pinfo = $db->query($psql)->fetch();
$smarty->assign('pinfo',$pinfo);

//$smarty->assign("shopcart",$cart->display_cart($jcart));
$smarty->display('supershow.tpl');
include "./footer.php";
?>