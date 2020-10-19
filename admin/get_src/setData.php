<?php
  
class setData{
   function replaceBrand($num, $brand){
      $sql = sprintf("UPDATE `catalog` SET `brand` = %d WHERE `brand` = '%s';",
         mysql_real_escape_string($num),
         mysql_real_escape_string($brand));
   
	   return db_query($sql, __LINE__, __FILE__);
   }   
      
   function createNewCustomer($customer_direct_link)
   {
      $query_result = mysql_query("SELECT * FROM `customer_touch_system` WHERE `direct_link` = '{$customer_direct_link}';");
      
      if (mysql_num_rows($query_result) == 0)
      {
         $sql = sprintf("INSERT INTO `customer_touch_system` (`direct_link`, `timestamp`) VALUES ('%s', '%s');",
            mysql_real_escape_string($customer_direct_link),
            mysql_real_escape_string(time()));
	   
	      return db_query($sql, __LINE__, __FILE__);
      }
      else return 1;
   }
   
   function createNewHotUser($user_direct_link, $vk_name) //javascript:location.href="http://app.po-sportu.ru/admin/get.php?act=addHotUser&link="+document.URL+"&name="+document.getElementById('title').textContent
   {
      $query_result = mysql_query("SELECT * FROM `hot_system` WHERE `direct_link` = '{$user_direct_link}';");
      
      if (mysql_num_rows($query_result) == 0)
      {
         $sql = sprintf("INSERT INTO `hot_system` (`vk_name`, `direct_link`, `doubt_reason`, `planning_purchase_date`, `timestamp`) VALUES ('%s', '%s', '%s', '%s', '%s');",
            mysql_real_escape_string($user_direct_link),
            mysql_real_escape_string($user_direct_link),
            mysql_real_escape_string("null"),
            mysql_real_escape_string("null"),
            mysql_real_escape_string(time()));
	   
	      return db_query($sql, __LINE__, __FILE__);
      }
      else return 1;
   }
}

?>
