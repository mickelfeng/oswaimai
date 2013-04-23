<?php
@session_start();
include "../global.php";
if (empty($_SESSION['uname']))
{
	header("location:./index.php");exit();
}
$unex=explode('|',$_SESSION['uname']);

if($_SERVER['REQUEST_METHOD']=='POST')
{
	extract($_POST);
	sha1($username);
	$stype="";
	if(!empty($shoptype)){
		foreach($shoptype as $st){
			$stype.=$st;}
	}
	$postdate  = date("Y-m-d H:i:s");
	if(empty($updateid))
	{
		if($db->query("select `shopid` from `wm_admin_b` where `username`='$username' or `email`='$shopemail'")->fetch())
		{
			echo "你输入的用户名:".$username."或者email:".$shopemail."已经存在";	
		}else
		{
			$sql="insert into wm_shopinfo(`printid`,`online`,`contact`,`shopname`,`shoparea`,`shopadd`,`shoptel`,`shopintro`,`shopimage`,`shoptype`,`dintype`,`swstart`,`swend`,`xwstart`,`xwend`,`post_time`) values('$print','2','$contact','$shopname','$areaid','$shopadd','$shoptel','$shopintro','$myFilePath','1','$stype','$swstart','$swend','$xwstart','xwend','$postdate')";
			
			if($db->query($sql)){
				$sid=$db->lastInsertId();
				$pwd=sha1("admin");
				$asql="insert into `wm_admin_b`(`shopid`,`username`,`email`,`password`) values('$sid','$username','$shopemail','$pwd')";
				if($db->query($asql)){
					echo "添加成功";
				}
			}else
			{
				echo "添加失败";
			}
		}
	}else
	{
		$upinfosql="update `wm_shopinfo` set `printid`='$print',`contact`='$contact',`shopname`='$shopname',`shoparea`='$areaid',`shopadd`='$shopadd',`shoptel`='$shoptel',`shopintro`='$shopintro',`shoptype`='1',`dintype`='$stype',`post_time`='$postdate',`online`='$online',`swstart`='$swstart',`swend`='$swend',`xwstart`='$xwstart',`xwend`='$xwend' where `shopid`='$updateid'";
		if($db->query($upinfosql))
		{
			if($db->query("update `wm_admin_b` set `username`='$username',`email`='$shopemail' where `shopid`='$updateid'"))
			{
				echo "修改成功 <a href='./shops.php'>返回</a>";
			}
		}
	}
}
$sql="SELECT * FROM `wm_printer` WHERE `printer_id` NOT IN (SELECT `printid` FROM `wm_shopinfo` WHERE `printid` <> '')";
$printers = $db->query($sql)->fetchall();
$stsql="SELECT * FROM `wm_dintype`";
$shoptypes = $db->query($stsql)->fetchall();

$csql="select `id`,`areaname` from `wm_areainfo` where fid='0'";
$cities = $db->query($csql)->fetchall();

