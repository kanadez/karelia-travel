var post_url = "post.php";

$(document).ready(function(){
   getContacts();
});

function getContacts(){
   $.post(
      post_url,{
         a: "gC"
      }, 
      function (result){
         var obj = eval("(" + result + ")");
         $('#phone').html(obj[0].phone);
         $('#vk_link').html(obj[0].vk);
         $('#vk_link').attr("href", "http://"+obj[0].vk);
         $('#skype_link').attr("href", "skype:"+obj[0].skype+"?call");
         $('#skype_link').html(obj[0].skype);
         $('#insta_link').html(obj[0].insta);
         $('#insta_link').attr("href", "http://"+obj[0].insta);
      }
   );
}