<?php

/**
 * bbPress - Forum Archive
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

	<?php do_action( 'bbp_before_main_content' ); ?>

	<?php do_action( 'bbp_template_notices' ); ?>

	<div id="forum-front" class="bbp-forum-front">
		<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
      
       <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <h1><?php bbp_forum_archive_title(); ?></h1>
                  
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
              <?php bbp_breadcrumb(); ?>
          </div>
       </div>
  </section>
<div class="clearfix"></div>

	
 <!--=================================
  Blog Posts
  ==========================================-->
 <section class="blog">
	<div class="container">
      <div class="row">     
      <div class="col-lg-9 col-md-9 col-sm-9">

		<div class="entry-content">

			<?php bbp_get_template_part( 'content', 'archive-forum' ); ?>

		</div>
		</div>
     <div class="col-lg-3 col-md-3 col-sm-9">
               <?php  get_sidebar(); ?>
      </div>
    </div><!--\\row-->
  </div>
</section>
	</div><!-- #forum-front -->

	<?php do_action( 'bbp_after_main_content' ); ?>

<?php get_footer(); ?>
