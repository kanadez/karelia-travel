<?php

class Cart{
   public function getCompleteData($order_id){
      global $db;
      $order_id = intval($order_id);
      
      $sql = "SELECT `user`, `tour` FROM `cart` WHERE `id` = $order_id";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      $user_id = $result["user"];
      $tour_id = $result["tour"];
      
      $sql = "SELECT `email` FROM `user` WHERE `id` = $user_id";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      $email = $result["email"];
      
      $sql = "SELECT `title` FROM `tour` WHERE `id` = $tour_id";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      $title = $result["title"];
      
      return array($email, $tour_id, $title);
   }
   
   public function getPaymentData($order){
      global $db;
      
      $order = intval($order);
      $sql = "SELECT `id`, `tour` AS `tour_id`,(SELECT `tour`.`title` FROM `tour` WHERE `tour`.`id` = `cart`.`tour`) AS `tour_title`, `total` AS `tour_price`, `client_data`, `phone`, `email`, `order_timestamp`, `settlement_timestamp` FROM `cart` WHERE `id` = $order;";
      return json_encode($db->db_fetchone_array($sql, __LINE__, __FILE__));
   }
   
   public function order($client_data, $date, $phone, $email, $tour, $user){
      global $db;
      $_user = $_SESSION["user"];
      $_tour = intval($tour);
      $password = uniqid();
      $password_hash = md5($password);
      
      $name_sql = "SELECT `title` FROM `tour` WHERE `id` = $_tour";
      $result = $db->db_fetchone_array($name_sql, __LINE__, __FILE__);
      $tour_name = $result["title"];
      
      $user_sql = "SELECT `id` FROM `user` WHERE `email` = '$email'";
      $user_result = $db->db_fetchone_array($user_sql, __LINE__, __FILE__);
      
      if (count($user_result) == 0){
         $sql = sprintf("INSERT INTO `user` (`email`, `passwd`, `timestamp`) VALUES ('%s', '%s', %d);",
         mysql_real_escape_string($email),
         mysql_real_escape_string($password_hash),
         mysql_real_escape_string(time()));
      
         $db->db_query($sql, __LINE__, __FILE__);
         $_user = mysql_insert_id();
         $msg = "Уважаемый клиент!
         <p>Это письмо сформировано автоматически, отвечать на него не нужно!
         <br>Вы сделали заказ тура <a href='http://karelia-travel.pro/tour.php?id=$_tour'>$tour_name</a> на сайте karelia-travel.pro.
         <p>Чтобы оплатить заказ: 
         <br>1) войдите в <a href='http://karelia-travel.pro/cart.php'>корзину</a>, введите свой адрес электронной почты ($email) и пароль $password<br>
         2) нажмите \"Оплатить\" напротив заказа
         <br>Далее мы свяжемся с Вами по телефону и проинструктируем касательно дальнейших действий.
         <p>Если Вы не совершали никаких заказов, просто проигнорируйте это письмо.
         <p>С уважением, компания Karelia Travel.";
      }
      else{
         $msg = "Уважаемый клиент!
         <p>Это письмо сформировано автоматически, отвечать на него не нужно!
         <br>Вы сделали заказ тура <a href='http://karelia-travel.pro/tour.php?id=$_tour'>$tour_name</a> на сайте karelia-travel.pro.
         <p>Чтобы оплатить заказ: 
         <br>1) войдите в <a href='http://karelia-travel.pro/cart.php'>корзину</a>, используя свой электронный адрес и пароль
         <br>2) нажмите \"Оплатить\" напротив заказа
         <br>Далее мы свяжемся с Вами по телефону и проинструктируем касательно дальнейших действий.
         <p>Если Вы не совершали никаких заказов, просто проигнорируйте это письмо.
         <p>С уважением, компания Karelia Travel.";
      }
      
      $sql = "SELECT `price` FROM `tour` WHERE `id` = $_tour";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      $tour_price = $result["price"];
      $client_data_decoded = json_decode(stripcslashes($client_data), true);
      $total = $tour_price*count($client_data_decoded);
      
      $sql = sprintf("INSERT INTO `cart` (`user`, `tour`, `client_data`, `phone`, `email`, `total`, `settlement_timestamp`, `order_timestamp`) VALUES (%d, %d, '%s', '%s', '%s', %d, %d, %d);",
         mysql_real_escape_string($_user),
         mysql_real_escape_string($tour),
         mysql_real_escape_string($client_data),
         mysql_real_escape_string($phone),
         mysql_real_escape_string($email),
         mysql_real_escape_string($total),
         mysql_real_escape_string($date),
         mysql_real_escape_string(time()));
         
      $this->sendEmail($email, "Заказ тура на karelia-travel.pro", $msg);
      $db->db_query($sql, __LINE__, __FILE__);
      $order_number = mysql_insert_id();
      
      //######################## put user to email db ###############################//
      
      $client_data_decoded = json_decode(stripcslashes($client_data), true);
      $emaildb_sql = sprintf("INSERT INTO `emaildb` (`name`, `email`, `phone`, `bdate`, `timestamp`) VALUES ('%s', '%s', '%s', %d, %d);",
         mysql_real_escape_string($client_data_decoded[0]["name"]),
         mysql_real_escape_string($email),
         mysql_real_escape_string($phone),
         mysql_real_escape_string($client_data_decoded[0]["bdate"]),
         mysql_real_escape_string(time()));
      
      $db->db_query($emaildb_sql, __LINE__, __FILE__);
      //#############################################################################//
      
      return json_encode(array($_user, $order_number));
   }
   
   public function get($user){
      global $db;
      $_user = intval($user);
      
      $sql = "SELECT `id`, `settlement_timestamp`, (SELECT `tour`.`title` FROM `tour` WHERE `tour`.`id` = `cart`.`tour`) AS `tour_title`, (SELECT `tour`.`photo` FROM `tour` WHERE `tour`.`id` = `cart`.`tour`) AS `tour_photo`, `total` AS `tour_price`, `tour`, `confirmed`, `payment_status` FROM `cart` WHERE `deleted` = 0 AND `user` = $_user ORDER BY `order_timestamp` DESC;";
      return json_encode($db->db_fetchall_array($sql, __LINE__, __FILE__));
   }
   
   public function delete($order){
      global $db;
      $_order = intval($order);
      
      $sql = "UPDATE `cart` SET `deleted` = 1 WHERE `id` = $_order;";
      return $db->db_query($sql, __LINE__, __FILE__);
   }
   
   public function restore($order){
      global $db;
      $_order = intval($order);
      
      $sql = "UPDATE `cart` SET `deleted` = 0 WHERE `id` = $_order;";
      return $db->db_query($sql, __LINE__, __FILE__);
   }
   
   public function sendEmail($to, $subject, $message){
      $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
      $headers .= "From: Karelia Travel <noreply@karelia-travel.pro>\r\n";
      
      return mail($to, $subject, $message, $headers);
   }
}

?>