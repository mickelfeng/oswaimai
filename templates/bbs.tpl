<div id="content">
{section name=tag loop=$row}
<div style="width:100%; min-height:20px;">
<b><font color=green style="font-size:12pt">{$row[tag].forum_name}</font></b>
</div>
<div style="width:100%; min-height:10px;background:url(./images/title_bg.gif)">
<table width=100%><tr><td width=5%></td><td width=65%>贴吧</td><td width=14%>帖子数</td><td width=16%>最后回复</td></tr></table>
</div>
<table width=100%>
{assign var='o' value=$row[tag].forum_id}
{section name=mark loop=$resultall[$o]}
<tr style='height:40px'>
<td width=5% style='border-bottom:1px dotted #CCC'>
<img src='./images/forum_new.gif'/>
</td>
<td width=65% style='font-size:11pt;border-bottom:1px dotted #CCC' >
<a href="./bbs_note.php?id={$resultall[$o][mark].forum_id}"><font style='color:blue'>{$resultall[$o][mark].forum_name}</font></a><br>
<font style='font-size:12px;color:#999'>
{$resultall[$o][mark].forum_desc}
</font>
</td>
<td width=14% style='border-bottom:1px dotted #CCC'>{$resultall[$o][mark].forum_numtopics}</td>
<td width=16% style='border-bottom:1px dotted #CCC'>{$resultall[$o][mark].forum_lastposter}<br>
<font color='#888888' style='font-size:11px'>{$resultall[$o][mark].forum_lastpost_time}</font></td>
</tr>
{/section}
</table>
{/section}
</div>