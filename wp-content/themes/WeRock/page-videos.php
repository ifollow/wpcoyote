<?php

/**
*Template Name: Videos
* @package werock
*/
get_header(); 
global $smof_data;
 ?>

<?php get_template_part( 'content', 'top' ); ?>



<!--=================================
videos
=================================-->

<section id="videos">
  <div class="container">
        <div class="row">
           

                  <?php query_posts(array('post_type'=>'videos'));  ?>
                  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                   <div class="col-lg-4 col-md-4 col-sm-4">
              
                <div class="latest-videos">

                  <div class="video-feed">
                   <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}

                      $saved_data = get_post_meta($post->ID,'xv_video_url',true);
                        if(!empty($saved_data)){

                   ?>
                      <a href="<?php echo $saved_data; ?>"><span class="fa fa-play"></span></a>
                      <?php } ?>
                      <h5><?php the_title(); ?></h5>





                </div><!--\\video-feed-->

                 
              </div>
            </div><!--latest videos-->
            

                                     <?php  endwhile; endif;   ?>
     
        </div>
    </div>    
</section>


<?php get_footer(); ?>
