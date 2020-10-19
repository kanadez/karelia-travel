var post_url = "php/main.php";
var selected_date = null;
var passenger_count = 1;
var selected_bdate_day = 31;
var selected_bdate_month = 11;
var selected_bdate_year = 2013;
var order_number;

$(document).ready(function(){
   $( "#tabs" ).tabs();
   init();
});

function init(){
   $.post(post_url,{
      a: "tour_get_settlement",
      b: getUrlParameter("id")
   }, 
   function (result){
      var obj = JSON.parse(result);
      selected_date = obj[0].timestamp;
      
      for (var i = 0; i < obj.length; i++)
         $('#settlement_select').append("<option value='"+obj[i].timestamp+"'>"+getDayNMonthYearFromTimestamp(obj[i].timestamp)+"</option>");
         
      $('#settlement_select').selectmenu({
         height: 160,
         change: function(event, ui) {
            selected_date = ui.item.value;
            $('#settlement_select-button').removeClass("neccesary_input");
         }
      });
   });
   
   $('#passenger1_type1_input').click(function(){
      passengerTypeAdult(1);
   });
   
   $('#passenger1_type2_input').click(function(){
      passengerTypeChild(1);
   });
   
   /*$.post(
      post_url,{
         a: "tour_get_dates",
         b: getUrlParameter("id")
      }, 
      function (result){
         var obj = JSON.parse(result);
         
         $('#settle_start_input').datepicker({ 
            dateFormat: "dd/mm/yy", 
            //minDate: new Date(obj.start_date*1000), 
            //maxDate: new Date(obj.end_date*1000), 
            onSelect: function(){
               selected_date = $('#settle_start_input').datepicker("getDate")/1000;
            }
         });
      });*/
      
   $('#add_passenger_button').click(function(){
      passenger_count++;
      $('#passengers_wrapper').append('<div id="passenger'+passenger_count+'_wrapper" style="margin-top:40px"><p><label for="item_status_input" style="margin-right:44px" class="neccesary">Пассажир '+passenger_count+': </label><input type="radio" checked name="passenger'+passenger_count+'_type_input" class="neccesary_input" style="width:20px" id="passenger'+passenger_count+'_type1_input" onclick="passengerTypeAdult('+passenger_count+')" value="1"/><label for="passenger'+passenger_count+'_type1_input">Взрослый</label><input type="radio" name="passenger'+passenger_count+'_type_input" class="neccesary_input" onclick="passengerTypeChild('+passenger_count+')" style="margin-left:33px;width:20px" id="passenger'+passenger_count+'_type2_input" value="2"/><label for="passenger'+passenger_count+'_type2_input" style="margin-right:36px">Ребёнок</label><p><label for="name_input">Имя:</label><input id="name_input" class="neccesary_input" style="width:259px" value="" placeholder="" onchange=""/><p><label id="bcert'+passenger_count+'_label" for="bcert'+passenger_count+'_input" style="display:none">Свидетельство о рождении:</label><input id="bcert'+passenger_count+'_input" style="width:259px;display:none;" value="" placeholder="" onchange=""/><p><label id="passport'+passenger_count+'_label" for="passport_input1">Паспортные данные:</label><input id="passport'+passenger_count+'_input1" class="neccesary_input" style="width:119px;margin-right: 4px;" value="" placeholder="серия" onchange=""/><input id="passport'+passenger_count+'_input2" class="neccesary_input" style="width:118px" value="" placeholder="номер" onchange=""/><br><input id="passport'+passenger_count+'_input3" class="neccesary_input" style="width:259px;margin-top:5px" value="" placeholder="когда и где выдан" onchange=""/></div>');
   });
   
   $('#order_button').click(function(){
      if (!checkEmpty() && !checkEmail())// && !this.checkNotChecked())
         $.post(
            post_url,{
               a: "cart_order",
               b: JSON.stringify(collectData()),
               c: selected_date,
               d: $('#phone_input').val(),
               e: $('#email_input').val(),
               f: getUrlParameter("id"),
               g: localStorage.user_id != undefined ? localStorage.user_id : -1 
            }, 
            function (result){
               var obj = JSON.parse(result);
               localStorage.user_id = obj[0];
               order_number = obj[1];
               showPaymentForm();
               //$('#tabs-5').html("<div style='text-align:center; width:100%;line-height:"+$('#tabs-5').height()+"px'>Ваша заявка отправлена на рассмотрение. Её статус можете посмотреть в <a href='cart.php' style='color:#2b587a !important'>Корзине</a>.</div>");
               //$('html,body').stop().animate({ scrollTop: $('#tabs-5').offset().top-100 }, 200);
            });
   });
   
   for (var i = 2013; i > 1929; i--)
      $('#bdate_year_select').append("<option value='"+i+"'>"+i+"</option>");
   
   for (var i = 31; i > 0; i--)
      $('#bdate_day_select').append("<option value='"+i+"'>"+i+"</option>");
   
   $('#bdate_year_select').selectmenu({
      height: 160,
      change: function(event, ui) {
         selected_bdate_year = ui.item.value;
         $('#bdate_year_select-button').removeClass("neccesary_input");
      }
   });
   
   $('#bdate_month_select').selectmenu({
      change: function(event, ui) {
         selected_bdate_month = ui.item.value;
         $('#bdate_month_select-button').removeClass("neccesary_input");
      }
   });
   
   $('#bdate_day_select').selectmenu({
      change: function(event, ui) {
         selected_bdate_day = ui.item.value;
         $('#bdate_day_select-button').removeClass("neccesary_input");
      }
   });
   
   $('#bdate_year_select-button').addClass("neccesary_input");
   $('#bdate_month_select-button').addClass("neccesary_input");
   $('#bdate_day_select-button').addClass("neccesary_input");
}