$editshop=$_GET['shopid'];
if(!empty($editshop))
{
	$singleinfo=$db->query("select `wm_shopinfo`.*,`wm_admin_b`.username,`wm_admin_b`.email from `wm_shopinfo`,`wm_admin_b` where `wm_shopinfo`.`shopid`='$editshop' and `wm_shopinfo`.`shopid`=`wm_admin_b`.shopid")->fetch();
	$cityid=$db->query("select `fid`,`areaname` from `wm_areainfo` where `id`='$singleinfo[shoparea]'")->fetch();
}
?>
<html>
<head>
<link href="css/main.css"      rel="stylesheet" type="text/css" />
<link href="css/default.css"   rel="stylesheet" type="text/css" />
<link href="css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../jcart/jquery-1.5.1.js"></script>
<script type="text/javascript" src="./js/swfobject.js"></script>
<script type="text/javascript" src="./js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#fileInput2").uploadify({
		'uploader'   : './js/uploadify.swf',//所需要的flash文件
		'cancelImg'  : './js/cancel.png',//单个取消上传的图片
		'script'     : './js/uploadify.php',//实现上传的程序
		'folder'     : 'uploads',//服务端的上传目录
		//'auto': true,//自动上传
		//'multi': true,//是否多文件上传
		//'checkScript': 'js/check.php',//验证 ，服务端的
		'displayData': 'speed',//进度条的显示方式
		'fileDesc'   : 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
		'fileExt'    : '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
		//'sizeLimit': 999999 ,//限制上传文件的大小
		//'simUploadLimit' :3, //并发上传数据 
		'queueSizeLimit' :1, //可上传的文件个数
		//'buttonText' :'文件上传',//通过文字替换钮扣上的文字
		'buttonImg'  : './js/browseBtn.png',//替换上传钮扣
		'width'      : 90,//buttonImg的大小
		'height'     : 34,//
		'rollover'   : false,//button是否变换
		onComplete: function (evt, queueID, fileObj, response, data) {
			//alert("Successfully uploaded: "+fileObj.filePath);
			//alert(response);
			getResult(response);//获得上传的文件路径
		}
		//onError: function(errorObj) {
		//	alert(errorObj.info+"			"+errorObj.type);
		//}
	});
	
	
	$('#city').change(function () {
        var city = $("#city").val();
        if (city == 0) {
            $("#areaid").empty();
            $("#areaid").append("<option value='0'>选择区域</option>");
        } else {
            $.ajax({
                url: './searcharea.php',
                data: "city=" + city,
                type: 'get',
                dataType: 'text',
                success: function (answers) {
                    $("#areaid").empty();
                    $("#areaid").append(answers);
                }
            });
        }
    });
});
</script>
<script type="text/javascript">
	function getResult(content){
		//通过上传的图片来动态生成text来保存路径
			var board = document.getElementById("divTxt");
			board.style.display="";
			var newInput = document.createElement("input");
			newInput.type = "text"; 
			newInput.size = "45"; 
			newInput.name="myFilePath";
			var obj = board.appendChild(newInput);
			var br= document.createElement("br"); 
			board.appendChild(br);
			obj.value=content;
	}
</script>
<script type="text/javascript">
function killErrors() {
return true;
}
window.onerror = killErrors;
	
	function clearNoNum(event,obj){ 
        event = window.event||event; 
        if(event.keyCode == 37 | event.keyCode == 39){ 
            return; 
        } 
        obj.value = obj.value.replace(/[^\d.]/g,""); 
        obj.value = obj.value.replace(/^\./g,""); 
        obj.value = obj.value.replace(/\.{2,}/g,"."); 
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$","."); 
    } 
    function checkNum(obj){ 
        obj.value = obj.value.replace(/\.$/g,"");
       

    }
	function isOK(){
	var phone=document.form2.tel.value;
	if(document.form2.add.value==""){alert('餐店地址不能为空');return false;}
	if(phone==""){return true;}
	 if(!(/^1[3-8][0-9]\d{8}$/.test(phone))){ 
    alert("你输入的号码有误，请重新输入"); 
    document.form2.tel.focus(); 
    return false; }
    return true;
	}
	window.onload = function() 　　//控制textarea文本框的字数 textarea没有value和maxlength属性
	{ 　　
	document.getElementById('intro').onkeydown = function(){ 　　
	if(this.value.length >= 80) 　　
	event.returnValue = false;
	}
	} 

