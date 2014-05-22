<?php

/**
 * Template Name: bbPress - Create Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>
<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
      
       <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <h1><?php the_title(); ?></h1>
                  
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
              <?php bbp_breadcrumb(); ?>
          </div>
       </div>
  </section>
<div class="clearfix"></div>
 <!--=================================
  Topic
  ==========================================-->
 <section class="blog">
	<div class="container">
      <div class="row">     
      <div class="col-lg-9 col-md-9 col-sm-9">

	<?php do_action( 'bbp_before_main_content' ); ?>

	<?php do_action( 'bbp_template_notices' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div id="bbp-new-topic" class="bbp-new-topic">
			<div class="entry-content">

				<?php the_content(); ?>

				<?php bbp_get_template_part( 'form', 'topic' ); ?>

			</div>
		</div><!-- #bbp-new-topic -->

	<?php endwhile; ?>

	<?php do_action( 'bbp_after_main_content' ); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
