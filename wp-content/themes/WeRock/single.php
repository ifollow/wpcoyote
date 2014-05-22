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
                                  _e( 'Blog', 'werock' );
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
Upcoming events
=================================-->

<section id="blog">
	<div class="container">
        <div class="row">
   
            <div class="col-lg-9 col-md-9 col-sm-9">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'single' ); ?>
						
						<?php //werock_content_nav( 'nav-below' ); ?>

					
			   
						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || '0' != get_comments_number() )
								comments_template();
						?>
					

					<?php endwhile; // end of the loop. ?>
			</div>
			 <div class="col-lg-3 col-md-3 col-sm-3">
			 	<?php get_sidebar(); ?>
			 </div>		
		</div>
	</div>
</section>

<?php get_footer(); ?>