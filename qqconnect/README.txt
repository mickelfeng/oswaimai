====================PHP SDK使用说明====================
开发者只需要按照下面的说明修改几行代码，就可以在网站上实现“QQ登录”功能。
1. 完成【QQ登录】准备工作(http://wiki.opensns.qq.com/wiki/%E3%80%90QQ%E7%99%BB%E5%BD%95%E3%80%91%E5%87%86%E5%A4%87%E5%B7%A5%E4%BD%9C)中的第1-2步。

2. 使用前先修改 comm/config.php 中的三个变量
	$_SESSION["appid"];
	$_SESSION["appkey"];
	$_SESSION["callback"];  

3. 在页面添加QQ登陆按钮
	<a href="#" onclick='toQzoneLogin()'><img src="img/qq_login.png"></a>

4. 页面需要的js代码
	<script>
		function toQzoneLogin()
		{
			var A=window.open("oauth/redirect_to_login.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizab
			le=1,status=1,titlebar=0,toolbar=0,location=1");
		} 
	</script>

5. SDK中使用session来保存必要的信息。为避免网站存在多个子域名或同一个主域名不同服务器造成的session无法共享问题，请开发者按照本SDK中comm/session.php中的注释对session.php进行必要的修改，以解决这2个问题。


====================当前版本信息====================
当前版本：beta_V1.5

发布日期：2011-09-02

文件大小：26.3 K 


====================修改历史====================
V1.5  在utils中增加了统一的URL编解码函数QQConnect_urlencode,QQConnect_urldecode;对于错误返回码增加了错误提示。
V1.4  增加了add_share接口的示例代码，去掉了不再支持的接口add_feeds的示例代码
V1.3  支持子域名共享session，支持跨服务器共享session
V1.2  增加了日志接口的SDK，代码注释规范化
V1.1  修复php低版本不支持hash_hmac函数的问题。
V1.0  beta版第一版发布。



====================文件结构信息====================
comm文件夹：
	config.php:配置文件，配置代码包中的宏参数
	util.php:  包含了OAuth认证过程中会用到的公用方法
        session.php: 支持子域名共享session，支持跨服务器共享session。

oauth文件夹：
	get_request_token.php: 获取临时token
	redirect_to_login.php：响应登录按钮事件，引导用户跳转到QQ登录授权页
	get_access_token：获取具有Qzone访问权限的access_token，存储获取到的信息，处理第三方帐户与openid的绑定逻辑

user文件夹：
	get_user_info.php：获取用户信息

share文件夹：
        add_share.php：将一条动态（feeds）同步到QQ空间中，展现给好友
        

photo文件夹：
	add_album.php： 获取登录用户的相册列表
	list_album.php：登录用户创建相册
	upload_pic.php：登录用户上传照片

blog文件夹：        
	add_blog.php：登录用户发表一篇新日志

img文件夹：
	QQ登录图标，程序中将引用这个图片作为按钮图标



====================联系我们====================
QQ登录官网：http://connect.opensns.qq.com/
开发者在使用过程中有任何意见和建议，请发邮件至connect@qq.com 进行反馈。
此外，你也可以通过企业QQ（号码：800030681。直接在QQ的“查找联系人”中输入号码即可开始对话）咨询。

