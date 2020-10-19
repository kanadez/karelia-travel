<?php

require_once dirname(__FILE__)."/src/getData.php";
require_once dirname(__FILE__)."/src/setData.php";
require_once dirname(__FILE__)."/src/mysqlAuthData.php";
require_once dirname(__FILE__)."/src/ftpAuthData.php";

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
      
      $get_data = new GetData;
      $set_data = new SetData;
   }

   switch ($_POST['a']){
      case "tour_photo_delete":
         echo $set_data->deleteTourPhoto($_POST["b"]);
      break;
      
      case "dTS":
         echo $set_data->deleteTourSettlement($_POST["b"]);
      break;
      
      case "sTS":
         echo $set_data->setTourSettlement($_POST["b"], $_POST["c"]);
      break;
      
      case "gTS":
         echo $get_data->getTourSettlement($_POST["b"]);
      break;
      
      case "delivery_set_bdate_msg":
         echo $set_data->deliverySetBDMsg($_POST["b"]);
      break;
      
      case "delivery_get_bdate_msg":
         echo $get_data->deliveryGetBDMsg();
      break;
      
      case "delivery_do":
         echo $set_data->delivery($_POST["b"], $_POST["c"]);
      break;
      
      case "save_aboutinfo_content":
         echo $set_data->saveAboutContent($_POST['b']);
      break;
      
      case "save_content":
         echo $set_data->saveContent($_POST['page'], $_POST['data']);
      break;
      
      case "gEDB":
         echo $get_data->getEmailDB();
      break;
      
      case "gPD":
         echo $get_data->getPaymentData();
      break;
      
      case "gAB":
         echo $get_data->getAboutData();
      break;
      
      case "gMP":
         echo $get_data->getMainPageData();
      break;
      
      case "gTGa":
         echo $get_data->getTourGallery($_POST['b']);
      break;
      
      case "gGT":
         echo $get_data->getTour($_POST['b']);
      break;
      
      case "dCO":
         echo $set_data->deleteConfirmedOrder($_POST['b']);
      break;
      
      case "cNO":
         echo $set_data->confirmNewOrder($_POST['b']);
      break;
      
      case "gCO":
         echo $get_data->getConfirmedOrders();
      break;
      
      case "gNO":
         echo $get_data->getNewOrders();
      break;
      
      case "sT":
         echo $set_data->saveTour($_POST['b'], $_POST['c'], $_POST['d'], $_POST['e'], $_POST['f'], $_POST['g'], $_POST['h'], $_POST['i'], $_POST['j'], $_POST['k']);
      break;
      
      case "sGN":
         echo $set_data->saveTourGroupName($_POST['b'], $_POST['c']);
      break;
      
      case "sGD":
         echo $set_data->saveTourGroupDesc($_POST['b'], $_POST['c']);
      break;
      
      case "aT":
         echo $set_data->addTour($_POST['b'], $_POST['c'], $_POST['d']);
      break;
      
      case "dT":
         echo $set_data->deleteTour($_POST['b']);
      break;
      
      case "gGN":
         echo $get_data->getTourGroupName($_POST['b']);
      break;
      
      case "gGD":
         echo $get_data->getTourGroupData($_POST['b']);
      break;
      
      case "dTG":
         echo $set_data->deleteTourGroup($_POST['b']);
      break;
      
      case "aTG":
         echo $set_data->addTourGroup($_POST['b']);
      break;
      
      case "gTG":
         echo $get_data->getTourGroups();
      break;
      
      default : 
         exit();
   }

   mysql_close();
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