<?php
include('./global.php');
$sn1 = $_GET['sn1'];
if(!empty($sn1)&&$sn1!='')
{
    $sql="select * from `wm_shopinfo` where printid='$sn1' limit 0 , 1";
	$shop=$db->query($sql)->fetch();
	if(!empty($shop))
	{
	    $print="<custid>".$shop['shopid']."</custid><phead>".$shop['shopname']."</phead><ptimes>1</ptimes><pfree>25</pfree><pend>Œ“∂ˆ¿≤Õ‚¬Ù www.welwm.com</pend>";
	}
	else
	{
	    $print="<none></none>";
	}
}
else{
    $print="<error></error>";
}
echo $print;
?>