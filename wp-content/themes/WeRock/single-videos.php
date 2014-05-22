<?php
/**
 * The Template for displaying all single posts.
 *
 * @package werock
 */

get_header(); ?>



<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
  		
       <div class="container">
       		<div class="row">
             <?php while ( have_posts() ) : the_post(); ?>
            	<div class="col-lg-6 col-md-6 col-sm-6">
                  <h1><?php 
                              $saved_data = get_post_meta($post->ID,'xv_post-top-title',true);
                              if(!empty($saved_data)){
                                
                                 echo $saved_data;
                                }else{
                                  _e( 'Video', 'werock' ); 
                                }
                            ?>
                    </h1>
                    <h5><?php the_title(); ?>
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

<section id="video-detail">
  <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               
              
                        <div class="alert alert-error">
                      <p><?php  _e( 'Kindly change easybox settings to allow videos. And check video page to preview videos.', 'werock'); ?></p>
       
                        </div>
           
              
            </div>
            
            
                                
        </div><!--row-->
         <?php endwhile; // end of the loop. ?>
    </div><!--container-->
</section>
<?php get_footer(); ?>
