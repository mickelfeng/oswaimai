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
<!--注意下面的table tr的id不能随意修改 -->
<table id="coll">
<tr id="c"><td colspan="3">收藏的店铺</td></tr>
{section name=tag loop=$collections}
<tr id="c{$smarty.section.tag.index}"><td><a href="./showshop.php?shopid={$collections[tag].shopid}">{$collections[tag].shopname}</a></td><td><input type="button" value="取消收藏" onclick="saveshop({$collections[tag].shopid},0,{$smarty.section.tag.index})"/></td><td><input type="button" value="上移" onclick="prev($(this).parent().parent().attr('id'))" /><input type="button" value="下移" onclick="next($(this).parent().parent().attr('id'))"/><input type="hidden" id="st" value="{$collections[tag].savetime}"/><input type="hidden" id="sp" value="{$collections[tag].shopid}" /></td></tr>
{/section}
</table>
</div>
</div>
{literal}
<script type="text/javascript" language="javascript">
function saveshop(shopid,tag,id)
{
	$.ajax({
			type: "POST",dataType : "text",async : false,url: "./shopcollection.php",
			data: {"shopid" : shopid,"tag":tag},
			success: function(res){
				if(res=='3'){
					$('#c'+id).remove();
				}
				},
			error : function(res,msg,err) {alert(msg);}
		});
}
function next(id)
{
	var currentshop = $("#"+id+" #sp").val();
	var currentime  = $("#"+id+" #st").val();
	
	var current=$("#"+id).html();
	var nexthtml =$("#"+id).next().html();
	if(nexthtml==null)
	{
		var nextshop = $("#coll tr:eq(1) #sp").val();
		var nextime  = $("#coll tr:eq(1) #st").val();
		
		nexthtml=$("#coll tr:eq(1)").html();
		$("#coll tr:eq(1)").html(current);
	}else
	{
		var nextid=$("#"+id).next().attr("id");
		var nextshop = $("#"+nextid+" #sp").val();
		var nextime  = $("#"+nextid+" #st").val();	
		$("#"+id).next().html(current);
	}
	$("#"+id).html(nexthtml)
	
	$.ajax({
		type: "POST",dataType : "text",async : false,url: "./updatecollectionorder.php",
		data: {"currentshop" : currentshop,"currentime":currentime,"nextshop":nextshop,"nextime":nextime},
		success: function(res){},
		error : function(res,msg,err) {alert(msg);}
	});
}
function prev(id)
{
	var currentshop = $("#"+id+" #sp").val();
	var currentime  = $("#"+id+" #st").val();
	
	var current=$("#"+id).html();
	var previd =$("#"+id).prev().attr("id");
	if(previd=="c")
	{
		var nextshop = $("#coll tr:last #sp").val();
		var nextime  = $("#coll tr:last #st").val();

		prevhtml=$("#coll tr:last").html();	
		$("#coll tr:last").html(current);
	}else
	{
		var nextshop = $("#"+previd+" #sp").val();
		var nextime  = $("#"+previd+" #st").val();
		
		prevhtml=$("#"+id).prev().html();
		$("#"+id).prev().html(current);
	}
	
	$("#"+id).html(prevhtml)
	$.ajax({
		type: "POST",dataType : "text",async : false,url: "./updatecollectionorder.php",
		data: {"currentshop" : currentshop,"currentime":currentime,"nextshop":nextshop,"nextime":nextime},
		success: function(res){},
		error : function(res,msg,err) {alert(msg);}
	});
}
</script>
{/literal}