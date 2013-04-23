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
	if($_POST['myFilePath']){
		$query = "update wm_shopinfo set shopadd='$_POST[add]',shoptel='$_POST[tel]',shopimage='$_POST[myFilePath]',online='$_POST[state]',shopintro='$_POST[intro]',beizhu='$_POST[beizhu]' where shopid='$unex[0]'";
	}else{
		$query = "update wm_shopinfo set shopadd='$_POST[add]',shoptel='$_POST[tel]',online='$_POST[state]',shopintro='$_POST[intro]',beizhu='$_POST[beizhu]' where shopid='$unex[0]'";
	}
	$result = $db->query($query);		
	if($result){echo "<IMG height=13 src=\"images/tick.png\" width=16 align=absMiddle />保存成功";}else{echo "<IMG height=13 src=\"images/cross.png\" width=16 align=absMiddle />保存失败";}
}
$row=get_shop_details($db,$unex[0]);
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
<?php if($_GET['id']==$unex[0]){?>

<fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">
<legend> <strong> 餐店图片上传</strong></legend>
<div>	
<input id="fileInput2" name="fileInput2" type="file" /> <font color="#FF0000"><strong>注意:上传图片大小不能超过100kb 上传图片为可选项，我们建议你上传！</strong></font>
<input type="button" value="确定上传" onClick="javascript:$('#fileInput2').uploadifyUpload();">
<!--<a href="javascript:$('#fileInput2').uploadifyClearQueue();">清除上传列表</a>--></div>
</fieldset>
<form action='shopinfo.php' name='form2' method='post' onSubmit='return isOK();'>
<?php }
$o=$row['online'];
if($o==2){$state="支持在线订餐";}else if($o==0){$state="打烊休息中";}else if($o==1){$state="自行电话订餐";}
?>

  <table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=8 style="height: 23px">基本信息|修改</th>
      </tr>
	  <tr bgcolor="#DEE5FA">
        <td colspan="8" align="center" class=txlrow><font color="#FF0000"><strong>注意:订餐热线目前只支持一个电话号码，如需更多请联系管理员</font></td>
      </tr>
      <tr align="center" bgcolor="#799AE1">
        <td width="20%" align="right" class=txlHeaderBackgroundAlternate>餐店名称</td>
		<td width="80%" align="left" class=txlrow><?php if($_GET['id']==$unex[0]){echo "<input type=text name='sname' size=20 disabled='disabled' value='".$row['shopname']."'/>";}else{echo "<input type=text name='sname' size=20 disabled='disabled' value='".$row['shopname']."'/>";}?></td>
      </tr> 
	   <tr align="center" bgcolor="#799AE1">
        <td width="20%" align="right" class=txlHeaderBackgroundAlternate>餐店地址</td>
		<td width="80%" align="left" class=txlrow><?php if($_GET['id']==$unex[0]){echo "<input type=text name='add' size=20 maxlength='20' value='".$row['shopadd']."'/>";}else{echo $row['shopadd'];}?></td>
      </tr> 
	   <tr align="center" bgcolor="#799AE1">
        <td width="20%" align="right" class=txlHeaderBackgroundAlternate>订餐热线</td>
		<td width="80%" align="left" class=txlrow><?php if($_GET['id']==$unex[0]){echo "<input type=text name='tel' size='13' maxlength='11' value='".$row['shoptel']."'/>";}else{echo $row['shoptel'];}?></td>
      </tr> 
	   <tr align="center" bgcolor="#799AE1">
        <td width="20%" align="right" class=txlHeaderBackgroundAlternate>餐店简介</td>
		<td width="80%" align="left" class=txlrow><?php if($_GET['id']==$unex[0]){echo "<textarea name='intro'  rows='5' cols='30' style='border: 1 solid #888888;LINE-HEIGHT:18px;padding: 3px;'>".$row['shopintro']."</textarea>";}else{echo $row['shopintro'];}?></td>
      </tr> 
	   <tr align="center" bgcolor="#799AE1">
        <td width="20%" align="right" class=txlHeaderBackgroundAlternate>餐店图片</td>
		<td width="80%" align="left" class=txlrow><?php if($_GET['id']==$unex[0]){echo "<div id='divTxt' style='display:none'></div>";}else{echo "<img src='".$row['shopimage']."' width='80px' height='60px'/>";}?></td>
      </tr> 
	  <tr align="center" bgcolor="#799AE1">
        <td width="20%" align="right" class=txlHeaderBackgroundAlternate>其他说明：如配送时间等</td>
		<td width="80%" align="left" class=txlrow><?php if($_GET['id']==$unex[0]){echo "<textarea name='beizhu'  rows='5' cols='30' style='border: 1 solid #888888;LINE-HEIGHT:18px;padding: 3px;'>".$row['beizhu']."</textarea>";}else{echo $row['beizhu'];}?></td>
      </tr> 
	  <tr align="center" bgcolor="#799AE1">
        <td width="20%" align="right" class=txlHeaderBackgroundAlternate>营业状态</td>
		<td width="80%" align="left" class=txlrow><?php if($_GET['id']==$unex[0]){?><select name='state'><option value='1' <?php if($o==1) {echo "selected";}?>>自行电话订餐<option value='0'<?php if($o==0) {echo "selected";}?>>打烊休息中<option value='2'<?php if($o==2){echo "selected";}?>>支持在线订餐<?php
		}else{echo $state;}?></td>
      </tr> 
	  <tr align="center" bgcolor="#799AE1">
        <td width="20%" align="right" class=txlHeaderBackgroundAlternate>操作</td>
		<td width="80%" align="left" class=txlrow><?php if($_GET['id']==$unex[0]){echo "<input type=submit value='保存'/>";}else{echo "<a href='shopinfo.php?id=".$unex[0]."'>修改</a>";}?></td>
      </tr> 
	</tbody>
  </table>
  <?php if($_GET['id']==$unex[0]){echo "</form>";}?>

</body>
</html>