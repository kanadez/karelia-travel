<?php
  
class GetData{
   function getNearestSettlment(){
      $result = db_fetchone_array("SELECT `value` FROM `parameters` WHERE `parameter` = 'nearest_settlment_timestamp';", __LINE__, __FILE__);
      
      return $result["value"];
   }
   
   function getContacts(){
      $sql = "SELECT * FROM `contacts`;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   function getExtra(){
      $sql = "SELECT `value` FROM `parameters` WHERE `parameter` = 'extra_content';";
      $result = db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["value"];
   }
   
   function getHousing(){
      $sql = "SELECT * FROM `housing`;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   function getPrices(){
      $sql = "SELECT * FROM `pricelist`;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
}

?>
