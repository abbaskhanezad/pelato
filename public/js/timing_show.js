var working_range = [0,23];
function work_on_cell(room,day,hour,sellable,reserved,price,page_start_view){
  if(reserved){
    $(".room_"+room+"#box_"+day+"_"+hour).addClass("timing_reserved_user");
    //Uncheck Cell for not sellable
  }else if(sellable){
    //Check Cell not Reserved
    if(! $(".room_"+room+"#box_"+day+"_"+hour).hasClass("timing_reserved_user") && !$(".room_"+room+"#box_"+day+"_"+hour).hasClass("timing_unsellable") ){
      $(".room_"+room+"#box_"+day+"_"+hour).addClass("timing_sellable_user");
    }
  }else{
    $(".room_"+room+"#box_"+day+"_"+hour).removeClass("timing_sellable_user");
    $(".room_"+room+"#box_"+day+"_"+hour).html("")
  }
  //Check cell Reserved to price
  if($(".room_"+room+"#box_"+day+"_"+hour).hasClass("timing_sellable_user") || page_start_view){
    $(".room_"+room+"#box_"+day+"_"+hour).html(price);
  }
}


$("#room_timing_reserve").click(function(){
  if($(".timing_select_to_reserve_user").length > 0){
    timing_view_to_object();

    $("input[name=order_list]").val(JSON.stringify(order_list));
    $("#order_form").submit();
  }else{
    return false;
  }
});
function timing_view_to_object(){
  var record = "";
  for(i=0;i<=23;i++){
    for(j=0;j<7;j++){
      window.room_list.forEach(function(element){
        record = _.where(window.room_timing,{week_id : week_id , room_id : element.id , day : j , start_hour : i });
        var cell = $(".room_"+element.id+"#box_"+j+"_"+i);

          //Cell checked - it should be inserted
          if(cell.hasClass("timing_select_to_reserve_user")){
            window.order_list.push({
              id: record[0].id,
            });
          }

      });
    }
  }


  window.room_timing = _.filter(window.room_timing,function(data){return data.operation_status != "n/a"; });
}
function timing_object_to_view(){
  var result = [];
  for(i=0;i<=23;i++){
    for(j=0;j<7;j++){
      window.room_list.forEach(function(element){
        result = _.where(window.room_timing, {room_id: element.id , week_id: window.week_id, day: j , start_hour: i});
        if(result != ""){
          if(result[0].selled)
          {
            work_on_cell(element.id,j,i,false,true,result[0].price,true);
          }
          else
          {
            work_on_cell(element.id,j,i,true,false,result[0].price, true);
          }
        }
      });
    }
  }
}

//Show on Page Start based on Database
timing_object_to_view();
//Set on click cell
$(".box").click(function(){
  room_id = $(this).attr("data-roomid");
  day = $(this).attr("data-day");
  hour = $(this).attr("data-hour");
  price = $("input[name=room_"+room_id+"_new_price]").val();


  if($(this).hasClass("timing_sellable_user")){
    $(this).removeClass("timing_sellable_user");
    $(this).addClass("timing_select_to_reserve_user");
  }else if($(this).hasClass("timing_select_to_reserve_user") && !$(this).hasClass("timing_unsellable")){
    $(this).addClass("timing_sellable_user");
    $(this).removeClass("timing_select_to_reserve_user");
  }else if($(this).hasClass("timing_reserved_user")){
    alert("این ساعت قابل رزرو نیست.");
  }else if($(this).hasClass("timing_unsellable")){
      alert("این ساعت قابل رزرو نیست.");
  }else{
    alert("این ساعت قابل رزرو نیست.");
    //work_on_cell(room_id,day,hour,true,false,price);
  }
});

$('.box').each(function(i, v){

var text = $.trim($(v).text()).length;
if(!text)
{
	$(v).addClass('timing_unsellable');
}

});


$('.timing_reserved_user').removeClass('timing_reserved_user').addClass('timing_unsellable').text(' ');
$('.timing_unsellable').removeClass('timing_reserved_user').text(' ');


