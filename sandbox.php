<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="laki-hotel-ru">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <meta http-equiv="expires" content="Mon, 22 Jul 2002 11:12:01 GMT"/>
      <meta http-equiv="cache-control" content="no-cache"/>
      <meta name="description" content="Laki - это карельская гостиница для животных. Мы предлагаем услуги по временному содержанию и уходу за домашними животными, а также бесплатную консультацию у ветеринара в любое удобное для Вас время." />
      <meta http-equiv="keywords" content="гостиница для животных, гостиница для собак, отель для собак, передержка животных">
      <title>Travel | туристическое агентство</title>
      
   </head>
   <body id="page">

   <form method="post" action="https://www.payanyway.ru/assistant.htm">
   <input type="hidden" name="MNT_ID" value="18410598">
   <input type="hidden" name="MNT_AMOUNT" value="100">
   <input type="hidden" name="paymentSystem.unitId" value="843858">
   <input type="submit" value="Оплатить заказ">
   </form>

<?php

$myCurl = curl_init();
$request = '{"Envelope": {
 "Header": {
 "Security": {
 "UsernameToken": {
 "Username": "hello@karelia-travel.pro",
 "Password": "7AVqoUVj"
 }
 }
 },
 "Body": {
 "GetOperationDetailsByIdRequest": 87047780
 }
}}';

curl_setopt_array($myCurl, array(
   CURLOPT_URL => 'https://service.moneta.ru/services',
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_POST => true,
   CURLOPT_POSTFIELDS => $request,
   CURLOPT_HTTPHEADER => array('Content-Type:application/json')

));

$response = curl_exec($myCurl);
curl_close($myCurl);

//echo $response;
//echo json_decode($response, true);
?>

</body>
</html>