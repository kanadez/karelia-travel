<?php

session_start();

if (isset($_SESSION['user_id'])) {
    echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
      <title>KCS Admin Panel</title>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <link rel="stylesheet" type="text/css" href="css/main.css"  />
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
      <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
      <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
      <script src="jq/upload.js"></script>
      <script src="//tinymce.cachefly.net/4.3/tinymce.min.js"></script>
      <script src="js/jquery.tinymce.min.js"></script>
   </head>
   <body>
      <div id="side_panel_div" class="side_panel">
		   <div id="accordion_div">
			   <div>
				   <h3><a href="#">Сайт</a></h3>
				   <div>
				      <button id="mainpage_edit" class="side_panel_button" onclick="editMainPage()">Главная</button>
				      <button id="about_edit" class="side_panel_button" onclick=\'urlparser.setURL("section=content&screen=about"); location.reload();\'>О нас</button>
				      <button id="tour_groups_edit" class="side_panel_button" onclick="editTourGroups()">Туры</button>
               </div>
			   </div>
			   <div>
				   <h3><a href="#">Заказы</a></h3>
				   <div>
                  <button id="new_orders_a" class="side_panel_button" onclick="showNewOrders()">Новые</button>
				      <button id="confirmed_orders_a" class="side_panel_button" onclick="showConfirmedOrders()">Подтверждённые</button>
				   </div>
			   </div>
			   <div>
				   <h3><a href="#">Рассылка</a></h3>
				   <div>
                  <button id="email_db_a" class="side_panel_button" onclick="showEmailDB()">База e-mail адресов</button>
                  <button id="delivery_a" class="side_panel_button" onclick=\'urlparser.setURL("section=delivery&screen=mass"); location.reload();\'>Массовая рассылка</button>
                  <button id="bdate_delivery_a" class="side_panel_button" onclick=\'urlparser.setURL("section=delivery&screen=bdate"); location.reload();\'>Рассылка поздравления с ДР</button>
				   </div>
			   </div>
		   </div>
      </div>
      <div id="content_div" >
      </div>
      <script type="text/javascript" src="js/urlparser.js?1"></script>
      <script type="text/javascript" src="js/main.js?2" ></script>
      <script type="text/javascript" src="js/new_orders.js?2" ></script>
      <script type="text/javascript" src="js/edit_tour.js?4" ></script>
      <script type="text/javascript" src="js/edit_tours.js?2" ></script>
      <script type="text/javascript" src="js/edit_tour_groups.js?2" ></script>
      <script type="text/javascript" src="js/edit_mainpage.js?2" ></script>
      <script type="text/javascript" src="js/edit_aboutpage.js?3" ></script>
      <script type="text/javascript" src="js/email_db.js?2" ></script>
      <script type="text/javascript" src="js/utils.js?3" ></script>
      <script src="js/jquery.ui.widget.js"></script>
      <script src="js/jquery.iframe-transport.js"></script>
      <script src="js/jquery.fileupload.js"></script>
   </body>
</html>
';
}
else 
{
    header('Location: http://'.$_SERVER['HTTP_HOST']."/admin");
}

?>
