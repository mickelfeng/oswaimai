<?php
 session_start();
 include('../global.php');
 $p=$_POST['password'];

 $query = "select `password` from wm_admin_c where email='".$_SESSION['email']."'";
 $row = $db->query($query)->fetchColumn(); 
 echo md5($p.'welwm')==$row?1:0;
?>
