<?php
include_once (dirname(__FILE__).'/config/config.php');
include_once (dirname(__FILE__).'/common/smarty/Smarty.class.php');
include_once (dirname(__FILE__).'/common/mysql.class.php'); 
include_once (dirname(__FILE__).'/common/common.fns.php');


//$db = new mysql($mydbhost, $mydbuser, $mydbpw, $mydbname, ALL_PS, $mydbcharset);
$db = new PDO("mysql:host=$mydbhost;dbname=$mydbname", $mydbuser, $mydbpw);
$db->query("set names gb2312");
//********smarty**********

$smarty = new smarty();
$smarty->template_dir	= $smarty_template_dir;
$smarty->compile_dir	= $smarty_compile_dir;
$smarty->config_dir	    = $smarty_config_dir;
$smarty->cache_dir	    = $smarty_cache_dir;
$smarty->caching	    = $smarty_caching;
$smarty->left_delimiter = $smarty_delimiter[0];
$smarty->right_delimiter= $smarty_delimiter[1];
$smarty->cache_lifetime = $smarty_cache_lifetime;

?>