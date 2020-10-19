<?php

class User{
   public function loginVK($id){
      global $db;
      
      $sql = sprintf("SELECT `id` FROM `user` WHERE `vk_id` = %d;",
         mysql_real_escape_string($id));
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      //return count($result);
      
      if (count($result) != 0){
         $_SESSION['user'] = $result["id"];
         $_SESSION['user_sn'] = 1;
         
         return 1;
      }
      else{
         $sql = sprintf("INSERT INTO `user` (`vk_id`, `timestamp`) VALUES (%d, %d);",
         mysql_real_escape_string($id),
         mysql_real_escape_string(time()));
         $db->db_query($sql, __LINE__, __FILE__);
         $_SESSION['user_sn'] = 1;
         $_SESSION['user'] = mysql_insert_id();
         
         return 1;
      }
   }
   
   public function loginOK($id){
      global $db;
      
      $sql = sprintf("SELECT `id` FROM `user` WHERE `ok_id` = %d;",
         mysql_real_escape_string($id));
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      //return count($result);
      
      if (count($result) != 0){
         $_SESSION['user'] = $result["id"];
         $_SESSION['user_sn'] = 1;
         
         return 1;
      }
      else{
         $sql = sprintf("INSERT INTO `user` (`ok_id`, `timestamp`) VALUES (%d, %d);",
         mysql_real_escape_string($id),
         time());
         $db->db_query($sql, __LINE__, __FILE__);
         $_SESSION['user_sn'] = 1;
         $_SESSION['user'] = mysql_insert_id();
         
         return 1;
      }
   }
}

?>