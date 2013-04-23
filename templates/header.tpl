<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <meta name="author" content="QIANFUNIAN" />
    <meta name="keywords" content="我饿啦外卖|江南大学外卖|网络订餐|在线网络订餐|无锡外卖" />
    <meta name="description" content="我饿啦网络订餐是最好的无锡快餐网，专业提供无锡网上订餐服务；点无锡快餐，无锡外卖就来我饿啦!" />
    <title>{$shopname}我饿啦外卖|我饿啦|无锡外卖-{$build}</title>
    <link href="css/layout.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="./jcart/jcart.css" rel="stylesheet" type="text/css" />
    <script src="./jcart/jquery-1.5.1.js" type="text/javascript"></script>
    <script src="./javascript/jcart.load.js" type="text/javascript"></script>
    <script src="./javascript/common.js" type="text/javascript"></script>	
    <script type="text/javascript" src="http://static.connect.renren.com/js/v1.0/FeatureLoader.jsp"></script>
</head>
<body>
<div id="loginbox" style="z-index:10px;height:130px; width:250px; border:5px solid #F90; background-color:white;display:none">
<div style="float:left; width:100%; margin-top:10px">
<form action="./login.php" method="post">
<table width="100%">
<tr><td align="right">用户名称:</td><td align="left"><input type="text" name="username" id="username" style="width:140px"/></td></tr>
<tr><td align="right">登陆密码:</td><td align="left"><input type="password" name="password" id="password" style="width:140px" /></td></tr>
<tr><td align="right"></td><td align="left"><input type="checkbox" name="remeber" value="1"/>记住登陆状态？</td></tr>
<tr><td></td><td><input type="submit" value="登陆" />&nbsp;&nbsp;<input type="button" value="关闭" onclick="hidebox('loginbox')" /></td></tr>
</table>
</form>
</div>
</div>
{literal}
<SCRIPT LANGUAGE="JavaScript">
<!-- Hide
function killErrors() {
return true;
}
window.onerror = killErrors;
function logout()
{
    XN_RequireFeatures(["Connect"], function(){
    XN.Main.init("fa0dc1c1d2624a9585910fc454a8c809","/xd_receiver.html");
    XN.Connect.get_status().waitUntilReady(function (login_state) {
      if (login_state == XN.ConnectState.connected){XN.Connect.logout(function () {window.location.href='loginout.php';});}
      else{window.location.href='loginout.php';}
       });
       });

}
function showtelephone()
{
    $(".outline").show();
	$.ajax({type: "POST",dataType : "text",async : false,url: "checkdata/ordertelephone.php",success: function(res){},error : function(res,msg,err) {}});
}
-->
</SCRIPT>
<script type="text/javascript">
  	function sendFeed(){
  		feedSettings = {
  			"template_bundle_id": 3,
  			"template_data": {"images":[{"src":"http://fmn028.xnimg.cn/fmn028/pic001/20090330/20/25/head_isr3_91558j206097.jpg", "href":"http://www.welwm.com/index.php"}, {"src": "http://fmn026.xnimg.cn/fmn026/pic001/20090330/20/25/head_Zbrj_91370b206097.jpg", "href":"http://www.welwm.com/index.php"}],"feedtype":"我饿啦网络订餐","content":"<a href='http://www.welwm.com/index.php'>我饿啦</a>","action":"click","xnuid":"12345"},
  			"body_general": "",
  			"callback": function(ok){},
  			"user_message_prompt": "写下你的想法",
  			"user_message": ""
  		};
  		XN.Connect.showFeedDialog(feedSettings);
  	}
</script>
{/literal}

