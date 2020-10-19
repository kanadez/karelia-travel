function DropDown(el){
	this.dd = el;
	this.initEvents();
}

DropDown.prototype = {
	initEvents : function(){
		var obj = this;
		
		obj.dd.on('click', function(event){
			$(this).toggleClass('active', caseActive($(this).attr("class"), $(this).attr("id")));
			event.stopPropagation();
		});	
	}
}

$(function(){
	var dd1 = new DropDown($('#dd1'));
	var dd2 = new DropDown($('#dd2'));
	var dd3 = new DropDown($('#dd3'));
	var dd4 = new DropDown($('#dd4'));
	
	$(document).click(function(){
		$('.wrapper-dropdown-5').removeClass('active', opaqueSubs());
	});
	
	$('.dropdown_variant').click(function(){
      dd_id = $(this).attr("dropdown_id");
      dv_text = $(this).html();
      dv_event = $(this).attr("onclick");
      dd_text = $('#dropdown_'+dd_id).html();
      dd_event = $('#dropdown_'+dd_id).attr("onclick");
      $('#dropdown_'+dd_id).html(dv_text);
      $('#dropdown_'+dd_id).attr("onclick", dv_event);
      $(this).html(dd_text);
      $(this).attr("onclick", dd_event);
   });
});

function caseActive(clas, id){
   if (clas == "wrapper-dropdown-5 active")
      opaqueSubs();
   else transparentSubs(id);
}

function opaqueSubs(){
   $('.sub').animate({opacity: 1}, 200);
}

function transparentSubs(id){
   switch (id){
      case "dd1":
         $('#breed_msg').animate({opacity: 0.1}, 200);
         $('#breed_div').animate({opacity: 0.1}, 200);
         break
      case "dd2":
         $('#specifics_msg').animate({opacity: 0.1}, 200);
         break
      case "dd3":
         $('#settle_term_msg').animate({opacity: 0.1}, 200);
         $('#settle_dates_div').animate({opacity: 0.1}, 200);
         $('#delivery_msg').animate({opacity: 0.1}, 200);
         break
      case "dd4":
         $('#get_number_msg').animate({opacity: 0.1}, 200);
         break
      default:
         break
   }
}