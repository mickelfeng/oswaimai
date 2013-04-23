<?php
@session_start();
include "../global.php";
if (empty($_SESSION['uname'])){
	header("location:login.php");exit();
}
$unex     = explode('|',$_SESSION['uname']);
$sid      = $unex[0];
$shopinfo = get_shop_details($db,$sid);
$shoptype = $shopinfo['shoptype'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
<link rel="stylesheet" href="./css/main.css" type="text/css" />
</head>
<body>
<table cellpadding="10px">
<tr><td><font style="color:#FF6600; font-weight:bold";><?php echo get_shopname($db,$sid);?></font></td></tr>
<tr><td>欢迎您，<?php echo $unex[1];?>&nbsp;<A href="loginout.php" target=_parent>退出</A></td></tr>
<tr><td><font style="color:#FF6600; font-weight:bold";>订单管理</font></td></tr> 
<tr><td><a href="list.php" target=mainFrame>订单查询</a></td></tr>
<?php if($sid==0){?>
<tr><td><a href="member.php" target=mainFrame>会员管理</a></td></tr>
<tr><td><a href="dinmanage.php" target=mainFrame>餐品管理</a></td></tr>
<tr><td><a href="area.php" target=mainFrame>区域管理</a></td></tr>
<tr><td><a href="shops.php" target=mainFrame>餐店管理</a></td></tr>
<!--<tr><td><a href="dintype.php" target=mainFrame>餐店类别</a></td></tr>-->
<tr><td><a href="addshop.php" target=mainFrame>餐店添加</a></td></tr>
<tr><td><a href="printer.php" target=mainFrame>打印机管理</a></td></tr>
<tr><td><font style="color:#FF6600; font-weight:bold";>个人资料</font></td></tr>
<?php }elseif($sid!=0){?>
<tr><td><A href="shopinfo.php" target=mainFrame>基本信息</A></td></tr>
<tr><td><A href="yhinfo.php" target=mainFrame>优惠信息</A></td></tr>
<tr><td><A href="range.php" target=mainFrame>送餐范围</A></td></tr>
<?php }?>
<tr><td><a href="modifypwd.php" target="mainFrame">修改密码</a></td></tr>
<?php if($shoptype==1){?>
<tr><td><font style="color:#FF6600; font-weight:bold";>餐品管理</font></td></tr>
<tr><td><a href="addCategory.php" target="mainFrame">餐品类别</a></td></tr>
<tr><td><a href="adddin.php" target="mainFrame">餐品添加</td></tr>
<tr><td><a href="dinnerShow.php" target="mainFrame">餐品浏览</a></td></tr>
<?php }elseif($shoptype==2){?>
<tr><td><font style="color:#FF6600; font-weight:bold";>商品管理</font></td></tr>
<tr><td><a href="addCategory.php" target="mainFrame">商品类别</a></td></tr>
<tr><td><a href="adddin.php" target="mainFrame">商品添加</td></tr>
<tr><td><a href="dinnerShow.php" target="mainFrame">商品浏览</a></td></tr>
<?php }?>
</body>
</html>