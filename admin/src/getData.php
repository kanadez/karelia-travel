<?php
  
class GetData{ // класс, получает данные с сервера и передаёт клиенту, в админку
   function getTourSettlement($tour){
      $tour = intval($tour);
      
      $sql = "SELECT * FROM `settlement` WHERE `tour` = $tour AND `deleted` = 0;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }

   function deliveryGetBDMsg(){
      $sql = "SELECT `value` FROM `content` WHERE `parameter` = 'happybirtday_msg';";
      $hbd_msg = db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $hbd_msg["value"];
   }

   function getEmailDB(){
      $sql = "SELECT * FROM `emaildb`;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }

   function getPaymentData(){
      $sql = "SELECT `parameter`, `value` FROM `content` WHERE `page` = 'payment';";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }

   function getAboutData(){
      $sql = "SELECT `parameter`, `value` FROM `content` WHERE `page` = 'about';";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   function getMainPageData(){
      $sql = "SELECT `parameter`, `value` FROM `content` WHERE `page` = 'mainpage';";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   function getNewOrders(){
      $sql = "SELECT `id`, `tour` AS `tour_id`,(SELECT `tour`.`title` FROM `tour` WHERE `tour`.`id` = `cart`.`tour`) AS `tour_title`, `client_data`, `phone`, `email`, `total`, `order_timestamp`, `settlement_timestamp`, `payment_status` FROM `cart` WHERE `confirmed` = 0 AND `deleted` = 0 ORDER BY `order_timestamp` DESC;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   function getConfirmedOrders(){
      $sql = "SELECT `id`, `tour` AS `tour_id`,(SELECT `tour`.`title` FROM `tour` WHERE `tour`.`id` = `cart`.`tour`) AS `tour_title`, `client_data`, `phone`, `email`, `total`, `order_timestamp`, `settlement_timestamp`, `payment_status` FROM `cart` WHERE `confirmed` = 1 AND `deleted` = 0 ORDER BY `order_timestamp` DESC;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }

   function getTour($id){
      $_id = intval($id);
      $sql = "SELECT * FROM `tour` WHERE `id` = $_id;";
      $result = db_fetchone_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   function getTourGallery($id){
      $_id = intval($id);
      $sql = "SELECT * FROM `photo` WHERE `tour` = $_id AND `deleted` = 0;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }

   function getTourGroups(){
      $sql = "SELECT * FROM `group` WHERE `deleted` <> 1;";
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   function getTourGroupData($id){
      $sql = sprintf("SELECT * FROM `tour` WHERE `deleted` <> 1 AND `group` = %d;",
            mysql_real_escape_string($id));
      $result = db_fetchall_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   function getTourGroupName($id){
      $sql = sprintf("SELECT `title`, `short_description`, `image` FROM `group` WHERE `id` = %d;",
            mysql_real_escape_string($id));
      $result = db_fetchone_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
}

?>
