function editAboutPage(){
   $('#content_div').html("");
   $('#content_div').load("./dom/edit_aboutpage.html", function() {
      setEditAboutDom();
   });
}

function setEditAboutDom(){
   $.post(
      post_url, {
         a: "gAB"
      }, 
      function(result){
         var obj = JSON.parse(result);
         console.log(obj)
         for (var i = 0; i < obj.length; i++)
            switch (obj[i].parameter) {
               case "company_info":
                  $('#aboutpage_company_info_input').val(obj[i].value);
               break;
               case "company_name":
                  $('#aboutpage_company_name_input').val(obj[i].value);
               break;
               case "company_phone":
                  $('#aboutpage_company_phone_input').val(obj[i].value);
               break;
               case "company_email":
                  $('#aboutpage_company_email_input').val(obj[i].value);
               break;
               case "company_address":
                  $('#aboutpage_company_address_input').val(obj[i].value);
               break;
               case "company_data1":
                  $('#aboutpage_company_data1_input').val(obj[i].value);
               break;
               case "company_data2":
                  $('#aboutpage_company_data2_input').val(obj[i].value);
               break;
               case "company_data3":
                  $('#aboutpage_company_data3_input').val(obj[i].value);
               break;
               case "company_data4":
                  $('#aboutpage_company_data4_input').val(obj[i].value);
               break;
               case "company_data5":
                  $('#aboutpage_company_data5_input').val(obj[i].value);
               break;
               case "company_data6":
                  $('#aboutpage_company_data6_input').val(obj[i].value);
               break;
            }
         
         $('#aboutpage_company_info_input').tinymce({
            script_url : 'js/tinymce.min.js',
            height:200
         });
      }
   );
   
   $.post(
      post_url, {
         a: "gPD"
      }, 
      function(result){
         var obj = JSON.parse(result);
         console.log(obj);
         for (var i = 0; i < obj.length; i++)
            $('#'+obj[i].parameter).val(obj[i].value);
      }
   );
   
   $('#tourist_agreement_input').fileupload({
      formData: {
         action: "upload_tourist_agreement"
      },
      done: function (e, data) {
         alert("Готово!");
     }
   });
   
   $('#agent_agreement_input').fileupload({
      formData: {
         action: "upload_agent_agreement"
      },
      done: function (e, data) {
         alert("Готово!");
     }
   });
}

function saveAboutPageData(){
   $.post(post_url, {
      a: "save_content",
      page: "about",
      data: JSON.stringify([
         {parameter: "company_name", value: $('#aboutpage_company_name_input').val()},
         {parameter: "company_phone", value: $('#aboutpage_company_phone_input').val()},
         {parameter: "company_email", value: $('#aboutpage_company_email_input').val()},
         {parameter: "company_address", value: $('#aboutpage_company_address_input').val()},
         {parameter: "company_data1", value: $('#aboutpage_company_data1_input').val()},
         {parameter: "company_data2", value: $('#aboutpage_company_data2_input').val()},
         {parameter: "company_data3", value: $('#aboutpage_company_data3_input').val()},
         {parameter: "company_data4", value: $('#aboutpage_company_data4_input').val()},
         {parameter: "company_data5", value: $('#aboutpage_company_data5_input').val()},
         {parameter: "company_data6", value: $('#aboutpage_company_data6_input').val()}
      ])
   }, 
   function(result){
      //$('#save_aboutpage_data').hide();
      $('#content_div').append("Данные сохранены!");
   });
   
   $.post(post_url, {
      a: "save_aboutinfo_content",
      b: $('#aboutpage_company_info_input').tinymce().getContent()
   }, 
   function(result){
      //$('#save_aboutpage_data').hide();
      //$('#content_div').append("Данные сохранены!");
   });
   
   $.post(post_url, {
      a: "save_content",
      page: "payment",
      data: JSON.stringify([ 
         {parameter: "bank_req", value: $('#bank_req').val()},
         {parameter: "visa_req", value: $('#visa_req').val()},
         {parameter: "mc_req", value: $('#mc_req').val()},
         {parameter: "maestro_req", value: $('#maestro_req').val()},
         {parameter: "yad_req", value: $('#yad_req').val()},
         {parameter: "wm_req", value: $('#wm_req').val()},
         {parameter: "qiwi_req", value: $('#qiwi_req').val()}
      ])
   }, 
   function(result){});
}