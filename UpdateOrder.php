<?php
include('./global.php');

$state   = $_GET['state'];
$orderid = $_GET['odid'];
$shopid  = $_GET['id'];

if($shopid==30)
{
    $print="<phead>ºÃÆæºº±¤</phead>";
}
if(!empty($state) && is_numeric($state))
{
	if(!empty($orderid)){
		$sql="update `wm_orders` set state='1' where `orderid`='$orderid' and shopid='$shopid' and state='0'";
		$result=$db->query($sql);
		if($result)
		{
			$print="<success></success>";	
		}
		else
		{
			$print="<error></error>";
		}
	}
	else{
		$print="<error></error>";
	}
} 
else 
{
	$print="<error></error>";
}
echo $print;

?>