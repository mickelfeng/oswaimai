<?php
include_once('./global.php');
include "./header.php";

$smarty->caching = true;
if($smarty->is_cached('promotion.tpl',$bulid))
{
    $smarty->display('promotion.tpl',$bulid);
	include "./footer.php";
	exit;
}
isset($_COOKIE['bid'])?$bulid=$_COOKIE['bid']:header("location:./index.php");
//获得餐店优惠信息
$psql = "select `shopid`,`shopname`,`yhcontent`,`yhdate`,`linktime` from wm_shopinfo where `shopid` IN (SELECT `shopid` FROM `wm_shoplinkbul` where areaid= $bulid) and `yhcontent`<>'' order by `linktime` desc";
$promotions = $db->query($psql)->fetchall();

$smarty->assign('promotions',$promotions);
$smarty->display('promotion.tpl',$bulid);

include "./footer.php";
?>