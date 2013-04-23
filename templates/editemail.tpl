<script type="text/javascript" src="./javascript/jquery.validate.js"></script>
<script type="text/javascript" src="./javascript/register.js"></script>
<div id="content">
<div style="float:left; height:300px; width:150px; border:1px solid #e7e7e7; margin-top:10px">
<table width="100%" border="0" style="text-align:center" cellpadding="5px">
<tr>
<td><a href="./ordercenter.php">我的订单</a></td>
</tr>
<tr><td><a href="./mycollection.php">我的收藏</a></td></tr>
<tr>
<td><a href="./editpwd.php">修改密码</a></td>
</tr>
<tr>
<td><a href="./editemail.php">修改邮箱</a></td>
</tr>
</table>
</div>
<div style="float:right; width:800px; border:1px solid #e7e7e7; margin-top:10px; min-height:300px">
<font color="red">{$tag}</font>
<form action="" method="post" id="editemailForm">
您当前的登录邮箱：<br/>
{$email}<br/><br>

您的登录密码：<br>
<input type="password" name="password" id="password" /><span></span><br><br>

您想设置的新登录邮箱<br />
<input type="email" name="newemail" id="newemail"/><span></span><br><br>
<input type="submit" value="确定" /></form>

</div>
</div>