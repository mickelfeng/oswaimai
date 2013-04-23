<link href="css/showcart.css" rel="stylesheet" type="text/css" />
<div id="content">
{if $searchshops!=NULL}
<div style="width:590px; border:1px solid #e7e7e7; float:left;margin-bottom:10px">
{section name=shop loop=$searchshops}
 <div class="sharp color2" style="width:19%; margin-left:5px; margin-top:10px" onmouseover="this.style.background='#F30'" onmouseout="this.style.background='#FFF'">
    <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b> 
    <div class="contround">   
    <div style="float:left;">
    <a href="./showshop.php?shopid={$searchshops[shop].shopid}"><img src="{$searchshops[shop].shopimage}" class="ct_pic" style="border: 0px" /></a>
    </div>
    <!--餐厅第一行信息开始-->
    <div style="PADDING-TOP:0px;width:100%; text-align:center">
    <a href="./showshop.php?shopid={$searchshops[shop].shopid}">{$searchshops[shop].shopname}</a>
    </div>
    <div>
    <!--电话餐厅标识开始-->
    <div style="padding:0px; margin:0px;width:100%; text-align:center; color:#999">
    <!--<LI class=ct_send>联系电话:</LI>-->          
    <!--餐店1为体验店铺-->
    {if $searchshops[shop].shopid eq 1}体验店铺{elseif  $now-$searchshops[shop].linktime<=60}<font size="2" color="#FF9900">支持在线订餐</font>
    {elseif $searchshops[shop].online eq 1}电话订餐{elseif $now-$searchshops[shop].linktime>60}店铺离线{elseif $searchshops[shop].online eq 0}打烊休息中{/if}
    </div>
    <!--电话餐厅标识结束-->
   
    </div>
    </div>
    <b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>
    </div>
{/section}
</div>
{/if}
<div style="width:590px; border:1px solid #e7e7e7; float:left;">
{section name=tag loop=$dinners}
<form method="post" action="" class="jcart" style="margin:0px;padding:0px">
<table width="100%" border="0" cellpadding="3">
<input type="hidden" name="my-item-shop"  value="{$dinners[tag].shopid}" />
<input type="hidden" name="my-item-id"    value="{$dinners[tag].dinid}" />
<input type="hidden" name="my-item-name"  value="{$dinners[tag].dinname}" />
<input type="hidden" name="my-item-price" value="{$dinners[tag].dinprice}" />
<input type="hidden" name="my-item-qty"   value="1" size="3" />
{assign var=s value=$dinners[tag].shopid}
{if $s!=$t}
<tr><td colspan="4"><font size="3"><b>
<a href="./showshop.php?shopid={$shops[$s].shopid}">{$shops[$s].shopname}</a></b></font></td>
<td colspan="1">
{if $shops[$s].shopid eq 1}体验店铺{elseif  $now-$shops[$s].linktime<=60}<font size="2" color="#FF9900">支持在线订餐</font>
{elseif $shops[$s].online eq 1}电话订餐{elseif $now-$shops[$s].linktime>60}店铺离线{elseif $shops[$s].online eq 0}打烊休息中{/if}
</td>
</tr>
{/if}
{assign var=t value=$s}
<tr>
<td width="20%" align="center">{$dinners[tag].dinname|replace:"$search":"<font color=red>$search</font>"}</td>
<td width="20%" align="center">{$dinners[tag].dinprice}</td>
<td width="20%" align="center"><input type='submit' name='my-add-button' value="来一份" class="button" /></td>
<td width="20%" align="center">
{if $dinners[tag].popnum==0}
{assign var="gif" value="no-repeat -211px -360px"}
{elseif $dinners[tag].popnum>0 and $dinners[tag].popnum<=20}
{assign var="gif" value="no-repeat -211px -344px"}
{elseif $dinners[tag].popnum>20 and $dinners[tag].popnum<=40}
{assign var="gif" value="no-repeat -211px -328px"}
{elseif $dinners[tag].popnum>40 and $dinners[tag].popnum<=60}
{assign var="gif" value="no-repeat -211px -312px"}
{elseif $dinners[tag].popnum>60 and $dinners[tag].popnum<=80}
{assign var="gif" value="no-repeat -211px -296px"}
{else}
{assign var="gif" value="no-repeat -211px -280px"}
{/if}

<span  title="人气指数:{$dinners[tag].popnum}" style=" background: url(./images/p.gif) {$gif};FLOAT:left;WIDTH: 50px; HEIGHT: 15px; margin-top:5px;"></span>

</td>
<td width="20%" align="center">
<span  title="有点滋味" style=" background: url(./images/p.gif) -271px -279px;FLOAT: left;WIDTH: 50px; HEIGHT: 15px; margin-top:5px;"></span>
</td>
</tr>
</table>
</form>
{/section}
</div>
</div>