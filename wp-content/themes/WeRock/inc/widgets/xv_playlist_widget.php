<?php

class xv_playlist_widget extends WP_Widget
{
  function xv_playlist_widget()
  {
    $widget_ops = array('classname' => 'xv_playlist_widget', 'description' => 'Display latest posts with thumbnails' );
    $this->WP_Widget('xv_playlist_widget', 'WeRock Playlist', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '','count'=>'' ) );
      
      if( $instance) {
            $title = esc_attr($instance['title']);
            $count = esc_attr($instance['count']);
            $select = esc_attr($instance['select']); // Added
            $select_cat = esc_attr($instance['select_cat']); // Added
          
    } else {
            $title = '';
            $count = '';
            $select = ''; // Added
            $select_cat = ''; // Added
            
           
    }
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo  esc_attr($title); ?>" /></label></p>
    <p>
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number Of Posts:', 'wp_widget_plugin'); ?></label>
    <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
    </p>

    <p class="description">
      <label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Select', 'wp_widget_plugin'); ?></label>
      <select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
        <?php
        $options = array('Style1', 'Style2', 'Style3','Style4','Style5','Style6','Style7');
        foreach ($options as $option) {
          echo '<option value="' . $option . '" id="' . $option . '"', $select == $option ? ' selected="selected"' : '', '>', $option, '</option>';
        }
        ?>
      </select>
      </p>

      <p class="description">
      <label for="<?php echo $this->get_field_id('select_cat'); ?>"><?php _e('Select', 'wp_widget_plugin'); ?></label>
      <select name="<?php echo $this->get_field_name('select_cat'); ?>" id="<?php echo $this->get_field_id('select_cat'); ?>" class="widefat">
      <?php

          $args = array(
             'public'   => false,
             '_builtin' => false
          );

          $args2 = array(
             'name' => 'post'
          );
          $args3 = array(
             'name' => 'page'
          );

          $output = 'objects'; // names or objects

          $post_types = get_post_types($args, 'names' ); 
          //$post_types += get_post_types($args1, 'names' ); 
          //$post_types += get_post_types($args2, 'names' ); 

          foreach ( $post_types as $post_type ) {

            echo '<option value="' . $post_type . '" id="' .$post_type . '"', $select_cat ==  $post_type  ? ' selected="selected"' : '', '>',  $post_type , '</option>';
            
          }
      ?>
      </select>
    </p>
    
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    
    // Retrieve Fields
    $instance['title']     = strip_tags($new_instance['title']);
    $instance['count']     = strip_tags($new_instance['count']);
    $instance['checkbox']  = strip_tags($new_instance['checkbox']);
    $instance['select']    = strip_tags($new_instance['select']);
    $instance['select_cat']= strip_tags($new_instance['select_cat']);

    
    return $instance;
  }
 
  function widget($args, $instance)
  {  
    echo $before_widget;
    $title = apply_filters('widget_title', $instance['title']);
    $style =  $instance['select'];
    $count = $instance['count'];

    if( $count && is_numeric($count) ) {
       $number_of_comments = $count;
    }
    else{ 
        $number_of_comments = 2;
    }

    if($select){$style = $select;}
    if($select_cat){$cat_name = $select_cat;}


        if($style == 'Style1')
          {
            xv_playlist_widget_style1($title,$cat_name,$number_of_posts,$style);
          }
    
    if(function_exists(get_werock_player_widget)){
        get_werock_player_widget();
    }else{

      echo 'Widget function is missing';
    }
       
  


   echo $after_widget;
  }
}
    add_action( 'widgets_init', create_function('', 'return register_widget("xv_playlist_widget");') );

