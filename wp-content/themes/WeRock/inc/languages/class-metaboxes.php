<?php
/*
Plugin Name: Demo MetaBox
Plugin URI: http://en.bainternet.info
Description: My Meta Box Class usage demo
Version: 3.1.1
Author: Bainternet, Ohad Raz
Author URI: http://en.bainternet.info
*/

//include the main class file
require_once("meta-box-class/my-meta-box-class.php");
if (is_admin()){
  /* 
   * prefix of meta keys, optional
   * use underscore (_) at the beginning to make keys hidden, for example $prefix = '_ba_';
   *  you also can make prefix empty to disable it
   * 
   */
  $prefix = 'xv_';
  /* 
   * configure your meta box
   */
  $config = array(
    'id'             => 'page-subtitle',          // meta box id, unique per meta box
    'title'          => 'Sub Title',          // meta box title
    'pages'          => array('page'),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'high',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
     'use_with_theme' => get_stylesheet_directory_uri() .'/inc/meta-box-class'          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your meta box
   */
  $my_meta =  new AT_Meta_Box($config);
  
  /*
   * Add fields to your meta box
   */
  
  //text field
  $my_meta->addText($prefix.'page-subtitle',array('name'=> 'Sub Title','class' => 'track-fields'));

  /*
   * Don't Forget to Close up the meta box Declaration 
   */
  //Finish Meta Box Declaration 
  $my_meta->Finish();
/////////////////////////////////////////////////////////////////////////////////////////////////
  $config0 = array(
    'id'             => 'post-titles',          // meta box id, unique per meta box
    'title'          => 'Top Titles',          // meta box title
    'pages'          => array('post','news','event','artist','album',),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'high',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
     'use_with_theme' => get_stylesheet_directory_uri() .'/inc/meta-box-class'          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your meta box
   */
  $my_meta0 =  new AT_Meta_Box($config0);
  
  /*
   * Add fields to your meta box
   */
  
  //text field
  $my_meta0->addText($prefix.'post-top-title',array('name'=> 'Top Title','class' => 'track-fields','placeholder' => 'Blog / News / Event (Optional)'));
  $my_meta0->addText($prefix.'post-subtitle',array('name'=> 'Sub Title','class' => 'track-fields'));

  /*
   * Don't Forget to Close up the meta box Declaration 
   */
  //Finish Meta Box Declaration 
  $my_meta0->Finish();
//////////////////////////////////--Menu--///////////////////////////////////////////////////////
  /* 
   * configure your meta box
   */
  $config1 = array(
    'id'             => 'menu',          // meta box id, unique per meta box
    'title'          => 'Menu URL',          // meta box title
    'pages'          => array('menu'),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'high',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
     'use_with_theme' => get_stylesheet_directory_uri() .'/inc/meta-box-class'             //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  /*
   * Initiate your 1nd meta box
   */
  $my_meta1 =  new AT_Meta_Box($config1);
  
  /*
   * Add fields to your 1nd meta box
   */

    $my_meta1->addText($prefix.'menu_url',array('name'=> 'Custom URL','class' => 'track-fields','group' => 'start'));
    
/*
     $Conditinal_fields[] = $my_meta1->addPosts('posts_field_id',array('post_type' => 'page'),array('name'=> 'Pages'),true);

  
      $my_meta1->addCondition($prefix.'is_menu_page',
      array(
        'name' => __('Select from your pages. ','mmb'),
        'desc' => __('<small>Turn ON if you want to enable the <strong>conditinal fields</strong>.</small>','mmb'),
        'fields' => $Conditinal_fields,
        'std' => false,
        'group' => 'end'
      ));
*/


  //Finish Meta Box Declaration 
  $my_meta1->Finish();
//////////////////////////////////--Playlist--///////////////////////////////////////////////////////
  /* 
   * configure your meta box
   */
  $config2 = array(
    'id'             => 'playlist',          // meta box id, unique per meta box
    'title'          => 'Track URL',          // meta box title
    'pages'          => array('playlist'),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'high',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
     'use_with_theme' => get_stylesheet_directory_uri() .'/inc/meta-box-class'             //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  /*
   * Initiate your 1nd meta box
   */
  $my_meta2 =  new AT_Meta_Box($config2);
  
  /*
   * Add fields to your 1nd meta box
   */

    $my_meta2->addText($prefix.'playlist_track_url',array('name'=> 'Track MP3 URL','class' => 'track-fields'));
    $my_meta2->addText($prefix.'playlist_artist',array('name'=> 'Artist Name','class' => 'track-fields'));
    


  //Finish Meta Box Declaration 
  $my_meta2->Finish();



/////////////////////////////////////--Artist--///////////////////////////////////////////////////////////  



  $config3 = array(
    'id'             => 'tracks',          // meta box id, unique per meta box
    'title'          => 'Tracks',          // meta box title
    'pages'          => array('artist'),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'low',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)

     'use_with_theme' => get_stylesheet_directory_uri() .'/inc/meta-box-class'              //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your 3rd meta box
   */
  $my_meta3 =  new AT_Meta_Box($config3);

  /*
   * To Create a reapeater Block first create an array of fields
   * use the same functions as above but add true as a last param
   */
  


  $repeater_fields[] = $my_meta3->addText($prefix.'track_title',array('name'=> 'Track Title','class' => 'track-fields', 'placeholder' => 'Enter Track Title'),true);
  $repeater_fields[] = $my_meta3->addText($prefix.'track_description',array('name'=> 'Track Description ','class' => 'track-fields','placeholder' => 'e.g: Release Date <span>2014</span>'),true);
  $repeater_fields[] = $my_meta3->addText($prefix.'track_url',array('name'=> 'Track URL','class' => 'track-fields'),true);
  $repeater_fields[] = $my_meta3->addText($prefix.'track_buy_btn',array('name'=> 'Buy Button Title ','class' => 'track-fields','placeholder' =>'BUY IT ON ITUNES (default)','std' =>'BUY IT ON ITUNES'),true);
  $repeater_fields[] = $my_meta3->addText($prefix.'track_buy_url',array('name'=> 'Buy URL ','class' => 'track-fields'),true);

    /*
     * Then just add the fields to the repeater block
     */
    //repeater block
    $my_meta3->addRepeaterBlock($prefix.'track_title',array('name' => ' ','fields' => $repeater_fields,'sortable' => true));
    /*
     * Don't Forget to Close up the meta box decleration
     */
  //Finish Meta Box Declaration 
  $my_meta3->Finish();



/////////////////////////////////////--Album--///////////////////////////////////////////////////////////  



  $config4 = array(
    'id'             => 'album-tracks',          // meta box id, unique per meta box
    'title'          => 'Tracks',          // meta box title
    'pages'          => array('album'),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'low',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)

     'use_with_theme' => get_stylesheet_directory_uri() .'/inc/meta-box-class'              //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your 4rd meta box
   */
  $my_meta4 =  new AT_Meta_Box($config4);

  /*
   * To Create a reapeater Block first create an array of fields
   * use the same functions as above but add true as a last param
   */
  


  $repeater_fields4[] = $my_meta4->addText($prefix.'album_track_title',array('name'=> 'Track Title','class' => 'track-fields', 'placeholder' => 'Enter Track Title'),true);
  $repeater_fields4[] = $my_meta4->addText($prefix.'track_description',array('name'=> 'Track Description ','class' => 'track-fields','placeholder' => 'e.g: Release Date <span>2014</span>'),true);
  $repeater_fields4[] = $my_meta4->addText($prefix.'track_url',array('name'=> 'Track URL','class' => 'track-fields'),true);
  $repeater_fields4[] = $my_meta4->addText($prefix.'track_buy_btn',array('name'=> 'Buy Button Title ','class' => 'track-fields','placeholder' =>'BUY IT ON ITUNES (default)','std' =>'BUY IT ON ITUNES'),true);
  $repeater_fields4[] = $my_meta4->addText($prefix.'track_buy_url',array('name'=> 'Buy URL ','class' => 'track-fields'),true);
  $repeater_fields4[] = $my_meta4->addTime($prefix.'track_time',array('name'=> 'Time '),true);
  $repeater_fields4[] = $my_meta4->addSelect($prefix.'track_popularity',array('1'=>'1 Bar',
                                                                            '2'=>'2 Bars',
                                                                            '3'=>'3 Bars',
                                                                            '4'=>'4 Bars',
                                                                            '5'=>'5 Bars',
                                                                            '6'=>'6 Bars',
                                                                            '7'=>'7 Bars',
                                                                            '8'=>'8 Bars',
                                                                            '9'=>'9 Bars',
                                                                            '10'=>'10 Bars',
                                                                            '11'=>'11 Bars',
                                                                            '12'=>'12 Bars',
                                                                            '13'=>'13 Bars'

                                                                            ),array('name'=> 'Popularity ', 'std'=> array('selectkey2')),true);

    /*
     * Then just add the fields to the repeater block
     */
    //repeater block
    $my_meta4->addRepeaterBlock($prefix.'re',array('name' => ' ','fields' => $repeater_fields4,'sortable' => true));
    /*
     * Don't Forget to Close up the meta box decleration
     */
  //Finish Meta Box Declaration 
  $my_meta4->Finish();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

$config5 = array(
    'id'             => 'album',          // meta box id, unique per meta box
    'title'          => 'Album Buy Buttons',          // meta box title
    'pages'          => array('album'),      // post types, accept custom post types as well, default is array('post'); optional
    'context'        => 'side',            // where the meta box appear: normal (default), advanced, side; optional
    'priority'       => 'high',            // order of meta box: high (default), low; optional
    'fields'         => array(),            // list of meta fields (can be added by field arrays)
    'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)

     'use_with_theme' => get_stylesheet_directory_uri() .'/inc/meta-box-class'              //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );
  
  
  /*
   * Initiate your 5rd meta box
   */
  $my_meta5 =  new AT_Meta_Box($config5);

  /*
   * To Create a reapeater Block first create an array of fields
   * use the same functions as above but add true as a last param
   */
  
  $repeater_fields5[] = $my_meta5->addText($prefix.'album_buy_btn',array('name'=> '','class' => 'track-fields','placeholder' =>'Buy Mp3 Album'),true);
  $repeater_fields5[] = $my_meta5->addText($prefix.'album_price',array('name'=> '','class' => 'track-fields','placeholder' =>'Price'),true);
  $repeater_fields5[] = $my_meta5->addText($prefix.'album_buy_url',array('name'=> '','class' => 'track-fields','placeholder' =>'URL'),true);


    /*
     * Then just add the fields to the repeater block
     */
    //repeater block
    $my_meta5->addRepeaterBlock($prefix.'re_album',array('name' => ' ','fields' => $repeater_fields5,'sortable' => true));
    /*
     * Don't Forget to Close up the meta box decleration
     */
  //Finish Meta Box Declaration 
  $my_meta5->Finish();











}
