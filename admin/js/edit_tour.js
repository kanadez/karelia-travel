var current_tour = null;
var start_date = null;
var end_date = null;

function _editTour(tour){
   current_tour = tour || urlparser.getParameter("id");
   $('#content_div').html("");
   $('#content_div').load("./dom/edit_tour.html", function() {
      setEditTourDom(current_tour);
   });
}

function setEditTourDom(tour){
   $.post(post_url, {
      a: "gGT",
      b: tour
   }, function(result){
      var obj = JSON.parse(result);
      
      current_group = obj.group;
      $('#tour_title_input').val(obj.title);
      $('#tour_img').attr("src", "../catalog/"+obj.photo);
      $('#tour_shortdesc_input').val(obj.short_description);
      $('#tour_fulldesc_input').val(obj.full_description);
      $('#tour_route_input').val(obj.route);
      $('#tour_pricedesc_input').val(obj.price_description);
      $('#tour_price_input').val(obj.price);
      $('#tour_type'+obj.hot+'_input').attr("checked", true);
      start_date = obj.start_date;
      end_date = obj.end_date;
      
      $('#tour_start_input').val(convertForDatepicker(obj.start_date)).datepicker({
         dateFormat: "dd/mm/yy",
         onSelect: function(){
            start_date = $('#tour_start_input').datepicker("getDate")/1000;
         }
      });
      
      $('#tour_end_input').val(convertForDatepicker(obj.end_date)).datepicker({
         dateFormat: "dd/mm/yy",
         onSelect: function(){
            end_date = $('#tour_end_input').datepicker("getDate")/1000;
         }
      });
      
      
      $('#tour_fulldesc_input').tinymce({
         script_url : 'js/tinymce.min.js',
         height:300
      });
      
      $('#tour_route_input').tinymce({
         script_url : 'js/tinymce.min.js',
         height:300
      });
      
      $('#tour_pricedesc_input').tinymce({
         script_url : 'js/tinymce.min.js',
         height:300
      });
   });
   
   $.post(post_url, {
      a: "gTGa",
      b: tour
   }, function(result){
      var obj = JSON.parse(result);
      
      for (var i = 0; i < obj.length; i++){
         if (i %4 == 0) $('#tour_photos_div').append("<br>");
         $('#tour_photos_div').append('<div class="tour_img_wrapper"><img id="tour_img_'+i+'" imgid="'+obj[i].id+'" onload="resizeUploadImg(this)" src="../catalog/'+obj[i].thumb+'" style="width:100px; margin:5px;"></div>');
      }
   });
   
   $('#tour_photo_edit_input').fileupload({
      formData: {
         tour: current_tour,
         action: "upload_tour_image"
      },
      done: function (e, data) {
         $('#tour_img').attr("src", "../catalog/"+data.result);
     }
   });
   
   $('#tour_gallery_edit_input').fileupload({
      formData: {
         tour: current_tour,
         action: "upload_tour_gallery"
      },
      done: function (e, data) {
         $.post(post_url, {
            a: "gTGa",
            b: current_tour
         }, function(result){
            var obj = JSON.parse(result);
            $('#tour_photos_div').html("");
            for (var i = 0; i < obj.length; i++){
               if (i %4 == 0) $('#tour_photos_div').append("<br>");
               $('#tour_photos_div').append('<div class="tour_img_wrapper"><img id="tour_img_'+i+'" imgid="'+obj[i].id+'" onload="resizeUploadImg(this)" src="../catalog/'+obj[i].thumb+'" style="width:100px; margin:5px;"></div>');
            }
         });
     }
   });
   
   setSettlementTable();
}

function resizeUploadImg(img2){
   $(img2).parent().append("<div id='"+img2.id+"_delete_wrapper' class='delete_photo_wrapper'></div>");
   $('#'+img2.id+'_delete_wrapper').height($(img2).height()).css("margin-top", "-"+($(img2).height()+7)+"px");
   $('#'+img2.id+'_delete_wrapper').click({img:img2},function(e){
      $.post(post_url,{
         a: "tour_photo_delete",
         b: $(img2).attr("imgid")
      },function(result){
         
      });
      
      var img = $(e.data.img);
      img.parent().hide();//html("");
   });
}

function setSettlementTable(){
   $.post(post_url, {
      a: "gTS",
      b: current_tour
   }, 
   function(result){
      var obj = JSON.parse(result);
      $('#tour_settlement_table').html('<tr class="header_tr"><td class="table_header" width=90%>Дата</td><td class="table_header">Действия</td></tr>');
      
      for (var i = 0; i < obj.length; i++){
         var tr = "<tr><td timestamp='"+obj[i].timestamp+"'>"+getDayNMonthYearFromTimestamp(obj[i].timestamp)+"</td><td><button onclick='deleteTourSettlement("+obj[i].id+")'>Удалить</button></td></tr>";
         $('#tour_settlement_table').append(tr);
      }
      
      var newtr = "<tr><td><input id='new_tour_settlement_input' style='width:90%' placeholder='Новая дата..' maxlength='100' /></td><td><button onclick='addTourSettlement()'>Добавить</button></td></tr>";
      $('#tour_settlement_table').append(newtr);
      
      $('#new_tour_settlement_input').datepicker({
         dateFormat: "dd/mm/yy"
      });
   });
}

function deleteTourSettlement(id){
    $.post(post_url, {
      a: "dTS",
      b: id
   }, 
   function(result){
      setSettlementTable();
   });
}

function addTourSettlement(){
   $.post(post_url, {
      a: "sTS",
      b: current_tour,
      c: $('#new_tour_settlement_input').datepicker("getDate")/1000
   }, 
   function(result){
      $('#new_tour_settlement_input').datepicker("option", "disabled", true);
      setSettlementTable();
   });
}

function saveTour(){
   $.post(post_url, {
      a: "sT",
      b: $('#tour_title_input').val(),
      c: $('#tour_shortdesc_input').val(),
      d: $('#tour_fulldesc_input').tinymce().getContent(),
      e: $('#tour_route_input').tinymce().getContent(),
      f: $('#tour_price_input').val(),
      g: $('#tour_pricedesc_input').tinymce().getContent(),
      h: start_date,
      i: end_date,
      j: $('.tour_type:checked').val(),
      k: current_tour
   }, function(result){
      //$('#save_tour_price').hide();
      $('#content_div').append("Данные сохранены!");
   });
}