<?php

require_once dirname(__FILE__)."/php/include/class_db.php";
require_once dirname(__FILE__)."/php/include/class_constructor.php";
require_once dirname(__FILE__)."/php/include/class_tour.php";
require_once dirname(__FILE__)."/php/include/class_mail.php";
require_once dirname(__FILE__)."/php/include/data_parameter.php";


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
   
   $constructor = new Constructor;
   $tour = new Tour;
   $parameter = new Parameter;
   $mail = new Mail;
}


switch ($_GET["step"]){
   case 1:
      if ($_POST["email"] != ""){ // 1 step; отправляем мыло со ссылкой для сброса, кладя сгенерированный токен юзеру
         $email = trim($_POST["email"]);
         $sql = sprintf("SELECT `id` FROM `user` WHERE `email` = '%s';", mysql_real_escape_string($email));
         $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
         
         if (count($result) === 0)
            header("Location: forgot.php?error=notexist");
         else{ 
            echo '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="laki-hotel-ru">
               <head>
                  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                  <meta http-equiv="expires" content="Mon, 22 Jul 2002 11:12:01 GMT"/>
                  <meta http-equiv="cache-control" content="no-cache"/>
                  <meta name="description" content="Laki - это карельская гостиница для животных. Мы предлагаем услуги по временному содержанию и уходу за домашними животными, а также бесплатную консультацию у ветеринара в любое удобное для Вас время." />
                  <meta http-equiv="keywords" content="гостиница для животных, гостиница для собак, отель для собак, передержка животных">
                  <title>Travel | туристическое агентство</title>
                  <link type="text/css" rel="stylesheet" href="css/main.css"/>
                  <link type="text/css" rel="stylesheet" href="css/cart.css"/>
                  <link rel="stylesheet" type="text/css" href="css/dropdown.css" />
                  <link rel="stylesheet" type="text/css" href="css/gallery.css" />
                  <link rel="stylesheet" type="text/css" href="css/white.css" />
                  <link rel="stylesheet" type="text/css" href="css/social_panel.css" />
                  <link rel="stylesheet" type="text/css" href="css/login.css" />
                  <link rel="shortcut icon" href="/img/icon.png">
                  <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
                  <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
                  <script type="text/javascript" src="js/md5.js"></script>
                  <style>   
                     @font-face {
                     	font-family: "Conv_Hattori_Hanzo";
                     	src: url("fonts/Hattori_Hanzo.eot");
                     	src: local("☺"), url("fonts/Hattori_Hanzo.woff") format("woff"), url("fonts/Hattori_Hanzo.ttf") format("truetype"), url("fonts/Hattori_Hanzo.svg") format("svg");
                     	font-weight: normal;
                     	font-style: normal;
                     }
            			
            			body{
            			   margin:0;
                        padding:0;
                        outline:none;
                        font-size: 62.5%;
                     	font-family:"Conv_Hattori_Hanzo" !important;
                     	background: #fff;
                     	background-size: cover;
                     	box-sizing:border-box;
            			}
            		</style>
               </head>
               <body id="page">
                  <div id="wrapper_div" class="container">
                     
                     '.$constructor->getWhiteHeader("cart").'
                     
                     <div id="content_div">
                        <h3 style="width:100%; text-align:center;color:#333">Восстановление пароля</h3>
                        <div class="block_wrapper">
                           <form id="reset-password-form" action="reset.php" method="post">';
                            $message = 'Уважаемый пользователь!
                              <br>Вами была инициирована процедура восстановления пароля на сайте karelia-travel.pro.
                              <br>Для восстановления пароля перейдите по <a href="http://karelia-travel.pro/reset.php?step=2&token=';
                              
                              $email = $_POST["email"];
                              $token = md5(uniqid());
                              $sql = sprintf("UPDATE `user` SET `token` = '%s' WHERE `email` = '%s'",
                                    mysql_real_escape_string($token),
                                    mysql_real_escape_string($email));
                                    
                              $db->db_query($sql, __LINE__, __FILE__);
                              
                              $message .= $token.'&login='.$email.'">этой ссылке</a>.
                                 <br>Если Вы не в курсе, о чем идет речь, просто проигнорируйте это письмо.
                                 <p>С уважением, компания Karelia Travel.';
                              $mail->sendEmail($email, "Восстановление пароля", $message);
                              echo 'На указанный Вами E-Mail выслано письмо с дальнейшими указаниями. Проверьте почту.
                           </form>                          
                        </div>
                     </div>
                  </div>
                  
                  '.$constructor->getFooter()."
                  
                  <script type='text/javascript'>
                  (function(){ var widget_id = 'HoBi0ByIPY';
                  var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
                  <!-- {/literal} END JIVOSITE CODE -->
               </body>  
            </html>";
         }
      }
      else header("Location: forgot.php?error=empty");
   break;
   case 2:
      if (isset($_GET["token"]) && isset($_GET["login"])){ // 2 step; переход по ссылке из мыла. Предлагаем вести новый пасс
         echo '
         <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
         <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="laki-hotel-ru">
            <head>
               <meta http-equiv="content-type" content="text/html; charset=utf-8" />
               <meta http-equiv="expires" content="Mon, 22 Jul 2002 11:12:01 GMT"/>
               <meta http-equiv="cache-control" content="no-cache"/>
               <meta name="description" content="Laki - это карельская гостиница для животных. Мы предлагаем услуги по временному содержанию и уходу за домашними животными, а также бесплатную консультацию у ветеринара в любое удобное для Вас время." />
               <meta http-equiv="keywords" content="гостиница для животных, гостиница для собак, отель для собак, передержка животных">
               <title>Travel | туристическое агентство</title>
               <link type="text/css" rel="stylesheet" href="css/main.css"/>
               <link type="text/css" rel="stylesheet" href="css/cart.css"/>
               <link rel="stylesheet" type="text/css" href="css/dropdown.css" />
               <link rel="stylesheet" type="text/css" href="css/gallery.css" />
               <link rel="stylesheet" type="text/css" href="css/white.css" />
               <link rel="stylesheet" type="text/css" href="css/social_panel.css" />
               <link rel="stylesheet" type="text/css" href="css/login.css" />
               <link rel="shortcut icon" href="/img/icon.png">
               <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
               <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
               <script type="text/javascript" src="js/md5.js"></script>
               <style>   
                  @font-face {
                  	font-family: "Conv_Hattori_Hanzo";
                  	src: url("fonts/Hattori_Hanzo.eot");
                  	src: local("☺"), url("fonts/Hattori_Hanzo.woff") format("woff"), url("fonts/Hattori_Hanzo.ttf") format("truetype"), url("fonts/Hattori_Hanzo.svg") format("svg");
                  	font-weight: normal;
                  	font-style: normal;
                  }
         			
         			body{
         			   margin:0;
                     padding:0;
                     outline:none;
                     font-size: 62.5%;
                  	font-family:"Conv_Hattori_Hanzo" !important;
                  	background: #fff;
                  	background-size: cover;
                  	box-sizing:border-box;
         			}
         		</style>
            </head>
            <body id="page">
               <div id="wrapper_div" class="container">
                  
                  '.$constructor->getWhiteHeader("cart").'
                  
                  <div id="content_div">
                     <h3 style="width:100%; text-align:center;color:#333">Восстановление пароля</h3>
                     <div class="block_wrapper">
                        <div id="notempty_alert" class="alert" style="'.((isset($_GET["error"]) && $_GET["error"] === "empty") ? "display:block" : "").'">Ошибка: оба поля должны быть заполнены</div>
                        <div id="notempty_alert" class="alert" style="'.((isset($_GET["error"]) && $_GET["error"] === "notmatch") ? "display:block" : "").'">Ошибка: пароли не совпадают</div>
                        <form id="reset-password-form" action="reset.php?step=3" method="post">
                           <input id="password" type="password" maxlength=20 placeholder="Введите новый пароль" name="password" class="neccesary_input login_input" />
                           <br><input id="password_again" type="password" maxlength=20 placeholder="Пароль ещё раз" name="password_again" class="neccesary_input login_input" />
                           <input name="token" id="token" type="text" style="display:none" value="'.$_GET["token"].'" />
                           <input name="login" id="login" type="text" style="display:none" value="'.$_GET["login"].'" />
                           <br><input id="restore_button" type="submit" class="login_button" style="width: 268px;" value="Сохранить" />
                        </form>                          
                     </div>
                  </div>
               </div>
               
               '.$constructor->getFooter()."
               
               <script type='text/javascript'>
               (function(){ var widget_id = 'HoBi0ByIPY';
               var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
               <!-- {/literal} END JIVOSITE CODE -->
            </body>  
         </html>";
      }
      else header("Location: forgot.php");
   break;
   case 3:
      if ($_POST["password"] !== "" && $_POST["password_again"] !== ""){ // 3 step; получаем из 2-го шага новый пароль и сохраняем, если токен подходит
         if ($_POST["password"] === $_POST["password_again"]){
            $password = md5($_POST['password']);
            $login = $_POST['login'];
            $token = $_POST['token'];
            $sql = sprintf("UPDATE `user` SET `passwd` = '%s' WHERE `token` = '%s' && `email` = '%s'",
                  mysql_real_escape_string($password),
                  mysql_real_escape_string($token),
                  mysql_real_escape_string($login));
                  
            $db->db_query($sql, __LINE__, __FILE__);
            
            echo '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="laki-hotel-ru">
               <head>
                  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                  <meta http-equiv="expires" content="Mon, 22 Jul 2002 11:12:01 GMT"/>
                  <meta http-equiv="cache-control" content="no-cache"/>
                  <meta name="description" content="Laki - это карельская гостиница для животных. Мы предлагаем услуги по временному содержанию и уходу за домашними животными, а также бесплатную консультацию у ветеринара в любое удобное для Вас время." />
                  <meta http-equiv="keywords" content="гостиница для животных, гостиница для собак, отель для собак, передержка животных">
                  <title>Travel | туристическое агентство</title>
                  <link type="text/css" rel="stylesheet" href="css/main.css"/>
                  <link type="text/css" rel="stylesheet" href="css/cart.css"/>
                  <link rel="stylesheet" type="text/css" href="css/dropdown.css" />
                  <link rel="stylesheet" type="text/css" href="css/gallery.css" />
                  <link rel="stylesheet" type="text/css" href="css/white.css" />
                  <link rel="stylesheet" type="text/css" href="css/social_panel.css" />
                  <link rel="stylesheet" type="text/css" href="css/login.css" />
                  <link rel="shortcut icon" href="/img/icon.png">
                  <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
                  <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
                  <script type="text/javascript" src="js/md5.js"></script>
                  <style>   
                     @font-face {
                     	font-family: "Conv_Hattori_Hanzo";
                     	src: url("fonts/Hattori_Hanzo.eot");
                     	src: local("☺"), url("fonts/Hattori_Hanzo.woff") format("woff"), url("fonts/Hattori_Hanzo.ttf") format("truetype"), url("fonts/Hattori_Hanzo.svg") format("svg");
                     	font-weight: normal;
                     	font-style: normal;
                     }
            			
            			body{
            			   margin:0;
                        padding:0;
                        outline:none;
                        font-size: 62.5%;
                     	font-family:"Conv_Hattori_Hanzo" !important;
                     	background: #fff;
                     	background-size: cover;
                     	box-sizing:border-box;
            			}
            		</style>
               </head>
               <body id="page">
                  <div id="wrapper_div" class="container">
                     
                     '.$constructor->getWhiteHeader("cart").'
                     
                     <div id="content_div">
                        <h3 style="width:100%; text-align:center;color:#333">Восстановление пароля</h3>
                        <div class="block_wrapper">
                           <div style="margin-top:15vh;margin-bottom:25vh;width:100%; text-align:center">
                              Пароль успешно сброшен!
                              <p style="margin-top:30px"></p>
                              <a class="login_button" style="padding: 13px 44px;" href="login.php">ВОЙТИ С НОВЫМ ПАРОЛЕМ</a>
                              </div>                          
                        </div>
                     </div>
                  </div>
                  
                  '.$constructor->getFooter()."
                  
                  <script type='text/javascript'>
                  (function(){ var widget_id = 'HoBi0ByIPY';
                  var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
                  <!-- {/literal} END JIVOSITE CODE -->
               </body>  
            </html>";
         }
         else header("Location: reset.php?step=2&token=".$_POST['token']."&login=".$_POST['login']."&error=notmatch");
      }
      else header("Location: reset.php?step=2&token=".$_POST['token']."&login=".$_POST['login']."&error=empty");
   break;

   default : 
      exit();
}

mysql_close();

?>