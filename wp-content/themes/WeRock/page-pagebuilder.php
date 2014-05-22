<?php
/**
*Template Name: Page Builder
 * @package werock
*/
get_header(); ?>


  

 <!--=================================
  Blog Posts
  ==========================================-->
 <section class="blog">

	 <div class="container">
	 	<?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content', 'page' ); ?>


       <?php endwhile; // end of the loop. ?>
     </div>
</section>

<?php get_footer(); ?>
