<?php

require_once dirname(__FILE__)."/php/include/class_db.php";
require_once dirname(__FILE__)."/php/include/class_constructor.php";
require_once dirname(__FILE__)."/php/include/class_tour.php";
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
}

if (isset($_GET['logout'])){
   unset($_SESSION["user"]);
   session_destroy(); // разрушаем сессию
   header('Location: /login.php');
}
elseif (isset($_SESSION['user'])){
   header('Location: /cart.php');
}
else{
   if (isset($_POST['password']) && isset($_POST['login'])){
      $login = $_POST['login'];
      $password = md5($_POST['password']);
      $query = "SELECT `id` FROM `user` WHERE `email` = '$login' AND `passwd` = '$password' LIMIT 1";
      $result = $db->db_fetchone_array($query, __LINE__, __FILE__);
   
      if (count($result) == 1){
         $_SESSION['user'] = $result['id'];
         $sql = sprintf("UPDATE `user` SET `lastseen` = %d WHERE `id` = %d;",
            mysql_real_escape_string(time()),
            mysql_real_escape_string($result['id']));
            
         $db->db_query($sql, __LINE__, __FILE__);
         header('Location: /cart.php');
      }
      else{
        header('Location: /login.php?error');;
      }
   }
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
            <h3 class="centered_h3">Вход на сайт</h3>
            <div class="block_wrapper">
            <form id="login-form" action="login.php" method="post">
               <div id="password_alert" class="alert" style="<?php echo (isset($_GET["error"]) ? "display:block" : "") ?>">Ошибка: неверные e-mail или пароль</div>   
               <label for="login_input" style="clear:both; display:none" class="neccesary">E-Mail: </label><input id="login_input" maxlength=100 name="login" placeholder="E-Mail" class="neccesary_input login_input" />
               <br><label for="password_input" class="neccesary" style="display:none">Пароль: </label><input id="password_input" type="password" maxlength=100 placeholder="Логин" name="password" class="neccesary_input login_input" />
               <br><a id="forgot_a" href="forgot.php">Забыли пароль?</a>
               <p><input id="login_button" href="javascript:void(0)" class="login_button" type="submit" value="ВОЙТИ" /><a style="padding:0 27px" href="register.php">Регистрация</a>
               <!--<p>
               <br><span style="color:#777;">Войти через социальные сети:</span>
               <div id="socialpanel" class="pluso-sharer pluso--theme11 pluso--square-corner pluso--big pluso--horizontal pluso--multiline " style=""></a>
                  <a id="sf_vkontakte" class="pluso__vkontakte pluso_link " target="_blank" title="ВКонтакте" to="1" onclick="VK.Auth.login(loginAuthInfo);"></a>
                  <a id="sf_odnoklassniki" class="pluso__odnoklassniki pluso_link " style="" title="Одноклассники" to="2" href="https://connect.ok.ru/oauth/authorize?client_id=1239390976&scope=VALUABLE_ACCESS&response_type=token&redirect_uri=http://karelia-travel.pro/login.php&layout=w"></a>
               </div>-->
            </form>
            </div>
         </div>
      </div>
      
      <?php echo $constructor->getFooter(); ?>
      
      <script type="text/javascript" src="js/login.js"></script>
      <script type="text/javascript" src="js/utils.js"></script>
      <script type='text/javascript'>
      (function(){ var widget_id = 'HoBi0ByIPY';
      var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
      <!-- {/literal} END JIVOSITE CODE -->
   </body>  
</html>

<?php

mysql_close();

?>