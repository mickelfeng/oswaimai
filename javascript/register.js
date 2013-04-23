$(document).ready(function() {
	//检查用户名是否可用
	function existUsername(value) {
		var exist = false;
		$.ajax({
			type: "POST",dataType : "text",async : false,url: "./checkdata/checkUsername.php",
			data: {"username" : value},
			success: function(res){if(res == 1) {exist = true;}else if(res == 0) {exist = false;}},
			error : function(res,msg,err) {alert(msg);}
		});
		return exist;
	}
	function existEmail(value) {
		var exist = false;
		$.ajax({type: "POST",dataType : "text",async : false,url: "./checkdata/checkEmail.php",
			data: {"email" : value},
			success: function(res){if(res == 1) {exist = true;}else if(res == 0) {exist = false;}},
			error : function(res,msg,err) {alert(msg);}
		});
		return exist;
	}
	function testUsername(value) {
		return (/^[a-zA-Z][a-zA-Z0-9_]{1,19}$/.test(value)||/[\u4e00-\u9fa5]/.test(value))?true:false;
	}
		
	function testPassword(value) {
		return /^[0-9a-zA-Z]+$/.test(value);
	}
	function testOldpassword(value)
	{
		var exist = false;
		$.ajax({
			type: "POST",dataType : "text",async : false,url: "./checkdata/checkPassword.php",
			data: {"password" : value},
			success: function(res){if(res == 1) {exist = true;}else if(res == 0) {exist = false;}},
			error : function(res,msg,err) {alert(msg);}
		});
		return exist;
	}
	//添加自定义的验证方法
	$.validator.addMethod("username_exist", function(value) {return existUsername(value);}, "该用户名已被他人注册！");
	$.validator.addMethod("email_exist",    function(value) {return existEmail(value);}, "该昵称已被他人使用！");
	$.validator.addMethod("username_test",  function(value) {return testUsername(value);}, "用户名不符合要求！");
	$.validator.addMethod("password_test",  function(value) {return testPassword(value);}, "密码不能含有特殊字符");
	$.validator.addMethod("oldpassword_exist",  function(value) {return testOldpassword(value);}, "旧密码不正确");
	
	$("#frmRegister").validate({
		onkeyup:false,
		rules : {
			"username" : {required : true,minlength : 2,username_test:true,username_exist : true},
			"pwd" :      {required : true,minlength : 6,password_test:true},
			"rpwd" :     {required : true,minlength : 6,equalTo : "#pwd"},
			"email" :    {required : true,email : true,email_exist : true}
		},
		messages : {
			"username" : {required : "请输入用户名",minlength : "用户名长度至少2位"},
			"pwd"      : {required : "请输入密码",minlength : "密码长度至少为6位"},
			"rpwd"     : {required : "请输入确认密码",minlength : "确认密码长度至少为6位",equalTo : "请输入一致的密码"},
			"email"    : {required : "请输入电子邮箱",email : "请输入正确格式的邮件地址"}
		},
		errorPlacement: function(error, element) {
			//错误信息输出位置
        	error.appendTo(element.parent().parent().parent().parent().parent());
		}
	});
	
	$("#frmRegister").submit(function() {
		var chkAgreement = $("#chkAgreement");
		if(chkAgreement.attr("checked") != true) {
			alert("您必须同意用户注册协议才能进行注册！");
			return false;
		}
	});
	
	$("#editpwdForm").validate({
		onkeyup:false,
		rules : {
			"oldpwd" : {required : true,oldpassword_exist : true},
			"newpwd" : {required : true,minlength : 6,password_test:true},
			"rpwd" :   {required : true,equalTo : "#newpwd"}
		},
		messages : {
			"oldpwd" : {required : "请输入旧密码"},
			"newpwd" : {required : "请输入密码",minlength : "密码长度至少为6位"},
			"rpwd"   : {required : "请输入确认密码",equalTo : "请输入一致的密码"}
		},
		errorPlacement: function(error, element) {
			//错误信息输出位置
        	error.appendTo(element.parent());
		}
	});
	
	$("#editemailForm").validate({
		onkeyup:false,
		rules : {
			"password" : {required : true,oldpassword_exist : true},
			"newemail" : {required : true,email : true,email_exist : true}
		},
		messages : {
			"password" : {required : "请输入旧密码"},
			"newemail" : {required : "请输入电子邮箱",email : "请输入正确格式的邮件地址"}
		},
		errorPlacement: function(error, element) {
			//错误信息输出位置
        	error.appendTo(element.next());
		}
	});
	
	$("#kaidian").validate({
		onkeyup:false,
		rules : {
		"realname" : {required : true},
		"mobilephone":{ required:true,minlength : 11},
		"shopname":{required:true},
		"shopaddress":{required:true},
		"shopinfo":{required:true}
		
		},
		messages : {
		"realname" : {required : "请输入店主姓名"},
		"mobilephone":{ required:"请输入手机号码",minlength : "你输入的手机号不正确"},
		"shopname":{required:"请输入餐店名称"},
		"shopaddress":{required:"请输入餐店地址"},
		"shopinfo":{required:"请输入餐店简介"}
		},
		errorPlacement: function(error, element) {
		//错误信息输出位置
		error.appendTo(element.parent().parent().parent().parent().parent());
		}
		
	 });
	
});
