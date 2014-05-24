<?php
/*
  Plugin Name: DZS Page Builder
  Plugin URI: http://digitalzoomstudio.net/
  Description: Drag & Drop Layout Builder
  Version: 1.00
  Author: Digital Zoom Studio
  Author URI: http://digitalzoomstudio.net/
 */
include_once(dirname(__FILE__).'/dzs_functions.php');
if(!class_exists('DZSPageBuilder')){
    include_once(dirname(__FILE__).'/class-dzspb.php');
}



$dzspb = new DZSPageBuilder();
