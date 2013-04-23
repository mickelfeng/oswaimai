<?php
include_once('./global.php');
$smarty_caching =true;
include 'jcart/jcart.php';
include "./header.php";

session_start();
isset($_COOKIE['bid'])?$bulid=$_COOKIE['bid']:header("location:./index.php");
$area  = get_area($db,$bulid);
$smarty->assign("district",$area['d']);	
$smarty->assign("build",$area['b']);	

//是否是人人登陆 是显示分享到人人按钮
$mark=$_COOKIE['fa0dc1c1d2624a9585910fc454a8c809']?1:0;
$smarty->assign("mark",$mark);
$cart =& $_SESSION['jcart']; if(!is_object($cart)) $cart = new jcart();

if($smarty->is_cached('graduate',$shopid))
{
	$smarty->display("graduate.tpl",$shopid);
	exit();
}

   $shopid=40;

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
			  $dinners[$e][]=array('dinid'=>$rsi['dinid'],'dinname'=>$rsi['dinname'],'dinimage'=>$rsi['dinimage'],'dinprice'=>$rsi['dinprice'],'shopid'=>$rsi['shopid'],'isellout'=>$rsi['isellout'],'intro'=>$rsi['beizhu']);  
		   }
	   }
   }
   $querys = "select yhtime,yhcontent from wm_yhinfo where shopid='".$shopid."'";
   foreach(@$db->query($querys) as $rowyh)
   {
        $yhtime = empty($rowyh['yhcontent'])?'':'截止日期:'.$rowyh[yhtime];
		$smarty->assign("yhtime",$yhtime);
   }
   
   $row=get_shop_details($db,$shopid);
   $smarty->assign("shopimage",$row['shopimage']);
   $smarty->assign("shopname",$row['shopname']);
   $smarty->assign("shopintro",$row['shopintro']);
   $smarty->assign("shoptel",$row['shoptel']);
   $smarty->assign("shopadd",$row['shopadd']);
   $smarty->assign("price",$row['price']);
   $smarty->assign("beizhu",$row['beizhu']);
   $smarty->assign("online",$row['online']);
   $smarty->assign("dinners",$dinners);
   $smarty->assign("shops",$dintypes);
   $smarty->assign("shopcart",$cart->display_cart($jcart));
   $smarty->display("graduate.tpl",$shopid);
   include_once('./footer.php'); 
?>