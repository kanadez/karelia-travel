<?php

class Feedback{
   public function get($page_value){
      global $db;
      global $constructor;
      global $parameter;
      
      $dom = ""; // у рио делает тоггл на класс fullViewShowed если развернуть категории
      $sql = "SELECT * FROM `feedback` ORDER BY `timestamp` DESC;";
      $result = $db->db_fetchall_array($sql, __LINE__, __FILE__);
      
      $page = $page_value-1;
      $per = $parameter->pagination_pages;
      $pages = ceil(count($result)/3);
      
      for ($i = $page*$per; $i < $page*$per+3; $i++){
         $out = 0;
         if ($i < count($result)){
            $dom .= 
            '<div id="feedback_'.$i.'" class="friend_block">
                  <div class="frienddata_wrapper"><div class="friendphoto_wrapper">
                     <img id="user_'.$i.'_photo" src="'.$result[$i]["user_photo"].'" class="friend_image_w">
                  </div>
                  <span class="friendname"><a href="http://vk.com/id'.$result[$i]["user_id"].'">'.$result[$i]["user_name"].'</a></span>
                  <br><div class="message_preview">'.$result[$i]["text"].'</div>
                  </div>
                  <span class="msg_time">'.$date = date('d.m', $result[$i]["timestamp"]).'</span>
               </div>';
         }
      }
      
      $dom .= '<div style="text-align:center"><ul class="pagination">'.$constructor->setPagination($page_value, $pages, null).'</ul></div>';
      
      return $dom;
   }
   
   public function set($user_id, $user_name, $user_photo, $text){
      global $db;
      
      $sql = sprintf("INSERT INTO `feedback` (`user_id`, `user_name`, `user_photo`, `text`, `timestamp`) VALUES (%d, '%s', '%s', '%s', %d);", // добавляем транзкцию пополнения юзеру
         mysql_real_escape_string($user_id),
         mysql_real_escape_string($user_name),
         mysql_real_escape_string($user_photo),
         mysql_real_escape_string($text),
         mysql_real_escape_string(time()));
      return $db->db_query($sql, __LINE__, __FILE__);
   }
   
   public function okAuth($token){
      return $sig = md5($token."82630551AD94447BFE21487C");
   }
}

?>