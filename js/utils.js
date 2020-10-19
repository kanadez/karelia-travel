function getDayNMonthYearFromTimestamp(timestamp){
   var a = new Date(timestamp*1000);
   var months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
   var month = months[a.getMonth()];
   var date = a.getDate();
   return date+" "+month+" "+a.getFullYear();
}

function getDayNMonthFromTimestamp(timestamp){
   var a = new Date(timestamp*1000);
   var months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
   var month = months[a.getMonth()];
   var date = a.getDate();
   return date+" "+month;
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

function getUrlParameter(parameter){
var params_string = window.location.href.slice(window.location.href.indexOf('?') + 1);
   var params = params_string.split("&");
   var result = {};
   for (var i = 0; i < params.length; i++){
      var tmp = params[i].split("=");
      result[tmp[0]] = tmp[1];
   }
   
   return result[parameter];
}

function getHashParameter(parameter){
var params_string = window.location.href.slice(window.location.href.indexOf('#') + 1);
   var params = params_string.split("&");
   var result = {};
   for (var i = 0; i < params.length; i++){
      var tmp = params[i].split("=");
      result[tmp[0]] = tmp[1];
   }
   
   return result[parameter];
}