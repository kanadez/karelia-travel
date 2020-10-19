<?php

class About{
   public function getAboutData(){
      global $db;
      
      $sql = "SELECT `data_value` FROM `about` WHERE `data_type` = 'about_company';";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["data_value"];
   }
   
   public function getContact($type){
      global $db;
      
      $sql = "SELECT `data_value` FROM `about` WHERE `data_type` = '$type';";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["data_value"];
   }
}

?>