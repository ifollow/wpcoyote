<?php
/**
*Template Name: Full Width
 * @package werock
*/
get_header(); ?>

<?php get_template_part( 'content', 'top' ); ?>


  <?php while ( have_posts() ) : the_post(); ?>


 <!--=================================
  Blog Posts
  ==========================================-->
 <section class="blog">
	<div class="container">
      <div class="row">     
        <div class="col-lg-12 col-md-12 col-sm-12">

        <?php get_template_part( 'content', 'page' ); ?>

        <?php
          // If comments are open or we have at least one comment, load up the comment template
          if ( comments_open() || '0' != get_comments_number() )
            comments_template();
        ?>
       <?php endwhile; // end of the loop. ?>
      </div>
    </div><!--\\row-->
  </div>
</section>

<?php get_footer(); ?>
