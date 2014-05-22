<?php
/**
 * The Template for displaying all single posts.
 *
 * @package werock
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
  		
       <div class="container">
       		<div class="row">
            	<div class="col-lg-6 col-md-6 col-sm-6">
                	 <h1><?php 
                              $saved_data = get_post_meta($post->ID,'xv_post-top-title',true);
                              if(!empty($saved_data)){
                                
                                 echo $saved_data;
                                }else{
                                  _e( 'Event', 'werock' ); 
                                }
                            ?>
                    </h1>
                    <h5><?php 
                              $saved_data = get_post_meta($post->ID,'xv_post-subtitle',true);
                              echo $saved_data;

                            ?>
                   </h5>
                </div>
                
               <div class="col-lg-6 col-md-6 col-sm-6">
                     <?php if (function_exists('werock_breadcrumbs')) { werock_breadcrumbs();} ?>
                </div>
       		</div>
       </div>
  </section>
<div class="clearfix"></div>
<!--=================================
videos
=================================-->

<section id="latest-events">
  <div class="container">
        <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-5">
                    <div class="event-feed latest">
                       <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                        <div class="date">
                            <span class="day"><?php the_time('j'); ?></span>
                            <span class="month"><?php the_time('M'); ?></span>
                        </div>
                        <h5><?php the_title(); ?></h5>
                        <ul>
                        <?php 
                            if( get_post_meta( $post->ID, 'xv_event_location', true ) ){ 
                    
                              echo '  <li><b class=" fa fa-location-arrow"></b>'. get_post_meta( $post->ID, 'xv_event_location', true ) .'</li>';
                            } 
                        ?>
                        <?php 
                           if( get_post_meta( $post->ID, 'xv_event_location', true ) ){ 
                        
                            echo '<li><b class=" fa fa-clock-o"></b> '.get_the_time('G:i').' - '.get_post_meta( $post->ID, 'xv_end_time_hh', true ).':'.get_post_meta( $post->ID, 'xv_end_time_mm', true ).'</li>';
                            
                            }
                            ?>
                        </ul>
                        <?php
                      
                          ?>
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
                                            $buy_tickets_btn = get_post_meta( $post->ID, 'xv_event_btn_text', true );
                                          }else{
                                            $buy_tickets_btn = "Buy Tickets";
                                    }
                                      $xv_event_btn_url = get_post_meta( $post->ID, 'xv_event_btn_url', true );
                                      if($xv_event_btn_url){ 
                                          echo '<a class="btn" href="'.$xv_event_btn_url.'">'.$buy_tickets_btn.'</a>';
                                        }
                                      }else{
                                        echo '<a class="btn" href="'.$xv_event_btn_url.'">Event Expired</a>';
                                      }
                           }

                          ?>
                    </div><!--\\event-feed latest-->
                    
                    <h1><?php _e( 'event location', 'werock' ); ?></h1>
                     <?php 
                      if( get_post_meta( $post->ID, 'xv_event_location', true ) ){ 
                    
                          echo '<div id="google-map" class="event-map" data-theme="'.$xv_data['map-skin'].'" data-address="'.get_post_meta( $post->ID, 'xv_event_location', true ).'" data-zoomlvl="13" data-maptype="HYBRID"></div>';
                     
                       } ?>
                </div><!--//col-->
                
                <div class="col-lg-8 col-md-8 col-sm-7">
                  <div class="event-info">
                        <?php the_content(); ?>
             
                  </div><!--//event-info-->
                </div><!--//col-->
        </div><!--row-->
    </div><!--//container-->  
</section>
  <?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>
