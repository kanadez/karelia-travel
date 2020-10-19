var current_group = -1;

function editTourGroups(){
   urlparser.setURL("section=content&screen=groups");
   $('#content_div').html("");
   $('#content_div').load("./dom/edit_tour_groups.html", function() {
      setEditTourGroupsDom();
   });
}

function setEditTourGroupsDom(){
   $.post(
      post_url, {
         a: "gTG"
      }, 
      function(result){
         var obj = JSON.parse(result);
         
         for (var i = 0; i < obj.length; i++){
            var tr = "<tr><td>"+obj[i].title+"</td><td><button onclick='deletetourGroup("+obj[i].id+")'>Удалить</button><button onclick='editTourGroup("+obj[i].id+")'>Изменить</button></td></tr>";
            $('#tour_groups_table').append(tr);
         }
         
         var newtr = "<tr><td><input id='new_tour_group_name_input' style='width:90%' placeholder='Название новой группы..' maxlength='100' /></td><td><button onclick='addTourGroup()'>Добавить</button></td></tr>";
         $('#tour_groups_table').append(newtr);
      }
   );
}

function deletetourGroup(id){
   $.post(post_url, {
      a: "dTG",
      b: id
   }, function(result){
      editTourGroups();
   });
}

function addTourGroup(){
   $.post(post_url, {
      a: "aTG",
      b: $('#new_tour_group_name_input').val()
   }, function(result){
      editTourGroups();
   });
}

function editTourGroup(id){
   current_group = id || urlparser.getParameter("id");
   urlparser.setURL("section=content&screen=group&id="+id);
   $('#content_div').html("");
   $('#content_div').load("./dom/edit_tours.html", function() {
      setEditToursDom(current_group);
   });
}