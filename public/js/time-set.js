var working_range = [0,23];
function work_on_cell(room,day,hour,sellable=false,reserved=false,price="",page_start_view = false){
  if(reserved){
    $(".room_"+room+"#box_"+day+"_"+hour).addClass("timing_reserved");
    //Uncheck Cell for not sellable
  }else if(sellable){
    //Check Cell not Reserved
    if(! $(".room_"+room+"#box_"+day+"_"+hour).hasClass("timing_reserved") ){
      $(".room_"+room+"#box_"+day+"_"+hour).addClass("timing_sellable");
    }
  }else{
    $(".room_"+room+"#box_"+day+"_"+hour).removeClass("timing_sellable");
    $(".room_"+room+"#box_"+day+"_"+hour).html("")
  }
  //Check cell Reserved to price
  if($(".room_"+room+"#box_"+day+"_"+hour).hasClass("timing_sellable") || page_start_view){
    $(".room_"+room+"#box_"+day+"_"+hour).html(price);
  }
}
function timing_view_to_object(){
  var record = "";

  for(i=0;i<=23;i++){
    for(j=0;j<7;j++){
      window.room_list.forEach(function(element){
        record = _.where(window.room_timing,{week_id : week_id , room_id : element.id , day : j , start_hour : i });
        var cell = $(".room_"+element.id+"#box_"+j+"_"+i);

        //Record Exist previously
        if(Object.keys(record).length != 0){

          //Cell Checked - cell should be updated
          if(cell.hasClass("timing_sellable")){
            if(record[0].price != cell.html()){
              record[0].operation_status = "update";
              record[0].price = cell.html();
            }else{
              record[0].operation_status = "n/a";
            }

          //Cell Reserved - nothing to do for this cell
          }else if(cell.hasClass("timing_reserved")){
          record[0].operation_status = "n/a";

          //Cell should be removed
          }else{
            record[0].operation_status = "delete";
          }

        //Record not Exist previously
        }else{
          //Cell checked - it should be inserted
          if(cell.hasClass("timing_sellable")){
            window.room_timing.push({
              id: 0,
              week_id : week_id,
              room_id : element.id,
              day: j,
              start_hour: i,
              price: cell.html(),
              selled: 0,
              created_at: "",
              updated_at: "",
              operation_status: "insert"
            });
          }
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
        result = _.where(room_timing, {room_id: element.id , week_id: window.week_id, day: j , start_hour: i});
        if(result != ""){
          if(result[0].selled){
            work_on_cell(element.id,j,i,false,true,result[0].price,true);
          }else{
            work_on_cell(element.id,j,i,true,false,result[0].price);
          }
        }
      });
    }
  }
}
//Batch cell control
function update_cells_batch(){
	//alert('aa');
  if(edit_enabled == 1){
    operation_type = $("input[name=control_what]:checked").val();

    if(operation_type == 1){
      //$(".box .timing_sellable").html("");
      //$(".box .timing_sellable").removeClass("timing_sellable");
      $(".box").html("");
      $(".box").removeClass("timing_sellable");

    }
    working_range[0] = Math.trunc(working_range[0]);
    working_range[1] = Math.trunc(working_range[1]);


    for(i=working_range[0];i<=working_range[1];i++){
      for(j=0;j<7;j++){
        window.room_list.forEach(function(element){
          if(operation_type == 1){
            work_on_cell(element.id,j,i,true,false,element.price);
          }else if(operation_type == 2){
            if($(".room_"+element.id+"#box_"+j+"_"+i).hasClass("timing_sellable")){
              var new_price = $("input[name=room_"+element.id+"_new_price]").val();
                //console.log(".room_"+element.id+"#box_"+j+"_"+i+"---------");
              work_on_cell(element.id,j,i,true,false,new_price);
            }else{
              //console.log(".room_"+element.id+"#box_"+j+"_"+i);
            }
          }
        });
      }
    }
	    alert('اعمال شد، برای نهایی کردن دکمه "ثبت نهایی" را بفشارید');

  }else{
    //alert("زمانبندی هفته های گذشته قابل تغییر نمی باشند");
	  swal("زمانبندی هفته های گذشته قابل تغییر نمی باشند", "", "error");


  }
}

function update_cells_batch2(){
	
  if(edit_enabled == 1){
    operation_type = $("input[name=control_what]:checked").val();

    if(operation_type == 1){
      //$(".box .timing_sellable").html("");
      //$(".box .timing_sellable").removeClass("timing_sellable");
      $(".box").html("");
      $(".box").removeClass("timing_sellable");

    }
    working_range[0] = Math.trunc(working_range[0]);
    working_range[1] = Math.trunc(working_range[1]);


    for(i=working_range[0];i<=working_range[1];i++){
      for(j=0;j<7;j++){
        window.room_list.forEach(function(element){
          if(operation_type == 1){
            work_on_cell(element.id,j,i,true,false,element.price);
          }else if(operation_type == 2){
            if($(".room_"+element.id+"#box_"+j+"_"+i).hasClass("timing_sellable")){
              var new_price = $("input[name=room_"+element.id+"_new_price]").val();
                //console.log(".room_"+element.id+"#box_"+j+"_"+i+"---------");
              work_on_cell(element.id,j,i,true,false,new_price);
            }else{
              //console.log(".room_"+element.id+"#box_"+j+"_"+i);
            }
          }
        });
      }
    }

    alert('اعمال شد، برای نهایی کردن دکمه "ثبت نهایی" را بفشارید');
  }else{
    alert("زمانبندی هفته های گذشته قابل تغییر نمی باشند");
  }
}


//Show on Page Start based on Database
timing_object_to_view();
//Set on click cell
$("#room_timing_result").submit(function(){
  timing_view_to_object();
  //alert(room_timing);
  $("input[name=result_to_save]").val(JSON.stringify(room_timing));
});
$(".box").click(function(){
  if(edit_enabled == 1){
    operation_type = $("input[name=control_what]:checked").val();

    room_id = $(this).attr("data-roomid");
    day = $(this).attr("data-day");
    hour = $(this).attr("data-hour");
    price = $("input[name=room_"+room_id+"_new_price]").val();

    if(operation_type == 1){
      if($(this).hasClass("timing_sellable")){
        work_on_cell(room_id,day,hour,false,false,"");
      }else{
        work_on_cell(room_id,day,hour,true,false,price);
      }
    }else if(operation_type == 2){
      work_on_cell(room_id,day,hour,true,false,price);
    }
  }else{
    //alert("زمانبندی هفته های گذشته قابل تغییر نمی باشند");
	   swal("زمانبندی هفته های گذشته قابل تغییر نمی باشند", "", "error");
	   




  }
});
$(".timing_reserved").hover(function(){
    var current_order_id = $(this).attr("data-order-id");
    $(".timing_reserved").each(function(){
      if($(this).attr("data-order-id") == current_order_id){
        $(this).addClass("reserved_hover");
      }
    });
},function(){
    var current_order_id = $(this).attr("data-order-id");
    $(".timing_reserved").each(function(){
      if($(this).attr("data-order-id") == current_order_id){
        $(this).removeClass("reserved_hover");
      }
    });
  }
);
$(".timing_reserved").each(function(){
  room = $(this).attr("data-roomid");
  day = $(this).attr("data-day");
  start_hour = $(this).attr("data-hour");
  record = _.where(window.room_timing,{week_id : week_id , room_id : parseInt(room) , day : parseInt(day) , start_hour : parseInt(start_hour) });
  $(this).attr("data-order-id",record[0].order_room[0].id);
  $(this).attr("href","/timing/ajax_order_view/"+record[0].order_room[0].id);
  $(this).attr("data-target","#reserve_data_box");
  $(this).attr("data-toggle","modal");
  $(this).attr("title","برای مشاهده جزئیات رزرو کلیک کنید");

});

$(document).on('click', ".timing_reserved", function(){
  var el = $(this);
  var url = $(el).attr('href');
  $.get(url, function (data) {
    $("#reserve_data_box").find('.modal-body:first').html('');
    $("#reserve_data_box").find('.modal-body:first').html(data);
    $("#reserve_data_box").modal("show");
  });
});
