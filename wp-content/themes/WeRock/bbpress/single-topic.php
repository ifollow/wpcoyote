<?php

/**
 * Single Topic
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
                  <h1><?php bbp_topic_title(); ?></h1>
                  
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

	<?php if ( bbp_user_can_view_forum( array( 'forum_id' => bbp_get_topic_forum_id() ) ) ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="bbp-topic-wrapper">
				
				<div class="entry-content">

					<?php bbp_get_template_part( 'content', 'single-topic' ); ?>

				</div>
			</div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->

		<?php endwhile; ?>

	<?php elseif ( bbp_is_forum_private( bbp_get_topic_forum_id(), false ) ) : ?>

		<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_after_main_content' ); ?>

</div>
	 <div class="col-lg-3 col-md-3 col-sm-9">
               <?php  get_sidebar(); ?>
      </div>
    </div><!--\\row-->
	</div>
</section>
<?php get_footer(); ?>
