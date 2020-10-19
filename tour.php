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
      <link type="text/css" rel="stylesheet" href="css/tour.css"/>
      <link rel="stylesheet" type="text/css" href="css/dropdown.css" />
      <link rel="stylesheet" type="text/css" href="css/gallery.css" />
      <link rel="stylesheet" type="text/css" href="css/white.css" />
      <link type="text/css" rel="stylesheet" href="jq-ui/jquery-ui.css"/>
      <link rel="shortcut icon" href="/img/icon.png">
      <script type="text/javascript" src="js/gallery.js"></script>
      <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="jq-ui/jquery-ui.js"></script>
      <script type="text/javascript" src="js/jquery.color-2.1.2.min.js"></script>
      
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
         
         <?php echo $constructor->getWhiteHeader("tours"); ?>
         
         <div id="content_div">
            <div id="breadcrumbs_div" style=" float:left"><a href="tours.php">Все туры</a> ❯ <a href="group.php?id=<?php echo $tour->getGroupId($_GET["id"]) ?>"><?php echo $tour->getGroupTitle($_GET["id"]) ?></a> ❯ <a href="tour.php?id=<?php echo $_GET["id"] ?>"><?php echo $tour->getTitle($_GET["id"]) ?></a></div>
            <div style="clear:both"></div>
            <h3 class="centered_h3"><?php echo $tour->getTitle($_GET["id"]) ?></h3>
            <div id="main_image" style="margin-top:20px;width:100%; height:400px; background-image: url(catalog/<?php echo $tour->getPhoto($_GET["id"]) ?>); background-size:cover;"></div>
            <div id="description" style="margin-top:20px; text-align:left"><?php echo $tour->getShortDesc($_GET["id"]) ?></div>
            <div id="price" style="margin-top:20px; text-align:left;color: rgb(255, 131, 0) !important">Полная стоимость тура: <?php echo $tour->getPrice($_GET["id"]) ?> руб.</div>
            <div id="tabs" style="margin-top:20px">
               <ul>
                  <li><a href="#tabs-1">Фото</a></li>
                  <li><a href="#tabs-2">Описание</a></li>
                  <li><a href="#tabs-3">Маршрут</a></li>
                  <li><a href="#tabs-4">Цены</a></li>
                  <li style="background: rgba(255, 166, 0, 0.6)"><a href="#tabs-5">Сделать заказ</a></li>
               </ul>
               <div id="tabs-1" class="tabs_content">
                  <table>
                  <?php
                     $photos = $tour->getPhotos($_GET["id"]);
                     
                     for ($i = 0; $i < ceil(count($photos)/4); $i++){
                        echo "<tr>";
                        for ($z = $i*4; $z < $i*4+4; $z++){
                           echo $photos[$z]["thumb"] != "" ? "<td><div id='photo".$z."' photoid='".$z."' photosrc='catalog/".$photos[$z]["original"]."' onclick=\"slideshow(".$z.")\" style='background-image:url(catalog/".$photos[$z]["thumb"].");' class='gallery_photo_wrapper'></div></td>" : "";
                        }
                        echo "</tr>";
                     }
                  ?>
                  </table>
               </div>
               <div id="tabs-2" class="tabs_content">
                  <p><?php echo $tour->getFullDesc($_GET["id"]) ?></p>
               </div>
               <div id="tabs-3" class="tabs_content">
                  <p><?php echo $tour->getRoute($_GET["id"]) ?></p>
               </div>
               <div id="tabs-4" class="tabs_content">
                  <p><?php echo $tour->getPriceDesc($_GET["id"]) ?></p>
               </div>
               <div id="tabs-5" class="tabs_content">
                  <h3 class="centered_h3">Оформление заказа на тур</h3>
                  <div id="order_progress_bar_div">
                     <div id="order_step_1_div" class="order_step order_step_active">Шаг 1: Ввод личных данных</div>
                     <div id="order_step_2_div" class="order_step order_step_unactive">Шаг 2: Оплата</div>
                  </div>
                  <p>
                  <div id="order_form" class="input_mode">
                     <label style="float: left;margin-left: 150px;" for="settlement_select">Выберите дату размещения:</label>
                     <select id="settlement_select" class="neccesary_input" style="width:277px;"></select>
                     <!--<input id="settle_start_input" style="width:259px" class="neccesary_input"/>-->
                     <div id="passengers_wrapper">
                        <div id="passenger1_wrapper">
                           <p><label for="item_status_input" style="margin-right:44px" class="neccesary">Пассажир: </label>
                           <input type="radio" name="passenger1_type_input" onchange="" style="width:20px" id="passenger1_type1_input" checked value="1"/><label for="passenger1_type1_input" class="neccesary_check">Взрослый</label>
                           <input type="radio" name="passenger1_type_input" onchange="" style="margin-left:33px;width:20px" id="passenger1_type2_input" value="2"/><label for="passenger1_type2_input" class="neccesary_check" style="margin-right:36px">Ребёнок</label>
                           <p><label for="name_input">Ваше имя:</label>
                           <input id="name_input" style="width:259px" class="neccesary_input" value="" placeholder="Например: Вася Петров" onchange=""/>
                           <p><label style="float: left;margin-left: 226px;" for="bdate_year_select">Дата рождения:</label>
                           <select id="bdate_year_select" class="neccesary_input" value="Год" style="width:89px;"></select>
                           <select id="bdate_month_select" class="neccesary_input" value="Месяц" style="width:89px;">
                              <option value="11">декабрь</option>
                              <option value="10">ноябрь</option>
                              <option value="9">октябрь</option>
                              <option value="8">сентябрь</option>
                              <option value="7">август</option>
                              <option value="6">июль</option>
                              <option value="5">июнь</option>
                              <option value="4">май</option>
                              <option value="3">апрель</option>
                              <option value="2">март</option>
                              <option value="1">февраль</option>
                              <option value="0">январь</option>
                           </select>
                           <select id="bdate_day_select" class="neccesary_input" value="День" style="width:89px;"></select>
                           <p><label id="bcert1_label" for="bcert1_input" style="display:none">Свидетельство о рождении:</label>
                           <input id="bcert1_input" style="width:259px;display:none;" value="" placeholder="" onchange=""/>
                           <p><label id="passport1_label" for="passport_input1">Паспортные данные:</label>
                           <input id="passport1_input1" style="width:119px" class="neccesary_input" value="" placeholder="серия" onchange=""/>
                           <input id="passport1_input2" style="width:118px" class="neccesary_input" value="" placeholder="номер" onchange=""/>
                           <br><input id="passport1_input3" style="width:259px;margin-top:5px" class="neccesary_input" value="" placeholder="когда и где выдан" onchange=""/>
                        </div>
                     </div>
                     <p><button id="add_passenger_button" class="link_button sbmt" style="width:259px">ДОБАВИТЬ ЕЩЁ ПАССАЖИРА</button>
                     <p><label for="phone_input">Ваш номер телефона:</label>
                     <input id="phone_input" style="width:259px" class="neccesary_input" value="" placeholder="Например: +79111234567" onchange=""/>
                     <p><div id="email_notmatch_alert" style="width:255px;margin-bottom: 0;" class="alert">Ошибка: адреса не совпадают</div>
                     <p><label for="email_input">Ваш E-mail:</label>
                     <input id="email_input" style="width:259px" class="neccesary_input" value="" placeholder="Например: vasya@yandex.ru" onchange=""/>
                     <p><label for="email_again_input">E-mail ещё раз:</label>
                     <input id="email_again_input" style="width:259px" class="neccesary_input" value="" placeholder="Тот же самый, повторно" onchange=""/>
                     <p><button id="order_button" class="sbmt" style="width:259px;margin-top:20px">ОФОРМИТЬ ЗАКАЗ</button>
                  </div>
               </div>
            </div>
            <div id="crosslinks_label">Похожие туры:</div>
            <div id="crosslinks_div">
               <?php echo $tour->getCrossLinks($_GET["id"]) ?>
            </div>
         </div>
      </div>
      
      <?php echo $constructor->getFooter(); ?>
      
      <script type="text/javascript" src="js/tour.js?3"></script>
      <script type="text/javascript" src="js/utils.js?3"></script>
      <!-- BEGIN JIVOSITE CODE {literal} -->
      <script type='text/javascript'>
      (function(){ var widget_id = 'HoBi0ByIPY';
      var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
      <!-- {/literal} END JIVOSITE CODE -->
   </body>  
</html>

<?php

mysql_close();

?>