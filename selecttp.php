<?php
header('Content-Type:text/html;charset=gb2312');
include_once('./global.php');
isset($_COOKIE['bid'])?$bulid=$_COOKIE['bid']:header("location:./index.php");
$now = strtotime(date("YmdHis"));
$mark=str_split($_POST['mark']);
$time = date("H:i:s");
$where="";
if($mark[0]==1){
	$where="and ((`linktime`+60>= '$now' and `online`=2) or (( `swstart`<'$time' and `swend`>'$time') or (`xwstart`<'$time' and `xwend`>'$time') and `online`=1))";
}
$tag="";
if($mark[1]==1){
	$tag.="and `dintype` like '%1%'";
}
if($mark[2]==1)
{
	$tag.="and `dintype` like '%2%'";
}
if($mark[3]==1)
{
	$tag.="and `dintype` like '%3%'";
}
if($mark[4]==1)
{
	$tag.="and `dintype` like '%4%'";
}

if($mark[5]==1)
{
	$tag.="and `dintype` like '%5%'";
}
$where.=$tag;
$query="SELECT * FROM `wm_shopinfo` WHERE `shopid` IN (SELECT `shopid` FROM `wm_shoplinkbul` where `areaid`= '$bulid') and `shoptype` = 1 $where";
$shops=$db->query($query)->fetchall();
foreach($shops as $row)
{
?>
<div style="width:650px;">
<div class="sharp color2 tp" style="width:19%; margin-left:5px" onmouseover="this.style.background='#F30'" onmouseout="this.style.background='#FFF'">
    <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b> 
    <div class="contround">
    <div style="float:left;">
    <a href="./showshop.php?shopid=<?php echo $row['shopid'];?>">
    <img src="<?php if($row['shopimage']!=null){echo $row['shopimage'];}else{echo $shops[0]['shopimage'];}?>" class="ct_pic" style="border: 0px"/></a>
    </div>
    <!--餐厅第一行信息开始-->
    <div style="PADDING-TOP:0px;width:98%; text-align:center">
    <a href="./showshop.php?shopid=<?php echo $row['shopid'];?>"><?php echo $row['shopname']?></a>
    </div>
    <div>
    <!--电话餐厅标识开始-->
    <div style="padding:0px; margin:0px;width:100%; text-align:center; color:#999">
    <?php if($mark[0]==1){ 

	if($row['shopid']==1){?>

    <font size="2" color="#FF9900">支持在线体验</font>

	<?php }else{?>

	<font size="2" color="#FF9900">支持在线订餐</font><?php }

	}else{

	

	if($row['shopid']==1)

	{

	    echo "<font size='2' color='#FF9900'>支持在线体验</font>";

	}else

	{

	    if($row['online']==0)

		{

		    echo "店铺离线";

		}elseif($row['online']==1)

		{

		    if((strtotime($time)>strtotime($row['swstart'])&&strtotime($time)<strtotime($row['swend']))|| (strtotime($time)>strtotime($row['xwstart'])&&strtotime($time)<strtotime($row['xwend'])))

			{

			    echo "<font size='2' color='#FF9900'>支持在线订餐</font>";

			}else

			{

			    echo "店铺离线";

			}

		}elseif($row['online']==2)

		{

		    if($row['linktime']+60>=$now)

			{

			    echo "<font size='2' color='#FF9900'>支持在线订餐</font>";

			}elseif($row['linktime']+60<$now)

			{

			    echo "店铺离线";

			}

		}elseif($row['online']==3)

		{

		    echo "<font size='2' color='#FF66CC'>自行电话预订</font>";

		}

		

	}

	}?>
    </div>
    <!--电话餐厅标识结束-->
    </div>
    </div>
    <b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>
    </div>
</div>
<?php 
}
?>