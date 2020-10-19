<?php
  
class SetData{
   function deleteTourPhoto($id){
      $sql = sprintf("UPDATE `photo` SET `deleted` = 1 WHERE `id` = %d;",
            mysql_real_escape_string($id));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function deleteTourSettlement($id){
      $sql = sprintf("UPDATE `settlement` SET `deleted` = 1 WHERE `id` = %d;",
            mysql_real_escape_string($id));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function setTourSettlement($tour, $timestamp){
      $sql = sprintf("INSERT INTO `settlement` (`tour`, `timestamp`) VALUES (%d, %d);",
            mysql_real_escape_string($tour),
            mysql_real_escape_string($timestamp));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function deliverySetBDMsg($msg){
      $sql = sprintf("UPDATE `content` SET `value` = '%s' WHERE `parameter` = 'happybirtday_msg';",
            mysql_real_escape_string($msg));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function deleteConfirmedOrder($num){
      $sql = sprintf("UPDATE `cart` SET `deleted` = 1 WHERE `id` = %d;",
            mysql_real_escape_string($num));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function saveAboutContent($data){
      $sql = sprintf("UPDATE `content` SET `value` = '%s' WHERE `parameter` = 'company_info' AND page = 'about';",
         mysql_real_escape_string($data));
      db_query($sql, __LINE__, __FILE__);
         
      return json_encode($data);
   }
   
   function saveContent($page, $data){
      $sql22 = "";
      $data = json_decode(stripcslashes($data), true);
      
      for ($i = 0; $i < count($data); $i++){
         $sql = sprintf("UPDATE `content` SET `value` = '%s' WHERE `parameter` = '%s' AND page = '%s';",
            mysql_real_escape_string($data[$i]["value"]),
            mysql_real_escape_string($data[$i]["parameter"]),
            mysql_real_escape_string($page));
         db_query($sql, __LINE__, __FILE__);
         
      }
      
      return json_encode($data);
   }
   
   function confirmNewOrder($num){
      $sql = sprintf("SELECT `email`, `tour` AS `tour_id`, (SELECT `tour`.`title` FROM `tour` WHERE `tour`.`id` = `cart`.`tour`) AS `tour_name` FROM `cart` WHERE `id` = %d",
         mysql_real_escape_string($num));
      $result = db_fetchone_array($sql, __LINE__, __FILE__);
      $email =  $result["email"];
      $tour_id =  $result["tour_id"];
      $tour_name =  $result["tour_name"];
      
      $sql = sprintf("UPDATE `cart` SET `confirmed` = 1 WHERE `id` = %d",
         mysql_real_escape_string($num));
	   db_query($sql, __LINE__, __FILE__);
	   
	   $this->sendEmail($email, 
         "Подтверждение заказа тура на karelia-travel.pro", 
         "Уважаемый клиент!
         <p>Это письмо сформировано автоматически, отвечать на него не нужно!
         <br>Сделанный Вами ранее заказ тура <a href='http://karelia-travel.pro/tour.php?id=$tour_id'>$tour_name</a> на сайте karelia-travel.pro был подтверждён.
         <p>Если Вы не совершали никаких заказов, просто проигнорируйте это письмо.
         <p>С уважением, компания Karelia Travel."
      );
      
      return 1;
   }
   
   public function delivery($subject, $message){
      $complete_result = 1;
      
      $sql = "SELECT `email` FROM `emaildb`";
      $email_array = db_fetchall_array($sql, __LINE__, __FILE__);
      
      for ($i = 0; $i < count($email_array); $i++)
         $complete_result *= $this->sendEmail($email_array[$i]["email"], $subject, $message);
         
      return $complete_result;
   }
   
   public function sendEmail($to, $subject, $message){
      $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
      $headers .= "From: Karelia Travel <noreply@karelia-travel.pro>\r\n";
      
      return mail($to, $subject, $message, $headers);
   }
   
   function addTour($name, $price, $group){
      $sql = sprintf("INSERT INTO `tour` (`title`, `price`, `group`, `start_date`, `end_date`) VALUES ('%s', '%s', %d, %d, %d);",
            mysql_real_escape_string($name),
            mysql_real_escape_string($price),
            mysql_real_escape_string($group),
            mysql_real_escape_string(time()),
            mysql_real_escape_string(time()));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function saveTour($title, $short_description, $full_description, $route, $price, $price_description, $start_date, $end_date, $hot, $id){
      $sql = sprintf("UPDATE `tour` SET 
               `title` = '%s', 
               `short_description` = '%s', 
               `full_description` = '%s', 
               `route` = '%s', 
               `price` = %d,
               `price_description` = '%s',
               `start_date` = %d,
               `end_date` = %d,
               `hot` = %d WHERE `id` = %d;",
            mysql_real_escape_string($title),
            mysql_real_escape_string($short_description),
            mysql_real_escape_string($full_description),
            mysql_real_escape_string($route),
            mysql_real_escape_string($price),
            mysql_real_escape_string($price_description),
            mysql_real_escape_string($start_date),
            mysql_real_escape_string($end_date),
            mysql_real_escape_string($hot),
            mysql_real_escape_string($id));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function saveTourGroupName($id, $newname){
      $sql = sprintf("UPDATE `group` SET `title` = '%s' WHERE `id` = %d;",
            mysql_real_escape_string($newname),
            mysql_real_escape_string($id));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function saveTourGroupDesc($id, $newdesc){
      $sql = sprintf("UPDATE `group` SET `short_description` = '%s' WHERE `id` = %d;",
            mysql_real_escape_string($newdesc),
            mysql_real_escape_string($id));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function deleteTour($id){
      $sql = sprintf("UPDATE `tour` SET `deleted` = 1 WHERE `id` = %d;",
            mysql_real_escape_string($id));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
   function deleteTourGroup($id){
      $sql = sprintf("UPDATE `group` SET `deleted` = 1 WHERE `id` = %d;",
            mysql_real_escape_string($id));
	   db_query($sql, __LINE__, __FILE__);
	   
	   $sql = sprintf("UPDATE `tour` SET `deleted` = 1 WHERE `group` = %d;",
            mysql_real_escape_string($id));
	   db_query($sql, __LINE__, __FILE__);
	   
	   return 1;
   }
   
   function addTourGroup($title){
      $sql = sprintf("INSERT INTO `group` (`title`) VALUES ('%s');",
            mysql_real_escape_string($title));
	   
	   return db_query($sql, __LINE__, __FILE__);
   }
   
}

?>
