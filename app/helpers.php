<?php
function flash_message($message,$type){
  session()->flash("flash_message",$message);
  session()->flash("flash_message_type",$type);
}
function date_day_plus($date,$day){
    $explode = explode("-",$date);
    $date =  \Carbon\Carbon::create($explode[0],$explode[1],$explode[2],0);
    return $date->addDays($day);

}
function jalali_date($date,$input_separator="-",$output_separator ="/"){
  $explode = explode("-",$date);
  $jalali =  \Morilog\Jalali\jDateTime::toJalali($explode[0],$explode[1],$explode[2]);
  return $jalali[0].$output_separator.$jalali[1].$output_separator.$jalali[2];
}
function jalali_datetime($datetime,$input_separator="-",$output_separator ="/"){
  $explode = explode(" ",$datetime);
  $date = $explode[0];
  $time = $explode[1];
  $explode = explode("-",$date);
  $jalali =  \Morilog\Jalali\jDateTime::toJalali($explode[0],$explode[1],$explode[2]);
  return $jalali[0].$output_separator.$jalali[1].$output_separator.$jalali[2]." ".$time;
}
function compare_with_today($comparable) {
    $today = Carbon\Carbon::now();
    if ($today > $comparable->addDays(1))
    { return true; }
    else
    { return false; }
}

function compare_with_now($comparable) {
    $now = jDate::forge('now')->format('H');
    $now = $now;
    if ($now + 2 > $comparable)
    { return true; }
    else
    { return false; }
}
function is_today($c_date) {
    $today = Carbon\Carbon::today();
    if ($today == $c_date) {
        return true;
    }
    else {
        return false;
    }
}
function day_inText($i) {
    switch ($i) {
        case 0:
            return "شنبه";
            break;
        case 1:
            return "یک شنبه";
            break;
        case 2:
            return "دوشنبه";
            break;
        case 3:
            return "سه شنبه";
            break;
        case 4:
            return "چهارشنبه";
            break;
        case 5:
            return "پنجشنبه";
            break;
        case 6:
            return "جمعه";
            break;
        default:
            return "N/A";
    }
}
 ?>
