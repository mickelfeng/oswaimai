<div id="content">
<!--透明层-->
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
<li><a href="?stype={$stype[$fid][srow].id}">{$stype[$fid][srow].dintype}</a></li>
{/section}
</ul>
{/section}
</div>

<div id="rightbar">

<div style="float:left; width:100%;min-height:300px;">
{section name=prow loop=$products}
<div style="float:left; height:190px;width:140px; margin:0px 4px 10px 4px; border:1px dotted green">
<div style="height:140px; width:140px;margin:0px auto"><a href="./supershow.php?pid={$products[prow].dinid}">
<img src="{$products[prow].dinimage}" height=100% width=100% border=0/></a></div>
<p><a href="./supershow.php?pid={$products[prow].dinid}">{$products[prow].dinname}</a></p>
<p>￥{$products[prow].dinprice}</p>
</div>
{/section}
</div>

</div>

</div>