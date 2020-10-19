function getDateTimeFromTimestamp(timestamp){
   var date = new Date(timestamp*1000);
   var hours = date.getHours()+1;
   var minutes = date.getMinutes();
   var seconds = date.getSeconds();
   var day = date.getDate();
   var month = date.getMonth()+1;
   var year = date.getFullYear();
   
   return day+"/"+month+"/"+year+" в "+hours+":"+minutes+":"+seconds;
}

function getDayNMonthFromTimestamp(timestamp){
   var a = new Date(timestamp*1000);
   var months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
   var month = months[a.getMonth()];
   var date = a.getDate();
   return date+" "+month;
}

function getDayNMonthYearFromTimestamp(timestamp){
   var a = new Date(timestamp*1000);
   var months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
   var month = months[a.getMonth()];
   var date = a.getDate();
   return date+" "+month+" "+a.getFullYear();
}

function getDateFromTimestamp(timestamp){
   var date = new Date(timestamp*1000);
   var hours = date.getHours()+1;
   var minutes = date.getMinutes();
   var seconds = date.getSeconds();
   var day = date.getDate();
   var month = date.getMonth()+1;
   var year = date.getFullYear();
   
   return day+"/"+month+"/"+year;
}

function getClock()
{
   var date = new Date();
   var hours = date.getHours();
   var minutes = date.getMinutes();
   var seconds = date.getSeconds();
   var day = date.getDate();
   var month = date.getMonth()+1;
   var year = date.getFullYear();
   
   $('#clock_div').html(day+"/"+month+"/"+year+" | "+hours+":"+minutes+":"+seconds);
}

function timestampFromDate()
{
   var input = $("<input />",
   {
      id: "datepicker_input"
   });
   
   var div = $("<div />",
   {
      id: "timestamp_div"
   });
   
   div.css("margin-top","20px");
   
   $('#content_div').html(input);
   $('#content_div').append(div);
   input.datepicker();
   input.change
   (
      function()
      {
         $.post
         (
            post_url, 
            {
               a: "tFD",
               b: input.val()
            }, 
            function (result)
            {
               $('#timestamp_div').html(result);
            }
         );
      }
   );
   //$('#clock_div').html(day+"/"+month+"/"+year+" | "+hours+":"+minutes+":"+seconds);
}

function evenRowColor(counter) // заливает нечетные строки любой таблицы контрастным цветом
{
   return (counter%2 == 0 ? "table_contrast_row" : "");
}

function changeOpacityOnLoad(tumbler)
{
   tumbler == 1 ? $('#clock_div').animate({"opacity":0.1}, 300) : $('#clock_div').animate({"opacity":1}, 300);
}

function log(string){
   console.log(string);
}

function convertForDatepicker(timestamp){
   var a = new Date(timestamp*1000);
   var year = a.getFullYear();
   var month = leadZero(a.getMonth()+1,2);
   var date = leadZero(a.getDate(), 2);
   var time = date+'/'+month+'/'+ year;
   
   return time;
}

function leadZero(number, length) {
   while(number.toString().length < length){
     number = '0' + number;
   }
   return number;
}