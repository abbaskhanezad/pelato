<?php

namespace App;


class Metronic
{
  public $setting;

  function __construct(){
    $table =[
        "title_icon"=> "settings",
        "title_name" => "title_name",
        "column" => "",
        "rows_checkbox" => false,
        "controller" => "",
        "button"=>[
          "title" => "اضافه کردن" , "color" => "blue" , "link" => ""
        ]
      ];
    $this->table = $this->array_to_object($table);
  }

  function array_to_object($array) {
  $obj = new \stdClass;
  foreach($array as $k => $v) {
     if(strlen($k)) {
        if(is_array($v)) {
           $obj->{$k} = $this->array_to_object($v); //RECURSION
        } else {
           $obj->{$k} = $v;
        }
     }
  }
  return $obj;
}
}
