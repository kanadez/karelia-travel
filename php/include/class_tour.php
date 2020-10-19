<?php

class Tour{
   public function getSettlement($tour){
      global $db;
      $tour = intval($tour);
      $sql = "SELECT * FROM `settlement` WHERE `deleted` = 0 AND `tour` = $tour ORDER BY `timestamp`;";
      return json_encode($db->db_fetchall_array($sql, __LINE__, __FILE__));
   }
   
   public function getGroups($page_value){
      global $db;
      global $constructor;
      global $parameter;
      
      $dom = ""; // у рио делает тоггл на класс fullViewShowed если развернуть категории
      $sql = "SELECT * FROM `group` WHERE `deleted` = 0 ORDER BY `timestamp` DESC;";
      $result = $db->db_fetchall_array($sql, __LINE__, __FILE__);
      
      $page = $page_value-1;
      $per = $parameter->pagination_pages;
      $pages = ceil(count($result)/9);
      
      for ($i = $page*$per; $i < $page*$per+9; $i++){
         $out = 0;
         if ($i < count($result)){
            if ($i % 9 == 0) $dom .= "<br>";
            $dom .= 
            '<div '.($i == 0 ? 'id="first_gallery_box_div"' : '').' class="gallery_element_box">
               <a href="group.php?id='.$result[$i]["id"].'"><div class="gallery_element_box_img_wrapper">
                  <img id="group_img_'.$result[$i]["id"].'" src="catalog/'.$result[$i]["image"].'" style="" onload="resizeOnLoadVip(this)"/>
               </div>
               <div class="vip_desc_div"><span class="gallery_box_title" id="group_title_'.$i.'">'.$result[$i]["title"].'</span><p><p><span class="group_desc_div">'.$result[$i]["short_description"].'</span></div></a>
            </div>';
         }
      }
      
      $dom .= '<div style="text-align:center"><ul class="pagination">'.$constructor->setPagination($page_value, $pages, null).'</ul></div>';
      
      return $dom;
   }
   
   public function getTours($group, $page_value){
      global $db;
      global $constructor;
      global $parameter;
      $_group = intval($group);
      
      $dom = ""; // у рио делает тоггл на класс fullViewShowed если развернуть категории
      $sql = "SELECT * FROM `tour` WHERE `group` = $_group AND `deleted` = 0 ORDER BY `start_date` DESC;";
      $result = $db->db_fetchall_array($sql, __LINE__, __FILE__);
      
      $page = $page_value-1;
      $per = $parameter->pagination_pages;
      $pages = ceil(count($result)/9);
      
      for ($i = $page*$per; $i < $page*$per+9; $i++){
         $out = 0;
         if ($i < count($result)){
            if ($i % 9 == 0) $dom .= "<br>";
            $dom .= 
            '<div '.($i == 0 ? 'id="first_gallery_box_div"' : '').' class="gallery_element_box">
               <a href="tour.php?id='.$result[$i]["id"].'">
               <div class="gallery_element_box_img_wrapper">
               '.($result[$i]["hot"] == 1 ? '<div class="hot_badge">горящий</div>' : "").'
                  <img id="group_img_'.$result[$i]["id"].'" src="catalog/'.$result[$i]["photo"].'" style="" onload="resizeOnLoadVip(this)"/>
               </div>
               <div class="vip_desc_div"><span class="gallery_box_title" id="group_title_'.$i.'">'.$result[$i]["title"].'</span><p><p><span class="group_desc_div">'.$result[$i]["price"].' руб.</span></div></a>
            </div>';
         }
      }
      
      $dom .= '<div style="text-align:center"><ul class="pagination">'.$constructor->setPagination($page_value, $pages, "id=".$group).'</ul></div>';
      
      return $dom;
   }
   
   public function getHot($page_value){
      global $db;
      global $constructor;
      global $parameter;
      
      $dom = ""; // у рио делает тоггл на класс fullViewShowed если развернуть категории
      $sql = "SELECT * FROM `tour` WHERE `deleted` = 0 AND `hot` = 1 ORDER BY `start_date` DESC;";
      $result = $db->db_fetchall_array($sql, __LINE__, __FILE__);
      
      if (count($result) > 0){
         $page = $page_value-1;
         $per = $parameter->pagination_pages;
         $pages = ceil(count($result)/9);
         
         for ($i = $page*$per; $i < $page*$per+9; $i++){
            $out = 0;
            if ($i < count($result)){
               if ($i % 9 == 0) $dom .= "<br>";
               $dom .= 
               '<div '.($i == 0 ? 'id="first_gallery_box_div"' : '').' class="gallery_element_box">
                  <a href="tour.php?id='.$result[$i]["id"].'">
                  <div class="gallery_element_box_img_wrapper">
                  <div class="hot_badge">горящий</div>
                     <img id="group_img_'.$result[$i]["id"].'" src="catalog/'.$result[$i]["photo"].'" style="" onload="resizeOnLoadVip(this)"/>
                  </div>
                  <div class="vip_desc_div"><span class="gallery_box_title" id="group_title_'.$i.'">'.$result[$i]["title"].'</span><p><p><span class="group_desc_div">'.$result[$i]["price"].' руб.</span></div></a>
               </div>';
            }
         }
         
         $dom .= '<div style="text-align:center"><ul class="pagination">'.$constructor->setPagination($page_value, $pages, null).'</ul></div>';
      }
      else{
         $dom .= '<div style="margin-top:15vh;margin-bottom:25vh;width:100%; text-align:center">Горящих туров сейчас нет.<br>Выберите что-нибудь из обычных туров.<p style="margin-top:30px"></p><a href="tours.php" style="padding: 13px 44px;" class="orange_link">ПОСМОТРЕТЬ ВСЕ ТУРЫ</a></div>';
      }
      return $dom;
   }
   
