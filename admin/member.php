<link rel="stylesheet" href="./css/main.css" type="text/css" />
<link rel="stylesheet" href="./css/paginate.css" type="text/css" />

<?php
@session_start();
if(!$_SESSION['uname']){
	header("location:./index.php");exit();
}
include "../global.php";
include("pagination3.php");
$rpp    = 26; // results per page
$page   = intval($_GET['page']);

//获取记录总数
if(!$_GET['tpages'])
{
	$count = $db->query("SELECT count( `id` ) FROM `wm_admin_c`")->fetchColumn();
	$tpages = ($count) ? ceil($count/$rpp) : 1;// total pages, last page number
}else{
	$tpages = $_GET['tpages'];
}
$adjacents  = intval($_GET['adjacents']);
if($page<=0)  $page  = 1;
if($adjacents<=0) $adjacents = 2;
$reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
$from = ($page-1)*$rpp;
$members = $db->query("SELECT * FROM `wm_admin_c` limit $from,$rpp")->fetchall();
?>
<table  width="100%" border=0 align=center cellpadding=2 cellspacing=1 bordercolor="#799AE1" class=tableBorder>
    <tbody>
      <tr>
        <th align=center colspan=4 style="height: 23px">会员信息</th>
      </tr>
	   <tr bgcolor="#DEE5FA">
        <td align="center" colspan="4" align="center" class=txlrow>
        <font color="#FF0000"><?php echo paginate_three($reload, $page, $tpages, $adjacents);?></font>
        </td>
      </tr>
      <tr bgcolor="#799AE1">
        <td width="25%" class=txlHeaderBackgroundAlternate>会员昵称</td>
        <td width="25%" class=txlHeaderBackgroundAlternate>Email</td>
		<td width="25%" class=txlHeaderBackgroundAlternate>注册时间</td>
        <td width="25%" class=txlHeaderBackgroundAlternate>会员积分</td>
      </tr>
      <?php
	  foreach($members as $mem)
	  {?>
      <tr>
      <td class=txlrow><?php echo $mem['nickname'];?></td>
      <td class=txlrow><?php echo $mem['email'];?></td>
      <td class=txlrow><?php echo $mem['regdate'];?></td>
      <td class=txlrow><?php echo $mem['jifen'];?></td>
      </tr>  
	  <?php
      }
	  ?>
</tbody>
</table>