<?php
  
class SetData{
   function reserve($client_data){
      $sql = sprintf("INSERT INTO `cart` (`client_data`, `timestamp`) VALUES ('%s', %d);",
         mysql_real_escape_string($client_data),
         mysql_real_escape_string(time()));
         
      return db_query($sql, __LINE__, __FILE__);
   }
}

?>
