<?php
header('Content-Type:text/html;charset=gb2312');
session_start();
if(isset($_SESSION['email']))
{
	header("Location:./index.php");exit;
}
include_once('./global.php');
require_once ('email.class.php');

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$nickname = ereg_replace('[[:space:]]','',$_POST['username']);
	$password = strtolower($_POST['pwd']);
	$password = ereg_replace('[[:space:]]','',$password);
	
	if(!preg_match("/^[0-9a-zA-Z]+$/",$password) || strlen($password)<6)
	{
		header("Location:./register.php?erroe=pass");
		exit;
	}
	if(!preg_match("#^[a-z0-9&\-_\.\+]+?@[\w\-]+\.([\w\-\.]+\.)?[\w]+$#i",$_POST['email']))
	{
		header("Location:./register.php?erroe=email");
		exit;
	}
	$randomstring='';
	for ($i = 0; $i < 10; $i++)
	{
		$randomstring .= chr(mt_rand(97, 122)); //Range of ASCII characters
	}
	$verifystring = $randomstring;
	
	$query = "insert into wm_admin_c  values('','$_POST[email]','".md5($password.'welwm')."','$nickname','$verifystring','0','200',now())";
	
	if($db->query($query))
	{
		$verifyurl = "http://".$_SERVER['HTTP_HOST']."/jihuo.php";
		$_SESSION['email'] = $_POST['email'];
		$smtpemailto = $_POST['email'];
		$mailsubject = "请激活您的吃玩网账户";
		$mailbody = "<h3>请妥善保管您的用户名和密码，谢谢！<br>您的用户名为：".$nickname."<br>您的密码为：".$password;
		$mailbody=<<<_MAIL_
<strong>亲爱的会员: $nickname 您好！</strong>
<p><br/>您已申请开通吃完网账户名（$nickname),请立即激活。</p>
<strong><a href=$verifyurl?email=$smtpemailto&verify=$verifystring>点此立即激活</a></strong>
<p><br/><small>如果上述文字点击无效，请把下面网页地址复制到浏览器地址栏中打开：</small></p>
$verifyurl?email=$smtpemailto&verify=$verifystring
_MAIL_;
		$smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
		$smtp->debug = FALSE;
		$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);
		header("Location:./index.php");
	}
}else
{
	include "./header.php";
	$smarty->display('register.tpl');
	include "./footer.php";
}
?>