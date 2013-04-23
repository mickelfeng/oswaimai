<div id="content">
<div style="width:958px; border-left:1px solid #FEE7CC; border-bottom:1px solid #FEE7CC; border-right:1px solid #FEE7CC; "><MARQUEE scrollAmount=1 behavior=alternate><font color="#E78C9D">我饿啦提醒您：订餐无须注册会员，注册会员享受更多实惠，尽快获得餐品，敬请提前订餐！</font></MARQUEE></div>
<div style="float:left; width:100%;border-bottom:1px solid #c3dd48">
<form action="./check_order.php" method="post">
<span style="float:left">当前位置:{$district} > {$build}</span>
<span style="float:right">
<input type="text" name="orderid" id="orderid" onblur="if(this.value=='')this.value='请输入订单号';" 
onfocus="if(this.value=='请输入订单号')this.value='';" value="请输入订单号"/> <input type="submit" value="查询"  />
</span>
</form>
</div>
<DIV style="float:left; width:958px; border:1px solid #FFF; height:145px; margin:5px 0px">
<div style="width:230px; float:left; height:100%; overflow:hidden;">
<div id="noticev2" style="white-space:nowrap;" onmouseover="javascript:isMove=false" onmouseout="javascript:isMove=true">
{section name=tag loop=$acinfo}
<span style="margin-left:10px;">
{if $acinfo[tag].nickname!=NULL}{$acinfo[tag].nickname}{else}食客{/if} 在 <a href="./showshop.php?shopid={$acinfo[tag].shopid}">{$acinfo[tag].shopname}</a> 消费 ￥{$acinfo[tag].total_price} 
</span>
<br>

{/section}
</div>

