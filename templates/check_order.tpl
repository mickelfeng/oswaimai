<div id="content">
{section name=tag loop=$order}
{if $smarty.section.tag.first}
<table width="100%" style="float:left">
<tr>
<td width="25%">餐店名称：{$shopname}</td>
<td width="20%">订单编号：{$order[tag].orderid}</td>
<td width="20%">订单总价：{$order[tag].total_price}元</td>
<td width="35%">配送地址：{$order[tag].address}</td>
</tr>
<tr>
<td>下单时间：{$order[tag].orderdate}</td>
<td>送餐时间：{$order[tag].sctime}</td>
<td>订单状态：<font color="red">{if $order[tag].state==0}未接受{elseif $order[tag].state==1}已接受{/if}</font></td>
<td><font color="red">联系电话</font>：{$order[tag].telphone}</font></td></tr>
</tr>
<tr>
<td colspan="4">
其他嘱咐：{$order[tag].beizhu}
</td>
</tr>
</table>
<hr style="width:100%; float:left"/>
<table border="0" width="100%" cellpadding="5" style="float:left">
<tr>
<td>
餐品名称
</td>
<td>
餐品类型
</td>
<td>
餐品数量
</td>
<td>
餐品总价
</td>
<td>
餐品单价
</td>
</tr>

{/if}
<tr>
<td>
{$order[tag].dinname}
</td>
<td>
{$order[tag].dintype}
</td>
<td>
{$order[tag].dinnum}
</td>
<td>
{$order[tag].dinprice}
</td>
<td>
{$order[tag].unitprice}
</td>
</tr>
{/section}
</table>
</div>