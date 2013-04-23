<?php

function db_connect() {
   if($_SERVER['REMOTE_ADDR']=="127.0.0.1"){
   $result = new mysqli('localhost', 'root', '', 'welwm');
   }else{
   $result = new mysqli('localhost', 's525071db0', '8t68u79z', 's525071db0');
   }
   if (!$result) {
      return false;
   }
   $result->query("set names gb2312");
   
   //$result->autocommit(TRUE);
   return $result;
}

function db_result_to_array($result) {
   $res_array = array();

   for ($count=0; $row = $result->fetch_assoc(); $count++) {
     $res_array[$count] = $row;
   }

   return $res_array;
}

?>
