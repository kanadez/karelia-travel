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
   <h3 style="width:100%; text-align:center;color:#333">Контакты</h3>
   <div style="width:100%;text-align:center;color:#333"><?php echo $constructor->getContent("about", "company_name");?></div>
   

   <p style=" color: #333;">
     <img src="img/telephone46.png" style="margin-right: 5px;margin-top: -11px;opacity: 0.5;" height="15" width="15" align="center" alt="" />
     <?php echo $constructor->getContent("about", "company_phone");?>
   </p>

   <p style=" color: #333;">
     <img src="img/email5.png" style="margin-right: 5px;margin-top: -11px;opacity: 0.5;" height="15" width="15" align="center" alt="" />
     <a href="mailto:<?php echo $constructor->getContent("about", "company_email"); ?>"><?php echo $constructor->getContent("about", "company_email"); ?></a>
   </p>
   <br>
   <h3 style="width:100%; text-align:left;color:#333">Реквизиты <?php echo $constructor->getContent("about", "company_name"); ?></h3>
   <br>
   <table style="color:#333; width:100%">
     <tr>
      <td style="text-align:left">Тел.: <?php echo $constructor->getContent("about", "company_phone");?></td>
    </tr>
    <tr>
      <td style="text-align:left"><?php echo $constructor->getContent("about", "company_name");?></td>
    </tr>
    <tr>
      <td style="text-align:left"><?php echo $constructor->getContent("about", "company_data1");?></td>
    </tr>
    <tr>
      <td style="text-align:left"><?php echo $constructor->getContent("about", "company_data2");?></td>
    </tr>
    <tr>
      <td style="text-align:left"><?php echo $constructor->getContent("about", "company_address");?></td>
    </tr>
    <tr>
      <td style="text-align:left"><?php echo $constructor->getContent("about", "company_data3");?></td>
    </tr>
    <tr>
      <td style="text-align:left"><?php echo $constructor->getContent("about", "company_data4");?></td>
    </tr>
    <tr>
      <td style="text-align:left"><?php echo $constructor->getContent("about", "company_data5");?></td>
    </tr>
    <tr>
      <td style="text-align:left"><?php echo $constructor->getContent("about", "company_data6");?></td>
    </tr>
  </table>
  <br><br>
  <h3 style="width:100%; text-align:left;color:#333">Физический адрес:</h3>
  <p style="width:100%; text-align:left;color:#333"><?php echo $constructor->getContent("about", "company_address");?></p>
  <br>
  <br>
  <a name="map"></a>
  <h3 style="width:100%; text-align:center;color:#333">Как до нас добраться:</h3>
</div>
<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=GQLqKz4u1fVT1eZ4BTIDBidiM-CFyJGD&width=100%&height=465&lang=ru_RU&sourceType=constructor"></script>
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