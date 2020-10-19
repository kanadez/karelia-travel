<?php

require_once dirname(__FILE__)."/include/class_db.php";
require_once dirname(__FILE__)."/include/class_tour.php";
require_once dirname(__FILE__)."/include/class_cart.php";
require_once dirname(__FILE__)."/include/class_feedback.php";
require_once dirname(__FILE__)."/include/class_user.php";

session_start(); 

$db = new DB;

if (!$db->mysqlConnect()){
   mysql_query("SET NAMES 'utf8'");
   mysql_query("SET collation_connection = 'UTF-8_general_ci'");
   mysql_query("SET collation_server = 'UTF-8_general_ci'");
   mysql_query("SET character_set_client = 'UTF-8'");
   mysql_query("SET character_set_connection = 'UTF-8'");
   mysql_query("SET character_set_results = 'UTF-8'");
   mysql_query("SET character_set_server = 'UTF-8'");
   
   $tour = new Tour;
   $cart = new Cart;
   $feedback = new Feedback;
   $user = new User;
}

switch ($_POST["a"]){
   case "cart_get_payment_data":
      echo $cart->getPaymentData($_POST["b"]);
   break;
   
   case "login_ok":
      echo $user->loginOK($_POST["b"]);
   break;
   
   case "login_vk":
      echo $user->loginVK($_POST["b"]);
   break;
   
   case "tour_get_settlement":
      echo $tour->getSettlement($_POST["b"]);
   break;
   
   case "rO":
      echo $cart->restore($_POST["b"]);
   break;
   
   case "dO":
      echo $cart->delete($_POST["b"]);
   break;
   
   case "feedback_set":
      echo $feedback->set($_POST["b"], $_POST["c"], $_POST["d"], $_POST["e"]);
   break;
   
   case "cart_get":
      echo $cart->get($_POST["b"]);
   break;
   
   case "cart_order":
      echo $cart->order($_POST["b"], $_POST["c"], $_POST["d"], $_POST["e"], $_POST["f"], $_POST["g"]);
   break;
   
   case "tour_get_dates":
      echo $tour->getDates($_POST["b"]);
   break;
   
   case "tour_search":
      echo $tour->search($_POST["b"], $_POST["c"], $_POST["d"], $_POST["e"], $_POST["f"]);
   break;
   
   case "tour_get_search_init_data":
      echo $tour->getSearchInitData();
   break;
   
   case "testing" :
      echo "testing is ok";
   break;

   default : 
      exit();
}

mysql_close();

?>