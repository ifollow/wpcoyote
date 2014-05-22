<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package werock
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function werock_page_menu_args( $args ) {
  $args['show_home'] = true;
  return $args;
}
add_filter( 'wp_page_menu_args', 'werock_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function werock_body_classes( $classes ) {
  // Adds a class of group-blog to blogs with more than 1 published author.
  if ( is_multi_author() )
    $classes[] = 'group-blog';

  return $classes;
}
add_filter( 'body_class', 'werock_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function werock_wp_title( $title, $sep ) {
  global $page, $paged;

  if ( is_feed() )
    return $title;

  // Add the blog name
  $title .= get_bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    $title .= " $sep $site_description";

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 )
    $title .= " $sep " . sprintf( __( 'Page %s', 'werock' ), max( $paged, $page ) );

  return $title;
}
add_filter( 'wp_title', 'werock_wp_title', 10, 2 );

//add active class in selected page
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';  // your new class
     }
     return $classes;
}

//add dropdown class in menu
function werock_menu_set_dropdown( $sorted_menu_items, $args ) {
    $last_top = 0;
    foreach ( $sorted_menu_items as $key => $obj ) {
        // it is a top lv item?
        if ( 0 == $obj->menu_item_parent ) {
            // set the key of the parent
            $last_top = $key;
        } else {
            $sorted_menu_items[$last_top]->classes['dropdown'] = 'dropdown';
        }
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'werock_menu_set_dropdown', 10, 2 );




/*
 Extra Search Form
*/
 function werock_search_form( $form ) {
    $form = '<form role="search" method="get" id="search-form-mobile" action="'. home_url( '/' ) .'">';
    $form .= ' <input  name="s" type="text" placeholder="search"/>';
    $form .= ' <button type="submit"><i class="fa fa-search"></i></button>';
    $form .= '</form>';
    return $form;
}
/*
 Excerpt
*/
function werock_get_excerpt($count,$news=0){
 global $post;
  $permalink = get_permalink($post->ID);
  $excerpt = get_the_content();
  $excerpt = strip_tags($excerpt);
  $excerpt = substr($excerpt, 0, $count);
  $excerpt = substr($excerpt, 0, strripos($excerpt, " "));

  if($news == 1){
         $excerpt = $excerpt;
  }else{
         $excerpt = $excerpt.'<p><a class="btn" href="'.$permalink.'"> Read more <i class="icon-angle-right"></i></a></p>';
       }
  echo $excerpt;

}
/*
* Pagination code
*/
function werock_get_pagination($pages = '', $range = 4)

{ 
     $showitems = ($range * 2)+1; 
     global $paged;
     if(empty($paged)) $paged = 1;
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
     if(1 != $pages)
     {
         echo "<ul class=\"pagination\">";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo; First</a></li>";
         echo'<li>';
          previous_posts_link('<i class="fa fa-angle-left pagination-icon"></i>');
         echo'</li>';
          //echo "<a href='".get_pagenum_link($paged - 1)."'><i class='icon-chevron-left pagination-icon'></i></a>";
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))

             {
                 echo ($paged == $i)? "<li class=\"active\"><a href='#'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a></li>";
             }
         }
          //echo "<a href=\"".get_pagenum_link($paged + 1)."\"><i class='icon-chevron-right pagination-icon'></i></a>";
          echo'<li>'; 
          next_posts_link('<i class="fa fa-angle-right pagination-icon"></i>','');
          echo'</li>';
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>Last &raquo;</a></li>";
         echo "</ul>\n";
     }
}

/**
 * Display template for breadcrumbs.
 *
 */
function werock_breadcrumbs()
{
    $home      = 'Home '; // text for the 'Home' link
    $before    = '<li class="active">'; // tag before the current crumb
    $sep       = ' ';
    $after     = '</li>'; // tag after the current crumb

    if (!is_home() && !is_front_page() || is_paged()) {

        echo '<div class="crumbs"><ul>';

        global $post;
        $homeLink = home_url();
            echo '<li><a href="' . $homeLink . '">' . $home . '</a> </li> ';
            if (is_category()) {
                global $wp_query;
                $cat_obj   = $wp_query->get_queried_object();
                $thisCat   = $cat_obj->term_id;
                $thisCat   = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                if ($thisCat->parent != 0) {
                    echo get_category_parents($parentCat, true, $sep);
                }
                echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
            } elseif (is_day()) {
                echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time(
                    'Y'
                ) . '</a></li> ';
                echo '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time(
                    'F'
                ) . '</a></li> ';
                echo $before . get_the_time('d') . $after;
            } elseif (is_month()) {
                echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time(
                    'Y'
                ) . '</a></li> ';
                echo $before . get_the_time('F') . $after;
            } elseif (is_year()) {
                echo $before . get_the_time('Y') . $after;
            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $post_type = get_post_type_object(get_post_type());
                    $slug      = $post_type->rewrite;
                    echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ';
                    echo $before . get_the_title() . $after;
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    echo '<li>'.get_category_parents($cat, true, $sep).'</li>';
                    echo $before . get_the_title() . $after;
                }
            } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                $post_type = get_post_type_object(get_post_type());
                echo $before . $post_type->labels->singular_name . $after;
            } elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $cat    = get_the_category($parent->ID);
                $cat    = $cat[0];
                echo get_category_parents($cat, true, $sep);
                echo '<li><a href="' . get_permalink(
                    $parent
                ) . '">' . $parent->post_title . '</a></li> ';
                echo $before . get_the_title() . $after;

            } elseif (is_page() && !$post->post_parent) {
                echo $before . get_the_title() . $after;
            } elseif (is_page() && $post->post_parent) {
                $parent_id   = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page          = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title(
                        $page->ID
                    ) . '</a>' . $sep . '</li>';
                    $parent_id     = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb) {
                    echo $crumb;
                }
                echo $before . get_the_title() . $after;
            } elseif (is_search()) {
                echo $before . 'Search results for "' . get_search_query() . '"' . $after;
            } elseif (is_tag()) {
                echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
            } elseif (is_author()) {
                global $author;
                $userdata = get_userdata($author);
                echo $before . 'Articles posted by ' . $userdata->display_name . $after;
            } elseif (is_404()) {
                echo $before . 'Error 404' . $after;
            }
            // if (get_query_var('paged')) {
            //     if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()
            //     ) {
            //         echo ' (';
            //     }
            //     echo __('Page', 'werock') . $sep . get_query_var('paged');
            //     if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()
            //     ) {
            //         echo ')';
            //     }
            // }

        echo '</ul></div>';

    }
}