</script>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
</head>
<body>
<form action='addshop.php' name='form2' method='post' onSubmit='return isOK();'>
  <table width="100%" border=0 align=center cellpadding=3 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr><th align=center colspan=8 style="height: 23px">餐店信息|修改</th></tr>
      <tr align="center" bgcolor="#799AE1">
        <td width="10%" align="right" class=txlHeaderBackgroundAlternate>登陆用户名</td>
		<td width="90%" align="left" class=txlrow>
        <?php if(!empty($singleinfo['shopid'])){?><input type="hidden" value="<?php echo $singleinfo['shopid'];?>" name="updateid" /><?php }?>
        <input id="username" type="text" value="<?php echo $singleinfo['username'];?>" name="username"/>
        <font color="red">默认密码为：admin，商家登陆后台可自行修改</font></td>
      </tr> 
      <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>商家邮箱</td>
		<td align="left" class=txlrow><input id="shopemail" type="text" value="<?php echo $singleinfo['email'];?>" name="shopemail"/></td>
      </tr> 
      <tr align="center" bgcolor="#799AE1" style="display:none">
        <td align="right" class=txlHeaderBackgroundAlternate>邮箱接收订单？</td>
		<td align="left" class=txlrow><input type="radio" value="1" name="toemail"/>是&nbsp;<input type="radio" value="0" name="toemail" checked/>否</td>
      </tr>
      <tr align="center" bgcolor="#799AE1" style="display:none">
        <td align="right" class=txlHeaderBackgroundAlternate>手机接收订单？</td>
		<td align="left" class=txlrow><input type="radio" value="1" name="totel"/>是&nbsp;<input type="radio" value="0" name="totel" checked/>否</td>
      </tr> 
      <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>餐店名称</td>
		<td align="left" class=txlrow><input id="shopname" type="text" value="<?php echo $singleinfo['shopname'];?>" name="shopname"/></td>
      </tr> 
	  <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>餐店地址</td>
		<td align="left" class=txlrow>
        <select name="city" id="city">
        <option value="0">选择城市</option>
		<?php foreach($cities as $city){
			$tg = (!empty($cityid)&&$cityid['fid']==$city['id'])?"selected":"";
			echo "<option value='".$city['id']."' ".$tg.">".$city['areaname']."</option>";}?></select>
        &nbsp;
        <select name="areaid" id="areaid">
        <?php if(!empty($cityid)){?>
        <option value="<?php echo $cityid['fid'];?>"><?php echo $cityid['areaname'];?></option>
		<?php }else{?>
        <option value="0">选择区域</option>
        <?php }?>
        </select>
        &nbsp;
        <input type="text" id="shopadd" name="shopadd" value="<?php echo $singleinfo['shopadd'];?>"/></td>
      </tr> 
       <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>店主姓名</td>
		<td align="left" class=txlrow><input type="text" name="contact" id="contact" value="<?php echo $singleinfo['contact'];?>"/></td>
      </tr> 
	  <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>联系电话</td>
		<td align="left" class=txlrow><input type="text" name="shoptel" id="shoptel" value="<?php echo $singleinfo['shoptel'];?>"/></td>
      </tr> 
	   <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate valign="top">餐店简介</td>
		<td align="left" class=txlrow><textarea name="shopintro" cols="70" rows="5"><?php echo $singleinfo['shopintro'];?></textarea></td>
      </tr> 
	   <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>餐店图片</td>
		<td align="left" class=txlrow>
        <?php if($singleinfo['shopimage']!=NULL){echo "<img src='".$singleinfo['shopimage']."'>";}?>
        <div id="divTxt" style="display:none"></div><fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">
<div>	
<input id="fileInput2" name="fileInput2" type="file" /><font color="red"></font><br>

