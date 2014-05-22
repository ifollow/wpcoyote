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
            	<div class="col-lg-6 col-md-6 col-sm-6">
                  <h1><?php 
                              $saved_data = get_post_meta($post->ID,'xv_post-top-title',true);
                              if(!empty($saved_data)){
                                
                                 echo $saved_data;
                                }else{
                                  _e( 'Artist', 'werock' ); 
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
Artist 
=================================-->

<section id="artists">
	<div class="container">
        <div class="row">
        	<div class="artist-detail">
        		<?php while ( have_posts() ) : the_post(); ?>

            	<div class="artist">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                    </div>
                     <div class="col-lg-8 col-md-8 col-sm-8">

					

                     	<div class="artist-detail-content">
                            <h3><?php the_title(); ?></h3>
                            <?php the_content(); ?>
                        </div><!--//artist-detail-content-->
                        
                        <div class="artist-tracks">
                        	<h1>latest tracks</h1>
                            <div id="track_player"></div>
                            
					<?php
						$track = 0;
						$saved_data = get_post_meta($post->ID,'xv_track_title',true);
            if(!empty($saved_data)){
						foreach ($saved_data as $arr){
						
							
					?>
					  
                        <div class="track<?php if($track % 2 == 0) { echo ' even';} ?>">
                            	<div class="track_title"><?php  echo $arr['xv_track_title']; ?></div>
                                <div class="track_release"><?php echo $arr['xv_track_description']; ?></div>
                                <div class="track_listen">
                                    <a href="<?php echo $arr['xv_track_url']; ?>">Listen <i class="fa fa-play"></i></a>
                                 </div>
                            	<div class="track_buy"><a href="<?php echo $arr['xv_track_buy_url']; ?>"><?php echo $arr['xv_track_buy_btn']; ?></a></div>
                            </div><!--track-->
                            <div class="clearfix"></div>
                            

					<?php 	$track++; }} ?>
   
                                  
                            
                        </div><!--artist tracks-->
                 
                    </div>
                </div><!--\\artist-->
                       <?php endwhile; // end of the loop. ?>
            </div><!--//artist detail-->
        </div><!--row-->
    </div><!--//container-->  
</section>
<?php get_footer(); ?>
