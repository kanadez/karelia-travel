$(document).ready(function(){
   setupDOM();
});

function setupDOM(){
   $('#input_panel_div').offset({"top": $(document).height()/2-23});
   $('#copyright_div').offset({"top": $(document).height()-33});

   $('#password_input').focus(function(){
      if ($(this).val() === "Enter password...")
         $(this).val("");
      
      $(this).prop('type', 'password');
   });
   
   $('#password_input').blur(function(){
      if ($(this).val() === ""){
         $(this).val("Enter password...");
         $(this).prop('type', 'text');
      }
   });
   
   $('#password_input').keyup(function(e){
      onEnter(e);
   });
}

function shakeInput(){
   $('#password_input').animate({"marginLeft":"-5px"},50, function(){
      $('#password_input').animate({"marginLeft":"+5px"},50, function(){
         $('#password_input').animate({"marginLeft":"-5px"},50, function(){
            $('#password_input').animate({"marginLeft":"+5px"},50);
         });
      });
   });
}

function onEnter(event){
   var key = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;

   if (key === 13){
      $.post("./login.php",{
         password: $('#password_input').val()
      }, 
      function (result){
         if(result == 0)
            location.href= location.origin+"/admin/admin.php";
         else{
            shakeInput();
         }
      });
   }
}