</div>
<div style="width:480px; float:left; height:100%;">
{literal}
<script type="text/javascript">
    <!--
    var focus_width=480
    var focus_height=145
    var text_height=0
    var swf_height = focus_height+text_height
    var pics='images/woela1.jpg|images/woela2.jpg|images/woela3.jpg|images/woela4.jpg'
    var links='./|||'
    var texts='人民|哈哈|吼吼|呵呵'
    document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'+ focus_width +'" height="'+ swf_height +'" align="center">');
    document.write('<param name="allowScriptAccess" value="sameDomain"><param name="movie" value="images/pixviewer.swf"><param name="quality" value="high"><param name="bgcolor" value="#EAEBEE">');
    document.write('<param name="menu" value="false"><param name=wmode value="opaque">');
    document.write('<param name="FlashVars" value="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'">');
    document.write('<embed src="images/pixviewer.swf" wmode="opaque" FlashVars="pics='+pics+'&links='+links+'&texts='+texts+'&borderwidth='+focus_width+'&borderheight='+focus_height+'&textheight='+text_height+'" menu="false" bgcolor="#FFFFFF" quality="high" width="'+ focus_width +'" height="'+ swf_height +'" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />');
    document.write('</object>');
 //-->
</script>
{/literal}
</div>

<div style="width:240px; float:left; height:100%; padding-left:5px">
{section name=tag loop=$promotions}
{if $smarty.section.tag.last}
<div style="float:left; width:100%; height:50%">
{else}
<div style="float:left; width:100%;border-bottom:1px solid #e7e7e7; height:50%">
{/if}
<table width="100%" height="100%" border="0">
<tr>
<td width="50%" style="padding-left:10px"><a href='showshop.php?shopid={$promotions[tag].shopid}'><font color='#0099cc' size="3"><b>{$promotions[tag].shopname}</b></font></a></td>
<td>截止:{$promotions[tag].yhdate}</span></td>
</tr>
<tr><td colspan="2" style="padding-left:10px">{$promotions[tag].yhcontent|truncate:32}</td></tr>
</table>
</div>
{/section}
</div>
</DIV>

<DIV class=ct_list>
<div style="float:left; width:650px; margin-left:2px; margin-bottom:10px">
{literal}
<div style="float:left; width:650px;">
  <img src="images/lv1.jpg" width="6" height="105" style="float:left"/>
  <div style="float:left; background-image:url(./images/lv2.jpg); height:105px">    
        <img id="t1" style="cursor:pointer; padding:11px 0px" src="images/lan1.jpg" tag="0" width="86" height="82" border="0" onclick=
      "if(this.tag==0||typeof(this.tag)=='undefined'){this.src='images/lan11.jpg';this.tag='1';$('.tt').attr('tag','0'); $('#t2').attr('src','images/lan2.jpg');$('#t3').attr('src','images/lan3.jpg');$('#t4').attr('src','images/lan4.jpg');$('#t5').attr('src','images/lan5.jpg');$('#t6').attr('src','images/lan6.jpg');$('#t7').attr('src','images/lan7.jpg');$('.aj').remove();$('.tp').show();}else{this.src='images/lan1.jpg';this.tag='0'};">
       
        <img id="t2" class="tt" style="cursor:pointer;padding:11px 0px" src="images/lan2.jpg" tag="0" width="86" height="82" border="0" onclick="
        if(this.tag==0||typeof(this.tag)=='undefined'){this.src='images/lan22.jpg';$('#t1').attr({'src':'images/lan1.jpg','tag':'0'});this.tag='1';}else{this.src='images/lan2.jpg';this.tag='0'};checktp()">
      
        <img id="t3" class="tt" style="cursor:pointer;padding:11px 0px" src="images/lan3.jpg" tag="0" width="86" height="82" border="0" onclick="
        if(this.tag==0||typeof(this.tag)=='undefined'){this.src='images/lan33.jpg';$('#t1').attr({'src':'images/lan1.jpg','tag':'0'});this.tag='1';}else{this.src='images/lan3.jpg';this.tag='0'};checktp()">
       
        <img id="t4" class="tt" style="cursor:pointer;padding:11px 0px" src="images/lan4.jpg" tag="0" width="86" height="82" border="0" onclick="
        if(this.tag==0||typeof(this.tag)=='undefined'){this.src='images/lan44.jpg';$('#t1').attr({'src':'images/lan1.jpg','tag':'0'});this.tag='1';}else{this.src='images/lan4.jpg';this.tag='0'};checktp()">
        
        <img id="t5" class="tt" style="cursor:pointer;padding:11px 0px" src="images/lan5.jpg" tag="0" width="86" height="82" border="0" onclick="
        if(this.tag==0||typeof(this.tag)=='undefined'){this.src='images/lan55.jpg';$('#t1').attr({'src':'images/lan1.jpg','tag':'0'});this.tag='1';}else{this.src='images/lan5.jpg';this.tag='0'};checktp()">
        <img id="t6" class="tt" style="cursor:pointer;padding:11px 0px" src="images/lan6.jpg" tag="0" width="86" height="82" border="0" onclick="
        if(this.tag==0||typeof(this.tag)=='undefined'){this.src='images/lan66.jpg';$('#t1').attr({'src':'images/lan1.jpg','tag':'0'});this.tag='1';}else{this.src='images/lan6.jpg';this.tag='0'};checktp()">
        <img id="t7" class="tt" style="cursor:pointer;padding:11px 0px" src="images/lan7.jpg" tag="0" width="86" height="82" border="0" onclick="
        if(this.tag==0||typeof(this.tag)=='undefined'){this.src='images/lan77.jpg';$('#t1').attr({'src':'images/lan1.jpg','tag':'0'});this.tag='1';}else{this.src='images/lan7.jpg';this.tag='0'};checktp()">
   </div>
   <img src="images/lv3.jpg" width="6" height="105" style="float:left"/> 
</div>
{/literal}
</div>

<div id="shop" style="width:650px; float:left;">
	{section name=shop loop=$shops}
    <div class="sharp color2 tp" tag="{$shops[shop].dintype}" style="width:19%; margin-left:5px" onmouseover="this.style.background='#F30'" onmouseout="this.style.background='#FFF'">
    <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b> 
    <div class="contround">
    <div style="float:left;">
    <a href="./showshop.php?shopid={$shops[shop].shopid}"><img src="{$shops[shop].shopimage}" class="ct_pic" style="border: 0px" /></a>
    </div>
    <!--餐厅第一行信息开始-->
    <div style="PADDING-TOP:0px;width:98%; text-align:center;">
    <a href="./showshop.php?shopid={$shops[shop].shopid}">{$shops[shop].shopname}</a>
    </div>
    <div>
    <!--电话餐厅标识开始-->
    <div style="padding:0px; margin:0px;width:100%; text-align:center; color:#999">
    {$shops[shop].showstate}
    </div>
    <!--电话餐厅标识结束-->
    </div>
    </div>
    <b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>
    </div>
	{/section}
</div>
</DIV>
<div id="sidebar">
{nocache}
{if $saveshops!=NULL}
<div class="sharp color6" id="collectionbox">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b> 
<div class="contround">  
<div>
<table width="100%"><th width="80%" align="left">我的收藏</th><th width="20%" align="right"><a href="./mycollection.php">更多</a></th></table>
<ul>
{section name=tag loop=$saveshops}
<li id="c{$saveshops[tag].shopid}"><a href="./showshop.php?shopid={$saveshops[tag].shopid}">{$saveshops[tag].shopname}</a>  
<input type="button" value="取消收藏" onclick="saveshop({$saveshops[tag].shopid},0)" /></li>
{/section}
</ul>
</div>
</div>
<b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
</div>
{/if}
{/nocache}
<div class="sharp color6">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b> 
<div class="contround">  
<div>
<table width="100%"><th width="50%">热卖美食</th><th width="30%">人气</th><th width="20%">价格</th></table>
{section name=tag loop=$rmms}
<form method='post' action='' class='jcart' style="margin:0px; padding:0px">
<input type='hidden' name='my-item-shop' value='{$rmms[tag].shopid}'/>
<input type='hidden' name='my-item-id' value='{$rmms[tag].dinid}' />
<input type='hidden' name='my-item-name' value='{$rmms[tag].dinname}' />
<input type='hidden' name='my-item-price' value='{$rmms[tag].dinprice}'/>
<input type='hidden' name='my-item-qty' value='1' size='3' />
<table width="100%">
<tr>
<td width="45%" align="center"><a href="./showshop.php?shopid={$rmms[tag].shopid}" title="{assign var=dinid value=$rmms[tag].dinid}{$rmshopname[$dinid]}">{$rmms[tag].dinname}</a></td>
<td><input type='submit' name='my-add-button' value="来一份" class="button" /></td>
<td width="30%" align="center">
<div style="margin-left:20px">
{if $rmms[tag].popnum==0}
{assign var="gif" value="no-repeat -211px -360px"}
{elseif $rmms[tag].popnum>0 and $rmms[tag].popnum<=20}
{assign var="gif" value="no-repeat -211px -344px"}
{elseif $rmms[tag].popnum>20 and $rmms[tag].popnum<=40}
{assign var="gif" value="no-repeat -211px -328px"}
{elseif $rmms[tag].popnum>40 and $rmms[tag].popnum<=60}
{assign var="gif" value="no-repeat -211px -312px"}
{elseif $rmms[tag].popnum>60 and $rmms[tag].popnum<=80}
{assign var="gif" value="no-repeat -211px -296px"}
{else}
{assign var="gif" value="no-repeat -211px -280px"}
{/if}

<span  title="人气指数:{$rmms[tag].popnum}" style=" background: url(./images/p.gif) {$gif};FLOAT:left;WIDTH: 50px; HEIGHT: 15px; margin-top:5px;"></span>
</div>
</td>
<td width="25%" align="center">{$rmms[tag].dinprice}</td>
</tr>
</table>
</form>
{/section}
</div>
</div>
<b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
</div>

<div class="sharp color6">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b> 
<div class="contround">  
<div>
<table width="100%"><th width="50%">推荐美食</th><th width="30%">人气</th><th width="20%">价格</th></table>
{section name=tag loop=$tjms}
<form method='post' action='' class='jcart' style="margin:0px; padding:0px">
<input type='hidden' name='my-item-shop' value='{$tjms[tag].shopid}'/>
<input type='hidden' name='my-item-id'   value='{$tjms[tag].dinid}' />
<input type='hidden' name='my-item-name' value='{$tjms[tag].dinname}' />
<input type='hidden' name='my-item-price'value='{$tjms[tag].dinprice}'/>
<input type='hidden' name='my-item-qty'  value='1' size='3' />
<table width="100%">
<tr>
<td width="45%" align="center">
<a href="./showshop.php?shopid={$tjms[tag].shopid}" title="{assign var=dinid value=$tjms[tag].dinid}{$tjshopname[$dinid]}">{$tjms[tag].dinname}</a>
</td>
<td><input type='submit' name='my-add-button' value="来一份" class="button" /></td>
<td width="30%" align="center">
<div style="margin-left:20px">
{if $tjms[tag].popnum==0}
{assign var="gif" value="no-repeat -211px -360px"}
{elseif $tjms[tag].popnum>0 and $tjms[tag].popnum<=20}
{assign var="gif" value="no-repeat -211px -344px"}
{elseif $tjms[tag].popnum>20 and $tjms[tag].popnum<=40}
{assign var="gif" value="no-repeat -211px -328px"}
{elseif $tjms[tag].popnum>40 and $tjms[tag].popnum<=60}
{assign var="gif" value="no-repeat -211px -312px"}
{elseif $tjms[tag].popnum>60 and $tjms[tag].popnum<=80}
{assign var="gif" value="no-repeat -211px -296px"}
{else}
{assign var="gif" value="no-repeat -211px -280px"}
{/if}

<span  title="人气指数:{$tjms[tag].popnum}" style=" background: url(./images/p.gif) {$gif};FLOAT:left;WIDTH: 50px; HEIGHT: 15px; margin-top:5px;"></span>
</div>

</td>
<td width="25%" align="center">{$tjms[tag].dinprice}</td>
</tr>
</table>
</form>
{/section}
</div>
</div>
<b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
</div>
</div>
<div style="width:100%; height:115px; float:left; margin-top:10px">
<img src="./images/liucheng.jpg" />
</div>
{literal}
<script type="text/javascript" language="javascript">
var tID;
var tn;
var nStopTime=3000
var nSpeed=50
var isMove=true;
var nHeight=20;
var nS=0
var nNewsCount=0

function moveT(n)
{
    clearTimeout(tID)
    var noticev2= document.getElementById("noticev2")
    if(n)
    {
        noticev2.style.lineHeight=nHeight+"px";
        var theText=noticev2.innerHTML.toLowerCase();   
        nNewsCount=theText.split("<br>").length     
        noticev2.innerHTML+=noticev2.innerHTML;
        tn=nHeight;
    }
    nS=nSpeed;
    if(isMove)
    {
        noticev2.style.marginTop=tn+"px";
        if((tn-2)%nHeight==0)
        {
            nS=nSpeed+nStopTime;
        }
           
        tn--;
        if(Math.abs(tn)==(nNewsCount*nHeight*2-nHeight))
        tn=(nNewsCount-1)*nHeight*-1;
    }
   
    tID=setTimeout("moveT()",nS);
}

moveT(5);
function checktp()
{
	//通过ajax实现分类
	//var mark=$('#t2').attr('tag')+$('#t3').attr('tag')+$('#t4').attr('tag')+$('#t5').attr('tag')+$('#t6').attr('tag')+$('#t7').attr('tag');
//	$.ajax({
//			type: "POST",dataType : "text",async : false,url: "./selecttp.php",
//			data: {"mark" : mark},
//			success: function(res){
//				$('.tp').hide();
//				$('.aj').remove();
//				$('.ct_list').append(res);
//			},
//			error : function(res,msg,err) {alert(msg);}
//	});
	var mark = new Array()
	if($('#t2').attr('tag')==1)mark.push(6);
	if($('#t3').attr('tag')==1)mark.push(1);
	if($('#t4').attr('tag')==1)mark.push(2);
	if($('#t5').attr('tag')==1)mark.push(3);
	if($('#t6').attr('tag')==1)mark.push(4);
	if($('#t7').attr('tag')==1)mark.push(5);
	if(mark.length!=0)
	{
		$(".tp").hide();
		$("#shop").children("div").each(function(){
			var isOK=false;
			var tag = $(this).attr("tag");
			for(var i=0;i<mark.length;i++){
				if(tag.indexOf(mark[i])!=-1){
					isOK=true;
				}else{
					isOK=false;
					break;
				}
			}
			if(isOK){
				$(this).show();	
			}
		});
	}else{
		$(".tp").show();
	}
}
function saveshop(id,tag)
{
	$.ajax({
			type: "POST",dataType : "text",async : false,url: "./shopcollection.php",
			data: {"shopid" : id,"tag":tag},
			success: function(res){
				if(res=='3'){
					$('#c'+id).remove();
					if($("#collectionbox ul").children("li").length==0)
					{
						$("#collectionbox").remove();
					}
				}
				},
			error : function(res,msg,err) {alert(msg);}
		});
}
</script>

{/literal}
</div>