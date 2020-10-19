var post_url = "php/main.php";
var user_vk_id = null;
var user_ok_id = null;

VK.init({apiId: 5203984});

$(document).ready(function(){
   if (getHashParameter("access_token") != undefined)
      okLogin();
});

function loginAuthInfo(response) {
   VK.Api.call('users.get', {user_ids: response.session.user.id, fields:"photo_100"}, function(r) { 
      if(r.response){
         user_vk_id = r.response[0].uid;
         
         $.post(post_url,{
            a: "login_vk",
            b: user_vk_id
         }, 
         function (result){
            location.href = "cart.php";
         });
      }
   });
}

function okLogin(){
   var sign = MD5('application_key=CBAMJQNKEBABABABAmethod=users.getCurrentUser'+MD5(getHashParameter("access_token")+"82630551AD94447BFE21487C"));
   $.get( "http://api.odnoklassniki.ru/fb.do",{ 
      method: "users.getCurrentUser", 
      access_token: getHashParameter("access_token"),
      application_key: "CBAMJQNKEBABABABA",
      sig: sign
   }, function(result){
      user_ok_id = result.uid;
      
      $.post(post_url,{
         a: "login_ok",
         b: user_ok_id
      }, 
      function (result){
         location.href = "cart.php";
      });
   });

}