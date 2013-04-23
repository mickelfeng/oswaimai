{literal}
<style type="text/css">
#sidebar {float:left; width:600px}
</style>
{/literal}

<div style="min-height:100px; width:350px; float:right">
</div>
<script src="javascript/checkout.js" type="text/javascript"></script>
<form  name="mycheck"action="purchase.php" method="post" onsubmit="return isOK();" style="float:left">
<table border="0" width="600px" cellspacing="0">  
<tr><td colspan="4" align="left" bgcolor="#DEEAF8">
<font color="red">温馨提醒：请准确填写详细信息，不在当前位置请慎重下单！</font>
只想测试下--<a href="./showshop.php?shopid=1" style="color:#CC3300">点击这里去我饿啦体验店</a>
</td></tr>

<tr height="40px">
<td><font color="red">详细地址：</font></td>
<td><input type="text" name="address" value="{$scadd[0]}" maxlength="40" size="40"/></td> 
</tr>

<tr height="40px">
<td><font color="red">手机号码：</font></td>
<td><input type="text" name="telphone" value="{$scadd[1]}" maxlength="11" size="40" onblur="return isPhone()"/></td>
</tr>

<tr height="40px">
<td>备用电话：</td>
<td><input type="text" name="otherphone" value="" maxlength="11" size="40" /></td>
</tr>

<tr>
<td colspan="4"><hr /></td>
</tr>
    
<tr>
<td>送餐时间：</td>
<td>
    <select name="deliver_time" id="deliver_time">	  
    <option value="尽快送出">尽快送出</option>	 
    {section name=tag loop=$sctime}
    <option value="{$sctime[tag]}">{$sctime[tag]}</option>		  
    {/section}
    </select>  
</td>
</tr>

<tr height="50px">
<td>我要吩咐：</td>
<td><br />
	  <input  type="button" value="么零钱" onclick="document.getElementById('xinxi').value+=this.value+' '"  /> 
	  <input  type="button" value="不要葱姜蒜" onclick="document.getElementById('xinxi').value+=this.value+' '"  /> 
	  <input  type="button" value="不吃辣" onclick="document.getElementById('xinxi').value+=this.value+' '"  />
	  <input  type="button" value="辣一点" onclick="document.getElementById('xinxi').value+=this.value+' '"  /> 
	  <input  type="button" value="多加米" onclick="document.getElementById('xinxi').value+=this.value+' '"  /><br />
	  <input  type="button" value="给力" onclick="document.getElementById('xinxi').value+=this.value+' '"  /> 
	  <input  type="button" value="囧" onclick="document.getElementById('xinxi').value+=this.value+' '"  /> 
	  <input  type="button" value="thank you" onclick="document.getElementById('xinxi').value+=this.value+' '"  /><br />
	  <textarea id="xinxi" name="bzxx" rows="3" cols="50"></textarea>
</td>
</tr>
   
<tr>
<td colspan="4" align="left" bgcolor="#DEEAF8"><font color="red">请点击确认按钮提交您的订单，谢谢!</font>
</td>
</tr>
<tr align="center">
<td colspan="4">
<input type='submit' id='jcart-paypal-checkout' name='jcart_paypal_checkout' value='确认订餐'  style='display:block; padding:10px; margin:20px auto;'/>
</td>
</tr>

</table>
</form>
</div>
