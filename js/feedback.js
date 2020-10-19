var post_url = "php/main.php";
var user_vk_id = null;
var user_vk_name = null;
var user_vk_photo = null;

var user_ok_id = null;
var user_ok_name = null;
var user_ok_photo = null;

VK.init({apiId: 5203984});

$(document).ready(function(){
   if (getHashParameter("access_token") != undefined)
      okLogin();
});

function loginAuthInfo(response) {
   VK.Api.call('users.get', {user_ids: response.session.user.id, fields:"photo_100"}, function(r) { 
      if(r.response){
         user_vk_id = r.response[0].uid;
         user_vk_photo = r.response[0].photo_100;
         user_vk_name = r.response[0].first_name+" "+r.response[0].last_name;
         
         $('#login_wrapper').css({"text-align": "left", "margin-bottom":"60px"});
         $('#login_wrapper').html('<div id="feedback_wrapper" class="friend_block"><div class="frienddata_wrapper"><div class="friendphoto_wrapper"><img id="user_photo" class="friend_image_w" src="'+user_vk_photo+'"></div><span class="friendname"><a href="http://vk.com/id'+user_vk_id+'">'+user_vk_name+'</a></span><br><div class="message_preview"><textarea id="message_input" class="message_input" placeholder="Напишите отзыв здесь..."></textarea></div></div><button id="send_feedback" class="sbmt" style="float: left;margin-left: 90px;margin-top: 20px;">Отправить</button></div>');
         
         $('#send_feedback').click(function(){
            $.post(post_url,{
               a: "feedback_set",
               b: user_vk_id,
               c: user_vk_name,
               d: user_vk_photo,
               e: $('#message_input').val()
            }, 
            function (result){
               $('#login_wrapper').html('<div style="margin-top: 57px;text-align: center;width: 100%;">Спасибо! Ваше мнение очень важно для нас!</div>');
            });
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
      user_ok_name = result.first_name+" "+result.last_name;
      user_ok_photo = result.pic_2;
      
      window.scrollTo(0,document.body.scrollHeight);
      $('#login_wrapper').css({"text-align": "left", "margin-bottom":"60px"});
      $('#login_wrapper').html('<div id="feedback_wrapper" class="friend_block"><div class="frienddata_wrapper"><div class="friendphoto_wrapper"><img id="user_photo" class="friend_image_w" src="'+user_ok_photo+'"></div><span class="friendname"><a href="http://ok.ru/profile/'+user_ok_id+'">'+user_ok_name+'</a></span><br><div class="message_preview"><textarea id="message_input" class="message_input" placeholder="Напишите отзыв здесь..."></textarea></div></div><button id="send_feedback" class="sbmt" style="float: left;margin-left: 90px;margin-top: 20px;">Отправить</button></div>');
      
      $('#send_feedback').click(function(){
         $.post(post_url,{
            a: "feedback_set",
            b: user_ok_id,
            c: user_ok_name,
            d: user_ok_photo,
            e: $('#message_input').val()
         }, 
         function (result){
            $('#login_wrapper').html('<div style="margin-top: 57px;text-align: center;width: 100%;">Спасибо! Ваше мнение очень важно для нас!</div>');
         });
      });
   });

}