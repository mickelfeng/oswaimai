<?php
include_once('./global.php');

include "./header.php";
$id=(int)$_GET['id'];
if(empty($id))exit;
$forum_name = $db->query("SELECT `forum_name` FROM `wm_bbs_forums` WHERE `forum_id`='".$id."'")->fetchColumn();

$results = $db->query("SELECT * FROM wm_bbs_notes where forum_id = '".$id."' ORDER BY id DESC")->fetchall();

$notes = '';
$left='';
$top='';
$zindex='';

foreach($results as $row)
{
	// The xyz column holds the position and z-index in the form 200x100x10:
	list($left,$top,$zindex) = explode('x',$row['xyz']);
	$notes.= '<div class="note '.$row['color'].'" style="left:'.$left.'px;top:'.$top.'px;z-index:'.$zindex.'">'.htmlspecialchars($row['text']).'<div class="author">'.htmlspecialchars($row['name']).'</div><span class="data">'.$row['id'].'</span></div>';
}

$smarty->assign("forum_id",$_GET['id']);
$smarty->assign("forum_name",$forum_name);
$smarty->assign('notes',$notes);
$smarty->display("bbs_note.tpl");
include "./footer.php";
?>