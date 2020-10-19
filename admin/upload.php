<?php

require_once dirname(__FILE__)."/src/mysqlAuthData.php";

//echo "No syntax errors!!!";
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

   if ($_POST["action"] == "upload_group_image"){
      $uploaddir = "../catalog/";
      $img_name = uniqid().".jpg";
      $uploadfile0 = $uploaddir . $img_name;
      
      moveUploadedFiles();
      updateDBGroupImage($img_name);
      echo $img_name;
   }
   
   if ($_POST["action"] == "upload_tour_image"){
      $uploaddir = "../catalog/";
      $img_name = uniqid().".jpg";
      $uploadfile0 = $uploaddir . $img_name;
      
      moveUploadedFiles();
      updateDBTourImage($img_name);
      echo $img_name;
   }
   
   if ($_POST["action"] == "upload_mainpage_bg"){
      $uploaddir = "../img/";
      $img_name = "bg.jpg";
      $uploadfile0 = $uploaddir . $img_name;
      
      moveUploadedFiles();
      echo $img_name;
   }
   
   if ($_POST["action"] == "upload_tourist_agreement"){
      $uploaddir = "../";
      $img_name = $_FILES['file']['name'];
      $uploadfile0 = $uploaddir . $img_name;
      
      $sql = sprintf("UPDATE `content` SET `value` = '%s' WHERE `parameter` = 'tourist_agreement';", mysql_real_escape_string($img_name));
      db_query($sql, __LINE__, __FILE__);
      moveUploadedFiles();
      echo $img_name;
   }
   
   if ($_POST["action"] == "upload_agent_agreement"){
      $uploaddir = "../";
      $img_name = $_FILES['file']['name'];
      $uploadfile0 = $uploaddir . $img_name;
      
      $sql = sprintf("UPDATE `content` SET `value` = '%s' WHERE `parameter` = 'agent_agreement';", mysql_real_escape_string($img_name));
      db_query($sql, __LINE__, __FILE__);
      moveUploadedFiles();
      echo $img_name;
   }

   mysql_close();
}

function updateDBGroupImage($image){
   $sql = sprintf("UPDATE `group` SET `image` = '%s' WHERE `id` = %d;",
      mysql_real_escape_string($image),
      mysql_real_escape_string($_POST["group"]));
      
   return db_query($sql, __LINE__, __FILE__);
}

function updateDBTourImage($image){
   $sql = sprintf("UPDATE `tour` SET `photo` = '%s' WHERE `id` = %d;",
      mysql_real_escape_string($image),
      mysql_real_escape_string($_POST["tour"]));
      
   return db_query($sql, __LINE__, __FILE__);
}

function moveUploadedFiles(){
   global $uploadfile0;
   global $img_name;
   $result = true;
   $result *= move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile0);
   
   return $result;
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

function ftpConnect(){ //connects to ftp-server. Credentials are in src/ftpAuthData.php file
   global $ftp_server;
   global $ftp_user;
   global $ftp_pass;
      
   $conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 

   if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) 
      return $conn_id;
   else
      return "Couldn't connect as $ftp_user\n";
}

function ftpCreateDirectory($directory_name){ //creates directory $directory_name

   $conn_id = ftpConnect();
   $result = 0;
   
   if (ftp_mkdir($conn_id, $directory_name))
      $result = "successfully created $dir\n";
   else
      $result = "There was a problem while creating $dir\n";
   
   ftp_close($conn_id);
   return $result;
}


?>