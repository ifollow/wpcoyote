<?php

/**
*Template Name: Events
* @package werock
*/
get_header(); 
global $smof_data;
 ?>

<?php get_template_part( 'content', 'top' ); ?>


<!--=================================
Latest Events
=================================-->

<section id="latest-events">
  <div class="container">
        <div class="row">
                <?php query_posts(array('post_type'=>'event','post_status'=>'future,publish'));  ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
               <div class="col-lg-4 col-md-4 col-sm-5">
                    <div class="event-feed latest">
                       <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                        <div class="date">
                            <span class="day"><?php the_time('j'); ?></span>
                            <span class="month"><?php the_time('M'); ?></span>
                        </div>
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <ul>
                        <?php 
                            $xv_event_location = get_post_meta( $post->ID, 'xv_event_location', true );
                            if($xv_event_location){ 
                    
                              echo '  <li><b class=" fa fa-location-arrow"></b>'.$xv_event_location.'</li>';
                            } 
                        ?>
                        <?php 
                           
                            echo '<li><b class=" fa fa-clock-o"></b> '.get_the_time('G:i').' - '.get_post_meta( $post->ID, 'xv_end_time_hh', true ).':'.get_post_meta( $post->ID, 'xv_end_time_mm', true ).'</li>';
                            
                          
                            ?>
                        </ul>
                        <?php
                                $xv_event_btn_woo = get_post_meta( $post->ID, 'xv_event_btn_woo', true );
                            if( !empty($xv_event_btn_woo)){

                                echo do_shortcode('[add_to_cart id="'.$xv_event_btn_woo.'"]'); 
                            }else{

                                    $postDate = strtotime( $post->post_date );
                                    $todaysDate = time() - (time() % 86400);
                                    if ( $postDate >= $todaysDate) {
                                          $xv_event_btn_text = get_post_meta( $post->ID, 'xv_event_btn_text', true );
                                        if(!empty($xv_event_btn_text)){
                                            $buy_tickets_btn = '';
                                            $buy_tickets_btn =$xv_event_btn_text;
                                          }else{
                                            $buy_tickets_btn = "Buy Tickets";
                                    } 
                                        $xv_event_btn_url = get_post_meta( $post->ID, 'xv_event_btn_url', true );
                                      if( get_post_meta( $post->ID, 'xv_event_btn_url', true ) ){ 
                                          echo '<a class="btn" href="'.$xv_event_btn_url.'">'.$buy_tickets_btn.'</a>';
                                        }
                                      }else{
                                        echo '<a class="btn" href="'.$xv_event_btn_url.'">Event Expired</a>';
                                      }
                           }

                          ?>
                    </div><!--\\event-feed latest-->
                    
                    
                </div><!--//col-->
                <?php  endwhile; endif;   ?>
                

 
        </div><!--row-->
    </div><!--//container-->  
</section>
<div class="clearfix"></div>



<?php get_footer(); ?>


