<?php
session_start();
header('Content-Type:text/html;charset=gb2312');
include "./global.php";
extract($_POST);
echo $sql="update `wm_saveshop` set `savetime`='$currentime' where `shopid`='$nextshop' and `username`='$_SESSION[email]';update `wm_saveshop` set `savetime`='$nextime' where `shopid`='$currentshop' and `username`='$_SESSION[email]'";
$db->query($sql);

?>