<div class="top">
 <div style="margin:0 auto; width:960px; height:100%">
 <div style="float:left; margin-top:3px">
 <span style="float:left">
 {if $nc!=NULL}
 您好，欢迎光临我饿啦！{$nc} | <a href="javascript:logout()">退出</a></span>
 {else}
 您好，欢迎光临我饿啦！<a href="javascript:showloginbox()">登陆</a> | <a href="./register.php">注册</a></span>
 
 <span style="margin-top:2px; float:left; margin-left:10px">
 {if $mark}
 <img src="./images/ico_renren.gif" style="border:0px"><a id="feed_link" href="javascript:void(0);">去告诉我的人人网好友</a>
 {else}
 <xn:login-button size="medium" autologoutlink="true" onlogin="javascript:window.location.href='renrencookie.php';"></xn:login-button>
 {/if}
 </span>
 
 {/if}
 </div>
 <div style="float:right; margin-top:3px">
 <img src="images/header/cart.png" align="absmiddle"/>
 <a href="checkout.php">美食篮子</a> | <a href="ordercenter.php">个人中心</a> | <a href="./kaidian.php">我要开店</a> | 
 <a href="http://page.renren.com/699112088?checked=true" target="_new">我饿啦人人应用主页</a></div>
 </div>
</div>

<!--header层开始-->
 <div class="head"> 
     <div style="margin:0 auto; width:960px">   
	 <div style="float:left; margin:3px">
	 <a href="index.php">
	 <img src="images/header/logo.png" border="0" style="padding:1px 10px"/>
	 </a>
	 </div> 
	 <div style="float:left; margin-left:0px; margin-top:0px;width:370px;">
		 <div style="float:left;margin-top:0px; width:200px; height:25px; margin-left:20px; margin-top:20px">
		 <font size="4" style="font-weight:bold;">{$city}</font>
		 </div>
		 <div style="float:left; margin-left:20px; margin-top:0px; width:100%">
		 <font color="#FF3300" size="4" style="font-weight:bold">{$build}</font>
		 <a onclick="return delCookie('bid')" href="index.php"><font color="#999933">切换位置</font></a>&nbsp;&nbsp;&nbsp;共<font color="#FF0000"><b>{$shopcount}</b></font>家餐店，<font color="#FF0000"><b>{$dinnercount}</b></font>种餐品
		 </div>
	 </div>
     <ul style="margin:10px 0px 0px 0px;float:right">
     <li style="float:left;margin-left:10px">
     <table border="0" cellpadding="2px">
     <tr style="font-weight:bold"><td>18762625775</td></tr>
     <tr style="font-weight:bold"><td><a href="http://wpa.qq.com/msgrd?v=3&uin=312181918&site=qq&menu=yes" target="_blank">
     <img border="0" title="call me" alt="点击这里给我发消息" src="http://wpa.qq.com/pa?p=2:312181918:50"></a></td></tr>

     </table>
     </li>
     </ul> 
     </div>
 </div>    
<!--header层结束-->
<div style="width:100%; height:45px; float:left; background-image:url(./images/threebg.png); margin:0px; padding:0px; ">
	<div id="headmenu">
    <ul>
		<li style="float:left"><span><a href="./index.php">首页</a></span></li>
		<li style="float:left"><span><a href="./promotion.php">优惠资讯</a></span></li>
		<li style="float:left"><span><a href="./gift.php">礼品园地</a></span></li>
		<li style="float:left"><span><a href="./bbs.php">反馈留言</a></span></li>
	</ul>
    <div style="float:left; margin-left:0px; margin-top:8px">
    <form action="searchdinners.php" method="post" name="myform" style="padding:0px; margin:0px">
    <table width="220" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="14"><img src="images/ss1.png" width="14" height="29" /></td>
        <td background="images/ss2.png">
        <input type="text" name="txtSuggestEntity" style="width:165px; height:18px;border:#ffffff solid 1px; margin-top:3px" value="搜索餐品 或 餐店" onclick="value='';focus()"/>

        </td>
        <td width="22"><input type="submit" value="" style="background-image:url(./images/ss3.png); border:0px; height:29px; width:22px"/></td>
      </tr>
    </table>
    </form>
    </div>
   
    </div>
</div>

<div class="container">