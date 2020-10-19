<?php

require_once dirname(__FILE__)."/php/include/class_db.php";
require_once dirname(__FILE__)."/php/include/class_constructor.php";
require_once dirname(__FILE__)."/php/include/class_about.php";

//session_start(); 

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
   $about = new About;
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
   <link rel="stylesheet" type="text/css" href="css/dropdown.css" />
   <link rel="stylesheet" type="text/css" href="css/white.css" />
   <link rel="shortcut icon" href="/img/icon.png">
   <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
   <style> 

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
      @font-face {
       font-family: "Conv_Hattori_Hanzo";
       src: url("fonts/Hattori_Hanzo.eot");
       src: local("☺"), url("fonts/Hattori_Hanzo.woff") format("woff"), url("fonts/Hattori_Hanzo.ttf") format("truetype"), url("fonts/Hattori_Hanzo.svg") format("svg");
       font-weight: normal;
       font-style: normal;
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

      <?php echo $constructor->getWhiteHeader("about"); ?>

      <div id="content_div">
         <a name="about"></a>
         <h3 style="width:100%; text-align:center;color:#333">О нас</h3>
         
         <div style="width:100%;text-align:center;color:#333 !important"><?php echo $constructor->getContent("about", "company_info"); ?></div>
         <a name="agreements"></a>
         <div class="br50"></div>
         <a href="<?php echo $constructor->getContent("about", "tourist_agreement"); ?>">Скачать договор с туристами</a>
         <br>
         <a href="<?php echo $constructor->getContent("about", "agent_agreement"); ?>">Скачать агенстский договор</a>
         <div class="br60"></div>
         <a name="payment"></a>
         <p style="width:100%; margin-top: 50px; text-align:center;color:#333">Способы оплаты:</p>
         <table style="margin-left:auto;margin-right:auto">
            <tr>
               <!--<td><img src="img/bank.jpg" height="35" alt="" /></td>-->
               <td><img src="img/pay_mc.png" height="35" alt="" /></td>
               <td><img src="img/pay_visa.png" height="35"  alt="" /></td>
               <td><img src="img/pay_wm.png" height="35"  alt="" /></td>
               <td><img src="img/pay_yad.png" height="35"  alt="" /></td>
               <td><img src="img/pay_qiwi.png" height="35"  alt="" /></td>
            </tr>
            <!--<tr>
               <td id="bank_req"><?php echo $constructor->getContent("payment", "bank_req"); ?></td>
               <td id="mc_req"><?php echo $constructor->getContent("payment", "mc_req"); ?></td>
               <td id="visa_req"><?php echo $constructor->getContent("payment", "visa_req"); ?></td>
            </tr>-->
            <!--<tr>
               <td><img src="img/pay_wm.png" height="35"  alt="" /></td>
               <td><img src="img/pay_yad.png" height="35"  alt="" /></td>
               <td><img src="img/pay_qiwi.png" height="35"  alt="" /></td>
            </tr>
            <tr>
               <td id="wm_req"><?php echo $constructor->getContent("payment", "wm_req"); ?></td>
               <td id="yad_req"><?php echo $constructor->getContent("payment", "yad_req"); ?></td>
               <td id="qiwi_req"><?php echo $constructor->getContent("payment", "qiwi_req"); ?></td>
            </tr>-->
         </table>
         <div style="width:100%; margin-top: 20px; text-align:center;color:#333">
            <div style="text-align: left">
               Оплата происходит через платежный агрегатор <a href="http://www.payanyway.ru/">PayAnyWay</a>.
               <p>Безопасность платежей обеспечивается использованием SSL протокола для передачи конфиденциальной информации от клиента на сервер 
               системы для дальнейшей обработки. Дальнейшая передача информации осуществляется по закрытым банковским сетям высшей степени защиты.
               <p>Обработка полученных в зашифрованном виде конфиденциальных данных клиента (реквизиты карты, регистрационные данные и т. д.) 
               производится в процессинговом центре. Таким образом, никто, даже продавец, не может получить персональные и банковские данные клиента, 
               включая информацию о его покупках, сделанных в других магазинах.
               <p>После совершения оплаты клиент в течение 3 (трех) рабочих дней получает на электронный адрес туристический ваучер, необходимый для
               последующего пользования туристическими услугами.
            </div>
         </div>
      </div>
   </div>

   <?php echo $constructor->getFooter(); ?>

   <script type="text/javascript" src="js/tour.js"></script>
   <script type='text/javascript'>
      (function(){ var widget_id = 'HoBi0ByIPY';
      var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
      <!-- {/literal} END JIVOSITE CODE -->
</body>  
</html>

<?php

mysql_close();

?>