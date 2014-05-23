<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package werock
 */

get_header(); ?>



  <section class="breadcrumb">
  		
       <div class="container">
       		<div class="row">
            	<div class="col-lg-6 col-md-6 col-sm-6">
                	<h1><?php printf( __( 'Buscar', 'werock' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                    <h5><?php printf( __( 'Resultados da busca para: %s', 'werock' ), '<span>' . get_search_query() . '</span>' ); ?></h5>
                </div>
                
           
       </div>
  </section>
<div class="clearfix"></div>
 <!--=================================
search
 =================================--> 
  <section id="blog" class="whiteBG">
 	<div class="container">
        <div class="row">
          <div class="col-lg-9 col-md-8 col-sm-12">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'blog' ); ?>

			<?php endwhile; ?>

		 <?php if (function_exists("werock_get_pagination")) {werock_get_pagination();} ?>
		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

 		</div>
	 	   <div class="col-lg-3 col-md-4 col-sm-12">
           	<?php get_sidebar(); ?>
           </div>
        </div>
    </div> 
</section>
<?php get_footer(); ?>
