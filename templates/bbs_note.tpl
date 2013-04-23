<div id="content">
<link rel="stylesheet" type="text/css" href="./css/styles.css" />
<link rel="stylesheet" type="text/css" href="./javascript/fancybox/jquery.fancybox-1.2.6.css" media="screen" />

<script type="text/javascript" src="./javascript/jquery-ui.min.js"></script>
<script type="text/javascript" src="./javascript/fancybox/jquery.fancybox-1.2.6.pack.js"></script>
<script type="text/javascript" src="./javascript/script.js"></script>
<div style="float:left;width:958px; border-bottom:1px solid #ffccff; border-left:1px solid #ffccff; border-right:1px solid #ffccff">
	<span style="float:left; padding:5px 0px"><a id="addButton" class="green-button" href="add_note.html" style="font-size:0.825em;font-family:Arial, Helvetica, sans-serif;">Add a note</a></span>
    <span style="float:left; padding-top:10px; margin-left:10px">{$forum_name}</span>
</div>
<div id="main">
    <input type="hidden" id="forum_id" value="{$forum_id}" />
   
	{$notes}
</div>
</div>