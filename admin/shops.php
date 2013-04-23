<link rel="stylesheet" href="./css/main.css" type="text/css" />
<script type="text/javascript" src="../jcart/jquery-1.5.1.js"></script>
<?php
@session_start();
include "../global.php";
if(!$_SESSION['uname']){
	header("location:./index.php");exit();
}

$del = $_GET['did'];
if(!empty($del))
{
	if($db->query("delete from `wm_shopinfo` where `shopid`='$del'")&&$db->query("delete from `wm_admin_b` where `shopid`='$del'")&&$db->query("delete from `wm_dincategory` where `shopid`='$del'")&&$db->query("delete from `wm_dininfo` where `shopid`='$del'")&&$db->query("delete from `wm_grade` where `shopid`='$del'")&&$db->query("delete from `wm_orders` where `shopid`='$del'")&&$db->query("delete from `wm_order_items` where `shopid`='$del'")&&$db->query("delete from `wm_shoplinkbul` where `shopid`='$del'"))
	{
		echo "<font color='#FF0000'>删除成功</font>";	
	}
}
$sql="SELECT * FROM `wm_shopinfo`";
$shops = $db->query($sql)->fetchall();
?>
<table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=9 style="height: 23px">餐店信息</th>
      </tr>
	   <tr bgcolor="#DEE5FA">
        <td align="center" colspan="9" align="center" class=txlrow><font color="#FF0000"><strong>&nbsp;</strong></font></td>
      </tr>
      <tr bgcolor="#799AE1">
        <td width="8%" class=txlHeaderBackgroundAlternate>状态</td>
        <td width="8%" class=txlHeaderBackgroundAlternate>餐店名称</td>
        <td width="12%" class=txlHeaderBackgroundAlternate>营业状态</td>
        <td width="18%" class=txlHeaderBackgroundAlternate>餐店地址</td>
        <td width="8%" class=txlHeaderBackgroundAlternate>打印机编号</td>
		<td width="8%" class=txlHeaderBackgroundAlternate>联系人</td>
        <td width="8%" class=txlHeaderBackgroundAlternate>联系电话</td>
        <td width="20%" class=txlHeaderBackgroundAlternate>营业时间</td>
        <td width="10%" class=txlHeaderBackgroundAlternate>操作</td>
      </tr>
      <?php
	  foreach($shops as $mem)
	  {?>
      <tr>
      <td class=txlrow id="shop<?php echo $mem['shopid'];?>">
      <?php if($mem['shoptype']==1){?>
      <a href="javascript:changeShoptype(2,<?php echo $mem['shopid'];?>)">隐藏</a>
      <?php }elseif($mem['shoptype']==2){?>
      <a href="javascript:changeShoptype(1,<?php echo $mem['shopid'];?>)">取消隐藏</a>
      <?php }?>
      </td>
      <td class=txlrow><?php echo $mem['shopname'];?></td>
      <td class=txlrow><?php if($mem['online']==0){echo "离线";}elseif($mem['online']==1){echo "依据营业时间";}elseif($mem['online']==2){echo "依据订单机";}elseif($mem['online']==3){echo "自行电话预订";}?></td>
      <td class=txlrow><?php echo $mem['shopadd'];?></td>
      <td class=txlrow><?php echo $mem['printid'];?></td>
      <td class=txlrow><?php echo $mem['contact'];?></td>
      <td class=txlrow><?php echo $mem['shoptel'];?></td>
      <td class=txlrow><?php echo "AM:".substr($mem['swstart'],0,5)."-".substr($mem['swend'],0,5)." PM:".substr($mem['xwstart'],0,5)."-".substr($mem['xwend'],0,5);?></td>
      <td class=txlrow><a href="addshop.php?shopid=<?php echo $mem['shopid']?>">编辑</a>&nbsp;<a href="shops.php?did=<?php echo $mem['shopid']?>" onclick="return delconfig()">删除</a></td>
      </tr>  
	  <?php
      }
	  ?>
</tbody>
</table>
<script language="javascript" type="text/javascript">
function delconfig()
{
   if(confirm("你确认删除吗？这将会删除关于此店铺所有相关信息")){
      return true;
   }else
   {
      return false;
   }
}
function changeShoptype(tag,shopid)
{
	$.ajax({type: "POST",dataType : "text",async : true,url: "changeShoptype.php",data:{"tag":tag,"shopid":shopid},
	    success: function(res){
			if(tag==1)
			{
				$('#shop'+shopid).html("<a href='javascript:changeShoptype(2,"+shopid+")'>隐藏</a>");
			}else if(tag==2)
			{
				$('#shop'+shopid).html("<a href='javascript:changeShoptype(1,"+shopid+")'>取消隐藏</a>");	
			}
		},
		error : function(res) {}
	});
}
</script>