<?php

$host = 'localhost'; 
$user = 'u0143301_default';
$pass = '3x8tkCg!'; 
$db = 'u0143301_default';

session_start();

if (isset($_SESSION['user_id'])) {
   if (!mysqlConnect($host, $user, $pass, $db)){
      mysql_query("SET NAMES 'utf8'");
      mysql_query("SET collation_connection = 'UTF-8_general_ci'");
      mysql_query("SET collation_server = 'UTF-8_general_ci'");
      mysql_query("SET character_set_client = 'UTF-8'");
      mysql_query("SET character_set_connection = 'UTF-8'");
      mysql_query("SET character_set_results = 'UTF-8'");
      mysql_query("SET character_set_server = 'UTF-8'");
   }
   
   
   //echo strtotime(date("d").'-'.date("m").'-1970 12:00:00');
   //echo time();
   
   happybirthday();

   mysql_close();
}

function happybirthday(){
   $today = strtotime(date("d").'-'.date("m").'-1970 12:00:00');
   
   $sql = "SELECT `value` FROM `content` WHERE `parameter` = 'happybirtday_msg';";
   $hbd_msg = db_fetchone_array($sql, __LINE__, __FILE__);
   
   $sql = "SELECT `name`, `email`, `bdate` FROM `emaildb`";
   $email_array = db_fetchall_array($sql, __LINE__, __FILE__);
   
   for ($i = 0; $i < count($email_array); $i++){
      if ($email_array[$i]["bdate"] == $today)
         $complete_result *= sendEmail($email_array[$i]["email"], "Поздравляем с днём рождения!", "Уважаемый ".$email_array[$i]["name"]."<p>".$hbd_msg["value"]);
   }
      
   return $complete_result;
}

function delivery($subject, $message){
   $complete_result = 1;
   
   $sql = "SELECT `email` FROM `emaildb`";
   $email_array = db_fetchall_array($sql, __LINE__, __FILE__);
   
   for ($i = 0; $i < count($email_array); $i++)
      $complete_result *= $this->sendEmail($email_array[$i]["email"], $subject, $message);
      
   return $complete_result;
}
   
function sendEmail($to, $subject, $message){
   $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
   $headers .= "From: Karelia Travel <noreply@karelia-travel.pro>\r\n";
   
   return mail($to, $subject, $message, $headers);
}

function mysqlConnect($host, $user, $pass, $db){
   if (!mysql_connect($host, $user, $pass)){
      pe('connecting to mysql server');
      exit();
   }
   
   if(!mysql_select_db($db)){
      pe('connecting to db');
      exit();
   }
   
   return 0;   
}

function db_query($query, $line=0, $file_name='filename'){
   $res = mysql_query($query) or die("Error: wrong SQL query #$query#;  ".mysql_error()." in ".$file_name." on line ".$line);
   return $res;
}

function db_fetchone_array($query, $line=0, $file_name='filename'){
   $res = db_query($query, $line, $file_name);
   $row = mysql_fetch_array($res,MYSQL_ASSOC);
   mysql_free_result($res);
   return ($row)? $row : array();
}

function db_fetchall_array($query, $line=0, $file_name='filename'){
   $res = db_query($query, $line, $file_name);
   while($row = mysql_fetch_array($res,MYSQL_ASSOC))
      $rows[] = $row;
   mysql_free_result($res);
   return ($rows)? $rows : array();
}

?>