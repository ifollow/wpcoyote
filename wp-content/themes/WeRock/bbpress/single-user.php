<?php

/**
 * Single User
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
                  <h1><?php bbp_displayed_user_field( 'display_name' ); ?></h1>
                  
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
              
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

	<div id="bbp-user-<?php bbp_current_user_id(); ?>" class="bbp-single-user">
		<div class="entry-content">

			<?php bbp_get_template_part( 'content', 'single-user' ); ?>

		</div><!-- .entry-content -->
	</div><!-- #bbp-user-<?php bbp_current_user_id(); ?> -->

	<?php do_action( 'bbp_after_main_content' ); ?>
</div>
	 <div class="col-lg-3 col-md-3 col-sm-9">
               <?php  get_sidebar(); ?>
      </div>
    </div><!--\\row-->
	</div>
</section>
<?php get_footer(); ?>
