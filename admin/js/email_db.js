function showEmailDB(){
   urlparser.setURL("section=delivery&screen=emaildb");
   $('#content_div').html("");
   $('#content_div').load("./dom/email_db.html", function() {
      setEmailDBDom();
   });
}

function setEmailDBDom(){
   $.post(post_url, {
      a: "gEDB"
   }, 
   function(result){
      var obj = JSON.parse(result);
         
      for (var k in obj){
         $('#email_db_table').append("<tr id='table_row_"+k+"'></tr>");
         $('#table_row_'+k).append("<td>"+obj[k].id+"</td>");
         $('#table_row_'+k).append("<td>"+obj[k].name+"</td>");
         $('#table_row_'+k).append("<td><a href='mailto:"+obj[k].email+"'>"+obj[k].email+"</a></td>");
         $('#table_row_'+k).append("<td>"+obj[k].phone+"</td>");
         $('#table_row_'+k).append("<td>"+getDayNMonthFromTimestamp(obj[k].bdate)+"</td>");
         $('#table_row_'+k).append("<td>"+getDateFromTimestamp(obj[k].timestamp)+"</td>");
      }
   });
}

function showDeliveryForm(){
   $('#content_div').html("");
   $('#content_div').load("./dom/email_delivery_form.html", function() {
      $('#message_input').tinymce({
         script_url : 'js/tinymce.min.js',
         height:200
      });
   });
}

function deliver(){
   $('#deliver_button').hide();
   $('#content_div').append("<span id='sending_msg'>Идёт рассылка...</span>");
   $.post(post_url, {
      a: "delivery_do",
      b: $('#subject_input').val(),
      c: $('#message_input').tinymce().getContent()
   }, 
   function(result){
      if (result == 1)
         $('#sending_msg').html("Сообщение успешно разослано!");
      //else $('#sendong_msg').html("На один или более адресов сообщение не попало в следствие");
   });
}

function showBDateDeliveryForm(){
   $('#content_div').html("");
   $('#content_div').load("./dom/email_bdate_delivery_form.html", function() {
      $.post(post_url, {
         a: "delivery_get_bdate_msg"
      }, 
      function(result){
         $('#message_input2').val(result);
         $('#message_input2').tinymce({
            script_url : 'js/tinymce.min.js',
            height:200
         });
      });
   });
}

function saveBdateDeliveryMsg(){
   $.post(post_url, {
      a: "delivery_set_bdate_msg",
      b: $('#message_input2').tinymce().getContent()
   }, 
   function(result){
      $('#deliver_button').hide();
      $('#content_div').append("Данные сохранены!");
   });
}