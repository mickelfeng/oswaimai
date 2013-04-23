<?php
// Error reporting
include('../global.php');

// Checking whether all input variables are in place:
if(!is_numeric($_POST['zindex']) || !isset($_POST['author']) || !isset($_POST['body']) || !in_array($_POST['color'],array('yellow','green','blue')))
die("0");

if(ini_get('magic_quotes_gpc'))
{
	// If magic_quotes setting is on, strip the leading slashes that are automatically added to the string:
	$_POST['author']=stripslashes($_POST['author']);
	$_POST['body']=stripslashes($_POST['body']);
}

// Escaping the input data:

//$author = iconv('utf-8','gb2312',strip_tags($_POST['author']));
//$body   = iconv('utf-8','gb2312',strip_tags($_POST['body']));
$author = iconv('utf-8','gb2312',strip_tags($_POST['author']));
$body   = iconv('utf-8','gb2312',strip_tags($_POST['body']));
$color  = $_POST['color'];
$zindex = (int)$_POST['zindex'];
$forum  = (int)$_POST['forum_id'];


$usql="update `wm_bbs_forums` set `forum_numtopics`=`forum_numtopics`+1,`forum_lastpost_time`=now(),`forum_lastposter`='".$author."' WHERE `forum_id`='".$forum."'";
$db->query($usql);
/* Inserting a new record in the notes DB: */
$sql="INSERT INTO wm_bbs_notes (forum_id,text,name,color,xyz) VALUES ('".$forum."','".$body."','".$author."' , '".$color."' ,'0x0x".$zindex."')";

$db->query($sql);

echo (int)$db->lastInsertId();


?>