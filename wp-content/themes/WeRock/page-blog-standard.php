<?php
/**
*Template Name: Standard Blog
* @package Ortax
*/
get_header(); ?>
<!--=========================================
  Bread Crumbs
==========================================-->
<div class="bread-crumb">
  <div class="container">
        <div class="row">
            <div class=" col-lg-7 col-md-7 col-sm-7">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="head"><?php the_title(); ?></div>
            <?php endwhile; // end of the loop. ?>   
            </div>
            <div class=" col-lg-5 col-md-5 col-sm-5">
              <?php if (function_exists('werock_breadcrumbs')) { werock_breadcrumbs();} ?>
            </div>
        </div>
    
    </div>
</div>
<!--=========================================
  Blog Posts
==========================================-->
<section id="blog-holder">
  <div class="container">
        <div class="row">     
          <div class="col-lg-9 col-md-9 col-sm-9">
              <div class="post-wide" >
                <?php 
               $temp = $wp_query; $wp_query= null;
               $wp_query = new WP_Query(); $wp_query->query('showposts='. $posts_per_page . '&paged='.$paged);
               while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                <?php get_template_part( 'content', 'blog' ); ?>
              <?php endwhile; // end of the loop. ?>
         <?php if (function_exists("werock_get_pagination")) {werock_get_pagination();} ?>
        </div>
      </div>
          <div class="col-lg-3 col-md-3 col-sm-3">
              <div class="blog-sidebar">
          <?php get_sidebar(); ?>
            </div>
          </div>

        </div><!--\\row-->
    </div>
</section>
<?php get_footer(); ?>