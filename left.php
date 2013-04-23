<?php
session_start();
include_once('./global.php');
isset($_COOKIE['bid'])?$bulid=$_COOKIE['bid']:header("location:./index.php");

$smarty->caching = true;
$smarty->cache_lifetime =60;

if(!empty($_SESSION['email']))
{
	$query="SELECT `wm_saveshop` . `shopid`, `wm_saveshop`.`savetime`, `wm_shopinfo`.`shopname`
FROM `wm_saveshop`
RIGHT OUTER JOIN `wm_shopinfo` ON `wm_saveshop`.`shopid` = `wm_shopinfo`.`shopid`
WHERE `wm_saveshop`.`username` = '$_SESSION[email]'
ORDER BY `wm_saveshop`.`savetime` ASC limit 0,10";
	$saveshops=$db->query($query)->fetchall();
	$smarty->assign("saveshops",$saveshops);	
}

function smarty_block_nocache($param,$content,$smarty)
{	
	return $content;	
}
$smarty->register_block('nocache','smarty_block_nocache',false);


if(!$smarty->is_cached('left.tpl',$bulid))
{
	$where = "where areaid= $bulid";
	$area  = get_area($db,$bulid);	
	$query="SELECT `shopid`,`online`,`linktime`,`shopname`,`shopimage`,`dintype`,`swstart`,`swend`,`xwstart`,`xwend` FROM `wm_shopinfo` WHERE `shopid` IN (SELECT `shopid` FROM `wm_shoplinkbul` $where) and `shoptype` = 1 order by linktime desc";
	
	$now = strtotime(date("YmdHis"));
	foreach(@$db->query($query) as $rs){
		//判断餐店状态开始
		$state = (strtotime(date($rs['swstart'])) < $now and strtotime(date($rs['swend'])) > $now)||(strtotime(date($rs['xwstart'])) < $now and strtotime(date($rs['xwend'])) > $now)?"1":"0";
		if($rs['shopid']==1){
			$showstate="<font size='2' color='#FF9900'>支持在线体验</font>";
			$rs['dintype'] = $rs['dintype']."6";	
		}else
		{
			if($rs['online']==1){
				if($state==1) {
					$showstate = "<font size='2' color='#FF9900'>支持在线预订</font>";
					$rs['dintype'] = $rs['dintype']."6";
				}else{
					$showstate = "店铺离线";
				}
			}elseif($rs['online']==2){
				 if(abs($now-$rs['linktime'])<=60){
					 $showstate = "<font size='2' color='#FF9900'>支持在线预订</font>";
					 $rs['dintype'] = $rs['dintype']."6";
				 }else{
					 $showstate = "店铺离线";
				 }
			}elseif($rs['online']==3){
				 $showstate = "<font size='2' color='#FF66CC'>自行电话预订</font>";
			}
		}
		//判断店铺状态结束
		$shops[]=array("shopid"=>$rs['shopid'],"showstate"=>$showstate,"shopname"=>$rs['shopname'],"shopimage"=>$rs['shopimage'],"dintype"=>$rs['dintype']);
	}
	
	//print_r($shops);exit;
	$tjms   = get_tuijianms($db,$bulid);
	$rmms   = get_remaimeishi($db,$bulid);
	
	foreach($tjms as $tjrow){
		$tjshopname[$tjrow['dinid']]=get_shopname($db,$tjrow['shopid']);
	}
	foreach($rmms as $rmrow){
		$rmshopname[$rmrow['dinid']]=get_shopname($db,$rmrow['shopid']);
	}
	$active = get_activeorder($db,$bulid);
	$acinfo = array();
	foreach($active as $i=>$row){
		$user = get_user($db,$row['user_id']);
		$acinfo[$i]['nickname'] = $user['nickname'];
		$acinfo[$i]['shopid'] = $row['shopid'];
		$acinfo[$i]['shopname'] = get_shopname($db,$row['shopid']);
		$acinfo[$i]['total_price'] = $row['total_price'];
	}
	
	//优惠信息开始
	$psql = "select `shopid`,`shopname`,`yhcontent`,`yhdate`,`linktime` from wm_shopinfo where `shopid` IN (SELECT `shopid` FROM `wm_shoplinkbul` $where) and shopid<>1 and yhcontent<>'' order by `linktime` desc limit 0,2";
	
	$promotions = $db->query($psql)->fetchall();
	
	$smarty->assign("shops",$shops);
	$smarty->assign("district",$area['d']);	
	$smarty->assign("build",$area['b']);
	$smarty->assign('promotions',$promotions);
	//优惠信息结束
	$smarty->assign("tjms",$tjms);	
	$smarty->assign("rmms",$rmms);	
	$smarty->assign("tjshopname",$tjshopname);	
	$smarty->assign("rmshopname",$rmshopname);
	$smarty->assign("acinfo",$acinfo);
	//西门町美食街
	$ximen = array('0'=>array('shopname'=>'空降鸡排','path'=>'1.jpg'),'1'=>array('shopname'=>'丁叮蛋挞','path'=>'2.jpg'),'2'=>array('shopname'=>'MR.CAO奶茶','path'=>'3.jpg'));
	$smarty->assign("ximen",$ximen);
	
	
}
$smarty->display("left.tpl",$bulid);
//$smarty->assign("shopcart",$cart->display_cart($jcart));
?>

		