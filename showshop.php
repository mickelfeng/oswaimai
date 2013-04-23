<?php
include_once('./global.php');
include 'jcart/jcart.php';
include "./header.php";
include "./admin/pagination3.php";
session_start();
isset($_COOKIE['bid'])?$bulid=$_COOKIE['bid']:header("location:./index.php");
$shopid = $_GET['shopid'];
$tag    = isset($_GET['tag'])?$_GET['tag']:0;
$page   = intval($_GET['page']);
if($page<=0)  $page  = 1;
$smarty->assign("tag",$tag);
if(!is_numeric($bulid)||!is_numeric($shopid)||!is_numeric($tag))exit;

$smarty->assign("shopid",$shopid);

$smarty->caching = true;
$cart =& $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();

if(!empty($_SESSION['email']))
{
	$exist = $db->query("select `id` from `wm_saveshop` where `username`='$_SESSION[email]' and `shopid`='$shopid'")->fetchcolumn();	
	$smarty->assign("exist",$exist);
}
function smarty_block_nocache($param,$content,$smarty)
{	
	return $content;	
}
$smarty->register_block('nocache','smarty_block_nocache',false);


if($smarty->is_cached('showshop.tpl',$shopid.$tag.$page))
{
	echo "<div id='sidebar'>";
	$smarty->assign("shopcart",$cart->display_cart($jcart));
	echo "</div>";
	$smarty->display("showshop.tpl",$shopid.$tag.$page);
	include('./footer.php');
	exit();
}
$area  = get_area($db,$bulid);
$smarty->assign("district",$area['d']);	
$smarty->assign("build",$area['b']);	

$query="SELECT DISTINCT dintype FROM wm_dininfo WHERE shopid ='".$shopid."'";

foreach(@$db->query($query) as $rs)
{ 
  $sql="select dintype from wm_dincategory where id ='".$rs['dintype']."'";
  foreach($db->query($sql) as $resarr)
  {
	  $rest=$resarr['dintype'];	  
  }
  $dintypes[]=array("dintype"=>$rs['dintype'],"typename"=>$rest);
}

if(is_array($dintypes))
{
   foreach($dintypes as $e=>$row)
   {
   
	   $i="select * from wm_dininfo where shopid = '".$shopid."' and dintype = '".$row['dintype']."' order by dinimage desc";
	   foreach($db->query($i) as $rsi)
	   {
		  $dinners[$e][]=array('dinid'=>$rsi['dinid'],'dinname'=>$rsi['dinname'],'dinprice'=>$rsi['dinprice'],'shopid'=>$rsi['shopid'],'isellout'=>$rsi['isellout'],'popnum'=>$rsi['popnum'],'dinimage'=>$rsi['dinimage']);  
	   }
   }
}

$shopinfo=get_shop_details($db,$shopid);

$yysj="上午".substr($shopinfo['swstart'],0,5)."-".substr($shopinfo['swend'],0,5)." 下午".substr($shopinfo['xwstart'],0,5)."-".substr($shopinfo['xwend'],0,5);

//餐品的评价开始
if($tag==1)
{
	$rpp = 18; // results per page
	
	$adjacents  = intval($_GET['adjacents']);
	if(!$_GET['tpages'])
	{
		$count = $db->query("SELECT count(`id`) FROM `wm_grade` WHERE `shopid`='$shopid' and `speed`='0'")->fetchColumn();
		$tpages = ($count) ? ceil($count/$rpp) : 1;// total pages, last page number
	}else
	{
		$tpages = $_GET['tpages'];
	}
	if($adjacents<=0) $adjacents = 2;
	$from = ($page-1)*$rpp;
	$dinpj =$db->query("SELECT `wm_grade`.*,`wm_admin_c`.`nickname` FROM `wm_grade`,`wm_admin_c` WHERE  `wm_grade`.`shopid`='$shopid' and `wm_grade`.`speed` ='0' and `wm_grade`.email=`wm_admin_c`.email ORDER BY `postdate` DESC limit $from,$rpp")->fetchall();
	$reload = $_SERVER['PHP_SELF'] . "?tpages=".$tpages."&amp;adjacents=".$adjacents."&amp;shopid=".$shopid."&amp;tag=".$tag;
	$smarty->assign("paginate",paginate_three($reload, $page, $tpages, $adjacents));
	
	foreach($dinpj as $key=>$pjrow){
		$dininfo=$db->query("select `dinname`,`dinprice`,`isellout` from wm_dininfo where dinid='".$pjrow['gradeid']."'")->fetch();
		$dinpj[$key]['dinname']=$dininfo['dinname'];
		$dinpj[$key]['dinprice']=$dininfo['dinprice'];
		$dinpj[$key]['isellout']=$dininfo['isellout'];
	}
//餐品评价结束
}
$smarty->assign("dinpj",$dinpj);
$smarty->assign("yysj",$yysj);
$smarty->assign("shopinfo",$shopinfo);
$smarty->assign("dinners",$dinners);
$smarty->assign("shops",$dintypes);
echo "<div id='sidebar'>";
$smarty->assign("shopcart",$cart->display_cart($jcart));
echo "</div>";
$smarty->display("showshop.tpl",$shopid.$tag.$page);
include('./footer.php'); 
?>