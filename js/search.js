var post_url = "php/main.php";
var selected_group = null;
var selected_start_date = null;
var selected_end_date = null;
var selected_min_price = null;
var selected_max_price = null;

$(document).ready(function(){
   init();
   
   $('#search_tour').click(function(){
      $.post(
         post_url,{
            a: "tour_search",
            b: selected_group,
            c: selected_start_date,
            d: selected_end_date,
            e: selected_min_price,
            f: selected_max_price
         }, 
         function (result){
            var obj = JSON.parse(result);
            $('#tours_div').html("");
            
            if (obj.length > 0){
               $('#tours_div').html('<div style="width:100%; text-align:center;color:#333; margin-bottom: 10px;">Результаты поиска:</div>');
               
               for (var i = 0; i < obj.length; i++)
                  $('#tours_div').append('<div id="first_gallery_box_div" class="gallery_element_box"><a href="tour.php?id='+obj[i].id+'"><div class="gallery_element_box_img_wrapper"><img id="group_img_1" onload="resizeOnLoadVip(this)" style="height: 134px;" src="catalog/'+obj[i].photo+'"></div><div class="vip_desc_div"><span id="group_title_0" class="gallery_box_title">'+obj[i].title+'</span><p></p><p><span class="group_desc_div">'+obj[i].price+' руб.</span></p></div></a></div>');
            }
            else $('#tours_div').html('<div style="width:100%; text-align:center;color:#333">К сожалению, по таким параметрам туров не найдено.</div>'); 
         });
   });
   
   $('#reset_form').click(function(){
      selected_group = null;
      selected_start_date = null;
      selected_end_date = null;
      selected_min_price = null;
      selected_max_price = null;
      
      $('#settle_start_input').val("");
      $('#settle_end_input').val("");
      $('#tour_select').selectmenu("destroy").html("");
      
      init();
   });
});

function init(){
   $.post(
      post_url,{
         a: "tour_get_search_init_data"
      }, 
      function (result){
         var obj = JSON.parse(result);
         //console.log(obj);
         var minprice = Number(obj["init_data"]["MIN(`price`)"]);
         var maxprice = Number(obj["init_data"]["MAX(`price`)"]);
         var maxdate = Number(obj["init_data"]["MAX(`end_date`)"]);
         
         $("#slider_leftedge_span").text(minprice);
         $("#slider_rightedge_span").text(maxprice);
         
         $('#price_slider').slider({
            range: true,
            min: minprice,
            max: maxprice,
            values: [minprice, maxprice],//floor, ceil ],
            slide: function(event, ui){
               $("#slider_leftedge_span").text(Number(ui.values[0]));
               $("#slider_rightedge_span").text(Number(ui.values[1]));
            },
            stop: function(event, ui){
               selected_min_price = ui.values[0];
               selected_max_price = ui.values[1];
            }
         });
         
         var startdate = Math.floor(Date.now() / 1000);
         var enddate = Math.ceil(Date.now() / 1000);
         $('#settle_start_input').datepicker({ 
            dateFormat: "dd/mm/yy", 
            //minDate: new Date(startdate*1000), 
            //maxDate: new Date(maxdate*1000), 
            onSelect: function(){
               selected_start_date = $('#settle_start_input').datepicker("getDate")/1000;
            }
         });
         $('#settle_end_input').datepicker({ 
            dateFormat: "dd/mm/yy", 
            //minDate: new Date(startdate*1000), 
            //maxDate: new Date(maxdate*1000), 
            onSelect: function(){
               selected_end_date = $('#settle_end_input').datepicker("getDate")/1000;
            }
         });
         
         selected_group = obj.group_data[0].id;
         
         for (var i = 0; i < obj.group_data.length; i++){
            $('#tour_select').append('<option value='+obj.group_data[i].id+'>'+obj.group_data[i].title+'</option>');
         }
         
         $('#tour_select').selectmenu({
            change: function(event, ui) {
               selected_group = ui.item.value;
            }
         });
      }
   );
}

function resizeOnLoadVip(image){
   var elm = $(image);
   elm.css("height", elm.parent().height()+"px");
}