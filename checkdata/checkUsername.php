<?php
 include('../global.php');
 $u=$_POST['username'];
 is_utf8($u)?$name=iconv('utf-8','gb2312',$u):$name=$u;

 $query = "select * from wm_admin_c where nickname='".$name."'";
 $row = $db->query($query)->rowCount(); 
 echo $row?0:1;
 
  function is_utf8($word) 
  { 
        return preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word) == true?true:false;
  } 
?>