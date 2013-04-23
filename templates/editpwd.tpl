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
<form action="" method="post" id="editpwdForm">
<table>
<tr><td>原密码:</td><td><input type="password" name="oldpwd" style="width:140px"/></td></tr>
<tr><td>新密码:</td><td><input type="password" name="newpwd" style="width:140px" id="newpwd" /></td></tr>
<tr><td>确认密码:</td><td><input type="password" name="rpwd" style="width:140px" /></td></tr>
<tr><td></td><td><input type="submit" value="确认修改" /></td></tr>
</table>
</form>
</div>
</div>