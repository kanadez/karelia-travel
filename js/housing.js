var post_url = "post.php";

$(document).ready(function(){
   $('#copyr_div').offset({top:$(window).height()-35});
   getHousing();
});

function reserve(){
   window.location = "reserve.html";
}

function getHousing(){
   $.post(
      post_url,{
         a: "gH"
      }, 
      function (result){
         var obj = eval("(" + result + ")");
         assignHousing(obj);
      }
   );
}

function assignHousing(housing_obj){
   $('#housing_1_title').html(housing_obj[0].title);
   $('#housing_1_content').html(housing_obj[0].content);
   $('#housing_2_title').html(housing_obj[1].title);
   $('#housing_2_content').html(housing_obj[1].content);
   $('#housing_3_title').html(housing_obj[2].title);
   $('#housing_3_content').html(housing_obj[2].content);
}