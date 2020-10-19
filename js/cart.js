var post_url = "php/main.php";

$(document).ready(function(){
   showCart();
});

function showCart(){
   $.post(post_url,{
      a: "cart_get",
      b: localStorage.user_id
   }, 
   function (result){
      var obj = JSON.parse(result);
      
      if (obj.length > 0){
         $('#content_div').append("<div id='cart_div'></div>");      
         $('#cart_div').append("<table id='cart_table' class='cart_table' cellspacing=0 cellpadding=0 border=0></table>");
         
         for (var i = 0; i < obj.length; i++){
            $('#cart_table').append("<tr><td id='cart_table_td_"+i+"'></td></tr>");
            $('#cart_table_td_'+i).html("<img id='cart_table_img_"+i+"' class='cart_table_img' src='catalog/"+obj[i].tour_photo+"'/>");
            $('#cart_table_td_'+i).append("<div id='cart_table_item_"+i+"' class='cart_item_info'></div>");
            $('#cart_table_item_'+i).append("<span id='cart_table_item_name_span_"+i+"' class='cart_item_name'><a href='tour.php?id="+obj[i].tour+"'>"+obj[i].tour_title+"</a></span>");
            $('#cart_table_item_'+i).append("<br><span id='cart_table_item_name_span_"+i+"' class='cart_item_besides_name'>Дата заезда: "+getDayNMonthFromTimestamp(obj[i].settlement_timestamp)+"</span>");  
            $('#cart_table_item_'+i).append("<br><span id='cart_table_item_price_span_"+i+"' class='cart_item_besides_name'>Стоимость: "+obj[i].tour_price+" руб.</span>");
               
            $('#cart_table_item_'+i).append("<br><span id='cart_table_item_status_span_"+i+"' class='cart_item_besides_name'>Статус: "+parseOrderStatus(obj[i].confirmed, obj[i].payment_status)+"</span>");
            if (obj[i].confirmed == 0 && obj[i].payment_status != 1) $('#cart_table_item_'+i).append("<a id='pay_order_"+obj[i].id+"' onclick='showPaymentForm("+obj[i].id+")' class='button pay_order_button' href='javascript:void(0)'>Оплатить</a><br>");
            $('#cart_table_item_'+i).append("<a id='cancel_order_"+obj[i].id+"' class='button cancel_order_button' href='javascript:void(0)'>Отменить</a>");

            $('#cart_table_item_'+i).append("<a id='restore_cancelled_order_"+obj[i].id+"' class='text_link restore_button' href='javascript:void(0)'>Восстановить</a></div>");                  
            $('#cancel_order_'+obj[i].id).bind("click",{
               num: obj[i].id,
               cancel_button_id: 'cancel_order_'+obj[i].id,
               restore_button_id: 'restore_cancelled_order_'+obj[i].id
            },
            function(event){
               $('#'+event.data.cancel_button_id).hide();
               $('#'+event.data.restore_button_id).show();
               cancelCartItem(event.data.num);
            });
               
            $('#restore_cancelled_order_'+obj[i].id).bind("click",{
               id: obj[i].id,
               cancel_button_id: 'cancel_order_'+obj[i].id,
               restore_button_id: 'restore_cancelled_order_'+obj[i].id
            },
            function(event){
               $('#'+event.data.cancel_button_id).show();
               $('#'+event.data.restore_button_id).hide();
               restoreCartItem(event.data.id);
            });
         }
      }
      else{
         $('#content_div').append('<div style="margin-top:15vh;margin-bottom:25vh;width:100%; text-align:center">Ваша корзина сейчас пуста.<br>Выберите что-нибудь из текущих туров.<p style="margin-top:30px"></p><a href="tours.php" style="padding: 13px 57px;" class="orange_link">ПОСМОТРЕТЬ ТУРЫ</a></div>');
      }
   });
}

function parseOrderStatus(confirmed, payment_status){
   if (confirmed == 0){
      if (payment_status == 0)
         return "не оплачено";
      if (payment_status == 1)
         return "оплачено, не подтверждено (мы позвоним Вам)";//(<a href='help.php?confirmation'>как подтвердить?</a>)";
      if (payment_status == 2)
         return "оплата была отменена";
      if (payment_status == 3)
         return "ошибка при оплате, попробуйте оплатить снова";
   }
   else return "оплачено и подтверждено";
}

function cancelCartItem(id){
   $.post(post_url,{
      a: "dO",
      b: id
   }, 
   function (result){
      
   });
}

function restoreCartItem(id){
   $.post(post_url,{
      a: "rO",
      b: id
   }, 
   function (result){
      
   });
}

function showPaymentForm(order_number){
   try{
      if (order_number === undefined)
         throw "Error: order number is undefined";
      
      $('#cart_div').load("./dom/order_confirm_form.html", function() {
         $.post(post_url,{
            a: "cart_get_payment_data",
            b: order_number
         }, 
         function (response){
            var obj = JSON.parse(response);
            $('#tour_title_span').html("<a href='tour.php?id="+obj.tour_id+"' target='_blank'>"+obj.tour_title+"</a>");
            $('#tour_price_span').html(obj.tour_price+" руб.");
            $('#tour_settlement_span').html(getDayNMonthYearFromTimestamp(obj.settlement_timestamp));
            $('#tour_order_span').html(getDayNMonthYearFromTimestamp(obj.order_timestamp));
            
            var client_data = JSON.parse(obj.client_data);
            console.log(client_data);
            for (var i = 0; i < client_data.length; i++){
               var tr = $("<tr />");
               tr.append("<td>"+client_data[i].name+"</td>");
               tr.append("<td>"+(client_data[i].type == 2 ? "ребёнок" : "взрослый")+"</td>");
               tr.append("<td>"+(client_data[i].type == 1 ? client_data[i].passport_data1+" "+client_data[i].passport_data2+" "+client_data[i].passport_data3 : client_data[i].bcert_data)+"</td>");
               
               if (i === 0){
                  tr.append("<td>"+obj.phone+"</td>");
                  tr.append("<td>"+obj.email+"</td>");
               }
               
               $('#tourists_table').append(tr);
            }
            
            $('#order_button').val("Оплатить "+obj.tour_price+" руб.");
            $('input[name=MNT_AMOUNT]').val(obj.tour_price);
            $('input[name=MNT_TRANSACTION_ID]').val(obj.id);
         });
         
         $('#cancel_payment_button').remove();
         $('#moneta_form').append('<a id="cancel_payment_a" class="sbmt transparent_sbmt" href="cart.php">Отмена</a>');
      });
   }
   catch(error){
      console.log(error);
   }
}