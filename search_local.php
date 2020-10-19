<?php

require_once dirname(__FILE__)."/php/include/class_db.php";
require_once dirname(__FILE__)."/php/include/class_constructor.php";
require_once dirname(__FILE__)."/php/include/class_tour.php";
require_once dirname(__FILE__)."/php/include/data_parameter.php";

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
   $tour = new Tour;
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
      <link type="text/css" rel="stylesheet" href="css/search.css"/>
      <link rel="stylesheet" type="text/css" href="css/dropdown.css" />
      <link rel="stylesheet" type="text/css" href="css/gallery.css" />
      <link rel="stylesheet" type="text/css" href="css/white.css" />
      <link type="text/css" rel="stylesheet" href="jq-ui/jquery-ui.css"/>
      <link rel="shortcut icon" href="/img/icon.png">
      <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="jq-ui/jquery-ui.js"></script>
      
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
         
         <?php echo $constructor->getWhiteHeader("search"); ?>
         
         <div id="content_div">
            <h3 style="width:100%; text-align:center;color:#333">Поиск тура по Карелии</h3>
            <div id="search_form">
               <label style="float:left">Даты:</label>
               <div id="settle_dates_div"><input id="settle_start_input" value="" placeholder="Начальная" onchange=""/> - 
               <input id="settle_end_input" value="" onchange="" placeholder="Конечная"/></div>
               <br><label style="float:left">Цена:</label>
               <div id="slider_leftedge_span" style="margin:7px 0 10px 0;float:left">1000</div>
               <div id="slider_rightedge_span" style="float: right;margin-right: 19px;margin-top: 7px;">10000</div>
               <br><div id="price_slider" style="height: 10px;margin-left: 53px;margin-top: 17px;width: 406px;margin-bottom: 20px"></div>
               <br><label style="float:left; margin-left:-62px">Категория тура:</label>
               <select id="tour_select" value="Выбрать">
               </select>
               <br><div style="margin:40px 0 0 43px">
                  <button id="search_tour" class="sbmt" style="">НАЙТИ ТУРЫ</button>
                  <button id="reset_form" class="sbmt transparent_sbmt" style="">СБРОСИТЬ</button>
               </div>
            </div>
            <div id="tours_div" style="width:100%; text-align:left;padding-top: 20px;">
               <div style="color: #aaa !important;font-size: 0.85em;margin-left: 12px;margin-bottom: 10px;margin-top: 20px;text-align: center;width: 100%;">Выберите параметры поиcка и нажмите "Найти туры". Результаты появятся здесь.</div>
            </div>
         </div>
      </div>
      
      <?php echo $constructor->getFooter(); ?>
      
      <script type="text/javascript" src="js/search.js"></script>
      <script type='text/javascript'>
      (function(){ var widget_id = 'HoBi0ByIPY';
      var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
      <!-- {/literal} END JIVOSITE CODE -->
   </body>  
</html>

<?php

mysql_close();

?>