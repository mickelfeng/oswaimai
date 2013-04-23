<div id="content">
<div id="evl" style="z-index:30;height:200px; width:350px; border:5px solid #F90; background-color:white;display:none">

</div>
{if $tag!=1}
<div style="border:1px #dee5fa solid; float:right; width:958px; margin-top:5px">欢迎您，您最近一天的订单会显示在订单中心。您还不是我饿啦的注册会员，<a href="register.php"><font color="#3399FF">现在就注册成为我饿啦会员。 </font></a></div>
{else}
<div style="float:left; height:300px; width:150px; border:1px solid #e7e7e7; margin-top:10px">
<table width="100%" border="0" style="text-align:center" cellpadding="5px">
<tr><td><a href="./ordercenter.php">我的订单</a></td></tr>
<tr><td><a href="./mycollection.php">我的收藏</a></td></tr>
<tr><td><a href="./editpwd.php">修改密码</a></td></tr>
<tr><td><a href="./editemail.php">修改邮箱</a></td></tr>
</table>
</div>
<div style="float:right; width:800px; border:1px solid #e7e7e7; margin-top:10px; min-height:300px">
<table width="100%" style="float:left" border="0">
<tr style="color:#00F; font-weight:bold; text-align:center">
<td width="8%">订单号</td><td width="15%">餐店</td><td width="13%">总价</td><td width="25%">配送地址</td><td width="20%">下单时间</td>
<td width="10%">状态</td><td width="9%">评价</td>
</tr>
{section name=tag loop=$orders}

{assign var=id value=$orders[tag].orderid}
<tr style="text-align:center">
<td style="border:1px solid green">{$orders[tag].orderid}</td>
<td style="border:1px solid green"><a href="./showshop_{$orders[tag].shopid}.html">{$shopnames[$id]}</a></td>
<td style="border:1px solid green">{$orders[tag].total_price}元</td>
<td style="border:1px solid green">{if $orders[tag].address!=NULL}{$orders[tag].address}{else}电话预订{/if}</td>
<td style="border:1px solid green">{$orders[tag].orderdate}</td>
<td style="border:1px solid green"><font color="red">
{if $orders[tag].state==0}未接受
{elseif $orders[tag].state==1}已接受
{elseif $orders[tag].state==2}电话预定
{elseif $orders[tag].state==3}成交
{elseif $orders[tag].state==4}失败
{elseif $orders[tag].state==5}打印未成交
{elseif $orders[tag].state==6}已评
{/if}</font></td>
<td style="border:1px solid green"><span id="pjs{$orders[tag].orderid}">
{if $orders[tag].state!=3&&$orders[tag].state!=6}暂无
{elseif $orders[tag].state==6}
已评
{else}
<a href="javascript:show_evl(1,'{$orders[tag].orderid}',0,'{$shopnames[$id]}','{$orders[tag].shopid}')">评价</a>
{/if}
</span></td>
</tr>
{section name=item loop=$orderitems[$id]}
<tr style=" text-align:center">
<td colspan="2" align="right">{$orderitems[$id][item].dinname}</td>
<td>单价:￥{$orderitems[$id][item].unitprice}</td>
<td>数量:{$orderitems[$id][item].dinnum}</td>
<td>总价:￥{$orderitems[$id][item].dinprice}</td>
<td></td>
<td>
<span id="pjs{$orders[tag].orderid}{$orderitems[$id][item].dinid}">
{if $orders[tag].state!=3&&$orderitems[$id][item].state!=1&&$orders[tag].state!=6}暂无
{elseif $orderitems[$id][item].state==1}
已评
{else}
<a href="javascript:show_evl(1,'{$orders[tag].orderid}','{$orderitems[$id][item].dinid}','{$shopnames[$id]}','{$orders[tag].shopid}','{$orderitems[$id][item].dinname}')">评价</a>
{/if}
</span></td>
</tr>
{/section}

{/section}
</table>
</div>
{/if}
{literal}
<script type="text/javascript">
function show_evl(tag,oid,did,shopname,shopid,dinname)
{
	if(tag==1)
	{
		if(did==0){
		$('#evl').html("<div style='float:left; width:100%; text-align:right'><span style='float:left'>餐店评价</span><span style='float:right'><a href='javascript:show_evl(0)'>关闭</a></span></div><div style='float:left;width:100%;border-top:1px solid #e7e7e7'><table width='100%' border='0'><tr><td colspan='2'>"+shopname+"   订单号："+oid+"</td></tr><tr><td>商铺评价：</td><td><input type='radio' name='pingjia' value='1'/>很差<input type='radio' name='pingjia' value='2' />差<input type='radio' name='pingjia' value='3' />一般<input type='radio' name='pingjia' value='4' />好<input type='radio' name='pingjia' value='5' checked='true' />很好</td></tr><tr><td>配送速度：</td><td>&nbsp;大约<select id='speed'><option value='15'>15</option><option value='30'>30</option><option value='45' selected>45</option><option value='60'>60</option><option value='75'>75</option><option value='90'>90</option><option value='115'>115</option><option value='120'>120</option></select>分钟送到</td></tr><tr><td valign='top'>写写点评：</td><td>&nbsp;<textarea style='width:200px; height:50px' id='pj_content'></textarea></td></tr><tr><td></td><td>&nbsp;<input type='button' value='发布评价' onclick='post_pj("+oid+","+did+","+shopid+")'/></td></tr></table></div>");
		}else
		{
			$('#evl').html("<div style='float:left; width:100%; text-align:right'><span style='float:left'>餐品评价</span><span style='float:right'><a href='javascript:show_evl(0)'>关闭</a></span></div><div style='float:left;width:100%;border-top:1px solid #e7e7e7'><table width='100%' border='0'><tr><td colspan='2'>"+shopname+"</td></tr><tr><td>餐品名称：</td><td>&nbsp;"+dinname+"</td></tr><tr><td>餐品评价：</td><td><input type='radio' name='pingjia' value='1'/>很差<input type='radio' name='pingjia' value='2' />差<input type='radio' name='pingjia' value='3' />一般<input type='radio' name='pingjia' value='4' />好<input type='radio' name='pingjia' value='5' checked />很好</td></tr><tr><td valign='top'>写写点评：</td><td>&nbsp;<textarea style='width:200px; height:50px' id='pj_content'></textarea></td></tr><tr><td></td><td>&nbsp;<input type='button' value='发布评价' onclick='post_pj("+oid+","+did+","+shopid+")'/></td></tr></table></div>");
		}

		$('#evl').show();
		welwm.centerLayer("evl");
	}else if(tag==0)
	{
		$('#evl').hide();
	}
}
function post_pj(oid,did,shopid)
{
	//did为0是订单评价否则为餐品评价
	var pinjia = $("input[type=radio][checked]").val();
	var speed   = $('#speed').val();
	var pj_content = $('#pj_content').val();
	$.ajax({type: "POST",dataType : "text",async : false,url: "./checkdata/post_grade.php",
			data: {"oid" : oid,'did':did,'shopid':shopid,'pinjia':pinjia,'speed':speed,'pj_content':pj_content},
			success: function(res){if(res){$('#evl').hide();if(did==0){$('#pjs'+oid).html('已评')}else{$('#pjs'+oid+did).html('已评')}}},
			error : function(res,msg,err) {alert(msg);}
	});
	
}
</script>
{/literal}
</div>