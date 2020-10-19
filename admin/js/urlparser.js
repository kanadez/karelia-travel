function urlParser(){
   this.parse = function(){
      var params_string = window.location.href.slice(window.location.href.indexOf('#') + 1);
      var params = params_string.split("&");
      var result = {};
      
      for (var i = 0; i < params.length; i++){
         var tmp = params[i].split("=");
         result[tmp[0]] = tmp[1];
      }
      
      switch (result.section) {
         case "content":
            switch (result.screen) {
               case "mainpage":
                  editMainPage();
               break;
               case "about":
                  editAboutPage();
               break;
               case "groups":
                  editTourGroups();
               break;
               case "group":
                  editTourGroup(urlparser.getParameter("id"));
               break;
               case "tour":
                  _editTour(urlparser.getParameter("id"));
               break;
               default:
                  this.setURL("/");
               break;
            }
         break;
         case "orders":
            switch (result.screen) {
               case "new":
                  showNewOrders();
               break;
               case "confirmed":
                  showConfirmedOrders();
               break;
               default:
                  this.setURL("");
               break;
            }
         break;
         case "delivery":
            switch (result.screen) {
               case "emaildb":
                  showEmailDB();
               break;
               case "mass":
                  showDeliveryForm();
               break;
               case "bdate":
                  showBDateDeliveryForm();
               break;
               default:
                  this.setURL("/");
               break;
            }
         break;
         default:
            this.setURL("");
         break;
      }
   };
   
   this.setURL = function(hash_value){
      location.href = location.origin+location.pathname+"#"+hash_value;
   };
   
   this.getParameter = function(parameter){
      var params_string = window.location.href.slice(window.location.href.indexOf('#') + 1);
      var params = params_string.split("&");
      var result = {};
      for (var i = 0; i < params.length; i++){
         var tmp = params[i].split("=");
         result[tmp[0]] = tmp[1];
      }
      
      return result[parameter];
   };
}

/*function inverse(x){
  if (!x)
    throw "Division by zero!";
  
  return 1/x;
}

try{
  console.log(inverse(5));
  console.log(inverse(0));
  console.log(inverse(28));
}
catch (error){
  console.log(error);
  }*/