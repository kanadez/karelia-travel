function showNewOrders(){
   urlparser.setURL("section=orders&screen=new");
   $('#content_div').html("");
   $('#content_div').load("./dom/new_orders_table.html", function() {
      setNewOrdersFormDom();
   });
}

function setNewOrdersFormDom(){
   $.post(
      post_url, {
         a: "gNO"
      }, 
      function(result){
         var obj = JSON.parse(result);
         
         for (var k in obj){
            console.log(obj);
            $('#new_orders_table').append("<tr id='table_row_"+k+"'></tr>");
            $('#table_row_'+k).append("<td>"+obj[k].id+"</td>");
            $('#table_row_'+k).append("<td><a href='../tour.php?id="+obj[k].tour_id+"' target='_blank'>"+obj[k].tour_title+"</a></td>");
            var client_data = JSON.parse(obj[k].client_data);
            var str = "";
            for (var i = 0; i < client_data.length; i++){
               str += "Пассажир "+(i+1)+": "+(client_data[i].type == 2 ? "ребёнок" : "взрослый")+", Имя: "+client_data[i].name+(client_data[i].type == 1 ? ", Паспорт: "+client_data[i].passport_data1+" "+client_data[i].passport_data2+" "+client_data[i].passport_data3 : ", Св-во о рождении: "+client_data[i].bcert_data)+(i === 0 ? ", День рождения: "+getDayNMonthFromTimestamp(client_data[i].bdate) : "")+"<br>";
            }
            $('#table_row_'+k).append("<td style='text-align:left'>"+str+"</td>");
            $('#table_row_'+k).append("<td>"+obj[k].phone+"</td>");
            $('#table_row_'+k).append("<td><a href='mailto:"+obj[k].email+"'>"+obj[k].email+"</a></td>");
            $('#table_row_'+k).append("<td>"+getDateFromTimestamp(obj[k].settlement_timestamp)+"</td>");
            $('#table_row_'+k).append("<td>"+getDateFromTimestamp(obj[k].order_timestamp)+"</td>");
            $('#table_row_'+k).append("<td>"+obj[k].total+"</td>");
            $('#table_row_'+k).append("<td>"+getPaymentStatus(obj[k].payment_status)+"</td>");
            $('#table_row_'+k).append("<td><button onclick='confirmNewOrder("+obj[k].id+")'>Подтвердить</button></td>");
         }
      });
}

function getPaymentStatus(value){
   if (value == 0)
      return "не оплачено";
   else if (value == 1)
      return "оплачено";
   else if (value == 2)
      return "оплата отменена";
   else if (value == 3)
      return "ошибка при оплате";
}

function confirmNewOrder(order_number){
   $.post(
      post_url, {
         a: "cNO",
         b: order_number
      }, 
      function(){
         showNewOrders();
      });
}

//######################################### WORKING WITH CONFIRMED ORDERS BELOW #####################################################

function showConfirmedOrders(){
   urlparser.setURL("section=orders&screen=confirmed");
   $('#content_div').html("");
   $('#content_div').load("./dom/new_orders_table.html", function() {
      setConfirmedOrdersFormDom();
   });
}

function setConfirmedOrdersFormDom(){
   $.post(post_url, {
      a: "gCO"
   }, 
   function(result){
      var obj = JSON.parse(result);
      
      for (var k in obj){
         console.log(obj);
         $('#new_orders_table').append("<tr id='table_row_"+k+"'></tr>");
         $('#table_row_'+k).append("<td>"+obj[k].id+"</td>");
         $('#table_row_'+k).append("<td><a href='../tour.php?id="+obj[k].tour_id+"' target='_blank'>"+obj[k].tour_title+"</a></td>");
         var client_data = JSON.parse(obj[k].client_data);
         var str = "";
         for (var i = 0; i < client_data.length; i++){
            str += "Пассажир "+(i+1)+": "+(client_data[i].type == 2 ? "ребёнок" : "взрослый")+", Имя: "+client_data[i].name+(client_data[i].type == 1 ? ", Паспорт: "+client_data[i].passport_data1+" "+client_data[i].passport_data2+" "+client_data[i].passport_data3 : ", Св-во о рождении: "+client_data[i].bcert_data)+(i === 0 ? ", День рождения: "+getDayNMonthFromTimestamp(client_data[i].bdate) : "")+"<br>";
         }
         $('#table_row_'+k).append("<td style='text-align:left'>"+str+"</td>");
         $('#table_row_'+k).append("<td>"+obj[k].phone+"</td>");
         $('#table_row_'+k).append("<td><a href='mailto:"+obj[k].email+"'>"+obj[k].email+"</a></td>");
         $('#table_row_'+k).append("<td>"+getDateFromTimestamp(obj[k].settlement_timestamp)+"</td>");
         $('#table_row_'+k).append("<td>"+getDateFromTimestamp(obj[k].order_timestamp)+"</td>");
         $('#table_row_'+k).append("<td>"+obj[k].total+"</td>");
         $('#table_row_'+k).append("<td>"+getPaymentStatus(obj[k].payment_status)+"</td>");
         $('#table_row_'+k).append("<td><button onclick='deleteConfirmedOrder("+obj[k].id+")'>Удалить</button></td>");
      }
   });
}

function deleteConfirmedOrder(order_number){
   $.post(post_url, {
      a: "dCO",
      b: order_number
   }, 
   function(){
      showConfirmedOrders();
   });
}