<?php
@session_start();
include "../global.php";

if (empty($_SESSION['uname'])){
	header("location:login.php");exit();
}
$unex=explode('|',$_SESSION['uname']);
$sid=$unex[0];

$dinid=empty($_GET['dinid'])?$_POST['dinid']:$_GET['dinid'];

if($_SERVER['REQUEST_METHOD']=='POST')
{        
	if($_POST['dinid']){
	   if($_POST['myFilePath'])
	   {
		   $query="update wm_dininfo set dinname='$_POST[name]', dintype='$_POST[type]',dinprice='$_POST[price]', dinimage='$_POST[myFilePath]',isellout='$_POST[isell]', beizhu = '$_POST[intro]' where dinid='$_POST[dinid]'";}
	   else
	   {
		$query="update wm_dininfo set dinname='$_POST[name]', dintype='$_POST[type]',dinprice='$_POST[price]',isellout='$_POST[isell]' , beizhu = '$_POST[intro]' where dinid='$_POST[dinid]'";}
	}else
	{
		$query = "insert into wm_dininfo values('','$sid','$_POST[name]','$_POST[type]','$_POST[price]','$_POST[myFilePath]','1','','$_POST[intro]')";
	}
	$result = $db->query($query);		
	if($result){
		echo "<IMG height=13 src=\"images/tick.png\" width=16 align=absMiddle />保存成功";}else{echo "<IMG height=13 src=\"images/cross.png\" width=16 align=absMiddle />保存失败";
	}
}
$array   = get_din_details($db,$dinid);
$typearr = getcategory($db,$sid,1);
?>
<html>
<head>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link href="css/uploadify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../jcart/jquery-1.5.1.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#fileInput2").uploadify({
		'uploader' : 'js/uploadify.swf',//所需要的flash文件
		'cancelImg': 'js/cancel.png',//单个取消上传的图片
		'script'   : 'js/uploadify.php',//实现上传的程序
		'folder'   : 'uploads',//服务端的上传目录
		//'auto': true,//自动上传
		//'multi': true,//是否多文件上传
		//'checkScript': 'js/check.php',//验证 ，服务端的
		'displayData': 'speed',//进度条的显示方式
		'fileDesc' : 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
		'fileExt'  : '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
		//'sizeLimit': 999999 ,//限制上传文件的大小
		//'simUploadLimit' :3, //并发上传数据 
		'queueSizeLimit' :1, //可上传的文件个数
		//'buttonText' :'文件上传',//通过文字替换钮扣上的文字
		'buttonImg': 'js/browseBtn.png',//替换上传钮扣
		'width'    : 90,//buttonImg的大小
		'height'   : 34,//
		'rollover' : false,//button是否变换
		onComplete : function (evt, queueID, fileObj, response, data) {
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
	function isOK()
	{	 
		if(document.form2.name.value==""){
			alert("请输入商品名称！");document.form2.name.focus('');return false;
		}else if(document.form2.type.value==" "){
			alert("请选择商品类型！");return false;
		}
		else if(document.form2.price.value==""){
		alert("请输入商品价格！");return false;
		}
	}
</script>
</head>
<body>
<fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">
		<legend> <strong> 商品图片上传</strong></legend>
		<div>	
			<input id="fileInput2" name="fileInput2" type="file" /> <font color="#FF0000"><strong>注意:上传图片大小不能超过100kb</strong></font>
			<input type="button" value="确定上传" onClick="javascript:$('#fileInput2').uploadifyUpload();">
			<!--<a href="javascript:$('#fileInput2').uploadifyClearQueue();">清除上传列表</a>--></div>
	<p></p>
</fieldset>
<form name="form2" action="adddin.php"  method="post" onSubmit="return isOK();">
  <table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=7 style="height: 23px">商品添加</th>
      </tr>
	  <tr bgcolor="#DEE5FA">
        <td colspan="7" align="center" class=txlrow><font color="#FF0000"><strong>注意：商品图片可以不上传 其他的信息为必填选项</strong></font></td>
      </tr>
      <tr align="center" bgcolor="#799AE1">
	  <?php if($dinid){echo "<td width=\"10%\"  align=\"center\" class=txlHeaderBackgroundAlternate>是否预售</td>";}?>
        <td width="10%"  align="center" class=txlHeaderBackgroundAlternate>商品名称</td>
        <td width="10%"  align="center" class=txlHeaderBackgroundAlternate>商品类型</td>
        <td width="10%"  align="center" class=txlHeaderBackgroundAlternate>商品价格</td>
		<td width="20%"  align="center" class=txlHeaderBackgroundAlternate>商品图片</td>
        <td width="40%"  align="center" class=txlHeaderBackgroundAlternate>商品简介</td>
		<td align="center" class=txlHeaderBackgroundAlternate>操作</td>
      </tr>  
	  <tr align="center" bgcolor="#799AE1">
	    <?php if($dinid){?><td width="10%"  align="center" class="txlRow"><select name="isell"><option value="1" <?php if($array['isellout']==1) {echo "selected='selected'";}?>>接受预售<option value="0" <?php if($array['isellout']==0){echo "selected='selected'";}?>>已售完</select></td></option><?php }?>
        <td width="20%"  align="center" class=txlrow><?php if($dinid){echo "<input type='text' name='name' size='20' value='".$array['dinname']."'/>";echo "<input type='hidden' name='dinid' value='".$array['dinid']."'/>";}else{echo "<input type='text' name='name' size='20' maxlength='18'/>";}?></td>
		
        <td width="20%"  align="center" class=txlrow>
		<select name="type">
		
		<?php foreach($typearr as $row){?>
		<option value="<?php echo $row['id'];?>" <?php if($dinid){if(($array['dintype'])==$row['id']){echo "selected";}}else{if(($_POST['type'])==$row['id']){echo "selected";}}?>>
		<?php echo $row['dintype']; }?>
		
		
		</select>
		</td>
        <td width="10%"  align="center" class=txlrow><?php if($dinid){echo "<input type='text' name='price' size='10'  onBlur='checkNum(this)' onKeyUp='clearNoNum(event,this)' onselectstart='return false' onpaste='return false' value='".$array['dinprice']."'/>";}else{ echo "<input type='text' name='price' size='10'  onBlur='checkNum(this)' onKeyUp='clearNoNum(event,this)' onselectstart='return false' onpaste='return false' />";}?></td>
		<td width="20%"  align="center" class=txlrow><div id="divTxt" style="display:none"></div></td>
        <td width="20%"  align="center" class=txlrow><textarea name="intro" cols="40" rows="5"><?php echo $array['beizhu']?></textarea></td>
		<td width="20%"  align="center" class=txlrow><input type="submit" value="保存"/></td>
      </tr>  
	 
	</tbody>
  </table>
</form>
</body>
</html>