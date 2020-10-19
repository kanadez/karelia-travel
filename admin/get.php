<?php

require_once dirname(__FILE__)."/src/mysqlAuthData.php";
require_once dirname(__FILE__)."/get_src/setData.php";

//echo "No syntax errors!!!";
//javascript:location.href="http://app.po-sportu.ru/admin/get.php?act=addCustomer&link"+document.URL

if (!mysqlConnect($host, $user, $pass, $db))
{
   mysql_query("SET NAMES 'utf8'");
   mysql_query("SET collation_connection = 'UTF-8_general_ci'");
   mysql_query("SET collation_server = 'UTF-8_general_ci'");
   mysql_query("SET character_set_client = 'UTF-8'");
   mysql_query("SET character_set_connection = 'UTF-8'");
   mysql_query("SET character_set_results = 'UTF-8'");
   mysql_query("SET character_set_server = 'UTF-8'");
   
   $set_data = new setData;
}

switch ($_GET["act"])
{  
   case "replaceBrand" :
      $set_data->replaceBrand($_GET["num"], $_GET["brand"]);
   break;
   
   case "addCustomer" :
      if ($set_data->createNewCustomer($_GET["link"]) == 1)
      {
         header('Location: '.$_GET["link"]);
      }
      else
      {
         echo "Error adding Customer!";
      }
   break;
   
   case "addHotUser" :
      if ($set_data->createNewHotUser($_GET["link"], $_GET["name"]) == 1)
      {
         header('Location: '.$_GET["link"]);
      }
      else
      {
         echo "Error adding Hot User!";
      }
   break;
}

mysql_close();

function mysqlConnect($host, $user, $pass, $db)
{
   if (!mysql_connect($host, $user, $pass))
   {
      pe('connecting to mysql server');
      exit();
   }
   
   if(!mysql_select_db($db))
   {
      pe('connecting to db');
      exit();
   }
   
   return 0;   
}

function db_query($query, $line=0, $file_name='filename')
{
   $res = mysql_query($query) or die("Error: wrong SQL query #$query#;  ".mysql_error()." in ".$file_name." on line ".$line);
   return $res;
}

function db_fetchone_array($query, $line=0, $file_name='filename')
{
   $res = db_query($query, $line, $file_name);
   $row = mysql_fetch_array($res,MYSQL_ASSOC);
   mysql_free_result($res);
   return ($row)? $row : array();
}

function db_fetchall_array($query, $line=0, $file_name='filename')
{
   $res = db_query($query, $line, $file_name);
   while($row = mysql_fetch_array($res,MYSQL_ASSOC))
      $rows[] = $row;
   mysql_free_result($res);
   return ($rows)? $rows : array();
}

?>
