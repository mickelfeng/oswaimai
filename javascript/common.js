var welwm= new Object();

welwm.centerLayer = function(layerId) {
	var layer = document.getElementById(layerId);
	var lw = layer.offsetWidth;
	var lh = layer.offsetHeight;
	var cw = document.documentElement.clientWidth == 0 ? document.body.clientWidth : document.documentElement.clientWidth;
	var ch = document.documentElement.clientHeight == 0 ? document.body.clientHeight : document.documentElement.clientHeight;
	var scrollTop=document.documentElement.scrollTop ==0?document.body.scrollTop : document.documentElement.scrollTop;
	var ll = ((cw/2) - (lw/2))+"px";
	var lt = (scrollTop+(ch/2) - (lh/2)) +"px";
	with(layer.style) {
		position = "absolute";
		left = ll;
		top = lt;
	}
	window.onscroll = function() {
		welwm.centerLayer(layerId);
	}

}

function showbox()
{
    
	//$("#alpha_bg").css({"height":document.body.scrollHeight,"width":document.body.scrollWidth-1});
	//$("#alpha_bg").show();
	$.ajax({
			type: "POST",
			dataType : "text",
			async : false,
			url: "./checkdata/getBuilding.php",
			success: function(res){
				$('#select_box').html(res);
				$('#dialog').show();
				welwm.centerLayer("dialog");
			},
			error : function(res,msg,err) {
				//alert(msg);
			}
		});
}
function showloginbox()
{
	$('#loginbox').show();
	welwm.centerLayer("loginbox");
}

function hidebox(id)
{
	$('#'+id).hide();
}
function showbul(id,typeid)
{
	$("."+typeid).css("color","black").css("font-weight","normal");
	$("#"+id).css("color","#F30").css("font-weight","bold");
	$(".build").hide();
	$("."+id).show();
}

function SetCookie(name,value,expires,path,domain,secure)
{
var expDays = expires*24*60*60*1000;
var expDate = new Date();
expDate.setTime(expDate.getTime()+expDays);
var expString = ((expires==null) ? "" : (";expires="+expDate.toGMTString()))
var pathString = ((path==null) ? "" : (";path="+path))
var domainString = ((domain==null) ? "" : (";domain="+domain))
var secureString = ((secure==true) ? ";secure" : "" )
document.cookie = name + "=" + escape(value) + expString + pathString + domainString + secureString;
}

function delCookie(name)
{
var ThreeDays=3*24*60*60*1000;
var expDate = new Date();
expDate.setTime(expDate.getTime()-ThreeDays);
document.cookie=name+"=;expires="+expDate.toGMTString();
}