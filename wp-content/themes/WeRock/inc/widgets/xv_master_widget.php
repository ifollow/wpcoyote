<?php 
class WeRock_Mega_Menu_Widget extends WP_Widget
{
  function WeRock_Mega_Menu_Widget()
  {
    $widget_ops = array('classname' => 'WeRock_Mega_Menu_Widget', 'description' => 'Display latest posts with thumbnails' );
    $this->WP_Widget('WeRock_Mega_Menu_Widget', 'WeRock Mega Menu', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '','count'=>'' ) );
      
      if( $instance) {
            $title = esc_attr($instance['title']);
            $count = esc_attr($instance['count']);
            $select = esc_attr($instance['select']); // Added
            $select_cat = esc_attr($instance['select_cat']); // Added
             $offset = esc_attr($instance['offset']);
          
    } else {
            $title = '';
            $count = '';
            $select = ''; // Added
            $select_cat = ''; // Added
            $offset = '';
            
           
    }
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo  esc_attr($title); ?>" /></label></p>
    <p>
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number Of Posts:', 'wp_widget_plugin'); ?></label>
    <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
    </p>
     <p>
    <label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e('Offset (Start posts from: e.g:3)', 'werock'); ?></label>
    <input id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" />
    </p>
    <p class="description">
      <label for="<?php echo $this->get_field_id('select'); ?>"><?php _e('Select', 'wp_widget_plugin'); ?></label>
      <select name="<?php echo $this->get_field_name('select'); ?>" id="<?php echo $this->get_field_id('select'); ?>" class="widefat">
        <?php
        $options = array('Thumbnails', 'Title Links', 'Large Post Style','Medium Post Style','Small Post Style');
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


$post_types =  array('post','news','album','artist','gallary');

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
     $instance['offset']    = strip_tags($new_instance['offset']);
    


    
    return $instance;
  }
 
  function widget($args, $instance)
  {
    //echo $before_widget;
   $title = apply_filters('widget_title', $instance['title']);
   $style =  $instance['select'];
   $count = $instance['count'];
   $offset =  $instance['offset'];
   $post_type =  $instance['select_cat'];

    if( $count && is_numeric($count) ) {
       $posts_per_page = $count;
    }
    else{ 
        $posts_per_page = 1;
    }


     // wp_reset_postdata();
     // wp_reset_query();
        if($style == 'Thumbnails')
          {
            WeRock_Mega_Menu_Widget_style1($title,$post_type,$posts_per_page,$offset);
          }
         elseif($style == 'Title Links') {

          WeRock_Mega_Menu_Widget_style2($title,$post_type,$posts_per_page,$offset);
          }

          elseif($style == 'Medium Post Style') {

          WeRock_Mega_Menu_Widget_style3($title,$post_type,$posts_per_page,$offset);
          }
          elseif($style == 'Style4') {

          WeRock_Mega_Menu_Widget_style4($title,$post_type,$posts_per_page,$offset);
          }
          elseif($style == 'Style5') {

          WeRock_Mega_Menu_Widget_style5($title,$post_type,$posts_per_page,$offset);
          }
          elseif($style == 'Large Post Style') {

          WeRock_Mega_Menu_Widget_style6($title,$post_type,$posts_per_page,$offset);
          }
          elseif($style == 'Small Post Style') {

          WeRock_Mega_Menu_Widget_style7($title,$post_type,$posts_per_page,$offset);
          }
   
     // wp_reset_query();


   // echo $after_widget;
  }
}
    add_action( 'widgets_init', create_function('', 'return register_widget("WeRock_Mega_Menu_Widget");') );