   public function getSearchInitData(){
      global $db;
      
      $sql = "SELECT MAX(`end_date`), MIN(`price`), MAX(`price`) FROM `tour` WHERE `deleted` = 0;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      $sql = "SELECT `title`, `id` FROM `group` WHERE `deleted` = 0;";
      $result2 = $db->db_fetchall_array($sql, __LINE__, __FILE__);
      
      $complete["init_data"] = $result;
      $complete["group_data"] = $result2;
      
      return json_encode($complete);
   }
   
   public function search($group, $start_date, $end_date, $min_price, $max_price){
      global $db;
      
      $sql = "SELECT * FROM `tour` WHERE `group` = ".intval($group)." 
         ".($start_date != null ? " AND `start_date` >= ".intval($start_date) : "")." 
         ".($end_date != null ? " AND `end_date` <= ".intval($end_date) : "")."
         ".($min_price != null ? " AND `price` >= ".intval($min_price) : "")."
         ".($max_price != null ? " AND `price` <= ".intval($max_price) : "")."
         AND `deleted` = 0 ORDER BY `start_date` DESC;";
         
      return json_encode($db->db_fetchall_array($sql, __LINE__, __FILE__));
   }
   
   public function getGroupTitle($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT (SELECT `group`.`title` FROM `group` WHERE `group`.id = `tour`.`group`) AS `group` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["group"];
   }
   
   public function getGroupTitleByGroup($group){
      global $db;
      $_group = intval($group);
      
      $sql = "SELECT `title` FROM `group` WHERE `id` = $_group;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["title"];
   }
   
   public function getGroupId($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `group` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["group"];
   }
   
   public function getTitle($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `title` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["title"];
   }
   
   public function getPhoto($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `photo` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["photo"];
   }
   
   public function getShortDesc($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `short_description` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["short_description"];
   }
   
   public function getFullDesc($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `full_description` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["full_description"];
   }
   
   public function getRoute($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `route` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["route"];
   }
   
   public function getPriceDesc($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `price_description` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["price_description"];
   }
   
   public function getPhotos($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT * FROM `photo` WHERE `tour` = $_tour AND `deleted` = 0;";
      $result = $db->db_fetchall_array($sql, __LINE__, __FILE__);
      
      return $result;
   }
   
   public function getCrossLinks($tour){
      global $db;
      global $constructor;
      global $parameter;
      $_tour = intval($tour);
      
      $dom = ""; // у рио делает тоггл на класс fullViewShowed если развернуть категории
      $sql = "SELECT * FROM `tour` WHERE `deleted` = 0 AND id <> $_tour AND `group` = (SELECT `group` FROM `tour` WHERE `id` = $_tour) ORDER BY `start_date` DESC LIMIT 3;";
      $result = $db->db_fetchall_array($sql, __LINE__, __FILE__);
      
      for ($i = 0; $i < 3; $i++){
         $out = 0;
         if ($i < count($result)){
            $dom .= 
            '<div '.($i == 0 ? 'id="first_gallery_box_div"' : '').' class="gallery_element_box">
               <a href="tour.php?id='.$result[$i]["id"].'"><div class="gallery_element_box_img_wrapper">
                  <img id="group_img_'.$result[$i]["id"].'" src="catalog/'.$result[$i]["photo"].'" style="" onload="resizeOnLoadVip(this)"/>
               </div>
               <div class="vip_desc_div"><span class="gallery_box_title" id="group_title_'.$i.'">'.$result[$i]["title"].'</span><p><p><span class="group_desc_div">'.$result[$i]["price"].'</span></div></a>
            </div>';
         }
      }
      
      return $dom;
   }
   
   public function getDates($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `start_date`, `end_date` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return json_encode($result);
   }
   
   public function getPrice($tour){
      global $db;
      $_tour = intval($tour);
      
      $sql = "SELECT `price` FROM `tour` WHERE `id` = $_tour;";
      $result = $db->db_fetchone_array($sql, __LINE__, __FILE__);
      
      return $result["price"];
   }
}

?>