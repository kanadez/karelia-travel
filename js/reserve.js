var post_url = "post.php";
var calculator_obj = {};

$(document).ready(function(){
   init();
   
});

function init(){
   getNearestSettlment();
   
   calculator_obj.dog_size = 0; // 0 - small, 1 - middle, 2 - large
   calculator_obj.food = 0; // 0 - on the house, 1 - own account
   calculator_obj.specials = 0; // 0 - no specials, 1 - too big, 2 - need doctor, 3 - otther
   calculator_obj.start_date_timestamp = null;
   calculator_obj.end_date_timestamp = null;
   calculator_obj.delivery = 0; // 0 - no delivery, 1 - there is
   calculator_obj.breed = "";
   calculator_obj.phone = "";
   calculator_obj.total_price = 0;
   
   $('#phone_input').keyup(function(){ setParameter("phone", $('#phone_input').val()) });
   $('#breed_input').keyup(function(){ setParameter("breed", $('#breed_input').val()) });
   $('#settle_start_input').change(function(){ setParameter("start_date", $('#settle_start_input').datepicker("getDate").getTime() / 1000) });
   $('#settle_end_input').change(function(){ setParameter("end_date", $('#settle_end_input').datepicker("getDate").getTime() / 1000) });
}

function calculate(){
   var start_timestamp = $('#settle_start_input').datepicker("getDate").getTime() / 1000;
   var end_timestamp = $('#settle_end_input').datepicker("getDate").getTime() / 1000;
   var days = (end_timestamp - start_timestamp)/86400;
   
   $.post(
      post_url,{
         a: "gP"
      }, 
      function (result){
         var obj = eval("(" + result + ")");
         var one_day_price = 0;
         var total_price = 0;
         var delivery_obj = [];
         
         for (var i = 0; i< obj.length; i++){
            if (obj[i].pet == calculator_obj.dog_size){
               if (calculator_obj.food == 1)
                  one_day_price = obj[i].own_account;
               else if (calculator_obj.food == 0) 
                  one_day_price = obj[i].on_the_house;
            }
            
            delivery_obj[i] = Number(obj[i].delivery);
         }
         
         if (calculator_obj.delivery == 1)
            total_price = one_day_price*days+delivery_obj[calculator_obj.dog_size];
         else total_price = one_day_price*days;
         
         calculator_obj.total_price = total_price;
         $('#price_value').html(total_price+" руб.");
      }
   );
}

function setParameter(parameter, value){
   switch (parameter){
      case "dog_size":
         calculator_obj.dog_size = value;
         break;
      case "food":
         calculator_obj.food = value;
         break;
      case "specials":
         calculator_obj.specials = value;
         break;
      case "start_date":
         calculator_obj.start_date_timestamp = value;
         break;
      case "end_date":
         calculator_obj.end_date_timestamp = value;
         break;
      case "delivery":
         calculator_obj.delivery = value;
         break;
      case "breed":
         calculator_obj.breed = value;
         break;
      case "phone":
         calculator_obj.phone = value;
         break;
      default:
         break;
   }
   
   calculate();
}

function reserve(){
   if (!checkFill()){
      var json_str = JSON.stringify(calculator_obj);
      
      $.post(
         post_url,{
            a: "R",
            b: json_str
         },
         function (result){
            $('#content_div').html('<div id="header_msg" style="margin-top:25%" class="centered_msg msg">Спасибо! В течение 24 часов мы позвоним Вам, чтобы подтвердить бронь.</div>');
         }
      );
   }
}

function checkFill(){
   var error = 0;
   
   if ($('#breed_input').val().length == 0){
      $('#breed_input').animate({backgroundColor: '#c36868'}, {queue:false, duration:0, complete: function(){$(this).animate({backgroundColor: '#FFF'}, {queue:false, duration:1000})}});
      error = 1;
   }
   
   if ($('#settle_start_input').val().length == 0){
      $('#settle_start_input').animate({backgroundColor: '#c36868'}, {queue:false, duration:0, complete: function(){$(this).animate({backgroundColor: '#FFF'}, {queue:false, duration:1000})}});
      error = 1;
   }
   
   if ($('#settle_end_input').val().length == 0){
      $('#settle_end_input').animate({backgroundColor: '#c36868'}, {queue:false, duration:0, complete: function(){$(this).animate({backgroundColor: '#FFF'}, {queue:false, duration:1000})}});
      error = 1;
   }
   
   if ($('#phone_input').val().length == 0){
      $('#phone_input').animate({backgroundColor: '#c36868'}, {queue:false, duration:0, complete: function(){$(this).animate({backgroundColor: '#FFF'}, {queue:false, duration:1000})}});
      error = 1;
   }
   
   return error;
}

function getNearestSettlment(){
   $.post(
      post_url,{
         a: "gNS"
      },
      function (result){
         $('#settle_start_input').datepicker({ dateFormat: "dd/mm/yy", minDate: new Date(result*1000) });
         $('#settle_end_input').datepicker({ dateFormat: "dd/mm/yy", minDate: new Date(result*1000) });
         $('#settle_start_input').datepicker("setDate", convertForDatepicker(result));
         $('#settle_end_input').datepicker("setDate", convertForDatepicker(Number(result)+604800));
         calculator_obj.start_date_timestamp = result;
         calculator_obj.end_date_timestamp = Number(result)+604800;
         calculate();
         $('#header_msg').html("Здесь Вы можете забронировать для своего питомца место в нашей гостинице.<br>На данный момент ближайшая свободная дата заезда - "+getDayNMonthFromTimestamp(result)+".");
      }
   );
}