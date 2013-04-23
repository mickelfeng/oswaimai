</div>
<!--footer层开始-->
<div class="footer">
<div style="width:960px;border-bottom:1px dotted #e7e7e7; margin:0 auto; height:50px; margin-top:10px">
<font style="color:#F30">友情链接</font><br>
<ul>
<li>
<a href="http://kaiyuan.welwm.com/" target="_new">我饿啦</a>
</li>
<li>
<a href="http://www.zan0421.com/" target="_new">朝阳信息网</a>
</li>
<li>
<a href="http://www.youku.com" target="_new">优酷</a>
</li>
<li>
<a href="http://www.aifangxin.com" target="_new">爱房信</a>
</li>
</ul>
</div>
<ul style="width:960px; margin:0 auto">
<li><a href="./contact_us.php">联系我们</a> |</li>
<li><a href="./privacy.php">隐私安全</a> |</li>
<li><a href="./agreement.php">服务条款</a> |</li>
<li><a href="./wanted.php">诚聘英才</a> |</li>
<li><a href="./bbs.php">贴吧</a></li>
<li style="float:right">&copy;2010 - 2012 我饿啦 苏ICP备10045625</li>
<ul>
</div>
  <!--footer层结束-->
  <!--container层结束-->
{literal}
	<script type="text/javascript">
	addEventListener = function(element, type, handler) {
	  if (element.addEventListener) {
		element.addEventListener(type, handler, false);
	  } else if (element.attachEvent){
		handler._ieEventHandler = function () {
		  handler(window.event);
		};
		(element).attachEvent("on" + type, (handler._ieEventHandler));
	  }
	}
	</script>
{/literal}
{if $mark==1}
{literal}
	<script type="text/javascript">
    XN_RequireFeatures(["EXNML"], function()
    {
      XN.Main.init("fa0dc1c1d2624a9585910fc454a8c809", "/xd_receiver.html");
	  addEventListener(document.getElementById("feed_link"), "click", function() {
        XN.Connect.requireSession(sendFeed);
      });
    });
  </script>
	{/literal}
{else}
{literal}
 <script type="text/javascript">
    XN_RequireFeatures(["EXNML"], function()
    {
      XN.Main.init("fa0dc1c1d2624a9585910fc454a8c809", "/xd_receiver.html",{"ifUserConnected":"renrencookie.php"});
	  addEventListener(document.getElementById("feed_link"), "click", function() {
        XN.Connect.requireSession(sendFeed);
      });
    });
  </script>
{/literal}
{/if}
</body>
</html>