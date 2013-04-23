<?php
include_once('./global.php');
session_start();
isset($_COOKIE['bid'])?$bulid=$_COOKIE['bid']:header("location:./index.php");
//获取城市
if(!isset($_SESSION['email']))
{
	if(isset($_COOKIE['email'])&&$_COOKIE['email']!=NULL&&isset($_COOKIE['mark'])&&$_COOKIE['mark']!=NULL)
	{
		if(check_login($db,$_COOKIE['email'],$_COOKIE['mark']))
		{
			 $_SESSION['email'] = $_COOKIE['email'];
		}
	}
}
if(strpos($_SERVER['REQUEST_URI'],'bbs'))
{
	$tag[1]=$tag[2]=$tag[3]=$tag[4]=$tag[5]=0;$tag[6]="class='current'";	
}elseif(strpos($_SERVER['REQUEST_URI'],'index') || $_SERVER['REQUEST_URI']=='/' || strpos($_SERVER['REQUEST_URI'],'showshop'))
{
	$tag[6]=$tag[2]=$tag[3]=$tag[4]=$tag[5]=0;$tag[1]="class='current'";
}elseif(strpos($_SERVER['REQUEST_URI'],'gift'))
{
	$tag[6]=$tag[2]=$tag[3]=$tag[4]=$tag[1]=0;$tag[5]="class='current'";
}elseif(strpos($_SERVER['REQUEST_URI'],'promotion'))
{
	$tag[6]=$tag[2]=$tag[3]=$tag[5]=$tag[1]=0;$tag[4]="class='current'";
}elseif(strpos($_SERVER['REQUEST_URI'],'graduate'))
{
	$tag[6]=$tag[4]=$tag[3]=$tag[5]=$tag[1]=0;$tag[2]="class='current'";
}
elseif(strpos($_SERVER['REQUEST_URI'],'supermarket'))
{
	$tag[6]=$tag[4]=$tag[2]=$tag[5]=$tag[1]=0;$tag[3]="class='current'";
}



if(isset($_COOKIE['renrenid'])){
    $_SESSION['email'] = $_COOKIE['renrenid'];
	$mark=1;
}else{
    $mark=0;
}
if(isset($_GET['shopid']))
{
	$smarty->assign('shopname',get_shopname($db,$_GET['shopid']));	
}
if(isset($_SESSION['email'])&&isset($_COOKIE['renrenid']))
{
    $user = get_user($db,$_SESSION['email']);
    $nc = "<img src='./images/ico_renren.gif' align='bottom'/><a href='http://www.renren.com'  target='_blank'>".$user['nickname']."</a>&nbsp;积分:".$user['jifen']."&nbsp;&nbsp;<a id='feed_link' href='javascript:void(0);'>告诉好友</a>";
}elseif(isset($_SESSION['email'])&&!isset($_COOKIE['renrenid']))
{
    $user = get_user($db,$_SESSION['email']);
	$nc   = $user['nickname']."&nbsp;积分:".$user['jifen'];
}else{
	$nc=NULL;
}
$city        = get_city($db,$bulid);
$area        = get_area($db,$bulid);	
$shopcount   = getshopcounts($db,$bulid);
$dinnercount = getdinnercounts($db,$bulid);

$smarty->assign("city",$city);
$smarty->assign("dinnercount",$dinnercount);
$smarty->assign("shopcount",$shopcount);
$smarty->assign("build",$area['b']);

$smarty->assign('mark',$mark);
$smarty->assign('nc',$nc);
$smarty->assign('tag',$tag);
$smarty->display("header.tpl");
?>
