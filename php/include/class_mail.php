<?php

class Mail{
   public function sendEmail($to, $subject, $message){
      $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
      $headers .= "From: Karelia Travel <noreply@karelia-travel.pro>\r\n";
      
      return mail($to, $subject, $message, $headers);
   }
}

?>