function passengerTypeChild(passenger_id){
   $('#passport'+passenger_id+'_label').hide();
   $('#passport'+passenger_id+'_input1').hide().removeClass("neccesary_input");
   $('#passport'+passenger_id+'_input2').hide().removeClass("neccesary_input");
   $('#passport'+passenger_id+'_input3').hide().removeClass("neccesary_input");
   $('#bcert'+passenger_id+'_label').show();
   $('#bcert'+passenger_id+'_input').show().addClass("neccesary_input");
}

function passengerTypeAdult(passenger_id){
   $('#passport'+passenger_id+'_label').show();
   $('#passport'+passenger_id+'_input1').show().addClass("neccesary_input");
   $('#passport'+passenger_id+'_input2').show().addClass("neccesary_input");
   $('#passport'+passenger_id+'_input3').show().addClass("neccesary_input");
   $('#bcert'+passenger_id+'_label').hide();
   $('#bcert'+passenger_id+'_input').hide().removeClass("neccesary_input");
}

function collectData(){
   var order_data = [];
   var passenger_data = {};
   var bd = new Date();
   bd.setFullYear(1970);
   bd.setMonth(selected_bdate_month);
   bd.setDate(selected_bdate_day);
   bd.setHours(12,0,0,0);
   var bd_timestamp = Math.floor(bd.getTime()/1000);
   
   for (var i = 1; i <= passenger_count; i++){
      passenger_data = {};
      passenger_data.type = $('div#passenger'+i+'_wrapper input[name=passenger'+i+'_type_input]:checked').val();
      passenger_data.name = $('div#passenger'+i+'_wrapper #name_input').val();
      passenger_data.passport_data1 = $('div#passenger'+i+'_wrapper #passport'+i+'_input1').val();
      passenger_data.passport_data2 = $('div#passenger'+i+'_wrapper #passport'+i+'_input2').val();
      passenger_data.passport_data3 = $('div#passenger'+i+'_wrapper #passport'+i+'_input3').val();
      passenger_data.bcert_data = $('div#passenger'+i+'_wrapper #bcert'+i+'_input').val();
      passenger_data.bdate = bd_timestamp;
      order_data.push(passenger_data);
   }
   
   return order_data;
}

function resizeOnLoadVip(image){
   var elm = $(image);
   elm.css("height", elm.parent().height()+"px");
}

var errors = 0;
var scrolled = 0;

function checkEmpty(){
   errors = 0;
   scrolled = 0;
   
   $('.neccesary_input').each(function(){
      if ($(this).val().length == 0){
         errors++;
         hlInput($(this));
       
         if(!scrolled){
            $('html,body').stop().animate({ scrollTop: $(this).offset().top-100 }, 200);
            scrolled++;
         }
      }
   });
   
   return errors;
}

function checkEmail(){
   errors = 0;
   scrolled = 0;
   
   if ($('#email_input').val().trim().length > 0 && $('#email_input').val().trim() !== $('#email_again_input').val().trim()){
      errors++;
      $('#email_notmatch_alert').show().css("display", "inline-block");
      hlInput($('#email_input'));
      hlInput($('#email_again_input'));
    
      if(!scrolled){
         $('html,body').stop().animate({ scrollTop: $('#email_input').offset().top-100 }, 200);
         scrolled++;
      }
   }
   
   return errors;
}
   
function hlInput(element){
   element.css({background:"#c6123d"});
   element.animate({backgroundColor: "rgba(0,0,0,0)"}, 1000);
}

function showPaymentForm(){
   //order_number = 88;
   
   try{
      if (order_number === undefined)
         throw "Error: order number is undefined";
      
      $('html,body').stop().animate({ scrollTop: $('#tabs-5').offset().top-20 }, 200);
      $('#order_step_1_div').addClass("order_step_unactive").removeClass("order_step_active");
      $('#order_step_2_div').addClass("order_step_active").removeClass("order_step_unactive");
      $('#order_form').html("");
      $('#order_form').toggleClass("confirm_mode").load("./dom/order_confirm_form.html", function() {
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
            
            $('#order_button').val("Оплатить "+obj.tour_price+" руб.").css({marginLeft: "50px", width: "233px"});
            $('input[name=MNT_AMOUNT]').val(obj.tour_price);
            $('input[name=MNT_TRANSACTION_ID]').val(obj.id);
            $('#cancel_payment_button').remove();
         $('#moneta_form').append('<a id="cancel_payment_a" class="sbmt transparent_sbmt" href="complete.php?status=order_cancelled&MNT_TRANSACTION_ID='+obj.id+'">Отмена</a>');
         });
         
         
      });
   }
   catch(error){
      console.log(error);
   }
}