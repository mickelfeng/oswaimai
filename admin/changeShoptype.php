<?php
include "../global.php";
$tag = $_POST['tag'];
$shopid = $_POST['shopid'];
echo $sql="update `wm_shopinfo` set `shoptype`='$tag' where `shopid`='$shopid'";
$db->exec($sql);
?>