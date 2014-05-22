<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package werock
 */

get_header(); ?>



 <!--=================================
 Blog
 =================================--> 



  <section class="breadcrumb">
      
       <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                	<?php if ( have_posts() ) : ?>

				<h1 class="page-title">
					<?php
						if ( is_category() ) :
							single_cat_title();

						elseif ( is_tag() ) :
							single_tag_title();

						elseif ( is_author() ) :
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							*/
							the_post();
							printf( __( 'Author: %s', 'werock' ), '<span class="vcard">' . get_the_author() . '</span>' );
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();

						elseif ( is_day() ) :
							printf( __( 'Day: %s', 'werock' ), '<span>' . get_the_date() . '</span>' );

						elseif ( is_month() ) :
							printf( __( 'Month: %s', 'werock' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

						elseif ( is_year() ) :
							printf( __( 'Year: %s', 'werock' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

						elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
							_e( 'Asides', 'werock' );

						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							_e( 'Images', 'werock');

						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							_e( 'Videos', 'werock' );

						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							_e( 'Quotes', 'werock' );

						elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
							_e( 'Links', 'werock' );

						else :
							_e( 'Archives', 'werock' );

						endif;
					?>
				</h1>
                    <h5>
	                    <?php
							// Show an optional term description.
							$term_description = term_description();
							if ( ! empty( $term_description ) ) :
								printf( '<div class="taxonomy-description">%s</div>', $term_description );
							endif;
						?>
                    </h5>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
              <?php if (function_exists('werock_breadcrumbs')) { werock_breadcrumbs();} ?>
          </div>
       </div>
  </section>
<div class="clearfix"></div>





  <section id="blog" class="whiteBG">
 	<div class="container">
 		<div class="row">
 			 <div class="col-lg-9 col-md-8 col-sm-12">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						//get_template_part( 'content', get_post_format() );
					?>
					<?php get_template_part( 'content', 'blog' ); ?>
				<?php endwhile; ?>

				
			<?php if (function_exists("werock_get_pagination")) {werock_get_pagination();} ?>
			<?php else : ?>

				<?php get_template_part( 'content', 'blog' ); ?>

			<?php endif; ?>
			</div>
			<div class="col-lg-3 col-md-4 col-sm-12">
	           	<?php get_sidebar(); ?>
	         </div>
      	</div>
        </div> <!--container-->
</section>


<?php // get_sidebar(); ?>
<?php  get_footer(); ?>
