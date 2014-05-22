<?php

/**
 * Topic Tag
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
                  <h1><?php printf( __( 'Topic Tag: %s', 'bbpress' ), '<span>' . bbp_get_topic_tag_name() . '</span>' ); ?></h1>
                  
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

	<div id="topic-tag" class="bbp-topic-tag">
	
		<div class="entry-content">

			<?php bbp_get_template_part( 'content', 'archive-topic' ); ?>

		</div>
	</div><!-- #topic-tag -->

	<?php do_action( 'bbp_after_main_content' ); ?>

</div>
	 <div class="col-lg-3 col-md-3 col-sm-9">
               <?php  get_sidebar(); ?>
      </div>
    </div><!--\\row-->
	</div>
</section>
<?php get_footer(); ?>
