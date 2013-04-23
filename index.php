<?php
include 'jcart/jcart.php';
session_start();
$cart =& $_SESSION['jcart'];
if(!is_object($cart)) $cart = new jcart();
if(isset($_COOKIE['bid']))
{
	include './header.php'; 
	include('./left.php'); 
	include('./footer.php'); 
}else
{
	$cart->empty_cart();
    $cid=$_GET['cid'];
    include('./global.php');
	$smarty->caching = true;
	$csql= "select `id`,`areaname` from wm_areainfo where fid=0";
	if(empty($cid))
	{
	    $city = $db->query($csql)->fetch();
		$cid=$city['id'];
	}
	
	if($smarty->is_cached('index.tpl',$cid))
	{
		$smarty->display("index.tpl",$cid);
		exit();
	}
	
	$cities = $db->query($csql)->fetchAll();
	
	if(!empty($cities))
	{
		$smarty->assign('cities',$cities);
		$smarty->assign('cid',$cid);
		
		foreach($cities as $crow)
		{
			$dsql  = "select `id`,`areaname` from wm_areainfo where fid='".$crow['id']."'";
			$districts[$crow['id']]= $db->query($dsql)->fetchAll();
		}
		
		
		foreach($districts as $drow)
		{
			$zsql  = "select `id`,`areaname` from wm_areainfo where fid='".$drow[0]['id']."'";
			$zones[$drow[0]['id']]=$db->query($zsql)->fetchAll();
		}
	
		$smarty->assign('zones',$zones);
		$smarty->assign('districts',$districts);
	}else
	{
		$smarty->assign('msg',"请以超级管理员身份进入后台添加区域,<a href='./admin'>点击这里进入</a>");	
	}
	$smarty->display('index.tpl',$cid);
}
?> 