///////////////////////////CUSTOM WIDGETS ////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////

class xv_latest_posts_wgt extends WP_Widget
{
  function xv_latest_posts_wgt()
  {
    $widget_ops = array('classname' => 'xv_latest_posts_wgt', 'description' => 'Display latest posts with thumbnails' );
    $this->WP_Widget('xv_latest_posts_wgt', 'werock Latest Posts', $widget_ops);
  }
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '','count'=>'' ) );
      
      if( $instance) {
             $title = esc_attr($instance['title']);
             $count = esc_attr($instance['count']);
          
    } else {
             $title = '';
             $count = '';
            
           
    }
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo  esc_attr($title); ?>" /></label></p>
    <p>
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number Of Posts:', 'wp_widget_plugin'); ?></label>
    <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
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
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
   $title = apply_filters('widget_title', $instance['title']);
   $count = $instance['count'];

   if( $count && is_numeric($count) ) {
       $number_of_posts = $count;
   }
     else{ 
        $number_of_posts = 3;
    } 
?>   
   <div class="recent-posts">                    
       <div class="head-wrapper">
          <h3 class="widget-title">
              <?php if (!empty($title)){echo $title;} else{echo "Recent Posts";} ?>
          </h3>
       </div>
                    
    <?php


        global $post;
     
     $catquery = new WP_Query( 'posts_per_page='. --$number_of_posts);
     
    if ( have_posts() ) : while($catquery->have_posts()) : $catquery->the_post(); ?>
            <div class="latest-post">
           
                 
                  <div class="recent-visual">
            
                    <?php if ( has_post_thumbnail() ) {the_post_thumbnail( array(75,75) );}?>
                  </div> 
                
              <div class="latest-detail">                  
                 <a title="Post: <?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                 <div class="date-stamp">Date: <?php the_time('F j, Y') ?></div>
              </div>
          </div>  
    <?php endwhile; ?>
    <?php else : ?>
    <p>Sorry, no posts were found.</p>
    <?php endif;

     wp_reset_query();  ?>
  </div>   <!-- End Popular Posts -->
     
 <?php
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("xv_latest_posts_wgt");') );
/*
*
  Latest comments Widget
*
*/
class xv_latest_comments_wgt extends WP_Widget
{
   function xv_latest_comments_wgt()
  {
    $widget_ops = array('classname' => 'xv_latest_comments_wgt', 'description' => 'Display Latest Comments' );
    $this->WP_Widget('xv_latest_comments_wgt', 'werock Latest Comments', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'content' => '','count'=>'') );
    
      if( $instance) {
             $title = esc_attr($instance['title']);
             $count = esc_attr($instance['count']);
          
    } else {
             $title = '';
             $count = '';
            
           
    }
?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
    <p>
    <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number Of Posts:', 'wp_widget_plugin'); ?></label>
    <input id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" />
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
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
   $title = apply_filters('widget_title', $instance['title']);
   $count = $instance['count'];

   if( $count && is_numeric($count) ) {
       $number_of_comments = $count;
   }
     else{ 
        $number_of_comments = 2;
    } 
?>
  
      
            
       <div class="head-wrapper">
          <h3 class="widget-title">
              <?php if (!empty($title)){echo $title;} else{echo "Recent Comments";} ?>
          </h3>
       </div>
             

   <?php
  global $wpdb;
  $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url, SUBSTRING(comment_content,1,30) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $number_of_comments";

  $comments = $wpdb->get_results($sql);


  foreach ($comments as $comment) { ?>

             <div class="latest-post">
                          <div class="recent-visual">
                              <span class="fa fa-comments"></span>
                            </div>
                            
                            <div class="latest-detail">
                              <a href="#"><?php echo strip_tags($comment->com_excerpt); ?></a>
                 
                            </div>
                          
                         </div><!--\\latest-post-->
   
 <?php
}

    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("xv_latest_comments_wgt");') );
////////////////////////////////////////////////////////////////////////////////////////////


  /**
 * Checks if a post thumbnails is already defined.
 *
 */
function werock_is_post_thumbnail_set()
{
    global $post;
    if (get_the_post_thumbnail()) {
        return true;
    } else {
        return false;
    }
}
function werock_autoset_featured_img()
{
    global $post;

    $post_thumbnail = werock_is_post_thumbnail_set();
    if ($post_thumbnail == true) {
        return get_the_post_thumbnail();
    }
    $image_args     = array(
        'post_type'      => 'attachment',
        'numberposts'    => 1,
        'post_mime_type' => 'image',
        'post_parent'    => $post->ID,
        'order'          => 'desc'
    );
    $attached_images = get_children($image_args, ARRAY_A);
    $first_image = reset($attached_images);
    if (!$first_image) {
        return false;
    }

    return get_the_post_thumbnail($post->ID, $first_image['ID']);

}
