<?php
include_once('./global.php');
$smarty->caching = false;
$mark = isset($_COOKIE['renrenid'])?1:0;
$smarty->assign('mark',$mark);
$smarty->display("footer.tpl");
?>