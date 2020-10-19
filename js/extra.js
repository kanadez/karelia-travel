var post_url = "post.php";

$(document).ready(function(){
   getExtra();
});

function getExtra(){
   $.post(
      post_url,{
         a: "gX"
      }, 
      function (result){
         $('#extra_content').html(result);
      }
   );
}