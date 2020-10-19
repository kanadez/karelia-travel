<?php

require_once dirname(__FILE__)."/php/include/class_db.php";
require_once dirname(__FILE__)."/php/include/class_constructor.php";
require_once dirname(__FILE__)."/php/include/class_tour.php";
require_once dirname(__FILE__)."/php/include/class_cart.php";
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
   $cart = new Cart;
   $parameter = new Parameter;
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
      <link rel="shortcut icon" href="/img/icon.png">
      <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
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
            <?php
            $order_id = $_GET["MNT_TRANSACTION_ID"];
            $complete_data = $cart->getCompleteData($order_id);
            $tour_id = $complete_data[1];
            $tour_name = $complete_data[2];
            
            switch ($_GET["status"]){
               case "order_cancelled":
                  setPaymentStatus($order_id, 2);
                  echo '<h3 style="width:100%; text-align:center;color:#333">Заказ отменен</h3>
                     <div style="margin-top:15vh;margin-bottom:25vh;width:100%; text-align:center">
                     Вы прервали процесс заказа, однако 
                     <br>
                     Вы всегда можете продложить его в корзине заказов.
                     <p style="margin-top:30px"></p>
                     <a class="orange_link" style="padding: 13px 44px;" href="cart.php">Открыть корзину</a>
                     </div>';
                     
                  $msg = "Уважаемый клиент!
                     <p>Это письмо сформировано автоматически, отвечать на него не нужно!
                     <br>Вы сделали заказ тура <a href='http://karelia-travel.pro/tour.php?id=$tour_id'>$tour_name</a> на сайте karelia-travel.pro.
                     <br>Однако процесс оплаты был прерван Вами.
                     <p>Чтобы продолжить оплату: 
                     <br>1) войдите в <a href='http://karelia-travel.pro/cart.php'>корзину</a>, используя свой электронный адрес и пароль
                     <br>2) нажмите \"Оплатить\" напротив заказа
                     <br>Далее мы свяжемся с Вами по телефону и проинструктируем касательно дальнейших действий.
                     <p>Если Вы не совершали никаких заказов, просто проигнорируйте это письмо.
                     <p>С уважением, компания Karelia Travel.";
               break;
               
               case "order_error":
                  setPaymentStatus($order_id, 3);
                  echo '<h3 style="width:100%; text-align:center;color:#333">Ошибка оплаты</h3>
                     <div style="margin-top:15vh;margin-bottom:25vh;width:100%; text-align:center">
                     Во время оплаты произошла ошибка. 
                     <br>
                     Попробуйте снова оплатить из корзины заказов через некоторое время.
                     <p style="margin-top:30px"></p>
                     <a class="orange_link" style="padding: 13px 44px;" href="cart.php">Открыть корзину</a>
                     </div>';
                     
                  $msg = "Уважаемый клиент!
                     <p>Это письмо сформировано автоматически, отвечать на него не нужно!
                     <br>Вы сделали заказ тура <a href='http://karelia-travel.pro/tour.php?id=$tour_id'>$tour_name</a> на сайте karelia-travel.pro.
                     <br>Однако во время оплаты произошла ошибка, и процесс был прерван.
                     <p>Чтобы попробовать оплатить заказ снова: 
                     <br>1) войдите в <a href='http://karelia-travel.pro/cart.php'>корзину</a>, используя свой электронный адрес и пароль
                     <br>2) нажмите \"Оплатить\" напротив заказа
                     <br>Далее мы свяжемся с Вами по телефону и проинструктируем касательно дальнейших действий.
                     <p>Если Вы не совершали никаких заказов, просто проигнорируйте это письмо.
                     <p>С уважением, компания Karelia Travel.";
               break;
               
               case "order_success":
                  setPaymentStatus($order_id, 1);
                  echo '<h3 style="width:100%; text-align:center;color:#333">Заказ оплачен</h3>
                     <div style="margin-top:15vh;margin-bottom:25vh;width:100%; text-align:center">
                     Оплата заказа прошла успешно.
                     <br>
                     Мы свяжемся с Вами в ближайшее время для дальнейших инструкций, либо
                     <br>Вы можете позвонить нам сами прямо сейчас по номеру +7 (900) 46-000-62,
                     назвав номер заказа: '.$order_id.'
                     <br>Следить за своими заказами Вы можете в корзине заказов.
                     <p style="margin-top:30px"></p>
                     <a class="orange_link" style="padding: 13px 44px;" href="cart.php">Открыть корзину</a>
                     </div>';
                     
                  $msg = "Уважаемый клиент!
                     <p>Это письмо сформировано автоматически, отвечать на него не нужно!
                     <br>Вы сделали заказ тура <a href='http://karelia-travel.pro/tour.php?id=$tour_id'>$tour_name</a> на сайте karelia-travel.pro.
                     <br>Оплата заказа прошла успешно.
                     <br>В течение суток мы свяжемся с Вами по телефону и проинструктируем касательно дальнейших действий.
                     <p>Если Вы не совершали никаких заказов, просто проигнорируйте это письмо.
                     <p>С уважением, компания Karelia Travel.";
               break;
               
               default : 
                  exit();
            }
            
            sendEmail($complete_data[0], "Заказ тура на karelia-travel.pro", $msg);
            
            function setPaymentStatus($order_id, $status){ // 1 - success, 2 - cancelled, 3 - error
               global $db;
               $order_id = intval($order_id);
               
               $sql = sprintf("UPDATE `cart` SET `payment_status` = %d WHERE `id` = %d;",
               mysql_real_escape_string($status),
               mysql_real_escape_string($order_id));
               return $db->db_query($sql, __LINE__, __FILE__);
            }
            
            function getTransactionStatus($order_id){ // получает статус заказа напрямую из системы payanyway. ф-ия необходима для доп. проверки статуса заказа
               $order_id = intval($order_id);
               $myCurl = curl_init();
               $request = '{"Envelope":{"Header":{"Security":{"UsernameToken":{"Username":"hello@karelia-travel.pro","Password":"7AVqoUVj"}}},"Body":{"GetOperationDetailsByIdRequest": '.$order_id.'}}}';
               
               curl_setopt_array($myCurl, array(
                  CURLOPT_URL => 'https://service.moneta.ru/services',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_POST => true,
                  CURLOPT_POSTFIELDS => $request,
                  CURLOPT_HTTPHEADER => array('Content-Type:application/json')
               
               ));
               
               $response = curl_exec($myCurl);
               curl_close($myCurl);
               
               echo $response;
            }
            
            function sendEmail($to, $subject, $message){
               $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
               $headers .= "From: Karelia Travel <noreply@karelia-travel.pro>\r\n";
               
               return mail($to, $subject, $message, $headers);
            }
            
            ?>
            
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