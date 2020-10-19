function setEditToursDom(group){
   $.post(post_url, {
      a: "gGD",
      b: group
   }, function(result){
      var obj = JSON.parse(result);
      
      for (var i = 0; i < obj.length; i++){
            var tr = "<tr><td id='tour_name_td_"+obj[i].id+"'>"+obj[i].title+"</td><td id='tour_price_td_"+obj[i].id+"'>"+obj[i].price+"</td><td id='tour_actions_td_"+obj[i].id+"'><button onclick='deleteTour("+obj[i].id+")'>Удалить</button><button onclick='urlparser.setURL(\"section=content&screen=tour&id="+obj[i].id+"\"); location.reload();'>Изменить</button></td></tr>";
            $('#tours_table').append(tr);
         }
         
         var newtr = "<tr><td><input id='new_tour_name_input' style='width:90%' placeholder='Название нового тура..' maxlength='100' /></td><td><input id='new_tour_price_input' style='width:90%' placeholder='Цена..' maxlength='100' /></td><td><button onclick='addTour()'>Добавить</button></td></tr>";
         $('#tours_table').append(newtr);
   });
   
   $.post(post_url, {
      a: "gGN",
      b: group
   }, function(result){
      var obj = JSON.parse(result);
      $('#group_title_input').val(obj.title);
      $('#group_description_input').val(obj.short_description);
      $('#group_img').attr("src", "../catalog/"+obj.image);
   });
   
   $('#group_photo_edit_input').fileupload({
      formData: {
         group: current_group,
         action: "upload_group_image"
      },
      done: function (e, data) {
         $('#group_img').attr("src", "../catalog/"+data.result);
     }
   });
}

function saveGroupTitle(){
   $.post(post_url, {
      a: "sGN",
      b: current_group,
      c: $('#group_title_input').val()
   }, function(result){
      editTourGroup(current_group);
   });
}

function saveGroupDesc(){
   $.post(post_url, {
      a: "sGD",
      b: current_group,
      c: $('#group_description_input').val()
   }, function(result){
      editTourGroup(current_group);
   });
}

function deleteTour(id){
   $.post(post_url, {
      a: "dT",
      b: id
   }, function(result){
      editTourGroup(current_group);
   });
}

function addTour(){
   $.post(post_url, {
      a: "aT",
      b: $('#new_tour_name_input').val(),
      c: $('#new_tour_price_input').val(),
      d: current_group
   }, function(result){
      editTourGroup(current_group);
   });
}