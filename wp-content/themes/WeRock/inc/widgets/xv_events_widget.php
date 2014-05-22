<?php

class xv_event_widget extends WP_Widget
{
  function xv_event_widget()
  {
    $widget_ops = array('classname' => 'xv_event_widget', 'description' => 'Display Latest Events' );
    $this->WP_Widget('xv_event_widget', 'WeRock Events', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '','count'=>'','offset' => '' ) );
      
      if( $instance) {
            $title = esc_attr($instance['title']);
            $count = esc_attr($instance['count']);
            $offset = esc_attr($instance['offset']);
          
          
    } else {
            $title = '';
            $count = '';
            $select = ''; // Added
            $select_cat = ''; // Added
            
           
    }
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'werock'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo  esc_attr($title); ?>" /></label></p>
    <p>
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number Of Posts:', 'werock'); ?></label>
    <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
    </p>
     <p>
    <label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e('Offset (Start posts from: e.g:3)', 'werock'); ?></label>
    <input id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" />
    </p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    
    // Retrieve Fields
    $instance['title']     = strip_tags($new_instance['title']);
    $instance['count']     = strip_tags($new_instance['count']);
    $instance['offset']    = strip_tags($new_instance['offset']);
    
    return $instance;
  }
 
  function widget($args, $instance)
  {  
    echo $before_widget;
    
    $title  = apply_filters('widget_title', $instance['title']);
    $offset =  $instance['offset'];
    $count  = $instance['count'];

    if( $count && is_numeric($count) ) {
       $post_per_page = $count;
    }
    else{ 
        $post_per_page = 1;
    }
    if(function_exists(get_werock_events_widget)){
       get_werock_events_widget($title,$post_per_page,$offset);
    }else{

      echo 'Widget function is missing';
    }
   echo $after_widget;
  }
}
    add_action( 'widgets_init', create_function('', 'return register_widget("xv_event_widget");') );

