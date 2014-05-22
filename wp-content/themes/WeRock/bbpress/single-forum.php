<?php

/**
 * Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

	
	<div id="forum-front" class="bbp-forum-front">
<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
      
       <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <h1><?php bbp_forum_title(); ?></h1>
                  
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


		<?php if ( bbp_user_can_view_forum() ) : ?>

			<div id="forum-<?php bbp_forum_id(); ?>" class="bbp-forum-content">
				
				<div class="entry-content">

					<?php bbp_get_template_part( 'content', 'single-forum' ); ?>

				</div>
			</div><!-- #forum-<?php bbp_forum_id(); ?> -->

		<?php else : // Forum exists, user no access ?>

			<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>
	<?php do_action( 'bbp_after_main_content' ); ?>
	</div>
	 <div class="col-lg-3 col-md-3 col-sm-9">
               <?php  get_sidebar(); ?>
      </div>
    </div><!--\\row-->
	</div>
</section>
	</div><!-- #forum-front -->

	

<?php get_footer(); ?>
