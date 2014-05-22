<?php
/**
 * The Template for displaying all single posts.
 *
 * @package werock
 */

get_header(); 
global $xv_data;
?>


<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
  		
       <div class="container">
       		<div class="row">
            	<div class="col-lg-6 col-md-6 col-sm-6">
                	<h1><?php if(!empty($xv_data['posts_top_title'])){echo $xv_data['posts_top_title'];}else{echo 'Blog';}?></h1>
                    <h5><?php if(!empty($xv_data['posts_top_subtitle'])){echo $xv_data['posts_top_subtitle'];}else{echo 'latest blog posts';}?></h5>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
              <?php if (function_exists('werock_breadcrumbs')) { werock_breadcrumbs();} ?>
       		</div>
       </div>
  </section>
<div class="clearfix"></div>


 <!--=================================
 Blog
 =================================--> 

<section id="blog">
	<div class="container">
        <div class="row">
          <div class="col-lg-9 col-md-8 col-sm-12">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'blog' ); ?>
				<?php endwhile; // end of the loop. ?>
			  	<?php if (function_exists("werock_get_pagination")) {werock_get_pagination();} ?>
			  	 
               
      	   </div> 
      	   <div class="col-lg-3 col-md-4 col-sm-12">
           	<?php get_sidebar(); ?>
           </div>
        </div>
    </div>    
</section>

<?php get_footer(); ?>

