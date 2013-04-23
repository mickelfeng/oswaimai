<div id="content">
<script type="text/javascript" src="./javascript/jquery.validate.js"></script>
<script type="text/javascript" src="./javascript/register.js"></script>
<link rel="stylesheet" href="css/register.css" type="text/css" />
<!--注册标题开始-->
<DIV style="PADDING-TOP: 15px" class=reg_main>
    <H1>个人用户注册</H1>
    <SPAN style="COLOR: #999">温馨提示：注册成功就能得到200积分哦！</SPAN> 
</DIV>
<!--注册标题结束-->

<!--主体开始-->
<DIV class=reg_main><!--注册信息填写开始-->
<FORM id=frmRegister method=post name=frmRegister action="">
<DIV class=reg_left>
<DIV>
<TABLE style="FLOAT: left" border=0 cellSpacing=0 cellPadding=0 width=340>
  <TBODY>

  <TR>
    <TD style="FONT-SIZE: 13px" height=38 width=88 align=right><STRONG>用户名称</STRONG>:</TD>
    <TD height=38 width=252><INPUT class=reg_inp name=username></TD>
  </TR>
  </TBODY>
</TABLE>
</DIV>

<DIV>
<TABLE border=0 cellSpacing=0 cellPadding=0 width=340>

  <TBODY>
  <TR>
    <TD style="FONT-SIZE: 13px" height=38 width=87 align=right><STRONG>用户密码</STRONG>:</TD>
    <TD height=38 width=253><INPUT id=pwd class=reg_inp type=password name=pwd> </TD>
  </TR>
  </TBODY>
</TABLE>
</DIV>

<DIV>
<TABLE border=0 cellSpacing=0 cellPadding=0 width=340>
  <TBODY>
  <TR>
    <TD style="FONT-SIZE: 13px" height=38 width=87 align=right><STRONG>确认密码</STRONG>:</TD>
    <TD height=38 width=253><INPUT class=reg_inp type=password name=rpwd></TD>
  </TR>
  </TBODY>

</TABLE>
</DIV>

<DIV>
<TABLE border=0 cellSpacing=0 cellPadding=0 width=340>
  <TBODY>
  <TR>
    <TD style="FONT-SIZE: 13px" height=38 width=87 align=right><STRONG>电子邮件</STRONG>:</TD>
    <TD height=38 width=253><INPUT id=email class=reg_inp name=email></TD>
  </TR>

  </TBODY>
</TABLE>
</DIV>

<TABLE border=0 cellSpacing=0 cellPadding=0 width=340>
  <TBODY>
  <TR>
    <TD style="FONT-SIZE: 13px" height=38 width=87 align=right>&nbsp;</TD>
    <TD style="COLOR: #000; FONT-SIZE: 13px" height=38 width=253>
	<INPUT style="MARGIN-LEFT: 18px" id=chkAgreement CHECKED type=checkbox> 我已阅读并同意 
    <A class=bluel href="register_agreement.html" target=_blank>我饿啦服务条款</A>

	</TD>
  </TR>
  </TBODY>
</TABLE>

<TABLE border=0 cellSpacing=0 cellPadding=0 width=340>
  <TBODY>
  <TR>
    <TD style="FONT-SIZE: 13px" height=38 width=87 align=right>&nbsp;</TD>
    <TD style="COLOR: #000; FONT-SIZE: 13px" height=38 width=253>

	<LABEL><INPUT id=btnReg class=reg_btn value=注册 type=submit> </LABEL>
	</TD>
  </TR>
  </TBODY>
</TABLE>
</DIV>
</FORM>
<!--注册信息填写开始--><!--间隔线开始-->
<DIV class=reg_line></DIV><!--间隔线结束-->
<!--申请登陆开始-->
<DIV class=reg_log><STRONG>已是会员？</STRONG> 
<A class=bluel href="javascript:showloginbox()"><STRONG>请登录</STRONG></A>
</DIV>
<!--申请登陆结束-->
</DIV><!--主体结束-->
</div>