<?php
if($_SERVER['REMOTE_ADDR']=="127.0.0.1"){
$mydbuser		="root";	        //数据库用户
$mydbpw			="";	        //数据库密码
$mydbname		="yiwaimai";		//数据库
}else{
$mydbuser		="s525071db0";	        //数据库用户
$mydbpw			="8t68u79z";	        //数据库密码
$mydbname		="s525071db0";		//数据库
}
$mydbhost		="localhost";//配置主机
$mydbcharset	="gb2312";
//================

$smarty_template_dir	='./templates/';
$smarty_compile_dir	    ='./templates_c/';
$smarty_config_dir	    ='./configs/';
$smarty_cache_dir	    ='./cache/';
$smarty_delimiter	    =explode("|","{|}");
$smarty_caching         = false;
$smarty_cache_lifetime  =60;   
//smtp email配置参数开始
$smtpserver = "smtp.126.com";
$smtpserverport =25;
$smtpusermail = "qianfunian@126.com";
$smtpuser = "qianfunian";
$smtppass = "7780790";
$mailsubject = "网络订单";
$mailtype = "HTML";
//smtp email配置参数结束

//及时短信配置参数开始  
$uid = '113527';		
$pwd = 'qfn000';		
//及时短信配置参数结束
error_reporting(E_ALL & ~E_NOTICE);
ini_set('date.timezone','PRC');
?>