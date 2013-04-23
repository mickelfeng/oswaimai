<div id="content">
{$shopcart}
<link href="./css/supermarket.css" rel="stylesheet" type="text/css" />
<div id="leftside">
<!--<div class="sidelist">
    <span><h3><a href="##">巧克力</a></h3></span>
    <div class="i-list">
        <ul>
        <li><a href="##">桶装</a></li>
        </ul>
    </div>
</div>-->
<ul>
{section name=frow loop=$ftype}
<p><font size=3 color="green"><b>{$ftype[frow].dintype}</b></font></p>
{assign var='fid' value=$ftype[frow].id}
<ul style="width:100%">
{section name=srow loop=$stype[$fid]}
<li><a href="./supermarket.php?stype={$stype[$fid][srow].id}">{$stype[$fid][srow].dintype}</a></li>
{/section}
</ul>
{/section}
</div>

<div id="rightbar">

<div style="float:left; width:100%;min-height:300px;border:1px dotted green">
<div style="float:left; height:200px; width:200px;margin:20px">
<img src="{$pinfo.dinimage}" height=100% width=100% border=0/>
</div>

<ul style="float:left; height:200px; width:450px;margin-top:20px">
<form method="post" action="" class="jcart" style="margin:0px;padding:0px">
<input type="hidden" name="my-item-shop" value="{$pinfo.shopid}" />
<input type="hidden" name="my-item-id" value="{$pinfo.dinid}" />
<input type="hidden" name="my-item-name" value="{$pinfo.dinname}" />
<input type="hidden" name="my-item-price" value="{$pinfo.dinprice}" />
<li><font size=4><b>{$pinfo.dinname}</b></font></li>
<li style="margin:5px 0px"><font size=4 style="color:#F30"><b>￥{$pinfo.dinprice}</b></font></li>
<li style="margin:5px 0px">数量：<input type="text" name="my-item-qty" value="1" size="3" /></li>
<li><input type='submit' name='my-add-button' value="添加到购物车"/></li>
</form>
</ul>

<div style="float:left; width:733px; min-height:200px; border-top:1px dotted #CCC; padding-left:20px">
<B>商品简介</b>
<p>{$pinfo.beizhu}</p>
</div>
</div>

</div>

</div>