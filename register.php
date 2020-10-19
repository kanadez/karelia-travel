<?php

require_once dirname(__FILE__)."/php/include/class_db.php";
require_once dirname(__FILE__)."/php/include/class_constructor.php";
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
   $parameter = new Parameter;
}



if ($_POST['password'] != "" && $_POST['password_again'] != "" && $_POST['login'] != ""){
   if ($_POST['password'] == $_POST['password_again']){
      $login = $_POST['login'];
      $password = md5($_POST['password']);
      $query = "SELECT `id` FROM `user` WHERE `email` = '$login' AND `passwd` = '$password' LIMIT 1";
      $result = $db->db_fetchone_array($query, __LINE__, __FILE__);
   
      if (count($result) == 0){
         $sql = sprintf("INSERT INTO `user` (`email`, `passwd`, `timestamp`) VALUES ('%s', '%s', %d);",
            mysql_real_escape_string($login),
            mysql_real_escape_string($password),
            mysql_real_escape_string(time()));
         
         $db->db_query($sql, __LINE__, __FILE__);
         sendEmail($login, 
            "Регистрация на сайте karelia-travel.pro", 
            "Уважаемый клиент!
            <p>Это письмо сформировано автоматически, отвечать на него не нужно!
            <br>Вы зарегистрировались на сайте karelia-travel.pro.
            <br>Ваш логин, указанный при регистрации: {$login}
            <br>Чтобы зайти в свою корзину заказов, введите логин и пароль на <a href='http://karelia-travel.pro/login.php'>странице входа</a>.
            <p>Если Вы нигде не регистрировались, просто проигнорируйте это письмо.
            <p>С уважением, компания Karelia Travel."
         );
         header('Location: /register.php?success');
      }
      else header('Location: /register.php?error_already');
   }
   else header('Location: /register.php?error_dontmatch');
}

function sendEmail($to, $subject, $message){
   $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
   $headers .= "From: Karelia Travel <noreply@karelia-travel.pro>\r\n";
   
   return mail($to, $subject, $message, $headers);
}

?>

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
                <!-- Yandex.Metrika counter -->
                <script type="text/javascript">
                    (function (d, w, c) {
                        (w[c] = w[c] || []).push(function() {
                            try {
                                w.yaCounter36251570 = new Ya.Metrika({
                                    id:36251570,
                                    clickmap:true,
                                    trackLinks:true,
                                    accurateTrackBounce:true
                                });
                            } catch(e) { }
                        });

                        var n = d.getElementsByTagName("script")[0],
                            s = d.createElement("script"),
                            f = function () { n.parentNode.insertBefore(s, n); };
                        s.type = "text/javascript";
                        s.async = true;
                        s.src = "https://mc.yandex.ru/metrika/watch.js";

                        if (w.opera == "[object Opera]") {
                            d.addEventListener("DOMContentLoaded", f, false);
                        } else { f(); }
                    })(document, window, "yandex_metrika_callbacks");
                </script>
                <noscript><div><img src="https://mc.yandex.ru/watch/36251570" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
                <!-- /Yandex.Metrika counter -->
   </head>
   <body id="page">
      <div id="wrapper_div" class="container">
         
         <?php echo $constructor->getWhiteHeader("cart"); ?>
         
         <div id="content_div">
            <h3 style="width:100%; text-align:center;color:#333">Регистрация на сайте</h3>
            <div class="block_wrapper">
               <div id="success_notify" style="<?php echo (isset($_GET["success"]) ? "display:block" : "display:none") ?>">
                  Регистрация прошла успешно!
                  <p>Теперь Вы можете <a href="login.php">зайти на сайт</a>.
               </div>
               <form id="register-form" action="register.php" method="post" style="<?php echo (isset($_GET["success"]) ? "display:none" : "display:block") ?>">
                  <div id="empty_alert" class="alert" style="<?php echo (isset($_GET["error_empty"]) ? "display:block" : "") ?>">Ошибка: не все поля заполнены</div>
                  <div id="password_alert" class="alert" style="<?php echo (isset($_GET["error_dontmatch"]) ? "display:block" : "") ?>">Ошибка: пароли не совпадают</div>
                  <div id="registered_alert" class="alert" style="<?php echo (isset($_GET["error_already"]) ? "display:block" : "") ?>">Ошибка: вы уже были зарегистрированы</div>
                  <br><input class="input" id="login" placeholder="Электронная почта" maxlength=100 name="login"   />
                  <br><input class="input" id="password" placeholder="Пароль" maxlength=100 name="password" type="password" />
                  <br><input class="input" id="password_again" placeholder="Пароль еще раз" maxlength=100 name="password_again" type="password"   />
                  <p><input id="login_button" href="javascript:void(0)" class="login_button" style="width: 268px" type="submit" value="ЗАРЕГИСТРИРОВАТЬСЯ" />
               </form>
            </div>
         </div>
      </div>
      
      <?php echo $constructor->getFooter(); ?>
      
      <script type='text/javascript'>
      (function(){ var widget_id = 'HoBi0ByIPY';
      var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
      <!-- {/literal} END JIVOSITE CODE -->
   </body>  
</html>

<?php

mysql_close();

?>