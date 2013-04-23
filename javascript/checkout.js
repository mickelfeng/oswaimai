
function isPhone(){
	var phone=document.mycheck.telphone.value;
	if(phone==""){alert("联系电话不能为空！如果有疑问请联系我：QQ：312181918");return false;}
	if(!(/^1[3|5|8][0-9]\d{8}$/.test(phone))){ 
    alert("你输入的手机号有误，请检查一下，谢谢！"); 
	document.mycheck.telphone.focus();
    return false; }
    return true;
	}
function isAddress(){
	var address=document.mycheck.address.value;
	if(address==""){alert("请输入配送地址，谢谢！");return false;}
    return true;
	}
function isOK()
{
	var mark = $('#mark').val()?0:1;
	if(mark)
	{
		if(checkForm() && isAddress() && isPhone())
		{
			$('#jcart-paypal-checkout').attr("disabled",true);
			return true;	
		}
		else
		{
			return false;
		}
	}
	else
	{
		alert("亲，请检查购物车中是否有离线店铺");
		return false;
	}
}
