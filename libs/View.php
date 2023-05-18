<?php

class View{

  function __construct(){
    //echo "Vista base";
  }
  function render($nombre){
    require 'views/' . $nombre . '.php';
  }
}