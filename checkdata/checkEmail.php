<?php
 include('../global.php');
 $u=$_POST['email'];
 $query = "select * from wm_admin_c where email='".$u."'";
 
 $row = $db->query($query)->rowCount();
  
 echo $row?0:1;
?>
