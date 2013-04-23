<div id="content">

{section name=tag loop=$promotions}
<div style="float:left; width:660px; border-bottom:1px dotted #e7e7e7; min-height:20px; padding:10px">
<span><a href='showshop.php?shopid={$promotions[tag].shopid}'><font color='#0099cc' size='3'>
{$promotions[tag].shopname}</font></a>
 ½ØÖ¹ÈÕÆÚ£º{$promotions[tag].yhdate}</span>
<div style='clear:both;'>{$promotions[tag].yhcontent}</div>
</div>
{/section}
</div>