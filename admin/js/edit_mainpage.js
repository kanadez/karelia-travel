var bg_counter = 0;

function editMainPage(){
   urlparser.setURL("section=content&screen=mainpage");
   $('#content_div').html("");
   $('#content_div').load("./dom/edit_mainpage.html", function() {
      setEditMainPageDom();
   });
}

function setEditMainPageDom(){
   $.post(
      post_url, {
         a: "gMP"
      }, 
      function(result){
         var obj = JSON.parse(result);
         console.log(obj)
         for (var i = 0; i < obj.length; i++)
            switch (obj[i].parameter) {
               case "title":
                  $('#mainpage_title_input').val(obj[i].value);
               break;
               case "uto":
                  $('#mainpage_uto_input').val(obj[i].value);
               break;
            }
      }
   );
   
   $('#mainpage_bg_input').fileupload({
      formData: {
         action: "upload_mainpage_bg"
      },
      done: function (e, data) {
         $('#mainpage_bg').attr("src", "../img/bg.jpg?"+bg_counter);
         bg_counter++;
     }
   });
}

function saveMainPageData(){
   $.post(
      post_url, {
         a: "save_content",
         page: "mainpage",
         data: JSON.stringify([{parameter: "title", value:$('#mainpage_title_input').val()}, {parameter: "uto", value: $('#mainpage_uto_input').val()}])
      }, 
      function(result){
         $('#save_mainpage_data').hide();
         $('#content_div').append("Данные сохранены!");
      });
}