<font color="#FF0000">建议上传151px × 121px 图片且不能超过100KB！</font>
<input type="button" value="确定上传" onClick="javascript:$('#fileInput2').uploadifyUpload();">
<!--<a href="javascript:$('#fileInput2').uploadifyClearQueue();">清除上传列表</a>--></div>
</fieldset>
</td>
      </tr> 
	  <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>配送时间</td>
		<td align="left" class=txlrow>
        上午
        <select name="swstart">
        <option value="9:00:00" <?php if($singleinfo['swstart']=="9:00:00"){echo "selected";}?>>9:00</option>
        <option value="9:30:00" <?php if($singleinfo['swstart']=="9:30:00"){echo "selected";}?>>9:30</option>
        <option value="10:00:00" <?php if($singleinfo['swstart']=="10:00:00"){echo "selected";}?>>10:00</option>
        <option value="10:30:00" <?php if($singleinfo['swstart']=="10:30:00"){echo "selected";}?>>10:30</option>
        </select>-<select name="swend">
        <option value="12:30:00" <?php if($singleinfo['swend']=="12:30:00"){echo "selected";}?>>12:30</option>
        <option value="13:00:00" <?php if($singleinfo['swend']=="13:00:00"){echo "selected";}?>>13:00</option>
        <option value="13:30:00" <?php if($singleinfo['swend']=="13:30:00"){echo "selected";}?>>13:30</option>
        <option value="14:00:00" <?php if($singleinfo['swend']=="14:00:00"){echo "selected";}?>>14:00</option>
        </select>
        下午
        <select name="xwstart">
        <option value="14:00:00" <?php if($singleinfo['xwstart']=="14:00:00"){echo "selected";}?>>14:00</option>
        <option value="15:00:00" <?php if($singleinfo['xwstart']=="15:00:00"){echo "selected";}?>>15:00</option>
        <option value="15:30:00" <?php if($singleinfo['xwstart']=="15:30:00"){echo "selected";}?>>15:30</option>
        <option value="16:00:00" <?php if($singleinfo['xwstart']=="16:00:00"){echo "selected";}?>>16:00</option>
        </select>-
        <select name="xwend">
        <option value="16:00:00" <?php if($singleinfo['xwend']=="16:00:00"){echo "selected";}?>>16:00</option>
        <option value="17:00:00" <?php if($singleinfo['xwend']=="17:00:00"){echo "selected";}?>>17:00</option>
        <option value="18:00:00" <?php if($singleinfo['xwend']=="18:00:00"){echo "selected";}?>>18:00</option>
        <option value="19:00:00" <?php if($singleinfo['xwend']=="19:00:00"){echo "selected";}?>>19:00</option>
        <option value="20:00:00" <?php if($singleinfo['xwend']=="20:00:00"){echo "selected";}?>>20:00</option>
        <option value="21:00:00" <?php if($singleinfo['xwend']=="21:00:00"){echo "selected";}?>>21:00</option>
        </select>
        </td>
      </tr> 
	  <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>营业状态</td>
		<td align="left" class=txlrow><select name="online" id="online">
        <option value="0" <?php if($singleinfo['online']==0) echo "selected";?>>店铺离线</option>
        <option value="1" <?php if($singleinfo['online']==1) echo "selected";?>>依据营业时间</option>
        <option value="2" <?php if($singleinfo['online']==2) echo "selected";?>>依据打印机</option>
        <option value="3" <?php if($singleinfo['online']==3) echo "selected";?>>自行电话预订</option>
        </select></td>
      </tr>
      <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>关联打印机</td>
		<td align="left" class=txlrow>
        <select name="print" id="print">
        <?php 
		if(!empty($singleinfo['printid'])){
			echo "<option value='".$singleinfo['printid']."'>".$singleinfo['printid']."</option>";
		}
		?>
        <?php 
		if(!empty($printers))
		{
			echo "<option value=''>不使用打印机</option>";	
			foreach($printers as $row)
			{
				echo "<option value='".$row['printer_id']."'>".$row['printer_id']."</option>";	
			}
		}else
		{
			echo "<option value=''>暂无打印机可用</option>";	
		}
		?>
        </select></td>
      </tr>
      <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>餐店类别</td>
		<td align="left" class=txlrow>
        <?php
		
		foreach($shoptypes as $row)
		{
			$tag= (strpos($singleinfo['dintype'],$row['id'])||strpos($singleinfo['dintype'],$row['id'])===0)?"checked":"";
			
			echo "<input type='checkbox' name='shoptype[]' value='".$row['id']."' ".$tag.">".$row['typename']."&nbsp;";	
		}
		?>
        </td>
      </tr> 
	  <tr align="center" bgcolor="#799AE1">
        <td align="right" class=txlHeaderBackgroundAlternate>操作</td>
		<td align="left" class=txlrow><input type="submit" value="添加"/></td>
      </tr> 
	</tbody>
  </table>
</form>

</body>
</html>