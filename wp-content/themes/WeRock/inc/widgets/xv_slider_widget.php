<?php

class xv_flex_slider_wgt extends WP_Widget
{
  function xv_flex_slider_wgt()
  {
    $widget_ops = array('classname' => 'xv_flex_slider_wgt', 'description' => 'Display latest posts with thumbnails' );
    $this->WP_Widget('xv_flex_slider_wgt', 'WeRock Flex Slider', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '','count'=>'' ) );
      
      if( $instance) {
            $title = esc_attr($instance['title']);
           
          
    } else {
            $title = '';
          
            
           
    }
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo  esc_attr($title); ?>" /></label></p>
   
    
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    
    // Retrieve Fields
    $instance['title']     = strip_tags($new_instance['title']);

    
    return $instance;
  }
 
  function widget($args, $instance)
  {  
    echo $before_widget;
    $title = apply_filters('widget_title', $instance['title']);
    $style =  $instance['select'];
    

  


    if(function_exists(get_werock_slider_widget)){
        get_werock_slider_widget();
    }else{

      echo 'Widget function is missing';
    }
       
  


   echo $after_widget;
  }
}
    add_action( 'widgets_init', create_function('', 'return register_widget("xv_flex_slider_wgt");') );