function WeRock_Mega_Menu_Widget_style1($title,$post_type,$posts_per_page=1,$style){?>
        <div class="thumbs_widget">
            <h2><?php echo $title; ?></h2>
            <?php
            
                 $xv_query = new WP_Query(array('post_type'=>$post_type,'posts_per_page' => $posts_per_page,'offset'=>$offset));
    
            while ($xv_query->have_posts()) : $xv_query->the_post(); ?>
            
            <div class="yamm-artist-album">
              <a href="<?php the_permalink(); ?>"> <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?></a>
            </div>
    
             <?php endwhile;     ?>
         </div>
         <div class="clearfix"></div>

<?php
}


                                      
                                      
                                    
function WeRock_Mega_Menu_Widget_style2($title,$post_type,$posts_per_page=1,$offset=0){
      
     // $xv_query = new WP_Query(array('post_type'=>'album','posts_per_page' => 5));?>

        <h2><?php echo $title; ?></h2>
        <ul class="yamm-artist-name">
  
        <?php
       $xv_query = new WP_Query(array('post_type'=>$post_type,'posts_per_page' => $posts_per_page,'offset'=>$offset));
                                                                           
     while ($xv_query->have_posts()) : $xv_query->the_post(); ?>
      <li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
     
         <?php endwhile;     ?>
         <div class="clearfix"></div>
 </ul>
<?php
}

function WeRock_Mega_Menu_Widget_style3($title,$post_type,$posts_per_page=1,$offset=0){?>
  <div class="yamm-artist-info">
<h2><?php echo $title; ?></h2>
<?php
              $xv_query = new WP_Query(array('post_type'=>$post_type,'posts_per_page' => $posts_per_page,'offset'=>$offset));
                   while ($xv_query->have_posts()) : $xv_query->the_post(); ?>

        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
          
             <a href="<?php the_permalink(); ?>"> <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?></a>
        </div>
        <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
          <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
           <p> <?php werock_get_excerpt(125); ?></p>
        </div><!--col-->

          <?php endwhile;     ?>
    </div>

<?php } 

function WeRock_Mega_Menu_Widget_style4($title,$post_type,$posts_per_page=1,$offset=0){?>

    <h2><?php echo $title; ?></h2>
    
    <?php
        $xv_query = new WP_Query(array('post_type'=>$post_type,'posts_per_page' => $posts_per_page,'offset'=>$offset));
        while ($xv_query->have_posts()) : $xv_query->the_post(); ?>

        <div class="video-feed">
          <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
            <a href="<?php the_permalink(); ?>"><span class="fa fa-play"></span></a>
            <h5><?php the_title(); ?></h5>
        </div>

          <?php endwhile;     ?>

<?php } 

function WeRock_Mega_Menu_Widget_style5($title,$post_type,$posts_per_page=1,$offset=0){?>
 
  <h2><?php echo $title; ?></h2>
<?php
              $xv_query = new WP_Query(array('post_type'=>$post_type,'posts_per_page' => $posts_per_page,'offset'=>$offset));
                   while ($xv_query->have_posts()) : $xv_query->the_post(); ?>

<div class="video-feed">
<?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
<a href="<?php the_permalink(); ?>"><span class="fa fa-play"></span></a>
<h6>1 week ago</h6>
</div><!--\\video-feed-->
<h4><?php the_title(); ?></h4>
 <p> <?php werock_get_excerpt(125); ?></p>
      


       
          <?php endwhile;     ?>
    

<?php } 

function WeRock_Mega_Menu_Widget_style6($title,$post_type,$posts_per_page=1,$offset=0){?>
 
  <h2><?php echo $title; ?></h2>
<?php
              $xv_query = new WP_Query(array('post_type'=>$post_type,'posts_per_page' => $posts_per_page,'offset'=>$offset));
                   while ($xv_query->have_posts()) : $xv_query->the_post(); ?>

<div class="yamm-blog">
<?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
</div>

       
          <?php endwhile;     ?>
    

<?php } 

function WeRock_Mega_Menu_Widget_style7($title,$post_type,$posts_per_page=1,$offset=0){?>
 
  <h2><?php echo $title; ?></h2>
<?php
              $xv_query = new WP_Query(array('post_type'=>$post_type,'posts_per_page' => $posts_per_page));
                   while ($xv_query->have_posts()) : $xv_query->the_post(); ?>

<div class="yamm-blog-detail clearfix">
  <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>

        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

       <p> <?php werock_get_excerpt(100,1); ?></p>

                                                    </div>

       
          <?php endwhile;     ?>
    

<?php } ?>