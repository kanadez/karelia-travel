var post_url = "post.php";

$(document).ready(function(){
   $('#copyr_div').offset({top:$(window).height()-35});
   //$('#copyr_div').offset({left:$(window).width()/2});
   createDogTable();
});

function createDogTable(){
   $('#content_div').html('<div class="centered_msg msg half-transparent" style="margin-top:10%">Суточная стоимость пребывания Вашей собаки в нашей гостинице составит:</div>');
   $('#content_div').append('<div class="msg" style="margin-top:20px;width: 62%" id="table_div"></div>');
   $('#table_div').load("dom/dog_pricelist_table.html", function(){getDogPrices()});
   $('#content_div').append('<div class="msg half-transparent" style="margin-top:20px;">Если Ваш питомец агрессивный, особенно крупный или нуждается в услугах ветеринара, стоимость его содержания обговаривается отдельно.</div>');
   $('#content_div').append('<div class="msg half-transparent" style="margin-top:10px;">Также мы можем самостоятельно доставить Вашу собаку в гостиницу. Трансфер стоит 600 рублей.</div>');
   $('#content_div').append('<div style="margin-top:40px;"><button id="reserve_button" class="sbmt">ЗАБРОНИРОВАТЬ МЕСТО</button></div>');
   $('#reserve_button').click(function(){
      reserve();
   });
}

function reserve(){
   window.location = "reserve.html";
}

function getDogPrices(){
   $.post(
      post_url,{
         a: "gP"
      }, 
      function (result){
         var obj = eval("(" + result + ")");
         assignDogPrices(obj);
      }
   );
}

function assignDogPrices(prices_obj){
   $('#own_account_pet_0').html(prices_obj[0].own_account+" рублей");
   $('#own_account_pet_1').html(prices_obj[1].own_account+" рублей");
   $('#own_account_pet_2').html(prices_obj[2].own_account+" рублей");
   $('#on_the_house_pet_0').html(prices_obj[0].on_the_house+" рублей");
   $('#on_the_house_pet_1').html(prices_obj[1].on_the_house+" рублей");
   $('#on_the_house_pet_2').html(prices_obj[2].on_the_house+" рублей");
}